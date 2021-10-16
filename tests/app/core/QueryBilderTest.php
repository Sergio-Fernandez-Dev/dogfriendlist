<?php declare(strict_types=1);

namespace Tests\Core;

use App\Core\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Exception;

class QueryBuilderTest extends TestCase
{
    public $qb;

    protected function setUp(): void
    {
        $this->qb = new QueryBuilder();
    }

    public function testSqlReturnsQueryPassedByParameter()
    {
        $expected = "SELECT * FROM 'Users'";
        $query = $this->qb->sql($expected)->get();
        
        $this->assertEquals($expected.";", $query );
    }

    public function testInsertWithoutFieldsReturnsExpectedSqlString()
    {
        $expected = "INSERT INTO Users VALUES (1, 'Eduardo', 'Sevilla')".";";
        $query = $this->qb->insert('Users', [1, 'Eduardo', 'Sevilla'])->get();

        $this->assertEquals($expected, $query);
    }

    public function testInsertWithFieldsReturnsExpectedSqlString()   
    {
        $expected = "INSERT INTO Users (Id, Name, City) VALUES (1, 'Eduardo', 'Sevilla')".";";
        $query = $this->qb->insert('Users', [1,'Eduardo', 'Sevilla'], ['Id', 'Name', 'City'])->get();

        $this->assertEquals($expected, $query);
    }

    public function testSelectReturnsExpectedSqlStringIfItReceivesEmptyFields()   
    {
        $expected = "SELECT *".";";
        $query = $this->qb->select()->get();

        $this->assertEquals($expected, $query);
    }

    public function testSelectReturnsExpectedSqlStringIfItReceivesGivenFields()   
    {
        $expected = "SELECT Id, Name, City".";";
        $query = $this->qb->select(['Id', 'Name', 'City'])->get();

        $this->assertEquals($expected, $query);
    }


    public function testSelectReturnsExpectedSqlStringIfItReceivesAsteriskLikeParam()   
    {
        $expected = "SELECT *".";";
        $query = $this->qb->select(['*'])->get();

        $this->assertEquals($expected, $query);
    }

    public function testSelectDistinctReturnsExpectedSqlStringIfItReceivesEmptyFields()   
    {
        $expected = "SELECT DISTINCT *".";";
        $query = $this->qb->selectDistinct()->get();

        $this->assertEquals($expected, $query);
    }    

    public function testSelectDistinctReturnsExpectedSqlStringIfItReceivesFields()
    {
        $expected = "SELECT DISTINCT Country, City".";";
        $query = $this->qb->selectDistinct(['Country','City'])->get();

        $this->assertEquals($expected, $query);
    }    

    public function testSelectDistinctReturnsExpectedSqlStringIfItReceivesAsteriskLikeParam()   
    {
        $expected = "SELECT DISTINCT *".";";
        $query = $this->qb->selectDistinct(['*'])->get();

        $this->assertEquals($expected, $query);
    }    

    public function testUpdateReturnsExpectedSqlString()   
    {
        $expected = "UPDATE Users".";";
        $query = $this->qb->update('Users')->get();

        $this->assertEquals($expected, $query);
    }

    public function testDeleteReturnsExpectedSqlString()   
    {
        $expected = "DELETE FROM Users".";";
        $query = $this->qb->delete('Users')->get();

        $this->assertEquals($expected, $query);
    }

    public function testSetReturnsExceptionIfQueryTypeIsNotUpdate()
    {
        $this->expectException(Exception::class);
        $this->qb->select()
                ->set('Country','=','Germany')
                ->get();
    }

    public function testSetReturnsExpectedSqlString()   
    {
        $expected = "UPDATE Users SET Country = 'Germany'".";";
        $query = $this->qb->update('Users')
                        ->set('Country','=','Germany')
                        ->get();

        $this->assertEquals($expected, $query);
    }

    public function testSetReturnsExpectedSqlStringWhenHasBeenPreviouslySet()   
    {
        $expected = "UPDATE Users SET Country = 'Germany', City = 'Berlin'".";";
        $query = $this->qb->update('Users')
                        ->set('Country','=','Germany')
                        ->set('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query);
    }

    public function testAsReturnsExceptionIfQueryTypeIsNotSelectUpdateOrDelete()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->as('Test')
                ->get();
    }

    public function testAsReturnsExpectedSqlString()
    {
        $expected = "SELECT Country AS Homeland".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->get();

        $this->assertEquals($expected, $query);      
    }

    public function testFromReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->from('Users')
                ->get();
    }

    public function testFromReturnsExpectedSqlString()
    {
        $expected = "SELECT Country AS Homeland FROM Users".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->get();
            
        $this->assertEquals($expected, $query);    
    }

    public function testWhereReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->where('Country','=','Germany')
                ->get();
    }

    public function testWhereReturnsExceptionIfQueryTypeIsWrong()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->where('Country','=','Germany')
                ->get();
    }

    public function testWhereReturnsExceptionIfTwoWhereCommandsAreSet()
    {
        $this->expectException(Exception::class);
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->where('City','=','Berlin')
                        ->where('Name','=','Hannsel')
                        ->get();
    }

    public function testTwoWhereCommandsReturnsExpectedSqlStringIfJoinCommandIsSet()
    {
        $expected = "SELECT Country AS Homeland FROM Users WHERE City = 'Berlin' INNER JOIN Spots".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->where('City','=','Berlin')
                        ->join('Spots')
                        ->get();
            
        $this->assertEquals($expected, $query);    
    }  

    public function testWhereReturnsExpectedSqlStringIfIsnullIsGiven()
    {
        $expected = "SELECT Country AS Homeland FROM Users WHERE City IS NULL".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->where('City','=','is null')
                        ->get();
            
        $this->assertEquals($expected, $query);    
    }  
    
    public function testWhereReturnsExpectedSqlString()
    {
        $expected = "SELECT Country AS Homeland FROM Users WHERE City = 'Berlin'".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->where('City','=','Berlin')
                        ->get();
            
        $this->assertEquals($expected, $query);    
    }  
    
    public function testAndwhereReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->as('Homeland')
                ->from('Users')
                ->where('City','=','Berlin')
                ->andWhere('Name','=','Hannsel')
                ->get();
    }

    public function testAndwhereReturnsExceptionIfQueryTypeIsWrong()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->as('Homeland')
                ->from('Users')
                ->where('City','=','Berlin')
                ->andWhere('Name','=','Hannsel')
                ->get();
    }

    public function testAndwhereReturnsExceptionIfWhereIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->select(['Country'])
                ->as('Homeland')
                ->from('Users')
                ->andWhere('Name','=','Hannsel')
                ->get();
    }

    public function testAndwhereReturnsExpectedSqlStringIfWherenotIsSet()
    {
        $expected = "SELECT Name AS User FROM Users WHERE NOT User = 'Hannsel' AND City = 'Berlin'".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->whereNot('User','=','Hannsel')
                        ->andWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query);  
    }

    public function testAndwhereReturnsExpectedSqlString()
    {
        $expected = "SELECT Name AS User FROM Users WHERE User = 'Hannsel' AND City = 'Berlin'".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->where('User','=','Hannsel')
                        ->andWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query);  
    }

    public function testOrwhereReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->as('Homeland')
                ->from('Users')
                ->where('City','=','Berlin')
                ->orWhere('Name','=','Hannsel')
                ->get();
    }

    public function testOrwhereReturnsExceptionIfQueryTypeIsWrong()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->as('Homeland')
                ->from('Users')
                ->where('City','=','Berlin')
                ->orWhere('Name','=','Hannsel')
                ->get();
    }

    public function testOrwhereReturnsExceptionIfWhereIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->select(['Country'])
                ->as('Homeland')
                ->from('Users')
                ->orWhere('Name','=','Hannsel')
                ->get();
    }

    public function testOrwhereReturnsExpectedSqlStringIfWherenotIsSet()
    {
        $expected = "SELECT Name AS User FROM Users WHERE NOT User = 'Hannsel' AND City = 'Berlin'".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->whereNot('User','=','Hannsel')
                        ->andWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query);  
    }

    public function testOrwhereReturnsExpectedSqlString()
    {
        $expected = "SELECT Name AS User FROM Users WHERE User = 'Hannsel' OR City = 'Berlin'".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->where('User','=','Hannsel')
                        ->orWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query);  
    }
    public function testWherenotReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->as('Homeland')
                ->from('Users')
                ->whereNot('City','=','Berlin')
                ->get();
    }

    public function testWherenotReturnsExceptionIfQueryTypeIsWrong()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->as('Homeland')
                ->from('Users')
                ->whereNot('City','=','Berlin')
                ->get();
    }

    public function testWherenotReturnsExceptionIfWhereIsSet()
    {
        $this->expectException(Exception::class);
        $this->qb->select(['Country'])
                ->as('Homeland')
                ->from('Users')
                ->where('Name','=','Hannsel')
                ->whereNot('City','=','Berlin')
                ->get();
    }

    public function testWherenotReturnsExpectedSqlString()
    {
        $expected = "SELECT Name AS User FROM Users WHERE NOT City = 'Berlin'".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->whereNot('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query);  
    }   



}


?>