<?php 
    $conn = mysqli_connect("localhost", "root", "", "chat");
    if(!$conn) {
        echo "Error" . mysqli_connect_error();
    }
?>