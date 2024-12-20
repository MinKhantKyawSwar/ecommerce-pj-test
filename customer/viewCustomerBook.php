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

try {
    $sql = "select * from category";
    $stmt = $conn->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "select * from publisher";
    $stmt = $conn->query($sql);
    $publisher = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "select * from author";
    $stmt = $conn->query($sql);
    $author = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST['ctySearch'])) {
    //selected id from user
    $id = $_POST['catgy'];
    try {
        $sql = "SELECT b.bookid, b.title, a.author_name as author, b.price, p.publisher_name as publisher, b.year, c.category_name as category,b.coverpath, b.quantity
        FROM book b, category c, author a, publisher p
        WHERE
        b.category = c.category_id AND
        b.author = a.author_id AND
        b.publisher = p.publisher_id AND
        c.category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['auSearch'])) {
    //selected id from user
    $id = $_POST['author'];

    try {
        $sql = "SELECT b.bookid, b.title, a.author_name as author, b.price, p.publisher_name as publisher, b.year, c.category_name as category,b.coverpath, b.quantity
        FROM book b, category c, author a, publisher p
        WHERE
        b.category = c.category_id AND
        b.author = a.author_id AND
        b.publisher = p.publisher_id AND
        a.author_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['pubSearch'])) {
    //selected id from user
    $id = $_POST['publisher'];

    try {
        $sql = "SELECT b.bookid, b.title, a.author_name as author, b.price, p.publisher_name as publisher, b.year, c.category_name as category,b.coverpath, b.quantity
        FROM book b, category c, author a, publisher p
        WHERE
        b.category = c.category_id AND
        b.author = a.author_id AND
        b.publisher = p.publisher_id AND
        p.publisher_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    //publisher select ends
}

if (isset($_POST['rSearch'])) {
    $priceRange = $_POST['priceRange'];
    try {
        $sql = "SELECT b.bookid, b.title, a.author_name as author, b.price, p.publisher_name as publisher, b.year, c.category_name as category,b.coverpath, b.quantity
        FROM book b, category c, author a, publisher p
        WHERE
        b.category = c.category_id AND
        b.author = a.author_id AND
        b.publisher = p.publisher_id AND
        b.price between ? and ?";
        $stmt =$conn->prepare($sql);
       
        if ($priceRange == 'third') {

            $stmt->execute([50, 100]);
        } elseif ($priceRange == 'second') {
            $stmt->execute([101, 150]);
        } else {
            $stmt->execute([151, 200]);
        }
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
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
                
            </div>
            <div class="col-md-10">
                <p>
                    <?php
                    if (isset($_SESSION['cLoginSuccess'])) {
                        echo "<span class='alert alert-success'>$_SESSION[cLoginSuccess]</span>";
                        unset($_SESSION['cLoginSuccess']);
                    } // if ends

                    if (isset($books)) {
                        echo "<div class='row'>";
                        foreach ($books as $book) {
                            echo "<div class='col-lg-2 col-md-6 col-sm-12 mb-4'>
                                    <div class='card h-100'>
                                        <img src='{$book['coverpath']}' class='card-img-top' alt='{$book['title']}'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>{$book['title']}</h5>
                                            <p class='card-text'><strong>Price:</strong> {$book['price']}</p>
                                            <p class='card-text'><strong>Author:</strong> {$book['author']}</p>
                                        </div>
                                    </div>
                                </div>";
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                    ?>
                </p>
            

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>