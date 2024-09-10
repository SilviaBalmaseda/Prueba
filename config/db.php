<?php
$host = 'ewr1.clusters.zeabur.com';
$db = 'nefelibata';
$user = 'root';
$pass = 'sK5GC2wY784NOFmqb1V369pUaXLZB0cz';
$charset = 'utf8mb4';

// $dsn = "mysqlsh --sql --host=ewr1.clusters.zeabur.com --port=32172 --user=root --password=sK5GC2wY784NOFmqb1V369pUaXLZB0cz --schema=nefelibata";
// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$dsn = "mysql:host=$host;port=32172;dbname=$db;charset=$charset"; 

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
