<?php
// users.php
require_once 'functions.php';

// Handle add, edit, delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addUser'])) {
        addUser($_POST['username'], $_POST['password'], $_POST['phone'], $_POST['returnDate']);
    }
    if (isset($_POST['deleteUser'])) {
        deleteUser($_POST['userId']);
    }
    if (isset($_POST['editUser'])) {
        editUser($_POST['userId'], $_POST['username'], $_POST['phone']);
    }
}

$users = getUsers(isset($_POST['filter']) ? $_POST['filter'] : '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleEditForm(userId) {
            const form = document.getElementById('edit-form-' + userId);
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
    <h2>Users</h2>

    <!-- Filter Form -->
    <form class="filter-form" method="POST">
        <input type="text" name="filter" placeholder="Filter users by name or email" value="<?= htmlspecialchars($_POST['filter'] ?? '') ?>">
        <button type="submit">Filter</button>
    </form>

    <!-- Users Table -->
    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Phone</th>
                <th>Books</th>
                <th>Last Return Date</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td>
                        <ul>
                            <?php foreach (getLastBooksByUser($user['user_id']) as $book): ?>
                                <li><?= htmlspecialchars($book['title']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td><?= htmlspecialchars($user['return_date']) ?></td>
                    
                    <td>
                        
                        <!-- Delete Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="userId" value="<?= $user['user_id'] ?>">
                            <button class="delete-btn" type="submit" name="deleteUser">Delete</button>
                        </form>

                        <!-- Toggle Edit Form Button -->
                        <button onclick="toggleEditForm(<?= $user['user_id'] ?>)">Edit</button>

                        <!-- Edit Form (hidden by default) -->
                        <form id="edit-form-<?= $user['user_id'] ?>" method="POST" style="display:none;">
                            <input type="hidden" name="userId" value="<?= $user['user_id'] ?>">
                            <label>Username: <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required></label>
                            <label>Phone: <input type="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required></label>
                            <label>Password: <input type="text" name="passwd" value="<?= htmlspecialchars($user['password']) ?>" required></label>
                            <button type="submit" name="editUser">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Add a New User</h3>

    <!-- Add User Form -->
    <form class="add-form" method="POST">
        <label>
            Username: <input type="text" name="username" required>
        </label>
        <label>
            Phone: <input type="phone" name="phone" required>
        </label>
        <label>
            Password: <input type="password" name="password" required>
        </label>
        <button type="submit" name="addUser">Add User</button>
    </form>
</body>
</html>
