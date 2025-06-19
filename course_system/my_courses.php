<?php
require 'db.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$stmt = $pdo->prepare("SELECT c.* FROM courses c JOIN user_courses uc ON uc.course_id = c.courses_id WHERE uc.user_id = ?");
$stmt->execute([$user_id]);
$my_courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>我的課程</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-2">我的選課</h2>
      <a href="index.php" class="btn btn-secondary btn-sm">← 返回課程列表</a>
    </div>
    <div>
      <span class="me-3">登入者：<?= htmlspecialchars($_SESSION["email"]) ?></span>
      <a href="logout.php" class="btn btn-outline-danger btn-sm">登出</a>
    </div>
  </div>

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
      <?php foreach ($my_courses as $c): ?>
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
            <a href="drop_course.php?id=<?= $c["courses_id"] ?>" class="btn btn-outline-danger btn-sm">退選</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
