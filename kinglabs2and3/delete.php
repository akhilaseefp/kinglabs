<?php
include('config.php');

if (isset($_GET["id"]) && !empty($_GET["id"])) 
{
    $sql = "DELETE FROM products WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) 
    {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $id = trim($_GET["id"]);
        if (mysqli_stmt_execute($stmt)) 
        {
            header("location: index.php");
            exit();
        } 
        else
        {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
} 
else 
{
    if (empty(trim($_GET["id"]))) 
    {
        header("location: error.php");
        exit();
    }
}

mysqli_close($link);
?>
