<?php
session_start(); 

$error_message = ''; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = 'localhost';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$servername;dbname=fitnaticSymfony", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

    $username = $_POST['username'];
    $password = $_POST['password'];



    $query = "SELECT * FROM users WHERE email = :username AND mot_de_passe = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        
        $_SESSION['username'] = $username;
        header("Location: homepage.php");
        exit(); 
    } else {
        
        $error_message = "Incorrect username or password. Please try again.";
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="path-to-your-font-awesome/css/font-awesome.min.css">
        <style>
        body {
            background: #222D32;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #1A2226;
            text-align: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            padding: 20px;
            border-radius: 8px;
            color: #ECF0F5;
        }

        .login-key {
            font-size: 80px;
            line-height: 100px;
            background: -webkit-linear-gradient(#27EF9F, #0DB8DE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-title {
            margin-top: 15px;
            text-align: center;
            font-size: 30px;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .login-form {
            margin-top: 25px;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            background-color: #1A2226;
            border: none;
            border-bottom: 2px solid #0DB8DE;
            border-top: 0px;
            border-radius: 0px;
            font-weight: bold;
            outline: 0;
            margin-bottom: 20px;
            padding: 10px;
            color: #ECF0F5;
            width: 100%;
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 40px;
        }

        .form-control:focus {
            border-color: inherit;
            -webkit-box-shadow: none;
            box-shadow: none;
            border-bottom: 2px solid #0DB8DE;
            outline: 0;
            background-color: #1A2226;
            color: #ECF0F5;
        }

        label {
            margin-bottom: 8px;
            display: block;
            font-size: 12px;
            color: #6C6C6C;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn-outline-primary {
            border-color: #0DB8DE;
            color: #0DB8DE;
            border-radius: 0px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: background-color 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #0DB8DE;
        }

        .login-btm {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-text,
        .login-button {
            flex: 1;
        }

        .login-text {
            text-align: left;
            color: #A2A4A4;
            font-size: 14px;
        }

        .login-button {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-lg-6 col-md-8 login-box">
            <div class="col-lg-12 login-key">
                <i class="fa fa-key" aria-hidden="true"></i>
            </div>
            <div class="col-lg-12 login-title">
                LOGIN
            </div>

            <div class="col-lg-12 login-form">
                <!-- Set the action attribute to the PHP file containing login logic -->
                <form method="post" action="../user_interface/index.html.twig">
                    <div class="form-group">
                        <label class="form-control-label">EMAIL</label>
                        <!-- Add the name attribute to access the value in PHP -->
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">PASSWORD</label>
                        <!-- Add the name attribute to access the value in PHP -->
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="col-lg-12 loginbttm">
                        <div class="col-lg-6 login-btm login-text">
                            <!-- Error Message -->
                            <?php echo $error_message; ?>
                        </div>
                        <div class="col-lg-6 login-btm login-button">
                            <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>