<?php
$host = 'localhost';
$dbname = 'radio_db'; // 数据库名称
$username = 'root';
$password = ''; // WampServer 默认密码为空

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8mb4'");
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}
?>