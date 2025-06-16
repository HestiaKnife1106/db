<?php
require 'db.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["course_name"];
    $instructor = $_POST["instructor"];
    $desc = $_POST["description"];
    $stmt = $pdo->prepare("INSERT INTO courses (course_name, instructor, description) VALUES (?, ?, ?)");
    $stmt->execute([$name, $instructor, $desc]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>新增課程</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="mb-4">新增課程</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">課程名稱</label>
      <input type="text" name="course_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">授課老師</label>
      <input type="text" name="instructor" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">課程簡介</label>
      <textarea name="description" class="form-control" rows="4"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">新增課程</button>
    <a href="index.php" class="btn btn-secondary">返回列表</a>
  </form>
</body>
</html>
