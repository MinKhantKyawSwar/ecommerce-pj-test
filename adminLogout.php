<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if($_SESSION['isLogginedIn']){
        session_destroy();
        header("Location: adminLogin.php");
    }
?>