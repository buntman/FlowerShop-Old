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
        include "formValidator.php";
        include "authenticate.php";
        include "storeData.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sanitizedData = input($_POST);
            $validator = new formValidator($sanitizedData);
            try {
                $validator->validateRegister();
                $authenticateUser = new authenticate($sanitizedData, $connect);
                $authenticateUser->authenticateRegistration();
                $storeData = new store($sanitizedData, $connect);
                $storeData->save();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        function input($arrayData)
        {
            foreach ($arrayData as $key => $data) {
                $arrayData[$key] = htmlspecialchars(stripslashes(trim($data)));
            }
            return $arrayData;
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
