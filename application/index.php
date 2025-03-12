<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请 Radio ID</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>申请 Radio ID</h1>
    <form action="submit.php" method="POST">
        <label for="name">姓名:</label>
        <input type="text" id="name" name="name" required>

        <label for="qq">QQ:</label>
        <input type="text" id="qq" name="qq" required>

        <label for="region">区域:</label>
        <select id="region" name="region" required>
            <option value="长沙市">长沙市</option>
            <option value="株洲市">株洲市</option>
            <option value="湘潭市">湘潭市</option>
            <option value="衡阳市">衡阳市</option>
            <option value="邵阳市">邵阳市</option>
            <option value="岳阳市">岳阳市</option>
            <option value="常德市">常德市</option>
            <option value="张家界市">张家界市</option>
            <option value="益阳市">益阳市</option>
            <option value="郴州市">郴州市</option>
            <option value="永州市">永州市</option>
            <option value="怀化市">怀化市</option>
            <option value="娄底市">娄底市</option>
            <option value="湘西土家族苗族自治州">湘西土家族苗族自治州</option>
        </select>

        <button type="submit">提交申请</button>
    </form>

    <h2>查询申请状态</h2>
    <form action="query_status.php" method="GET">
        <label for="query_name">姓名:</label>
        <input type="text" id="query_name" name="query_name" required>

        <label for="query_qq">QQ:</label>
        <input type="text" id="query_qq" name="query_qq" required>

        <button type="submit">查询</button>
    </form>

    <?php
    if (isset($_GET['query_name']) && isset($_GET['query_qq'])) {
        $query_name = $_GET['query_name'];
        $query_qq = $_GET['query_qq'];

        // 查询数据库
        $stmt = $pdo->prepare("SELECT status FROM dmr_ids WHERE name = ? AND qq = ?");
        $stmt->execute([$query_name, $query_qq]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if ($result['status'] === 'approved') {
                echo "<p>您的申请已通过！</p>";
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
</body>
</html>