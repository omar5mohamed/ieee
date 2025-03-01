<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: index.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$sql = "SELECT * FROM books WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$books = $stmt->get_result();

$orders_sql = "SELECT b.title, b.price, b.discount, b.image, o.name, o.address, o.phone, o.order_date 
               FROM orders o JOIN books b ON o.book_id = b.id WHERE b.seller_id = ?";
$orders_stmt = $conn->prepare($orders_sql);
$orders_stmt->bind_param("i", $seller_id);
$orders_stmt->execute();
$orders = $orders_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .bookadd { padding: 50px; }
        .footer { padding: 20px 0; background-color: #1a237e; color: #fff; text-align: center; }
        .admin-table { margin-top: 40px; }
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

    <div class="container center-align">
        <h2>Seller Portal</h2>
    </div>

    <div class="card-panel bookadd">
        <h5>Add a New Book</h5>
        <form method="POST" action="add_book.php" enctype="multipart/form-data">
            <div class="input-field">
                <input type="text" name="title" id="title" required>
                <label for="title">Book Title</label>
            </div>
            <div class="input-field">
                <input type="text" name="author" id="author" required>
                <label for="author">Author</label>
            </div>
            <div class="input-field">
                <input type="number" step="0.01" name="price" id="price" required>
                <label for="price">Price ($)</label>
            </div>
            <div class="input-field">
                <input type="number" step="0.01" name="discount" id="discount" value="0">
                <label for="discount">Discount ($)</label>
            </div>
            <div class="input-field">
                <input type="file" name="image" id="image" accept="image/*" required>
                <label for="image">Book Image</label>
            </div>
            <button type="submit" class="btn indigo accent-3">Add Book</button>
        </form>
    </div>

    <div class="admin-table card-panel">
        <h5>Your Books</h5>
        <table class="highlight">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Final Price</th>
                    <th>Image</th>
                    <th>Settings</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($book = $books->fetch_assoc()): ?>
                    <?php $final_price = $book['price'] - $book['discount']; ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['author']; ?></td>
                        <td><?php echo $book['price']; ?>$</td>
                        <td><?php echo $book['discount']; ?>$</td>
                        <td><?php echo $final_price; ?>$</td>
                        <td><img src="uploads/<?php echo $book['image']; ?>" style="max-width: 50px;"></td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn indigo accent-3">Edit</a>
                            <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="btn red" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h5>Completed Orders</h5>
        <table class="highlight">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Final Price</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <?php $final_price = $order['price'] - $order['discount']; ?>
                    <tr>
                        <td><?php echo $order['title']; ?></td>
                        <td><?php echo $final_price; ?>$</td>
                        <td><?php echo $order['name']; ?></td>
                        <td><?php echo $order['address']; ?></td>
                        <td><?php echo $order['phone']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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