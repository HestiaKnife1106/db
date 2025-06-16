<?php
require 'db.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$stmt = $pdo->prepare("SELECT c.* FROM courses c JOIN user_courses uc ON uc.course_id = c.id WHERE uc.user_id = ?");
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
  <h2 class="mb-4">我的選課</h2>
  <a href="index.php" class="btn btn-secondary mb-3">← 返回課程列表</a>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>課程名稱</th><th>老師</th><th>簡介</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($my_courses as $c): ?>
      <tr>
        <td><?= $c["course_name"] ?></td>
        <td><?= $c["instructor"] ?></td>
        <td><?= $c["description"] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
