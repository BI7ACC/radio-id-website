<!-- admin/register.php -->
<?php
session_start();
include '../includes/db.php';

// 检查用户是否已经登录
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 验证密码是否匹配
    if ($password !== $confirm_password) {
        echo "密码不匹配";
        exit();
    }

    // 检查用户名是否已存在
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "用户名已存在";
        exit();
    }

    // 哈希密码
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 插入新用户
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $hashed_password]);

    echo "注册成功";

    // 删除注册页面
    unlink(__FILE__);

    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注册</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>注册</h1>
    <form action="register.php" method="POST">
        <label for="username">用户名:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">密码:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">确认密码:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">注册</button>
    </form>
    <p>已有账号？<a href="login.php">登录</a></p>
</body>
</html>