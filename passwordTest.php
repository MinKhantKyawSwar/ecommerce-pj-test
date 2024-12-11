<?php
    $hash_code = password_hash("Abc123!@#", PASSWORD_BCRYPT);
    echo $hash_code . "<br>";
    echo strlen($hash_code);
?>