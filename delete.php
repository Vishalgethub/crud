<?php

include 'config.php';

$id = $_GET['id'];

$query = "DELETE FROM users WHERE id = '{$id}'";
$result = mysqli_query($conn, $query);

if ($result) {
    header('Location: http://localhost/crud/add.php');
}


?>