<?php
session_start();
include 'db_connect.php';

$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'buyer') {
        $error = "Please log in to add books to your cart.";
    } else {
        $book_id = $_POST['book_id'];
        $buyer_id = $_SESSION['user_id'];
        $check = $conn->prepare("SELECT * FROM cart WHERE buyer_id = ? AND book_id = ?");
        $check->bind_param("ii", $buyer_id, $book_id);
        $check->execute();
        if ($check->get_result()->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO cart (buyer_id, book_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $buyer_id, $book_id);
            $stmt->execute();
        }
    }
}

$cart_count = 0;
if (isset($_SESSION['role']) && $_SESSION['role'] === 'buyer') {
    $count_stmt = $conn->prepare("SELECT COUNT(*) as count FROM cart WHERE buyer_id = ?");
    $count_stmt->bind_param("i", $_SESSION['user_id']);
    $count_stmt->execute();
    $cart_count = $count_stmt->get_result()->fetch_assoc()['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .book-card { padding: 20px; border: 1px solid #ddd; border-radius: 5px; text-align: center; }
        .book-card img { max-width: 100%; height: auto; border-radius: 5px; }
        .footer { padding: 20px 0; background-color: #1a237e; color: #fff; text-align: center; }
    </style>
</head>
<body>
    <nav class="nav-wrapper indigo accent-3">
        <div class="container">
            <a href="index.php" class="brand-logo left">Bookstore</a>
            <ul class="right">
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['role'])): ?>
                    <?php if ($_SESSION['role'] === 'buyer'): ?>
                        <li><a href="cart.php">Cart (<?php echo $cart_count; ?>)</a></li>
                    <?php elseif ($_SESSION['role'] === 'seller'): ?>
                        <li><a href="seller_portal.php">Seller Portal</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($error)) echo "<p class='red-text'>$error</p>"; ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php $final_price = $row['price'] - $row['discount']; ?>
                <div class="col s12 m6 l4">
                    <div class="book-card">
                        <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                        <h5><?php echo $row['title']; ?></h5>
                        <p>Author: <?php echo $row['author']; ?></p>
                        <?php if ($row['discount'] > 0): ?>
                            <p>Price: <del style="color: red;"><?php echo $row['price']; ?>$</del></p>
                            <p>Final Price: <b style="color: green;"><?php echo $final_price; ?>$</b></p>
                        <?php else: ?>
                            <p>Price: <b style="color: green;"><?php echo $row['price']; ?>$</b></p>
                        <?php endif; ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="add_to_cart" class="btn indigo accent-3">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; Bookstore. All rights reserved to Omar.</p>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>