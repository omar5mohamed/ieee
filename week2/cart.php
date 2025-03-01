<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'buyer') {
    header("Location: index.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

if (isset($_POST['remove'])) {
    $book_id = $_POST['book_id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE buyer_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $buyer_id, $book_id);
    $stmt->execute();
}

if (isset($_POST['checkout'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $stmt = $conn->prepare("INSERT INTO orders (buyer_id, book_id, name, address, phone) SELECT buyer_id, book_id, ?, ?, ? FROM cart WHERE buyer_id = ?");
    $stmt->bind_param("sssi", $name, $address, $phone, $buyer_id);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM cart WHERE buyer_id = ?");
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    $message = "Order placed successfully!";
}

$sql = "SELECT b.* FROM cart c JOIN books b ON c.book_id = b.id WHERE c.buyer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $buyer_id);
$stmt->execute();
$cart_items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .bookadd { padding: 50px; }
        .footer { padding: 20px 0; background-color: #1a237e; color: #fff; text-align: center; }
        #finalcost::before { content: "Final Cost: "; }
    </style>
</head>
<body>
    <nav class="nav-wrapper indigo accent-3">
        <div class="container">
            <a href="index.php" class="brand-logo left">Bookstore</a>
            <ul class="right">
                <li><a href="index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Your Cart</h2>
        <?php if (isset($message)) echo "<p class='green-text'>$message</p>"; ?>
        <div class="card-panel bookadd">
            <h5>Checkout Details</h5>
            <form method="POST">
                <div class="input-field">
                    <input type="text" name="name" id="name" required>
                    <label for="name">Your Name</label>
                </div>
                <div class="input-field">
                    <input type="text" name="address" id="address" required>
                    <label for="address">Address</label>
                </div>
                <div class="input-field">
                    <input type="number" name="phone" id="phone" required>
                    <label for="phone">Phone Number</label>
                </div>
                <table class="highlight">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        while ($item = $cart_items->fetch_assoc()):
                            $final_price = $item['price'] - $item['discount'];
                            $total += $final_price;
                        ?>
                            <tr>
                                <td><?php echo $item['title']; ?></td>
                                <td><?php echo $item['author']; ?></td>
                                <td><?php echo $final_price; ?>$</td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="book_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" name="remove" class="btn red">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td id="finalcost"><?php echo $total; ?>$</td>
                            <td><button type="submit" name="checkout" class="btn green">Checkout</button></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
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