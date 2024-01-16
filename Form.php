<?php
include_once("./connection.php");
// Session start

// $_SESSION['login'] = true;
// Check Request

// Login Page
// Read User credentials
// Search for username then valid password
//      Login user
// else
//      redirect user

// Sign up Page
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION["ermsg"]); //if the error message is exist it will remove it 
    if(isset($_POST['register'])){
        $firstName= $_POST['firstName'];
        $lastName= $_POST['lastName'];
        $username = $_POST['username'];
        $email= $_POST['email'];
        $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);// return one row from returned query result example : if 5 rows back  then it returns first row only
            if (!$row){ 
                $sql="INSERT INTO users (firstName,lastName,username,email,password) VALUES ('$firstName','$lastName','$username','$email','$password') ";
                $result = mysqli_query($conn,$sql);// execute query
                $_SESSION["login"]= true;
            }
            else{
                $_SESSION["ermsg"]= "Username is already exist";
                header('Location: '.$_SERVER['PHP_SELF']); die;
            }

    }
// login page
        
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            if ($row){
                $_SESSION["login"]= true;
            }
            else{
                $_SESSION["ermsg"]= "Username or Password is wrong";
                header('Location: '.$_SERVER['PHP_SELF']); die;
            }
    }
    if(isset($_SESSION['login'])){
        header('Location: ./index.php '); die; //redirect to home page
    }
    
}
else{
    if(isset($_SESSION['login'])){
        header('Location: ./index.php');
        die;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="form.css">
    <style>
        .redMsg{
            padding: 15px 15px;
            background-color: #ef616e;
            color: white;
            border: 1px solid red;
            border-radius: 20px; 
            font-weight: bold;
        }
    </style>
    <title>PETS</title>
</head>
<body>
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
            <img src="images/logo.jpg" alt="">
            <p>PETS</p>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
            <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>
    <?php 
        if(isset($_SESSION['ermsg'])){
        echo "<div class='redMsg'>".$_SESSION["ermsg"]."</div>";}
    ?>
<!----------------------------- Form box ----------------------------------->    
    <div class="form-box">
        
        
        <!------------------- login form -------------------------->

        <div class="login-container" id="login">
            <div class="top">
                <span>Don't have an account? <a href="#" onclick="register()">Sign Up</a></span>
                <header>Login</header>
            </div>
                <form action='' method="post">
                    <div class="input-box">
                        <input type="text" class="input-field" name="username" placeholder="Username">
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                    
                        <input type="password" class="input-field" name='password' placeholder="Password" required maxlength="8" minlength="6">
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Sign In" name='login'>
                    </div>
                    <div class="two-col">
                    <div class="one">
                        <input type="checkbox" id="login-check">
                        <label for="login-check"> Remember Me</label>
                    </div>
                    <div class="two">
                        <label><a href="#">Forgot password?</a></label>
                    </div>
                </form>
            </div>
        </div>

        <!------------------- registration form -------------------------->
        <div class="register-container" id="register">
            <div class="top">
                <span>Have an account? <a href="#" onclick="login()">Login</a></span>
                <header>Sign Up</header>
            </div>
            <form action='' method="post">
                <div class="two-forms">
                    <div class="input-box">
                        <input type="text" class="input-field" name="firstName" placeholder="Firstname">
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" name="lastName" placeholder="Lastname">
                        <i class="bx bx-user"></i>
                    </div>
                </div>
                <div class="input-box">
                    <input type="text" class="input-field" name='username' placeholder="Username">
                    <i class="bx bx-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="text" class="input-field" name='email' placeholder="Email">
                    <i class="bx bx-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" name='password' placeholder="Password" required maxlength="8" minlength="6">
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-box">
                    <input type="submit" class="submit" value="Register" name="register">
                </div>
            </form>
            <div class="two-col">
                <div class="one">
                    <input type="checkbox" id="register-check">
                    <label for="register-check"> Remember Me</label>
                </div>
                <div class="two">
                    <label><a href="#">Terms & conditions</a></label>
                </div>
            </div>
        </div>
    </div>
</div>   




<script>

    var a = document.getElementById("loginBtn");
    var b = document.getElementById("registerBtn");
    var x = document.getElementById("login");
    var y = document.getElementById("register");

    function login() {
        x.style.left = "4px";
        y.style.right = "-520px";
        a.className += " white-btn";
        b.className = "btn";
        x.style.opacity = 1;
        y.style.opacity = 0;
    }

    function register() {
        x.style.left = "-510px";
        y.style.right = "5px";
        a.className = "btn";
        b.className += " white-btn";
        x.style.opacity = 0;
        y.style.opacity = 1;
    }

</script>

</body>
</html>
