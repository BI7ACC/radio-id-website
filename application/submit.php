<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请已提交</title>
</head>

<?php
include '../includes/db.php';

$regionPrefixes = [
    '长沙市' => 4301,
    '株洲市' => 4302,
    '湘潭市' => 4303,
    '衡阳市' => 4304,
    '邵阳市' => 4305,
    '岳阳市' => 4306,
    '常德市' => 4307,
    '张家界市' => 4308,
    '益阳市' => 4309,
    '郴州市' => 4310,
    '永州市' => 4311,
    '怀化市' => 4312,
    '娄底市' => 4313,
    '湘西土家族苗族自治州' => 4331,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $qq = $_POST['qq'];
    $region = $_POST['region'];

    // 获取区域前缀
    $prefix = isset($regionPrefixes[$region]) ? $regionPrefixes[$region] : 0;
    if (!$prefix) {
        die("无效的区域");
    }

    // 生成 Radio ID
    $stmt = $pdo->query("SELECT MAX(radio_id) AS maxId FROM radio_ids WHERE radio_id LIKE '$prefix%'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxId = isset($result['maxId']) ? $result['maxId'] : ($prefix * 1000 + 1);
    $radioId = $maxId + 1;

    // 保存申请
    $stmt = $pdo->prepare("INSERT INTO radio_ids (radio_id, name, qq, region) VALUES (?, ?, ?, ?)");
    $stmt->execute([$radioId, $name, $qq, $region]);

    echo "申请已提交！请耐心等待。";
}
?>