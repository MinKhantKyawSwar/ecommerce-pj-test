<?php
    include("dbconnect.php");  

    try {
    $sql = $conn->query("SELECT * FROM customer WHERE income >= 10000");
    // 2 $sql = $conn->query( "SELECT * FROM customer WHERE state = 'Florida'");
    // 3 $sql = $conn->query("SELECT * FROM customer WHERE num_vehicles > 1");
    // 4 $sql = $conn->query("SELECT * FROM customer WHERE sex = 'M'");
    
        while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo "<br><br>" . $row["custid"] . " ";
            echo $row["sex"] . " ";
            echo $row["income"] . " ";
            echo $row["martial_stat"] . " ";
            echo $row["num_vehicles"] . " ";
            echo $row["age"] . " ";
            echo $row["state"] . " ";
        }
    } catch (PDOException $e) {
        echo $e->getMessage() ."";
    }
?>



<!-- Write the following queries on customer table.
show customers whose incomes are greater than or equal to 100000.
show customers whose living state is Florida.
show customers whose number of vehicle owned is greater than 1.
show customers who are Male. -->