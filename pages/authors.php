<?php
// authors.php
require_once 'functions.php';

// Handle add, edit, delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addAuthor'])) {
        addAuthor($_POST['firstName'], $_POST['lastName']);
    }
    if (isset($_POST['deleteAuthor'])) {
        deleteAuthor($_POST['authorId']);
    }
    if (isset($_POST['editAuthor'])) {
        editAuthor($_POST['authorId'], $_POST['firstName'], $_POST['lastName']);
    }
}

$authors = getAuthors(isset($_POST['filter']) ? $_POST['filter'] : '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authors</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleEditForm(authorId) {
            const form = document.getElementById('edit-form-' + authorId);
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
    <h2>Authors</h2>

    <!-- Filter Form -->
    <form class="filter-form" method="POST">
        <input type="text" name="filter" placeholder="Filter authors by name or surname" value="<?= htmlspecialchars($_POST['filter'] ?? '') ?>">
        <button type="submit">Filter</button>
    </form>

    <!-- Authors Table -->
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Books</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?= htmlspecialchars($author['first_name']) ?></td>
                    <td><?= htmlspecialchars($author['last_name']) ?></td>
                    <td>
                        <?php 
                        $booksByAuthor = getBooksByAuthor($author['author_id']);
                        foreach ($booksByAuthor as $book): ?>
                            <p><?= htmlspecialchars($book['title']) ?></p>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <!-- Delete Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="authorId" value="<?= $author['author_id'] ?>">
                            <button class="delete-btn" type="submit" name="deleteAuthor">Delete</button>
                        </form>

                        <!-- Toggle Edit Form Button -->
                        <button onclick="toggleEditForm(<?= $author['author_id'] ?>)">Edit</button>

                        <!-- Edit Form (hidden by default) -->
                        <form id="edit-form-<?= $author['author_id'] ?>" method="POST" style="display:none;">
                            <input type="hidden" name="authorId" value="<?= $author['author_id'] ?>">
                            <label>First Name: <input type="text" name="firstName" value="<?= htmlspecialchars($author['first_name']) ?>" required></label>
                            <label>Last Name: <input type="text" name="lastName" value="<?= htmlspecialchars($author['last_name']) ?>" required></label>
                            <button type="submit" name="editAuthor">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Add a New Author</h3>

    <!-- Add Author Form -->
    <form class="add-form" method="POST">
        <label>
            First Name: <input type="text" name="firstName" required>
        </label>
        <label>
            Last Name: <input type="text" name="lastName" required>
        </label>
        <button type="submit" name="addAuthor">Add Author</button>
    </form>
</body>
</html>
