<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$seller_id = $_SESSION['user_id'];
$stmt = $conn->prepare("DELETE FROM books WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $id, $seller_id);
$stmt->execute();
header("Location: seller_portal.php");
exit();
?>