<?php
include('config.php');

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) 
{
    header("location: dashboard.php");
    exit;
}
$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (empty(trim($_POST["email"]))) 
    {
        $email_err = "Please enter email.";
    } else 
    {
        $email = trim($_POST["email"]);
    }
    if (empty(trim($_POST["password"]))) 
    {
        $password_err = "Please enter your password.";
    } 
    else 
    {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) 
    {
        $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) 
        {
            mysqli_stmt_bind_param($stmt, "s", $email);
            if (mysqli_stmt_execute($stmt)) 
            {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) 
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) 
                    {
                        if (password_verify($password, $hashed_password)) 
                        {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;

                            header("location: dashboard.php");
                        } 
                        else 
                        {
                            $login_err = "Invalid email or password.";
                        }
                    }
                } 
                else 
                {
                    $login_err = "Invalid email or password.";
                }
            } 
            else 
            {
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <?php
                        if (!empty($login_err)) {
                            echo '<div class="alert alert-danger">' . $login_err . '</div>';
                        }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                                <span class="help-block text-danger"><?php echo $email_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control">
                                <span class="help-block text-danger"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Login">
                            </div>
                            <p>Don't have an account? <a href="index.php">Sign up now</a>.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
