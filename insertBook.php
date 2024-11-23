<?php
    require_once "dbconnect.php";
    try{
        $sql = "select * from category";
        $stmt = $conn->query($sql);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $sql = "select * from publisher";
        $stmt = $conn->query($sql);
        $publisher = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "select * from author";
        $stmt = $conn->query($sql);
        $author= $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){  
        echo $e->getMessage();
    }

    if (isset($_POST['insert'])) {
        $title = $_POST['title'];
        $categories = $_POST['category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $author = $_POST['author'];
        $publisher = $_POST['publisher'];
        $year = $_POST['year'];

        $file_name = $_FILES['cover']['name'];
        // $tempname = $_FILES['cover']['tmp_name'];
        $folder = "covers/". $file_name;
        move_uploaded_file($_FILES['cover']['tmp_name'], $folder);

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
            <div class="col-md-2">Some links</div>
            <div class="col-md-10">
                <a href="insertbook.php">Add New Book</a>
                <form method="POST" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity">
                    </div>
                    <div>
                        <select class="form-select" name="category">
                            <option selected>Open this select menu</option>
                            <?php
                            if(isset($categories)){
                                foreach($categories as $category){
                                echo "<option value=$category[category_id]>$category[category_name]</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select class="form-select" name="publisher" id="publisher">
                            <option disable selected>Select Publisher</option>
                            <?php
                            if(isset($publisher)){
                                foreach($publisher as $publishers){
                                echo "<option value=$publishers[publisher_id]>$publishers[publisher_name]</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <select class="form-select" name="author" id="author">
                            <option disable selected>Select author</option>
                            <?php
                            if(isset($author)){
                                foreach($author as $authors){
                                echo "<option value=$authors[author_id]>$authors[author_name]</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="year" id="year" placeholder="" required/>
                        <label for="year">Year</label>
                    </div>
                    <div>
                        <input type="file" name="cover" id="cover" placeholder="" required/>
                        <label for="cover">Book Cover</label>
                    </div>
                    <button type="submit" name="insert" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>