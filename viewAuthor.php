<?php
    require_once("dbconnect.php");
    if(!isset($_SESSION)){
        session_start();
    }

    $sql = "SELECT * FROM author";
    try{
        $stmt = $conn->query($sql);
        $status = $stmt->execute();
        if ($status) {
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($authors);
        }
        else {
        }
    }catch(PDOException $e) {
        echo $e ->getMessage();
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
                <a class="nav-link"  href="viewBook.php">View Books</a>
                <a class="nav-link" href="viewAuthor.php">View Authors</a>
                <a class="nav-link" href="viewPublisher.php">View Publisher</a>
                <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </div>
            <div class="col-md-10">
                <div class="pb-5">
                    <a href="insertAuthor.php" class="text-decoration-none bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Add New Author</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Author_id</th>
                            <th>Author_Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>City</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($authors)){
                                foreach($authors as $author){
                                    echo "<tr>
                                        <td>$author[author_id]</td>
                                        <td>$author[author_name]</td>
                                        <td>$author[email]</td>
                                        <td>$author[address]</td>
                                        <td>$author[city]</td>
                                        <td><a href='editAuthor.php?bid=$author[author_id]' class='btn btn-info'>Edit </a></td>
                                        <td><a href='deleteAuthor.php?bid=$author[author_id]' class='btn btn-danger'>Delete </a></td>
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
