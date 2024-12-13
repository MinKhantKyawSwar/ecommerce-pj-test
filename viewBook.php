<?php
require_once("dbconnect.php");

if (!isset($_SESSION)) {
    session_start();
}

$sql = "SELECT b.bookid, b.title, a.author_name as author, b.price, p.publisher_name as publisher, b.year, c.category_name as category,b.coverpath, b.quantity
            FROM book b, category c, author a, publisher p
            WHERE
            b.category = c.category_id AND
            b.author = a.author_id AND
            b.publisher = p.publisher_id;";
try {
    $stmt = $conn->query($sql);
    $status = $stmt->execute();
    if ($status) {
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
    } else {
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: cornflowerblue; color: white">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <?php
                    if (isset($_SESSION['adminLoginSuccess'])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" herf="adminLogout.php">Logout</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown link
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php
                if (isset($_SESSION["isLoggedIn"])) {
                ?>
                    <a class="nav-link" href="viewBook.php">View Books</a>
                    <a class="nav-link" href="viewAuthor.php">View Authors</a>
                    <a class="nav-link" href="viewPublisher.php">View Publisher</a>
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                <?php
                }
                ?>
            </div>
            <div class="col-md-10">
                <div class="pb-5">
                    <a href="insertbook.php" class="text-decoration-none bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Add New Book</a>
                </div>
                <p>
                    <?php
                    if (isset($_SESSION['deleteSuccess'])) {
                        echo "<span class='alert alert-success'>$_SESSION[deleteSuccess]</span>";
                        unset($_SESSION['deleteSuccess']);
                    }

                    if (isset($_SESSION['insertSuccess'])) {
                        echo "<span class='alert alert-success'>$_SESSION[insertSuccess]</span>";
                        unset($_SESSION['insertSuccess']);
                    }

                    if (isset($_SESSION['updateBookSuccess'])) {
                        echo "<span class='alert alert-success'>$_SESSION[updateBookSuccess]</span>";
                        unset($_SESSION['updateBookSuccess']);
                    }

                    if (isset($_SESSION['adminLoginSuccess'])) {
                        echo "<span class='alert alert-success'>$_SESSION[adminLoginSuccess]</span>";
                        unset($_SESSION['adminLoginSuccess']);
                    }
                    ?>
                </p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Book_id</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Year</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Coverpath</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($books) && ($_SESSION['isLoggedIn'])) {
                            foreach ($books as $book) {
                                echo "<tr>
                                        <td>$book[bookid]</td>
                                        <td>$book[title]</td>
                                        <td>$book[price]</td>
                                        <td>$book[year]</td>
                                        <td>$book[author]</td>
                                        <td>$book[publisher]</td>
                                        <td>$book[category]</td>
                                        <td>$book[quantity]</td>
                                        <td>
                                            <img src='$book[coverpath]' style='width: 50px; height: 80px;'>
                                        </td>
                                        <td><a href='editbook.php?bid=$book[bookid]' class='btn btn-info'>Edit </a></td>
                                        <td><a href='deletebook.php?bid=$book[bookid]' class='btn btn-danger'>Delete </a></td>
                                    </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>