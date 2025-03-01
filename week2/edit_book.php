<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$seller_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $id, $seller_id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    header("Location: seller_portal.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, price=?, discount=?, image=? WHERE id=? AND seller_id=?");
        $stmt->bind_param("ssddsii", $title, $author, $price, $discount, $image, $id, $seller_id);
    } else {
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, price=?, discount=? WHERE id=? AND seller_id=?");
        $stmt->bind_param("ssddii", $title, $author, $price, $discount, $id, $seller_id);
    }
    $stmt->execute();
    header("Location: seller_portal.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <nav class="nav-wrapper indigo accent-3">
        <div class="container">
            <a href="index.php" class="brand-logo left">Bookstore</a>
        </div>
    </nav>

    <div class="container">
        <h2>Edit Book</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" name="title" id="title" value="<?php echo $book['title']; ?>" required>
                <label for="title">Book Title</label>
            </div>
            <div class="input-field">
                <input type="text" name="author" id="author" value="<?php echo $book['author']; ?>" required>
                <label for="author">Author</label>
            </div>
            <div class="input-field">
                <input type="number" step="0.01" name="price" id="price" value="<?php echo $book['price']; ?>" required>
                <label for="price">Price ($)</label>
            </div>
            <div class="input-field">
                <input type="number" step="0.01" name="discount" id="discount" value="<?php echo $book['discount']; ?>" required>
                <label for="discount">Discount ($)</label>
            </div>
            <div class="input-field">
                <input type="file" name="image" id="image" accept="image/*">
                <label for="image">Book Image (optional)</label>
                <?php if ($book['image']) echo "<img src='uploads/{$book['image']}' style='max-width: 50px;'>"; ?>
            </div>
            <button type="submit" class="btn indigo accent-3">Update Book</button>
        </form>
        <a href="seller_portal.php" class="btn grey">Back</a>
    </div>

    <footer class="footer">
        <div class="container">
            <p>© Bookstore. All rights reserved to Omar.</p>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>