<?php
include('config.php');
include('functions.php');

generate_csrf_token();

$name = $price = "";
$name_err = $price_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (empty(trim($_POST["name"]))) 
    {
        $name_err = "Please enter a product name.";
    } 
    else 
    {
        $name = trim($_POST["name"]);
    }
    if (!validate_csrf_token($_POST['csrf_token'])) 
    {
        die("CSRF token validation failed.");
    }

    if (empty(trim($_POST["price"]))) 
    {
        $price_err = "Please enter a price.";
    } 
    elseif (!is_numeric($_POST["price"])) 
    {
        $price_err = "Please enter a valid price.";
    } 
    else 
    {
        $price = trim($_POST["price"]);
    }

    if (empty($name_err) && empty($price_err)) 
    {
        $sql = "INSERT INTO products (name, price) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) 
        {
            mysqli_stmt_bind_param($stmt, "sd", $param_name, $param_price);

            $param_name = $name;
            $param_price = $price;

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

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Add Product</div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                                <span class="help-block text-danger"><?php echo $name_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                                <label>Price</label>
                                <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                                <span class="help-block text-danger"><?php echo $price_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
