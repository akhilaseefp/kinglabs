<?php
include('config.php');

$id = $_GET["id"];

$sql = "SELECT * FROM products WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) 
{
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) 
    {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) 
        {
            $row = mysqli_fetch_assoc($result);
            $name = $row["name"];
            $price = $row["price"];
        } 
        else 
        {
            echo "Error fetching data.";
            exit();
        }
    } 
    else 
    {
        echo "Error fetching data.";
        exit();
    }
    mysqli_stmt_close($stmt);
} 
else 
{
    echo "Error statement.";
    exit();
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">View Product</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <p class="form-control-static"><?php echo $name; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <p class="form-control-static"><?php echo $price; ?></p>
                        </div>
                        <p><a href="index.php" class="btn btn-primary">Back</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
