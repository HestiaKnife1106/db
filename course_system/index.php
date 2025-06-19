<?php
require 'db.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$stmt = $pdo->query("SELECT * FROM courses");
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>課程清單</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>課程清單</h2>
    <div>
      <span class="me-3">登入者：<?= $_SESSION["email"] ?></span>
      <a href="logout.php" class="btn btn-outline-danger btn-sm">登出</a>
    </div>
  </div>

  <div class="mb-3">
    <?php if ($_SESSION["role"] === "admin"): ?>
      <a href="insert_course.php" class="btn btn-primary">新增課程</a>
    <?php endif; ?>
    <a href="my_courses.php" class="btn btn-secondary">我的課程</a>
  </div>

  <form class="mb-4 d-flex" action="search.php" method="GET">
    <input type="text" name="q" class="form-control me-2" placeholder="搜尋課程...">
    <button type="submit" class="btn btn-outline-primary">搜尋</button>
  </form>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>課程名稱</th>
        <th>授課老師</th>
        <th>電腦代碼</th>
        <th>類別</th>
        <th>學分</th>
        <th>星期</th>
        <th>節次</th>
        <th>教室</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($courses as $c): ?>
      <tr>
        <td><?= htmlspecialchars($c["course_name"]) ?></td>
        <td><?= htmlspecialchars($c["instructor"]) ?></td>
        <td><?= htmlspecialchars($c["code"]) ?></td>
        <td><?= htmlspecialchars($c["category"]) ?></td>
        <td><?= htmlspecialchars($c["credit"]) ?></td>
        <td><?= htmlspecialchars($c["day"]) ?></td>
        <td><?= htmlspecialchars($c["period"]) ?></td>
        <td><?= htmlspecialchars($c["classroom"]) ?></td>
        <td>
          <a href="enroll_course.php?id=<?= $c["courses_id"] ?>" class="btn btn-success btn-sm">選課</a>
          <?php if ($_SESSION["role"] === "admin"): ?>
            <a href="edit_course.php?id=<?= $c["courses_id"] ?>" class="btn btn-warning btn-sm">編輯</a>
            <a href="delete_course.php?id=<?= $c["courses_id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('確定刪除？')">刪除</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
