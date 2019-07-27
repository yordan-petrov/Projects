<?php 
    require_once 'config/db.php';
    require_once 'config/tables.php';

$name = '';
$lastName = '';
$email = '';
$password = '';
$rePassword = '';
$errors = [];


if(isset($_POST['submit'])){
    if(!mb_strlen($_POST['name'])){
        $errors[] = 'Please enter Your name';
    }else if(mb_strlen($_POST['name']) > 32
    || mb_strlen($_POST['name']) <4){
        $errors [] = 'Your name shoud be betwean 4 and 32 symbols';
    }else{
        $name = trim($_POST['name']);
    }

    if(!mb_strlen($_POST['lastname'])){
        $errors[] = 'Please enter your lastname';
    }else if(mb_strlen($_POST['lastname']) > 32 
    || mb_strlen($_POST['lastname']) < 4 ){
        $errors[] = 'Your name shoud be betwean 4 and 32 symbols';
    }else {
        $lastName = trim($_POST['lastname']);
    }

    if(!mb_strlen($_POST['email'])){
        $errors[] = 'Enter your Email';
    }else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Please enter valid email adress';
    }else {
        $sql = "SELECT `id`
                FROM `".TABLES_USERS."`
                WHERE `id` = '".mysqli_real_escape_string($conn , $_POST['email'])."'
        ";
        if($result = mysqli_query($conn , $sql)){
            $email = trim($_POST['email']);
            if(mysqli_num_rows($result)){
                $errors[] = 'Email alredy exist';
            }else {
                $email = trim($_POST['email']);
            }
        }
    }
    if(!mb_strlen($_POST['password'])){
        $errors[] = 'Enter your password';
    }else if(mb_strlen($_POST['password']) < 8){
        $errors[] = 'Your password must be more then 8 symbols';
    }else if($_POST['password'] !== $_POST['re_password']){
        $errors[] = "your password not match";
    }else{
        $password = trim($_POST['password']);
    }
    
    if(!count($errors)){ 
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = " INSERT INTO `".TABLES_USERS."`
        (
            `name`,
            `lastname`,
            `email`,
            `password`,
            `added`,
            `modified`
        )VALUES(
            '".mysqli_real_escape_string($conn,$name)."',
            '".mysqli_real_escape_string($conn,$lastName)."',
            '".mysqli_real_escape_string($conn,$email)."',
            '".mysqli_real_escape_string($conn,$password)."',
            NOW(),
            NOW()
        )
        ";
        ShowArray($sql);
        if(mysqli_query($conn,$sql)){
            echo "Registered";
        } else {
            echo "problem with registration";
        }
    }
}

ShowArray($errors);


function showArray($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Register at Movies</title>
    </head>
    <body>
    <form action="" method="POST">
    <p>Name</p>
    <input type="text" name="name" value="<?=$name?>">
    <br>
    <p>lastname</p>
    <input type="text" name="lastname" value="<?=$lastName?>">
    <br>
    <p>Email</p>
    <input type="email" name="email" value="<?=$email?>">
    <br>
    <p>Password</p>
    <input type="password" name="password">
    <br>
    <p>Retype password</p>
    <input type="password" name="re_password">
    <br>
    <input type="submit" name="submit" value="Register Now">
    <br>
    <br>   
    </form>
        <a href="login.php" alt='login'>Alredy have registration ?</a>

    <div>
        <ul>
        <?php if(isset($errors) && count($errors)) : ?>
        <?php for($i = 0; $i < count($errors); $i++) :?>
        <li> <?=$errors[$i]?> </li>
        <?php endfor ?>
        <?php endif ?>
        </ul>
    </div>
    </body>
</html>