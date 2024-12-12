<?php
require_once "dbconnect.php";

if (!isset($_SESSION)) {
    session_start();
}

function ispasswordstrong($password)
{
    if (strlen($password) < 8) {
        return false;
    } elseif (isstrong($password)) {
        return true;
    } else
        return false;
}

function isstrong($password)
{
    $digitcount = 0;
    $capitalcount = 0;
    $speccount = 0;
    $lowercount = 0;
    foreach (str_split($password) as $char) {
        if (is_numeric($char)) {
            $digitcount++;
        } elseif (ctype_upper($char)) {
            $capitalcount++;
        } elseif (ctype_lower($char)) {
            $lowercount++;
        } elseif (ctype_punct($char)) {
            $speccount++;
        }
    }

    if ($digitcount >= 1 && $capitalcount >= 1 && $speccount >= 1) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['signup']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $file_name = $_FILES['profile']['name'];
    // $tempname = $_FILES['cover']['tmp_name'];
    $uploadPath = "profile/" . $file_name;

    if ($password == $cpassword) {
        if (ispasswordstrong($password)) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            move_uploaded_file($_FILES['profile']['tmp_name'], $uploadPath);

            try {
                $sql = "INSERT INTO customer2 (username, email, password, profile) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$username, $email, $password_hash, $uploadPath]);

                if ($status) {
                    $_SESSION['signUpSuccess'] = "Signup success!";
                    header("Location: customerLogin.php");
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            $password_err = "Password must contain at least 8 characters, 1 digit, 1 capital letter, 1 special character.";
        }
    } else {
        $password_err = "Password must be at least 8 characters long.";
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
            <div class="col-md-10">
                <h4 class="p-20">Sign Up</h4>
                <!-- <a href="insertbook.php" class="text-decoration-none bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Add New Book</a> -->
                <form method="POST" enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="Name">
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <p>
                                <?php if(isset($password_err)){
                                    echo "<span class='alert alert-danger'>$password_err</span>";
                                } ?>
                            </p>
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label for="cpassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="cpassword">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <input type="file" name="profile" id="profile" placeholder="" required />
                            <label for="profile">Select Your Profile</label>
                        </div>
                    </div>
                    <button type="submit" name="signup" class="btn btn-primary text-sm">Signup</button>
                    <p>
                    If you are already a member, you can
                    <a href="customerLogin.php">
                        Login
                    </a>
                    here
                </p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>