<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
         <link rel="stylesheet" href="/css/register-style.css">
<title>Register</title>
</head>
<body>

<?php
    include "connectMysql.php";

if (isset($_POST['register'])) {
    $emp_user = $_POST['username'];
    $emp_pass = $_POST['password'];

    $encrypted_pass = password_hash($emp_pass, PASSWORD_DEFAULT);


    $sql = "INSERT INTO Employees(username,password) VALUES(?, ?)";
    $sql_statement = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($sql_statement, 'ss', $emp_user, $encrypted_pass);

    if (mysqli_stmt_execute($sql_statement)) {
        echo "Created successfully";
        header("Location: home.php");
    }
}
?>
        <h1>
            Rizza's Flower Shop
        </h1>
        <div class="main-container">
        <form class="form" action="#" method="POST">
        <h2>System Registration</h2>
        <p>Please enter your credentials below to continue</p>
        <div class="form-container">
            <label for="username"></label><br>
            <input type="text" id="username" placeholder="Username" name="username">
        </div>
        <div class="form-container">
            <label for="password"></label><br>
            <input type="password" id="password" placeholder="Password" name="password">
        </div>
        <div class="button-container">
            <button type="submit" name="register" value="register">Sign up</button>
        </div>
        <div class="form-login">
                    <p> 
                    Already have an account?
    <a href="login.php" class="login">Login</a>
                    </p>
         </div>
        </form>
        </div>
</body>
</html> 
