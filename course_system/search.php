<?php
require 'db.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$q = $_GET["q"] ?? "";

// 查詢：課程名稱、代碼、類別、老師、教室
$stmt = $pdo->prepare("
    SELECT * FROM courses 
    WHERE course_name LIKE ? 
       OR code LIKE ?
       OR category LIKE ?
       OR instructor LIKE ?
       OR classroom LIKE ?
");
$like = "%$q%";
$stmt->execute([$like, $like, $like, $like, $like]);
$results = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>搜尋結果</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>搜尋結果：「<?= htmlspecialchars($q) ?>」</h2>
    <a href="index.php" class="btn btn-secondary">← 返回課程列表</a>
  </div>

  <?php if (count($results) > 0): ?>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>課程名稱</th>
        <th>電腦代碼</th>
        <th>類別</th>
        <th>學分</th>
        <th>星期</th>
        <th>節次</th>
        <th>老師</th>
        <th>教室</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $c): ?>
      <tr>
        <td><?= htmlspecialchars($c["course_name"]) ?></td>
        <td><?= htmlspecialchars($c["code"]) ?></td>
        <td><?= htmlspecialchars($c["category"]) ?></td>
        <td><?= htmlspecialchars($c["credit"]) ?></td>
        <td><?= htmlspecialchars($c["day"]) ?></td>
        <td><?= htmlspecialchars($c["period"]) ?></td>
        <td><?= htmlspecialchars($c["instructor"]) ?></td>
        <td><?= htmlspecialchars($c["classroom"]) ?></td>
        <td>
          <a href="enroll_course.php?id=<?= $c["courses_id"] ?>" class="btn btn-success btn-sm">選課</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <div class="alert alert-warning">找不到符合的課程。</div>
  <?php endif; ?>
</body>
</html>
