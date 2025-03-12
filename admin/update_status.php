<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // 更新状态
    $stmt = $pdo->prepare("UPDATE radio_ids SET status = ? WHERE id = ?");
    if ($stmt->execute([$status, $id])) {
        echo "状态更新成功！";
    } else {
        echo "状态更新失败：" . $stmt->errorInfo()[2];
    }

    // 重定向回后台管理页面
    header("Location: index.php");
    exit;
}
?>