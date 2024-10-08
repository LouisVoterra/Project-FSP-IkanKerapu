<html>
    <head>
        <title>Login</title>
    </head>
    <link rel = "stylesheet" href="../style.css">
    <body class="login">
        <div class='wrapper'> 
            <form action="login_process.php" method="post">
                
                <h1>Login</h1>

                <div class = "input-box">
                    <label>username:</label>
                    <input type="text" name="username" placeholder="Username" require><br><br>
                </div>
                
                <div class = "input-box">
                    <label>password</label>
                    <input type="password" name="password" placeholder="Password" require><br><br>
                </div>


                <input type="submit" value="Login" name="btnLogin">

                <div class="register-box">
                    <p>dont have account <a href="register.php">Register</a></p>
                <div>

            </form>
        </div>
    </body>
<html>