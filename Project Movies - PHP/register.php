
<?php 

require_once 'config/db.php';
require_once 'config/tables.php';

$name = '';
$lastName = '';
$email = '';
$password = '';
$rePassword ='';
$errors = [];

if(isset($_POST['submit'])){
    
    if(!mb_strlen($_POST['name'])){
        $errors[] = 'Please Enter Your Name';
        
    }else if(mb_strlen($_POST['name']) > 32
        || mb_strlen($_POST['name']) < 4){

        $errors[] = 'Your Name shoud be between 4 and 32 symbols';
    }else{
        $name = trim($_POST['name']);
    }

    if(!mb_strlen($_POST['lastname'])){
        $errors[] = 'Please Enter Your last name';
    
    }else if(mb_strlen($_POST['lastname']) > 32
        || mb_strlen($_POST['lastname']) < 4){

        $errors[] = 'Your last name shoud be between 4 and 32 symbols';
    }else{
        $lastName = trim($_POST['lastname']);
    }

    if(!mb_strlen($_POST['email'])){
        $errors[] = 'Please Enter valid Email address';

    }else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Please Enter valid Email address';

    } else {
        
        $sql = "SELECT `id`
                FROM `".TABLES_USERS."`
                WHERE `email` = '".mysqli_real_escape_string($conn, $_POST['email'])."'
            ";
        $result = mysqli_query($conn, $sql);
        
        if ($result = mysqli_query($conn, $sql)) {
            $email = trim($_POST['email']);
            if (mysqli_num_rows($result)) {
                $errors[] = "This exists";
            }else{
                $email = trim($_POST['email']);
            }
        }
        
    }
    
    if(!mb_strlen($_POST['password'])){
        $errors[] = 'Please Enter valid password';

    }else if (mb_strlen($_POST['password'])<8){
        $errors[] = 'Please Enter valid password';

    }else if($_POST['password'] !== $_POST['re_password']){
        $errors[] = 'Please Enter again your passes';

    }else{
        $password = trim($_POST['password']);
    }
    // ShowArray($email);
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
        // ShowArray($sql);
        if(mysqli_query($conn,$sql)){
            echo "okey";
        } else {
            echo "nishto";
        }
    }
}
// ShowArray($errors);

    

function ShowArray($data){
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
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <p>Name:</p>
        <input type="text" name="name" value="<?=$name?>"/>
        <p>Lastname:</p>
        <input type="text" name="lastname" value="<?=$lastName?>"/>
        <p>Emali:</p>
        <input type="email" name="email" value="<?=$email?>"/>
        <p>Password:</p>
        <input type="password" name="password"/>
        <p>Repeat Password:</p>
        <input type="password" name="re_password"/>
        <br>
        <button type="submit" name="submit"> Send</button>
    </form>
    <a href="login.php">Go to login page</a>

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