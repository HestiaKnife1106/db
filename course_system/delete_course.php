<?php
require 'db.php';
session_start();
if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit(); }

$id = $_GET["id"];
$stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit();
