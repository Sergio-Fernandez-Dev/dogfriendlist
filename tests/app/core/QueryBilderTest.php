<?php declare(strict_types=1);

namespace Tests\Core;

use App\Core\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public $qb;

    protected function setUp(): void
    {
        $this->qb = new QueryBuilder();
    }

    public function testSqlReturnsQueryPassedByParameter()
    {
        $query = "SELECT * FROM 'Users'";
        $expected = $this->qb->sql($query)->get();
        
        $this->assertEquals($query.";", $expected );
    }

    public function testInsertWithoutFieldsReturnsRightSqlString()
    {
        $query = "INSERT INTO Users VALUES ('Eduardo', 'Gil', 'Sevilla')".";";
        $expected = $this->qb->insert('Users', null, ['Eduardo', 'Gil', 'Sevilla'])->get();

        $this->assertEquals($query, $expected);
    }
}

?>