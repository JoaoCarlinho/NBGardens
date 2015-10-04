$server = 'localhost';
$user = 'adebeem_JSkeete';
$pass = 'GETMONEY15';
$dbname = 'adebeem_phptutorial';
$con = mysql_connect($server, $user, $pass) or die("Can't connect");
mysql_select_db($dbname);