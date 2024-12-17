<?php

require_once 'config.php';

// Get all books
function getBooks($filter = '') {
    global $pdo;
    $query = "SELECT * FROM books";
    if ($filter) {
        $query .= " WHERE title LIKE :filter";
    }
    $stmt = $pdo->prepare($query);
    if ($filter) {
        $stmt->bindValue(':filter', "%$filter%");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all authors
function getAuthors($filter = '') {
    global $pdo;
    $query = "SELECT * FROM authors";
    if ($filter) {
        $query .= " WHERE first_name LIKE :filter OR last_name LIKE :filter";
    }
    $stmt = $pdo->prepare($query);
    if ($filter) {
        $stmt->bindValue(':filter', "%$filter%");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all users
function getUsers($filter = '') {
    global $pdo;
    $query = "SELECT * FROM USERS";
    if ($filter) {
        $query .= " WHERE username LIKE :filter";
    }
    $stmt = $pdo->prepare($query);
    if ($filter) {
        $stmt->bindValue(':filter', "%$filter%");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Add a new book
function addBook($title, $category, $authorId, $description) {
    global $pdo;
    $query = "INSERT INTO books (title, category, author_id, description) VALUES (:title, :category, :authorId, :description)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':category' => $category,
        ':authorId' => $authorId,
        ':description' => $description
    ]);
}

// Delete a book
function deleteBook($id) {
    global $pdo;
    $query = "DELETE FROM books WHERE book_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
}

// Edit a book
function editBook($id, $title, $category, $authorId, $description) {
    global $pdo;
    $query = "UPDATE books SET title = :title, category = :category, author_id = :authorId, description = :description WHERE book_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':category' => $category,
        ':authorId' => $authorId,
        ':description' => $description
    ]);
}


// Get books by a specific author
function getBooksByAuthor($authorId) {
    global $pdo;
    $query = "SELECT * FROM BOOKS WHERE author_id = :authorId";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':authorId', $authorId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get books by a specific user, last and current
function getLastBooksByUser($userId) {
    global $pdo;
    $query = "SELECT b.book_id, b.title, a.return_date
              FROM rentals a
              JOIN books b ON a.book_id = b.book_id
              WHERE a.user_id = :userId"; 
    $stmt = $pdo->prepare($query);
    $stmt->execute([':userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getBooksByUser($userId) {
    global $pdo;
    $query = "SELECT b.book_id, b.title, a.return_date
              FROM rentals a
              JOIN books b ON a.book_id = b.book_id
              WHERE a.user_id = :userId AND a.return_date IS NULL"; 
    $stmt = $pdo->prepare($query);
    $stmt->execute([':userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Add a new user
function addUser($username, $password, $phone, $returnDate=null) {
    global $pdo;
    $query = "INSERT INTO users (username, password, phone, return_date)
              VALUES (:username, :password, :phone, :returnDate)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password,
        ':phone' => $phone,
        ':returnDate' => $returnDate
    ]);
}

// Delete a user
function deleteUser($userId) {
    global $pdo;
    $query = "DELETE FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':userId' => $userId]);
}

// Edit an existing user
function editUser($userId, $username, $phone, $returnDate = null) {
    global $pdo;
    $query = "UPDATE users SET username = :username, phone = :phone, return_date = :returnDate WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':username' => $username,
        ':phone' => $phone,
        ':returnDate' => $returnDate,
        ':id' => $userId
    ]);
}





 // Get User by Id

 function getUserById($userId) {
    global $pdo;
    $query = "SELECT * FROM users WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $userId]);
    return $stmt->fetch();
}

// Add new author
function addAuthor($firstName, $lastName) {
    global $pdo;
    $query = "INSERT INTO authors (first_name, last_name) VALUES (:firstName, :lastName)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName
    ]);
}

// Delete author
function deleteAuthor($authorId) {
    global $pdo;
    $query = "DELETE FROM authors WHERE author_id = :authorId";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':authorId' => $authorId]);
}

// Edit existing author
function editAuthor($authorId, $firstName, $lastName) {
    global $pdo;
    $query = "UPDATE authors SET first_name = :firstName, last_name = :lastName WHERE author_id = :authorId";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':authorId' => $authorId
    ]);
}

// Obtener el autor del libro segun su id
function getBooksByAuthorId($authorId) {
    global $pdo;
    $query = "SELECT first_name, last_name FROM authors WHERE author_id = :authorId";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':authorId' => $authorId]);
    $author = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($author) {
        return $author['first_name'] . ' ' . $author['last_name'];
    }

    return 'Unknown Author'; // Si no se encuentra el autor
}



?>

