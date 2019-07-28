<?php 
    session_start();
    require_once 'config/db.php';
    require_once 'config/tables.php';
if(!isset($_SESSION['user'])){
    header('Location: index.php');
}
echo "Profile page";

function showResult($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
$_SESSION['user']['id'];
showResult($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Page</title>
</head>
<body>
<a href="logout.php">Logout</a>
</body>
</html>