<?php
session_start();

session_destroy();

if(isset ($_COOKIE['id_cookie'])){
    setcookie("id_cookie","",time()-50000,'/');
    setcookie("pass_cookie","",time()-50000,'/');
}

if(session_is_registered('username')){
    echo("Could not log you out, please try again!");
    exit();
}else{
    header("Location: index.php");
}
?>