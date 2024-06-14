<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) 
{
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <h3>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h3>
                        <p>
                            <a href="logout.php" class="btn btn-danger">Logout</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
