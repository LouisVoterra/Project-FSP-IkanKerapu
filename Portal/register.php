<html>
    <head>
        <title>Login</title>
    </head>
    <link rel = "stylesheet" href="../style.css">
    <body class="login">
        <div class='wrapper'> 
            <form action="register_process.php" method="post">
                
                <h1>Registration</h1>

                <div class = "input-box">
                    <label>first name:</label>
                    <input type="text" name="fname" placeholder="First Name" require><br><br>
                </div>

                <div class = "input-box">
                    <label>last name:</label>
                    <input type="text" name="lname" placeholder="Last Name" require><br><br>
                </div>

                <div class = "input-box">
                    <label>username:</label>
                    <input type="text" name="username" placeholder="Username" require><br><br>
                </div>
                
                <div class = "input-box">
                    <label>password</label>
                    <input type="password" name="password" placeholder="Password" require><br><br>
                </div>

                <div class = "input-box">
                    <label>Re-password</label>
                    <input type="password" name="repassword" placeholder="Password" require><br><br>
                </div>


                <button type="submit" name="btnSubmit">Submit</button>

                

            </form>
        </div>
    </body>
<html>