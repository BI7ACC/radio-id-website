<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请结果</title>
</head>

<?php
include '../includes/db.php';

if (isset($_GET['query_name']) && isset($_GET['query_qq'])) {
    $query_name = $_GET['query_name'];
    $query_qq = $_GET['query_qq'];

    // 查询数据库
    $stmt = $pdo->prepare("SELECT status, radio_id FROM radio_ids WHERE name = ? AND qq = ?");
    $stmt->execute([$query_name, $query_qq]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['status'] === 'approved') {
            echo "<p>您的申请已通过！您的 Radio ID 是：<strong>{$result['radio_id']}</strong></p>";
        } elseif ($result['status'] === 'rejected') {
            echo "<p>您的申请已被拒绝。</p>";
        } else {
            echo "<p>您的申请正在审核中，请耐心等待。</p>";
        }
    } else {
        echo "<p>未找到匹配的申请记录。</p>";
    }
}
?>