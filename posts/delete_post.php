<?php
require("../config.php");

if (isset($_GET['id'])){
    $id = $_GET['id'];
    
    $sql = "DELETE FROM posts WHERE id=$id";
    
    mysqli_query($conn, $sql);

    header("Location: ../index.php");
    exit();
}
?>