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
        
        $this->assertEquals($expected.";", $query['query']);
    }

    public function testInsertWithoutFieldsReturnsExpectedSqlString()
    {
        $expected = "INSERT INTO Users VALUES (:0, :1, :2)".";";
        $query = $this->qb->insert('Users', [1, 'Eduardo', 'Sevilla'])->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testInsertWithFieldsReturnsExpectedSqlString()   
    {
        $expected = "INSERT INTO Users (Id, Name, City) VALUES (:0, :1, :2)".";";
        $query = $this->qb->insert('Users', [1,'Eduardo', 'Sevilla'], ['Id', 'Name', 'City'])->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testSelectReturnsExpectedSqlStringIfItReceivesEmptyFields()   
    {
        $expected = "SELECT *".";";
        $query = $this->qb->select()->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testSelectReturnsExpectedSqlStringIfItReceivesGivenFields()   
    {
        $expected = "SELECT Id, Name, City".";";
        $query = $this->qb->select(['Id', 'Name', 'City'])->get();

        $this->assertEquals($expected, $query['query']);
    }


    public function testSelectReturnsExpectedSqlStringIfItReceivesAsteriskLikeParam()   
    {
        $expected = "SELECT *".";";
        $query = $this->qb->select(['*'])->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testSelectDistinctReturnsExpectedSqlStringIfItReceivesEmptyFields()   
    {
        $expected = "SELECT DISTINCT *".";";
        $query = $this->qb->selectDistinct()->get();

        $this->assertEquals($expected, $query['query']);
    }    

    public function testSelectDistinctReturnsExpectedSqlStringIfItReceivesFields()
    {
        $expected = "SELECT DISTINCT Country, City".";";
        $query = $this->qb->selectDistinct(['Country','City'])->get();

        $this->assertEquals($expected, $query['query']);
    }    

    public function testSelectDistinctReturnsExpectedSqlStringIfItReceivesAsteriskLikeParam()   
    {
        $expected = "SELECT DISTINCT *".";";
        $query = $this->qb->selectDistinct(['*'])->get();

        $this->assertEquals($expected, $query['query']);
    }    

    public function testUpdateReturnsExpectedSqlString()   
    {
        $expected = "UPDATE Users".";";
        $query = $this->qb->update('Users')->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testDeleteReturnsExpectedSqlString()   
    {
        $expected = "DELETE FROM Users".";";
        $query = $this->qb->delete('Users')->get();

        $this->assertEquals($expected, $query['query']);
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
        $expected = "UPDATE Users SET Country = :0".";";
        $query = $this->qb->update('Users')
                        ->set('Country','=','Germany')
                        ->get();
    

        $this->assertEquals($expected, $query['query']);
    }

    public function testSetReturnsExpectedSqlStringWhenHasBeenPreviouslySet()   
    {
        $expected = "UPDATE Users SET Country = :0, City = :1".";";
        $query = $this->qb->update('Users')
                        ->set('Country','=','Germany')
                        ->set('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query['query']);
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

        $this->assertEquals($expected, $query['query']);
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
        

        $this->assertEquals($expected, $query['query']); 
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
        $expected = "SELECT Country AS Homeland FROM Users WHERE City = :0 INNER JOIN Spots".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->where('City','=','Berlin')
                        ->join('Spots')
                        ->get();
        

        $this->assertEquals($expected, $query['query']);
    }  

    public function testWhereReturnsExpectedSqlStringIfIsnullIsGiven()
    {
        $expected = "SELECT Country AS Homeland FROM Users WHERE City IS NULL".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->where('City','=','is null')
                        ->get();
        

        $this->assertEquals($expected, $query['query']); 
    }  
    
    public function testWhereReturnsExpectedSqlString()
    {
        $expected = "SELECT Country AS Homeland FROM Users WHERE City = :0".";";
        $query = $this->qb->select(['Country'])
                        ->as('Homeland')
                        ->from('Users')
                        ->where('City','=','Berlin')
                        ->get();
        

        $this->assertEquals($expected, $query['query']);
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
        $expected = "SELECT Name AS User FROM Users WHERE NOT User = :0 AND City = :1".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->whereNot('User','=','Hannsel')
                        ->andWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testAndwhereReturnsExpectedSqlString()
    {
        $expected = "SELECT Name AS User FROM Users WHERE User = :0 AND City = :1".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->where('User','=','Hannsel')
                        ->andWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query['query']);
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
        $expected = "SELECT Name AS User FROM Users WHERE NOT User = :0 AND City = :1".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->whereNot('User','=','Hannsel')
                        ->andWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testOrwhereReturnsExpectedSqlString()
    {
        $expected = "SELECT Name AS User FROM Users WHERE User = :0 OR City = :1".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->where('User','=','Hannsel')
                        ->orWhere('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query['query']);
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
        $expected = "SELECT Name AS User FROM Users WHERE NOT City = :0".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->whereNot('City','=','Berlin')
                        ->get();

        $this->assertEquals($expected, $query['query']); 
    }   

    public function testLimitReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->as('Homeland')
                ->from('Users')
                ->limit(3)
                ->get();
    }

    public function testLimitReturnsExceptionIfQueryTypeIsWrong()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->as('Homeland')
                ->from('Users')
                ->limit(3)
                ->get();
    }

    public function testLimitWithOneArgumentReturnsExpectedSqlString()
    {
        $expected = "SELECT Name AS User FROM Users LIMIT 3".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->limit(3)
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }   

    public function testlimitWhitTwoArgumentsReturnsExpectedSqlString()
    {
        $expected = "SELECT Name AS User FROM Users LIMIT 3, 10".";";
        $query = $this->qb->select(['Name'])
                        ->as('User')
                        ->from('Users')
                        ->limit(3, 10)
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }   

    public function testOrderbyReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->from('Users')
                ->orderBy('Name')
                ->get();
    }

    public function testOrderbyReturnsExceptionIfQueryTypeIsWrong()
    {
        $this->expectException(Exception::class);
        $this->qb->delete('Users')
                ->from('Users')
                ->orderBy('Name')
                ->get();
    }

    public function testOrderbyWithOneArgumentReturnsExpectedSqlString()
    {
        $expected = "SELECT * FROM Users ORDER BY Name ASC".";";
        $query = $this->qb->select(['*'])
                        ->from('Users')
                        ->orderBy('Name')
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }   

    public function testOrderbyWhitTwoArgumentsReturnsExpectedSqlString()
    {
        $expected = "SELECT * FROM Users ORDER BY Name DESC".";";
        $query = $this->qb->select(['*'])
                        ->from('Users')
                        ->orderBy('Name', 'desc')
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }   

    public function testJoinReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->as('Homeland')
                ->from('Users')
                ->join('Spots')
                ->get();
    }

    public function testJoinReturnsExceptionIfQueryTypeIsWrong()
    {
        $this->expectException(Exception::class);
        $this->qb->insert('Users', ['Germany', 'Berlin'])
                ->as('Homeland')
                ->from('Users')
                ->join('Spots')
                ->get();
    }

    public function testJoinWithOneArgumentReturnsExpectedSqlString()
    {
        $expected = "SELECT * FROM Users INNER JOIN Spots".";";
        $query = $this->qb->select(['*'])
                        ->from('Users')
                        ->join('Spots')
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }
    
    public function testJoinWithTwoArgumentReturnsExpectedSqlString()
    {
        $expected = "SELECT * FROM Users LEFT JOIN Spots".";";
        $query = $this->qb->select(['*'])
                        ->from('Users')
                        ->join('Spots', 'left')
                        ->get();

        $this->assertEquals($expected, $query['query']);
    }
    
    public function testOnReturnsExceptionIfQueryTypeIsNotSet()
    {
        $this->expectException(Exception::class);
        $this->qb->select(['Users.Id'])
                        ->from('Users')
                        ->on ('Users.SpotId', '=', 'Spots.Id')
                        ->get();
    }

    public function testOnReturnsExpectedSqlString()
    {
        $expected = "SELECT Users.Id FROM Users LEFT JOIN Spots ON Users.SpotId = :0".";";
        $query = $this->qb->select(['Users.Id'])
                        ->from('Users')
                        ->join('Spots', 'LEFT')
                        ->on('Users.SpotId', '=', 'Spots.Id')
                        ->get();
    

        $this->assertEquals($expected, $query['query']);
    }

    public function testLongQueryReturnsExpectedSqlString()
    {
        $expected = 
                "SELECT Spots.Title AS Title,"
                ." Categories.Name AS Category"
                ." FROM Spots"
                ." INNER JOIN Categories ON Spots.CategoryId = :0"
                ." WHERE Category != :1"
                ." OR Category != :2"
                ." ORDER BY Category ASC"
                ." LIMIT 10".";";
        $query = 
        $this->qb->select(['Spots.Title'])
                ->as('Title')
                ->select(['Categories.Name'])
                ->as('Category')
                ->from('Spots')
                ->join('Categories')
                ->on('Spots.CategoryId','=','Categories.Id')
                ->where('Category','!=','Parques')
                ->orWhere('Category','!=','Guarderias')
                ->orderBy('Category')
                ->limit(10)
                ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testLongQueryReturnsExpectedValuesToBind()
    {
        $expected = 
        [
            ':0'=> 'Categories.Id', 
            ':1' => 'Parques', 
            ':2' => 8
        ];

        $query = 
        $this->qb->select(['Spots.Title'])
                ->as('Title')
                ->select(['Categories.Name'])
                ->as('Category')
                ->from('Spots')
                ->join('Categories')
                ->on('Spots.CategoryId','=','Categories.Id')
                ->where('Category','!=','Parques')
                ->orWhere('Id','!=', 8)
                ->orderBy('Category')
                ->limit(10)
                ->get();

        $this->assertEquals($expected, $query['values']);
    }

    public function testSingleQueryReturnsExpectedValuesToBind()
    {
        $expected = 
        [
            ':0'=> 'Zegius', 
            ':1' => 'test@testing.com' 
        ];

        $query = 
        $this->qb->select(['nickname', 'email'])
                ->from('Users')
                ->where('Nickname','=','Zegius')
                ->orWhere('Email','=','test@testing.com')
                ->get();
        
        $this->assertEquals($expected, $query['values']);
    }

    
}


?>