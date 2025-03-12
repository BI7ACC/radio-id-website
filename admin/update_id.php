<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $newId = $_POST['new_id'];

    // 检查新 ID 是否已存在
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM radio_ids WHERE radio_id = ?");
    $stmt->execute([$newId]);
    if ($stmt->fetchColumn() > 0) {
        die("新 ID 已存在，请使用其他 ID。");
    }

    // 更新 ID
    $stmt = $pdo->prepare("UPDATE radio_ids SET radio_id = ? WHERE id = ?");
    if ($stmt->execute([$newId, $id])) {
        echo "ID 更新成功！";
    } else {
        echo "ID 更新失败：" . $stmt->errorInfo()[2];
    }

    // 重定向回后台管理页面
    header("Location: index.php");
    exit;
}
?>