# LibraryDBManager

A simple interface for managing a library database using PHP and phpMyAdmin. This project allows users to efficiently manage books, authors, and users with options to create, edit, delete, update, and filter records.

## Features

- **User management**: Add, edit, delete, and filter users.
- **Book management**: Register new books, update information, delete records, and search using filters.
- **Author management**: Add new authors, edit their details, and delete records.
- **Full CRUD functionality**: Create, read, update, and delete operations for all modules.
- **Dynamic filters**: Search for specific information in the database.

## Prerequisites

1. A local server such as [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/).
2. PHP 7.4 or higher.
3. MySQL database configured with phpMyAdmin.
4. A web browser compatible with HTML5 and CSS3.

## Installation

1. Clone this repository into your local server:

   ```bash
   git clone https://github.com/yourusername/LibraryDBManager.git
   ```

2. Import the database from the included SQL file in /db/:

- Open phpMyAdmin.
- Create a new database (e.g., library).
- Import the library.sql file from the /db folder.

3. Configure the database connection in the config.php file:

```bash
<?php
$host = "localhost";
$user = "root"; // Change if your username is different
$password = ""; // Change if you have a password
$database = "library";
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

4. Open your browser and navigate to:

```bash
http://localhost/LibraryDBManager

```

## Usage

Navigate through the Users, Books, and Authors sections using the navigation bar. Perform actions such as:

- Add new records.
- Edit existing information.
- Delete records.
- Search using filters.

## Contributing

Feel free to fork this repository and submit pull requests to improve the functionality or fix issues.
