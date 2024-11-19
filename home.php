<?php
    require_once("dbconnect.php");
    $sql = "SELECT * FROM customer where income>=3000 order by income desc limit 20";
try{
    $stmt = $conn->query($sql);
    $status = $stmt->execute();
    if ($status) {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
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
            <div class="col-md-2">Some links</div>
            <div class="col-md-10">
                <table class="table table-striped table-danger">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gender</th>
                            <th>Income</th>
                            <th>Martial Stat</th>
                            <th>Numbers of Vehicles</th>
                            <th>Age</th>
                            <th>State</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($rows)){
                                foreach($rows as $row){
                                    echo "<tr>
                                        <td>$row[custid]</td>
                                        <td>$row[sex]</td>
                                        <td>$row[income]</td>
                                        <td>$row[marital_stats]</td>
                                        <td>$row[num_vehicles]</td>
                                        <td>$row[age]</td>
                                        <td>$row[state]</td>
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
