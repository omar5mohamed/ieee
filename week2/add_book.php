<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $seller_id = $_SESSION['user_id'];

    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, price, discount, image, seller_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddsi", $title, $author, $price, $discount, $image, $seller_id);
        $stmt->execute();
        header("Location: seller_portal.php");
        exit();
    } else {
        $error = "Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Add Book Error</h1>
        <?php if (isset($error)) echo "<p class='red-text'>$error</p>"; ?>
        <p>Please try again. <a href="seller_portal.php">Back to Seller Portal</a></p>
    </div>
</body>
</html>
<?php $conn->close(); ?>