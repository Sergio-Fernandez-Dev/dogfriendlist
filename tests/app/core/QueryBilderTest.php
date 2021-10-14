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

    public function testFromReturnsExceptionIfQueryTypeIsNotSelect()
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

}


?>