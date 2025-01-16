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
        $userError = $passError = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $emp_user = input($_POST['username']);
            if (empty($_POST['username'])) {
                $userError = "Username is required!";
            } elseif (!preg_match("/^[a-zA-Z]*$/", $emp_user)) {
                $userError = "Only letters are allowed";
            } elseif (strlen($_POST['username']) < 6 || strlen($_POST['username']) > 12) {
                $userError = "Username must be 6-12 characters long.";
            }

            $emp_pass = input($_POST['password']);
            if (empty($_POST['password'])) {
                $passError = "Password is required!";
            } elseif (!preg_match('/([a-z]{1,})/', $emp_pass)) {
                $passError = "Password must have one lowercase letter!";
            } elseif (!preg_match('/([A-Z]{1,})/', $emp_pass)) {
                $passError = "Password must have one uppercase letter!";
            } elseif (!preg_match('/([\d]{1,})/', $emp_pass)) {
                $passError = "Password must have one digit!";
            } elseif (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 16) {
                $passError = "Password must be 8-16 characters long.";
            }

            if (empty($userError) && empty($passError)) {
                $encrypted_pass = password_hash($emp_pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO Employees(username,password) VALUES(?, ?)";
                $sql_statement = mysqli_prepare($connect, $sql);
                mysqli_stmt_bind_param($sql_statement, 'ss', $emp_user, $encrypted_pass);
                if (mysqli_stmt_execute($sql_statement)) {
                    header("Location: home.php");
                }
            }
        }

        function input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>
        <h1>
            Rizza's Flower Shop
        </h1>
        <div class="main-container">
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <h2>System Registration</h2>
        <p>Please enter your credentials below to continue</p>
        <div class="form-container">
            <label for="username"></label><br>
            <input type="text" id="username" placeholder="Username" name="username">
            <span class="error">  <?php echo $userError;?> </span>
        </div>
        <div class="form-container">
            <label for="password"></label><br>
            <input type="password" id="password" placeholder="Password" name="password">
            <span class="error">  <?php echo $passError;?> </span>
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
