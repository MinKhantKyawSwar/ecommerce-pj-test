<?php
    require_once "dbconnect.php";

    if(!isset($_SESSION)){
        session_start();
    }

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
        $uploadPath = "covers/". $file_name;
        move_uploaded_file($_FILES['cover']['tmp_name'], $uploadPath);

        try{
            $sql = "INSERT INTO book (title, author, price, publisher, year, category, coverpath, quantity) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$title, $author, $price,  $publisher,  $year,  $categories,  $uploadPath, $quantity]);
    
            $book_id = $conn ->lastInsertId();
            if($status){
                $_SESSION['insertSuccess'] = "Book with book id $bookid has been inserted!";
                header("Location: viewBook.php");
            }
    
        }catch(PDOException){
            echo "Error Occurs";  
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
                <div class="navbar-nav ps-3">
                    <a class="nav-link"  href="viewBook.php">View Books</a>
                    <a class="nav-link" href="viewAuthor.php">View Authors</a>
                    <a class="nav-link" href="viewPublisher.php">View Publisher</a>
                    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </div>
            </div>
            <div class="col-md-10   ">
                <a href="insertbook.php" class="text-decoration-none bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Add New Book</a>
                <form method="POST" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']?>">
                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity">
                        </div>
                        <div class="mb-2 col-lg-4">
                            <label for="Category" class="form-label">Category</label>
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
                    </div>
                    
                    <div class="row">
                        <div  class="mb-3 col-lg-4">
                            <label for="Publisher" class="form-label">Publisher</label>
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
                        <div class="mb-3 col-lg-4">
                            <label for="Author" class="form-label">Author</label>
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
                    </div>
                   
                    
                   <div class="row">
                        <div  class="mb-3 col-lg-4">
                            <input type="number" name="year" id="year" placeholder="" required/>
                            <label for="year">Year</label>
                        </div>
                        <div  class="mb-3 col-lg-4">
                            <input type="file" name="cover" id="cover" placeholder="" required/>
                            <label for="cover">Book Cover</label>
                        </div>
                   </div>
                    <button type="submit" name="insert" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>