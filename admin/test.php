<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio ID 申请管理</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Radio ID 申请管理</h1>
    <form action="index.php" method="GET">
        <label for="region">筛选区域:</label>
        <select id="region" name="region">
            <option value="">全部</option>
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
        <button type="submit">筛选</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>QQ</th>
                <th>区域</th>
                <th>Radio ID</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $app): ?>
            <tr>
                <td><?= $app['id'] ?></td>
                <td><?= $app['name'] ?></td>
                <td><?= $app['qq'] ?></td>
                <td><?= $app['region'] ?></td>
                <td><?= $app['dmr_id'] ?></td>
                <td><?= $app['status'] ?></td>
                <td>
                    <form action="update_status.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $app['id'] ?>">
                        <button type="submit" name="status" value="approved">批准</button>
                        <button type="submit" name="status" value="rejected">拒绝</button>
                    </form>
                    <form action="delete.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $app['id'] ?>">
                        <button type="submit" name="delete" style="background-color: #dc3545;">删除</button>
                    </form>
                    <form action="update_id.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $app['id'] ?>">
                        <input type="number" name="new_id" placeholder="新 ID" required>
                        <button type="submit" name="update_id" style="background-color: #ffc107;">更改 ID</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>