<?php 
session_start();
require_once 'config/db.php';
require_once 'config/tables.php';

$name = '';
$lastName = '';
$password = '';
$email = '';
$errors = [];   
$count = 1;

function showResult($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}


if(isset($_POST['submit'])){
    // Email check
    if(!mb_strlen($_POST['email'])){
        $errors[] = 'Please enter valid email adress';
    }else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter";
    }else {
        $email = trim($_POST['email']);
    }
 
    // Password check
    if (!mb_strlen($_POST['password'])){
        $errors[] = 'Please enter valid password';
    }else if (mb_strlen($_POST['password']) < 8){
        $errors[] = 'Your password is less then 8 symbols';
    }else {
        $password = trim($_POST['password']);
    }

    if (!count($errors)) {
        $sql = "SELECT 
                `id`,
                `name`,
                `email`,
                `password`
            FROM `".TABLES_USERS."`
            WHERE `email` = '".mysqli_real_escape_string($conn , $email)."'
        ";
        $user = [];
        
        if($result = mysqli_query($conn , $sql)){
        $user = mysqli_fetch_assoc($result);
            
        }
        
        if(is_array($user) && count($user)){
            showResult($password);
            if (password_verify($password, $user['password'])){
                $_SESSION['user'] = $user;   
                header('Location: profile.php');
            }else {
                $errors[] = 'Your password is not match';
            }
        }else {
            $errors[] = "user not exist.";
        }

    }
    
    // showResult($user);

}




?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <form action="" method="POST">
            <p>Enter your Email</p>
            <input type="email" name="email">
            <br>
            <p>Enter your password</p>
            <input type="password" name="password">
            <br>
            <p>Enter again your password</p>
            <input type="submit" name="submit">
        </form>
        <div>
        <ul>
            <?php if(isset($errors) && count($errors)) :?>
            <?php for($i = 0; $i < count($errors) ;$i++) :?>
            <li> <?=$errors[$i];?> </li>
            <?php endfor ?>
            <?php endif ?>
        </ul>
    </div>
    </body>
</html>