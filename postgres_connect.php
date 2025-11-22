<?php
class PostgresConnect
{
    public $pdo;
    public function __construct($host, $username, $password, $database)
    {
        $this->pdo = new PDO("pgsql:host=$host;dbname=$database", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public function createTable()
    {
        $this->pdo;
        $sql = "CREATE TABLE IF NOT EXISTS bad_words (id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    age INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";
        $this->pdo->exec($sql);

    }
}
$db = new PostgresConnect('localhost','laxxi','1246','study_database');
$db->createTable();
