<html>
    <head>
        <title>Login</title>
    </head>
    <link rel = "stylesheet" href="../style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <body class="login">
        <div class='wrapper'> 
            <form action="login_process.php" method="post">
                
                <h1>Login</h1>

                <div class = "input-box">
                    <label>username:</label>
                    <input type="text" name="username" placeholder="Username" require><br><br>
                    <i class='bx bx-user' ></i> 
                </div>
                
                <div class = "input-box">
                    <label>password</label>
                    <input type="password" name="password" placeholder="Password" require><br><br>
                    <i class='bx bxs-lock-alt' ></i>
                </div>


                <input type="submit" value="Login" name="btnLogin">

                <div class="register-box">
                    <p>dont have account <a href="register.php">Register</a></p>
                <div>

            </form>
        </div>
    </body>
<html>