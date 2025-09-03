<?php
    $dbhost = '127.0.0.1';
    $dbuser = 'root';
    $dbpass = 'Maddineni@1234';
    $dbname = "Agriculture";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if($conn->connect_errno ) {
        printf("Connect failed: %s<br />", $conn->connect_error);
        exit();
    }
?> 