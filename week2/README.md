## you have the files create s server with xammpp and make database her the query for the databas

## and the password for everything is password usernames seller and buyer

CREATE DATABASE bookstore_db;
USE bookstore_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    role ENUM('buyer', 'seller') DEFAULT 'buyer'
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    author VARCHAR(100),
    price DECIMAL(10,2),
    discount DECIMAL(10,2) DEFAULT 0,
    image VARCHAR(255),
    seller_id INT,
    FOREIGN KEY (seller_id) REFERENCES users(id)
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT,
    book_id INT,
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT,
    book_id INT,
    name VARCHAR(100),
    address VARCHAR(255),
    phone VARCHAR(20),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Initial Data
INSERT INTO users (username, password, role) VALUES
('seller', '$2y$10$0HXMDa5RVnGULKBq4Uw6FObFYiP93jQsjcZGOaLo5C5NTbxu/Eh2S', 'seller'),
('buyer', '$2y$10$0HXMDa5RVnGULKBq4Uw6FObFYiP93jQsjcZGOaLo5C5NTbxu/Eh2S', 'buyer');

INSERT INTO books (title, author, price, discount, image, seller_id) VALUES
('Test Book', 'Test Author', 20.00, 5.00, 'book.jpg', 1);
