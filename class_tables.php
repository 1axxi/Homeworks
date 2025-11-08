<?php

class Database
{
    private $pdo;

    public function __construct()
    {

        $dsn = "sqlite:bad_words_database.sqlite";
        $this->pdo = new PDO($dsn);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

class BadWords
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS bad_words (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            word TEXT NOT NULL UNIQUE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function addWord($word)
    {
        $sql = "INSERT OR IGNORE INTO bad_words (word) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$word]);
    }
}

class Users
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function addUser($username, $email)
    {
        $sql = "INSERT INTO users (username, email) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$username, $email]);
    }
}

class UsersInfo
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users_info (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            full_name TEXT,
            age INTEGER,
            country TEXT,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            UNIQUE(user_id)
        )";
        $this->pdo->exec($sql);
    }

    public function addInfo($userId, $fullName, $age, $country)
    {
        $sql = "INSERT INTO users_info (user_id, full_name, age, country) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $fullName, $age, $country]);
    }
}

class UserBadWords
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS user_bad_words (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            word_id INTEGER NOT NULL,
            usage_count INTEGER DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (word_id) REFERENCES bad_words(id) ON DELETE CASCADE,
            UNIQUE(user_id, word_id)
        )";
        $this->pdo->exec($sql);
    }

    public function addUsage($userId, $wordId)
    {
        // SQLite версия вместо ON DUPLICATE KEY UPDATE
        $sql = "INSERT INTO user_bad_words (user_id, word_id) 
                VALUES (?, ?)
                ON CONFLICT(user_id, word_id) DO UPDATE SET usage_count = usage_count + 1";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $wordId]);
    }

    public function getUsersTopBadWords()
    {
        $sql = "
            SELECT 
                u.username,
                bw.word,
                ubw.usage_count,
                (SELECT COUNT(*) FROM user_bad_words ubw2 
                 WHERE ubw2.user_id = u.id AND ubw2.usage_count > ubw.usage_count) + 1 as rank
            FROM users u
            JOIN user_bad_words ubw ON u.id = ubw.user_id
            JOIN bad_words bw ON bw.id = ubw.word_id
            ORDER BY u.username, ubw.usage_count DESC
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



// Создание таблиц
$users = new Users($pdo);
$usersInfo = new UsersInfo($pdo);
$badWords = new BadWords($pdo);
$userBadWords = new UserBadWords($pdo);

$users->createTable();
$usersInfo->createTable();
$badWords->createTable();
$userBadWords->createTable();



// Пример добавления данных
$users->addUser('john_doe', 'john@example.com');
$users->addUser('jane_smith', 'jane@example.com');

$usersInfo->addInfo(1, 'John Doe', 25, 'USA');
$usersInfo->addInfo(2, 'Jane Smith', 30, 'Canada');

$badWords->addWord('rude');
$badWords->addWord('offensive');
$badWords->addWord('vulgar');

$userBadWords->addUsage(1, 1);
$userBadWords->addUsage(1, 1);
$userBadWords->addUsage(1, 2);
$userBadWords->addUsage(2, 3);
$userBadWords->addUsage(2, 3);
$userBadWords->addUsage(2, 3);

// Вывод пользователей с их доп информацией
$sql = "
    SELECT 
        u.username,
        u.email,
        ui.full_name,
        ui.age,
        ui.country
    FROM users u
    JOIN users_info ui ON u.id = ui.user_id
";

$stmt = $pdo->query($sql);
$usersWithInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Users with additional information:</h2>";
foreach ($usersWithInfo as $user) {
    echo "Username: {$user['username']}<br>";
    echo "Email: {$user['email']}<br>";
    echo "Full Name: {$user['full_name']}<br>";
    echo "Age: {$user['age']}<br>";
    echo "Country: {$user['country']}<br>";
    echo "-------------------------<br>";
}

// Вывод пользователей с их наиболее часто используемыми плохими словами
$topBadWords = $userBadWords->getUsersTopBadWords();

echo "<h2>Users with their most frequently used bad words:</h2>";
$currentUser = null;
foreach ($topBadWords as $row) {
    if ($row['rank'] == 1) {
        if ($currentUser !== $row['username']) {
            echo "Username: {$row['username']}<br>";
            echo "Most used bad word: {$row['word']} (used {$row['usage_count']} times)<br>";
            echo "-------------------------<br>";
            $currentUser = $row['username'];
        }
    }
}

echo "<br><strong>SQLite database file created: bad_words_database.sqlite</strong>";


