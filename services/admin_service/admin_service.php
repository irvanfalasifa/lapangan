
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <?php

    include '../../config.php';
    
    // error_reporting(0);

    session_start();

    echo $_SESSION['username'];
 
    if (isset($_SESSION['username'])) {
        header("Location: ../../index.php");
    }
    
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $sql = "SELECT * FROM admin WHERE email= '$email' AND password= '$password'";
        $result = mysqli_query($connect_admin, $sql);
        $data = mysqli_fetch_assoc($result);

        if ($password == $data['password'] && $email == $data['email'] ) {
            $_SESSION['username'] = $row['username'];
            header("Location: ../../index.php");
        } else {
            echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
        }
    }
    ?>
    <div class="mt-5 row justify-content-center">
        <div class="col-md-4">
            <main class="form-signin w-100 m-auto">
                <h1 class="h3 mt-5 mb-5 fw-normal text-center">Please Login</h1>
                
                <form action="" method="POST" class="login-email">
                <div class="form-floating">
                    <input type="text" name="email" class="form-control" id="email" placeholder="name@example.com" autofocus required value="">
                    <label for="email">Email address</label>
                </div>
                <div class="mt-4 form-floating">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                    <button class="w-100 btn mt-4 btn-lg btn-primary" type="submit" name="submit">Login</button>
                </form>
            </main>
        </div>
    </div>
</body>