<?php
//$db = pg_connect("host=localhost dbname=study_database user=laxxi password=1246");
//$result = pg_query($db, "SELECT * FROM bad_words")  как было
//;

$host = "localhost";
$user = "laxxi";
$pass = "1246";
$db = "homeworks";
$port = 5432;
try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения!" . $e->getMessage());
}