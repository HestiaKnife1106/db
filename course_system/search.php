<?php
require 'db.php';
$q = $_GET["q"] ?? "";
$stmt = $pdo->prepare("SELECT * FROM courses WHERE course_name LIKE ?");
$stmt->execute(["%$q%"]);
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
  <h2 class="mb-4">搜尋結果：「<?= htmlspecialchars($q) ?>」</h2>
  <a href="index.php" class="btn btn-secondary mb-3">← 返回課程列表</a>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>課程名稱</th><th>授課老師</th><th>課程簡介</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $c): ?>
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
