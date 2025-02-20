<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/register-style.css">
<title>Register</title>
</head>
<body>
        <h1>
            Rizza's Flower Shop
        </h1>
        <div class="main-container">
        <form class="form" action="/register" method="POST">
        <h2>System Registration</h2>
        <p>Please enter your credentials below to continue</p>
        <div class="form-container">
            <label for="username"></label><br>
            <input type="text" id="username" placeholder="Username" name="username">
                    <span class="errors"> <?php echo $errors['username'] ?? ''; ?> </span>
        </div>
        <div class="form-container">
            <label for="password"></label><br>
            <input type="password" id="password" placeholder="Password" name="password">
                    <span class="errors"> <?php echo $errors['password'] ?? ''; ?> </span>
        </div>
        <div class="button-container">
            <button type="submit" name="register" value="register">Sign up</button>
        </div>
        <div class="form-login">
                    <p> 
                    Already have an account?
    <a href="/login" class="login">Login</a>
                    </p>
         </div>
        </form>
        </div>
</body>
</html> 
