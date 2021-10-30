<?php /* declare (strict_types = 1);

namespace Tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\DBHandler;

class ConnectionTest extends TestCase
{
protected static $config;
protected static $conn;
protected static $dbh;

public static function setUpBeforeClass(): void
{
define('DB_CONFIG', '../config/database.php');

self::$dbh = new DBHandler();
self::$conn = self::$dbh->connect();
}

public static function tearDownAfterClass(): void
{
self::$conn = null;
}

public function testConnectionIsNotEmpty(): void
{
$this->assertNotEmpty(self::$conn);
}

public function testConnectionIsAnObject(): void
{
$this->assertIsObject(self::$conn);
}

public function testConnectionIsNotNull(): void
{
$this->assertNotNull(self::$conn);
}

public function testClosedConnectionReturnsNullValue(): void
{
self::$conn = self::$dbh->disconnect();
$this->assertNull(self::$conn);
}
} */

?>