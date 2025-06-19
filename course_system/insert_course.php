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
    $code = $_POST["code"];
    $category = $_POST["category"];
    $credit = $_POST["credit"];
    $day = $_POST["day"];
    $period = $_POST["period"];
    $classroom = $_POST["classroom"];

    $stmt = $pdo->prepare("INSERT INTO courses (course_name, instructor, code, category, credit, day, period, classroom) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $instructor, $code, $category, $credit, $day, $period, $classroom]);

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
      <label class="form-label">電腦代碼</label>
      <input type="text" name="code" class="form-control" required>
    </div>
    <div class="mb-3">
     <label class="form-label">類別</label>
      <select name="category" class="form-select" required>
        <?php
         $options = ["大一必修", "大一選修", "大二必修", "大二選修", "大三必修", "大三選修", "大四必修", "大四選修"];
          foreach ($options as $opt) {
            $selected = ($opt == $course["category"]) ? "selected" : "";
            echo "<option value=\"$opt\" $selected>$opt</option>";
          }
       ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">學分數</label>
      <input type="number" name="credit" class="form-control" min="0" required>
    </div>
    <div class="mb-3">
      <label class="form-label">上課星期</label>
      <input type="text" name="day" class="form-control" placeholder="例如：星期一" required>
    </div>
    <div class="mb-3">
      <label class="form-label">節次</label>
      <input type="text" name="period" class="form-control" placeholder="例如：第1~2節" required>
    </div>
    <div class="mb-3">
      <label class="form-label">教室</label>
      <input type="text" name="classroom" class="form-control" placeholder="例如：F203" required>
    </div>
    <button type="submit" class="btn btn-primary">新增課程</button>
    <a href="index.php" class="btn btn-secondary">返回列表</a>
  </form>
</body>
</html>
