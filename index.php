<?php
include '../includes/db.php';

// 获取筛选条件
$region = isset($_GET['region']) ? $_GET['region'] : '';

// 构建查询
$query = "SELECT * FROM radio_ids";
if ($region) {
    $query .= " WHERE region = :region";
}
$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
if ($region) {
    $stmt->execute(['region' => $region]);
} else {
    $stmt->execute();
}
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* 折叠菜单样式 */
        .collapse-menu {
            margin-bottom: 20px;
        }
        .collapse-menu button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .collapse-menu button:hover {
            background-color: #218838;
        }
        .collapse-content {
            display: none;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* 弹出窗口样式 */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        .modal input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .modal button {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal button:hover {
            background-color: #218838;
        }
        .modal button[type="button"] {
            background-color: #dc3545;
        }
        .modal button[type="button"]:hover {
            background-color: #c82333;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <h1>Radio ID 申请管理</h1>

    <!-- 筛选表单 -->
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
        <button type="submit">刷新</button>
    </form>

<!-- 申请列表 -->
<table>
    <thead>
        <tr>
            <!--<th>ID</th>-->
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
            <!--<td><?= $app['id'] ?></td>-->
            <td><?= $app['name'] ?></td>
            <td><?= $app['qq'] ?></td>
            <td><?= $app['region'] ?></td>
            <td><?= $app['radio_id'] ?></td>
            <td><?= $app['status'] ?></td>
            <td>
                <!-- 批准操作按钮 -->
                <button onclick="openApprovalModal(<?= $app['id'] ?>)">批准操作</button>
                <button onclick="openModal(<?= $app['id'] ?>, <?= $app['radio_id'] ?>)">修改 ID</button>
                <form action="delete.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $app['id'] ?>">
                    <button type="submit" style="background-color: #dc3545;">删除</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 弹出窗口 -->
<div class="overlay" id="overlay"></div>
<div class="modal" id="approvalModal">
    <h2>批准操作</h2>
    <form action="update_status.php" method="POST">
        <input type="hidden" name="id" id="modalApprovalId">
        <button type="submit" name="status" value="approved">批准</button>
        <button type="submit" name="status" value="rejected">拒绝</button>
    </form>
    <button type="button" onclick="closeApprovalModal()">取消</button>
</div>

<div class="overlay" id="overlay"></div>
<div class="modal" id="modal">
    <h2>修改 Radio ID</h2>
    <form id="updateIdForm" method="POST" action="update_id.php">
        <input type="hidden" name="id" id="modalId">
        <label for="new_id">新 Radio ID:</label>
        <input type="number" name="new_id" id="new_id" required>
        <button type="submit">保存</button>
        <button type="button" onclick="closeModal()">取消</button>
    </form>
</div>

    <script>
        // 打开批准弹窗
        function openApprovalModal(id) {
            document.getElementById('modalApprovalId').value = id;
            document.getElementById('approvalModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        // 关闭批准弹窗
        function closeApprovalModal() {
            document.getElementById('approvalModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        // 弹出窗口功能
        function openModal(id, currentId) {
            document.getElementById('modalId').value = id;
            document.getElementById('new_id').value = currentId;
            document.getElementById('modal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        // 点击遮罩层关闭弹出窗口
        document.getElementById('overlay').addEventListener('click', function() {
            closeApprovalModal();
            closeModal();
        });
    </script>
</body>
</html>