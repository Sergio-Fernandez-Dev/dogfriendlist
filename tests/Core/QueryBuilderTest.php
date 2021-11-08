<?php declare (strict_types = 1);

namespace Tests\Core;

use Exception;
use App\Core\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase {
    /**
     * @var mixed
     */
    public $qb;

    protected function setUp(): void {

        $this->qb = new QueryBuilder();
        $this->qb->setTableName('Users');
    }

    public function testTableNameCanBeSet() {

        $this->qb->setTableName('Test');

        $this->assertEquals('Test', $this->qb->getTableName());
    }

    public function testImmutablesCanBeSet() {

        $values = ['id', 'name'];
        $this->qb->setImmutableValues($values);

        $this->assertContains('id', $this->qb->getImmutableValues());
    }

    public function testImmutablesAreNotIncludedInUpdateQuery() {

        $values = ['id', 'name'];
        $this->qb->setImmutableValues($values);
        $data = [
            'id'   => 1,
            'name' => 'Sergio',
            'city' => 'Oviedo',
        ];

        $expected = "UPDATE Users SET city = :0" . ";";
        $query = $this->qb->update($data)->get();

        $this->assertEquals($expected, $query['query']);

    }

    public function testImmutablesRemainsAfterChangeTableName() {

        $values = ['id', 'name'];
        $this->qb->setImmutableValues($values);

        $this->qb->setTableName('Test');

        $this->assertContains('name', $this->qb->getImmutableValues());
    }

    public function testRawReturnsQueryPassedByParameter() {

        $expected = "SELECT * FROM Users";
        $query = $this->qb->raw($expected)->get();

        $this->assertEquals($expected . ";", $query['query']);
    }

    public function testRawCombinedWithAnotherFunctionReturnsRightBindedParams() {

        $expected = "SELECT * FROM Users WHERE name = :0 OR name = :1 AND city = :2" . ";";
        $query = $this->qb->raw("SELECT * FROM Users WHERE name = :0 OR name = :1", "Sergio", "Sara")
            ->andWhere('city', '=', 'Madrid')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testInsertReturnsExpectedSqlString() {

        $expected = "INSERT INTO Users (id, name, city) VALUES (:0, :1, :2)" . ";";
        $values = [
            'id'   => 1,
            'name' => 'Eduardo',
            'city' => 'Sevilla',
        ];

        $query = $this->qb->insert($values)->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testSelectReturnsExpectedSqlString() {

        $expected = "SELECT * FROM Users" . ";";
        $query = $this->qb->select()->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testSelectDistinctReturnsExceptionIfItReceivesEmptyFields() {

        $this->expectException(Exception::class);

        $this->qb->selectDistinct()->get();
    }

    public function testSelectDistinctReturnsExpectedSqlStringIfItReceivesFields() {
        $expected = "SELECT DISTINCT Country, City FROM Users" . ";";
        $query = $this->qb->selectDistinct('Country', 'City')->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testSelectDistinctReturnsExceptionIfASelectQueryIsExecutedFirst() {
        $this->expectException(Exception::class);

        $this->qb->select()->get();
        $this->qb->selectDistinct()->get();
    }

    public function testUpdateReturnsExpectedSqlString() {
        $expected = "UPDATE Users SET name = :0, country = :1" . ";";
        $data = [
            'name'    => 'Manolo',
            'country' => 'Germany',
        ];

        $query = $this->qb->update($data)->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testDeleteReturnsExpectedSqlString() {
        $expected = "DELETE FROM Users" . ";";
        $query = $this->qb->delete('Users')->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testWhereReturnsExceptionIfQueryTypeIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->where('Country', '=', 'Germany')
            ->get();
    }

    public function testWhereReturnsExceptionIfQueryTypeIsWrong() {
        $this->expectException(Exception::class);
        $this->qb->insert(['Nickname' => 'Test'])
            ->where('Country', '=', 'Germany')
            ->get();
    }

    public function testWhereReturnsExceptionIfTwoWhereCommandsAreSet() {
        $this->expectException(Exception::class);
        $query = $this->qb->select()
            ->where('City', '=', 'Berlin')
            ->where('Name', '=', 'Hannsel')
            ->get();
    }

    public function testWhereReturnsExpectedSqlStringIfIsnullIsGiven() {
        $expected = "SELECT * FROM Users WHERE City IS NULL" . ";";
        $query = $this->qb->select()
            ->where('City', '=', 'is null')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testWhereReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users WHERE City = :0" . ";";
        $query = $this->qb->select()
            ->where('City', '=', 'Berlin')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testAndwhereReturnsExceptionIfQueryTypeIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->where('City', '=', 'Berlin')
            ->andWhere('Name', '=', 'Hannsel')
            ->get();
    }

    public function testAndwhereReturnsExceptionIfQueryTypeIsWrong() {
        $this->expectException(Exception::class);
        $this->qb->insert(['Nickname' => 'Test'])
            ->where('City', '=', 'Berlin')
            ->andWhere('Name', '=', 'Hannsel')
            ->get();
    }

    public function testAndwhereReturnsExceptionIfWhereIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->select()
            ->andWhere('Name', '=', 'Hannsel')
            ->get();
    }

    public function testAndwhereReturnsExpectedSqlStringIfWherenotIsSet() {
        $expected = "SELECT * FROM Users WHERE NOT User = :0 AND City = :1" . ";";
        $query = $this->qb->select()
            ->whereNot('User', '=', 'Hannsel')
            ->andWhere('City', '=', 'Berlin')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testAndwhereReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users WHERE User = :0 AND City = :1" . ";";
        $query = $this->qb->select()
            ->where('User', '=', 'Hannsel')
            ->andWhere('City', '=', 'Berlin')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testOrwhereReturnsExceptionIfQueryTypeIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->where('City', '=', 'Berlin')
            ->orWhere('Name', '=', 'Hannsel')
            ->get();
    }

    public function testOrwhereReturnsExceptionIfQueryTypeIsWrong() {
        $this->expectException(Exception::class);
        $this->qb->insert(['Nickname' => 'Test'])
            ->where('City', '=', 'Berlin')
            ->orWhere('Name', '=', 'Hannsel')
            ->get();
    }

    public function testOrwhereReturnsExceptionIfWhereIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->select()
            ->orWhere('Name', '=', 'Hannsel')
            ->get();
    }

    public function testOrwhereReturnsExpectedSqlStringIfWherenotIsSet() {
        $expected = "SELECT * FROM Users WHERE NOT User = :0 AND City = :1" . ";";
        $query = $this->qb->select()
            ->whereNot('User', '=', 'Hannsel')
            ->andWhere('City', '=', 'Berlin')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testOrwhereReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users WHERE User = :0 OR City = :1" . ";";
        $query = $this->qb->select()
            ->where('User', '=', 'Hannsel')
            ->orWhere('City', '=', 'Berlin')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testWherenotReturnsExceptionIfQueryTypeIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->whereNot('City', '=', 'Berlin')
            ->get();
    }

    public function testWherenotReturnsExceptionIfQueryTypeIsWrong() {
        $this->expectException(Exception::class);
        $this->qb->insert(['Nickname' => 'Test'])
            ->whereNot('City', '=', 'Berlin')
            ->get();
    }

    public function testWherenotReturnsExceptionIfWhereIsSet() {
        $this->expectException(Exception::class);
        $this->qb->select()
            ->where('Name', '=', 'Hannsel')
            ->whereNot('City', '=', 'Berlin')
            ->get();
    }

    public function testWherenotReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users WHERE NOT City = :0" . ";";
        $query = $this->qb->select()
            ->whereNot('City', '=', 'Berlin')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testLimitReturnsExceptionIfQueryTypeIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->limit(3)
            ->get();
    }

    public function testLimitReturnsExceptionIfQueryTypeIsWrong() {
        $this->expectException(Exception::class);
        $this->qb->insert(["Name" => "Sergio"])
            ->limit(3)
            ->get();
    }

    public function testLimitWithOneArgumentReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users LIMIT 3" . ";";
        $query = $this->qb->select()
            ->limit(3)
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testlimitWhitTwoArgumentsReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users LIMIT 3, 10" . ";";
        $query = $this->qb->select()
            ->limit(3, 10)
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testOrderbyReturnsExceptionIfQueryTypeIsNotSet() {
        $this->expectException(Exception::class);
        $this->qb->orderBy('Name')
            ->get();
    }

    public function testOrderbyReturnsExceptionIfQueryTypeIsWrong() {
        $this->expectException(Exception::class);
        $this->qb->delete('Users')
            ->orderBy('Name')
            ->get();
    }

    public function testOrderbyWithOneArgumentReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users ORDER BY Name ASC" . ";";
        $query = $this->qb->select()
            ->orderBy('Name')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testOrderbyWhitTwoArgumentsReturnsExpectedSqlString() {
        $expected = "SELECT * FROM Users ORDER BY Name DESC" . ";";
        $query = $this->qb->select()
            ->orderBy('Name', 'desc')
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testLongQueryReturnsExpectedSqlString() {
        $expected =
            "SELECT * FROM Users"
            . " WHERE Category != :0"
            . " OR Category != :1"
            . " ORDER BY Category ASC"
            . " LIMIT 10" . ";";

        $query =
        $this->qb->select()
            ->where('Category', '!=', 'Parques')
            ->orWhere('Category', '!=', 'Guarderias')
            ->orderBy('Category')
            ->limit(10)
            ->get();

        $this->assertEquals($expected, $query['query']);
    }

    public function testLongQueryReturnsExpectedValuesToBind() {
        $expected =
            [
            ':0' => 'Parques',
            ':1' => 8,
        ];

        $query =
        $this->qb->select()
            ->where('Category', '!=', 'Parques')
            ->orWhere('Id', '!=', 8)
            ->orderBy('Category')
            ->limit(10)
            ->get();

        $this->assertEquals($expected, $query['values']);
    }

}

?>