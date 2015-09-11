<?php
session_start();
session_destroy();

if(isset ($_COOKIE['id_cookie'])){
    setcookie("id_cookie","",time()-50000,'/');
    setcookie("pass_cookie","",time()-50000,'/');
    echo("cookies reset");
    echo("ID cookie set to: ".$_COOKIE['id_cookie']);
    echo("Pass cookie set to: ".$_COOKIE['pass_cookie']);
}

if(isset($_SESION['email'])){
    echo("Could not log you out, please try again!");
    exit();
}else{
    echo('no cookies set and session ended');
}

?>

<html>
    <a href="index.php"><div style="height:200px; width:200px; margin:0 auto 0 auto;">Please return to home page and log in</div></a>
</html>