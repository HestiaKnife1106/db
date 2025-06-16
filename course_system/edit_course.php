<?php
require 'db.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$id = $_GET["id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["course_name"];
    $inst = $_POST["instructor"];
    $desc = $_POST["description"];
    $stmt = $pdo->prepare("UPDATE courses SET course_name=?, instructor=?, description=? WHERE id=?");
    $stmt->execute([$name, $inst, $desc, $id]);
    header("Location: index.php");
    exit();
}
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$id]);
$course = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>編輯課程</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="mb-4">編輯課程</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">課程名稱</label>
      <input type="text" name="course_name" class="form-control" value="<?= $course["course_name"] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">授課老師</label>
      <input type="text" name="instructor" class="form-control" value="<?= $course["instructor"] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">課程簡介</label>
      <textarea name="description" class="form-control"><?= $course["description"] ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">儲存變更</button>
    <a href="index.php" class="btn btn-secondary">返回</a>
  </form>
</body>
</html>
