<?php
require 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$course_id = $_GET["id"];

// ✅ 加入這段：先檢查是否已經選過
$check = $pdo->prepare("SELECT * FROM user_courses WHERE user_id = ? AND course_id = ?");
$check->execute([$user_id, $course_id]);

if ($check->rowCount() === 0) {
    // 沒有重複就新增
    $stmt = $pdo->prepare("INSERT INTO user_courses (user_id, course_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $course_id]);
}

// 不管有沒有重複，最後都跳轉回「我的選課」
header("Location: my_courses.php");
exit();
