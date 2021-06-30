<?php
session_start();

// logout
if (isset($_GET['action']) and $_GET['action'] == 'logout') {
    // session
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    print('Logged out!');
    
}



// login logic
$msg = '';
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    if ($_POST['username'] == 'Sandra' && $_POST['password'] == 'sandra1') {
        $_SESSION['logged_in'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $_POST['username'];
        $msg = 'You have entered valid use name and password';
        header('Location: ./');
    } else {
        $msg = 'Wrong username or password';
    }
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Enter Username and Password</h2>
</body>
<div>
    <?php
    if ($_SESSION['logged_in'] == true) {
        print('<h1>You can only see this if you are logged in!</h1>');
    }
    ?>
</div>
<div>
    <form action="./index.php" method="post" <?php $_SESSION['logged_in'] == true ? print("style = \"display: none\"") : print("style = \"display: block\"") ?>>
        <h4><?php echo $msg; ?></h4>
        <input type="text" name="username" placeholder="username = Sandra" required autofocus></br>
        <input type="password" name="password" placeholder="password = sandra1" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
    </form>
    Click here to <a href="index.php?action=logout"> logout.
</div>

</html>
