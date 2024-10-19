<?php
// Include your database configuration file
include 'config.php';

// Initialize a message variable for feedback
$message = "";
$message_type = "";

// Handle adding a new book
if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("INSERT INTO Books (title, author, price, description, stock, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsis", $title, $author, $price, $description, $stock, $image);
    if ($stmt->execute()) {
        $message = "Book added successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    $stmt->close();
}

// Handle updating a book
if (isset($_POST['update_book'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE Books SET title = ?, author = ?, price = ?, description = ?, stock = ?, image = ? WHERE book_id = ?");
    $stmt->bind_param("ssdsisi", $title, $author, $price, $description, $stock, $image, $book_id);
    if ($stmt->execute()) {
        $message = "Book updated successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    $stmt->close();
}

// Handle deleting a book
if (isset($_GET['delete_book'])) {
    $book_id = $_GET['delete_book'];
    $stmt = $conn->prepare("DELETE FROM Books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);
    if ($stmt->execute()) {
        $message = "Book deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_type = "danger";
    }
    $stmt->close();
}

// Fetch all books
$books = $conn->query("SELECT * FROM Books");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Books</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .fade-out {
            transition: opacity 0.5s ease-out;
            opacity: 1;
        }
        .fade-out.hidden {
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Admin - Manage Books</h1>

        <!-- Success/Error Message -->
        <?php if (!empty($message)): ?>
            <div id="message-box" class="alert alert-<?php echo $message_type; ?> fade-out">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add Book Form -->
        <h3>Add New Book</h3>
        <form action="admin.php" method="POST">
            <div class="form-group">
                <label for="title">Book Title:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" name="author" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" name="price" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" class="form-control" name="stock" required>
            </div>
            <div class="form-group">
                <label for="image">Image URL:</label>
                <input type="text" class="form-control" name="image">
            </div>
            <button type="submit" class="btn btn-success" name="add_book">Add Book</button>
        </form>

        <hr>

        <!-- Books Table -->
        <h3>Manage Existing Books</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $books->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['book_id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['author']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td><img src="<?php echo $row['image']; ?>" alt="Book Image" style="width: 50px;"></td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-primary" onclick="editBook(<?php echo $row['book_id']; ?>)">Edit</button>
                            <!-- Delete Button -->
                            <a href="admin.php?delete_book=<?php echo $row['book_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Edit Book Modal -->
        <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Book</h4>
                    </div>
                    <div class="modal-body">
                        <form action="admin.php" method="POST">
                            <input type="hidden" name="book_id" id="edit_book_id">
                            <div class="form-group">
                                <label for="edit_title">Book Title:</label>
                                <input type="text" class="form-control" name="title" id="edit_title" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_author">Author:</label>
                                <input type="text" class="form-control" name="author" id="edit_author" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_price">Price:</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="edit_price" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_description">Description:</label>
                                <textarea class="form-control" name="description" id="edit_description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_stock">Stock:</label>
                                <input type="number" class="form-control" name="stock" id="edit_stock" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_image">Image URL:</label>
                                <input type="text" class="form-control" name="image" id="edit_image">
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_book">Update Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hide success/error messages after 3 seconds
        setTimeout(function () {
            var messageBox = document.getElementById("message-box");
            if (messageBox) {
                messageBox.classList.add("hidden");
            }
        }, 3000);

        function editBook(book_id) {
            // Get the values from the table row and fill the modal inputs
            document.getElementById('edit_book_id').value = book_id;
            document.getElementById('edit_title').value = document.querySelector('tr[data-id="' + book_id + '"] td:nth-child(2)').innerText;
            document.getElementById('edit_author').value = document.querySelector('tr[data-id="' + book_id + '"] td:nth-child(3)').innerText;
            document.getElementById('edit_price').value = document.querySelector('tr[data-id="' + book_id + '"] td:nth-child(4)').innerText;
            document.getElementById('edit_description').value = document.querySelector('tr[data-id="' + book_id + '"] td:nth-child(5)').innerText;
            document.getElementById('edit_stock').value = document.querySelector('tr[data-id="' + book_id + '"] td:nth-child(6)').innerText;
            document.getElementById('edit_image').value = document.querySelector('tr[data-id="' + book_id + '"] td:nth-child(7)').innerText;

            // Show the modal
            $('#editModal').modal('show');
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
