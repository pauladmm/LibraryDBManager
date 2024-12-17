<?php
// books.php
require_once 'functions.php';

// Handle add, edit, delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addBook'])) {
        addBook($_POST['title'], $_POST['category'], $_POST['authorId'], $_POST['description']);
    }
    if (isset($_POST['deleteBook'])) {
        deleteBook($_POST['bookId']);
    }
    if (isset($_POST['editBook'])) {
        editBook($_POST['bookId'], $_POST['title'], $_POST['category'], $_POST['authorId'], $_POST['description']);
    }
}

$books = getBooks(isset($_POST['filter']) ? $_POST['filter'] : '');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="styles.css"> 
    <script>
        function toggleEditForm(bookId) {
            const form = document.getElementById('edit-form-' + bookId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
<nav>
      <ul>
        <li><a href="books.php">Books</a></li>
        <li><a href="authors.php">Authors</a></li>
        <li><a href="users.php">Users</a></li>
      </ul>
    </nav>
    <h2>Books</h2>

    <!-- Filter Form -->
    <form class="filter-form" method="POST">
        <input type="text" name="filter" placeholder="Filter books by title" value="<?= htmlspecialchars($_POST['filter'] ?? '') ?>">
        <button type="submit">Filter</button>
    </form>

    <!-- Books Table -->
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Description</th>
                
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['category']) ?></td>
                    <td><?= getBooksByAuthorId((string)$book['author_id']) ?></td>                     
                   </td>
                    <td><?= htmlspecialchars($book['description']) ?></td>
                    
                    <td>
                        <!-- Delete Form -->
                        <form  method="POST" style="display:inline;">
                            <input type="hidden" name="bookId" value="<?= $book['book_id'] ?>">
                            <button class="delete-btn" type="submit" name="deleteBook">Delete</button>
                        </form>

                        <!-- Toggle Edit Form Button -->
                        <button onclick="toggleEditForm(<?= $book['book_id'] ?>)">Edit</button>

                        <!-- Edit Form (hidden by default) -->
                        <form id="edit-form-<?= $book['book_id'] ?>" method="POST" style="display:none;">
                            <input type="hidden" name="bookId" value="<?= $book['book_id'] ?>">
                            <label>Title: <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required></label>
                            <label>Category: <input type="text" name="category" value="<?= htmlspecialchars($book['category']) ?>" required></label>
                            <label>Author ID: <input type="text" name="authorId" value="<?= htmlspecialchars($book['author_id']) ?>" required></label>
                            <label>Description: <input type="text" name="description" value="<?= htmlspecialchars($book['description']) ?>" required></label>
                            <button type="submit" name="editBook">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Add a New Book</h3>

    <!-- Add Book Form -->
    <form class="add-form" method="POST">
        <label>
            Title: <input type="text" name="title" required>
        </label>
        <label>
            Category: <input type="text" name="category" required>
        </label>
        <label>
            Author ID: <input type="number" name="authorId" required>
        </label>
        <label>
            Description: <input type="text" name="description" required>
        </label>
        <button type="submit" name="addBook">Add Book</button>
    </form>
</body>
</html>
