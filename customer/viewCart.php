<?php
require_once "dbconnect.php";
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
    $cart = $_SESSION['cart'];
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $sql = "SELECT * FROM book WHERE bookid IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($cart);
    $books = $stmt->fetchAll();
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
                    <li>
                        <?php
                        if (isset($_SESSION['is_logged_in'])) {
                        ?>
                            <a href="clogout.php">Logout</a>

                            <div><?php echo $_SESSION['cemail'] ?></div>
                        <?php
                            if (isset($_SESSION['cart'])) {
                                echo "<a href='viewCart.php' class='btn btn-primary'>View Cart</a>";
                            }
                        } ?>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">

                <a class="nav-link" href="viewBook.php">View Books</a>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <p class="text-primary">Category</p>
                    <select name="catgy" class="mt-3 form-select">
                        <?php
                        foreach ($categories as $category) {
                            echo "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-outline-primary mt-4" name="ctySearch"> Search </button>
                </form>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <p class="text-primary">Author</p>
                    <select name="author" class="mt-3 form-select">
                        <?php
                        foreach ($author as $au) {
                            echo "<option value='" . $au['author_id'] . "'>" . $au['author_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-outline-primary mt-4" name="auSearch"> Search </button>
                </form>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <p class="text-primary">publisher</p>
                    <select name="publisher" class="mt-3 form-select">
                        <?php
                        foreach ($publisher as $pu) {
                            echo "<option value='" . $pu['publisher_id'] . "'>" . $pu['publisher_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-outline-primary mt-4" name="pubSearch"> Search </button>
                </form>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div>
                        <input type="radio" name="priceRange" value="third" class="form-check-input">
                        <span for="third" class="form-check-span">$50 - $100</span></br>
                    </div>
                    <div>
                        <input type="radio" name="priceRange" value="second" class="form-check-input">
                        <span for="second" class="form-check-span">$101 - $150</span></br>
                    </div>
                    <div>
                        <input type="radio" name="priceRange" value="first" class="form-check-input">
                        <span for="first" class="form-check-span">$151 - $200</span></br>
                    </div>
                    <button type="submit" class="btn btn-outline-primary" name="rSearch"> Search </button>
                </form>

            </div>


            <div class="col-md-10">
                <p>
                    <?php
                    if (isset($_SESSION['cLoginSuccess'])) {
                        echo "<span class='alert alert-success'>$_SESSION[cLoginSuccess]</span>";
                        unset($_SESSION['cLoginSuccess']);
                    } // if ends

                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        $cart = $_SESSION['cart'];
                        foreach ($cart as $id) {
                            echo "$id<br>";
                        }
                    }

                    echo "</div>";
                    ?>
                </p>
            </div>
            <div class="col-md-10">
                <?php if (!empty($books)) : ?>
                    <h3>Books in Your Cart</h3>
                    <ul>
                        <?php foreach ($books as $book) : ?>
                            <li><?php echo htmlspecialchars($book['title']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>