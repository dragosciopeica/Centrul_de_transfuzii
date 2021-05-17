<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
/*
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'pacienti');
 */ 

define('DB_SERVER', 'mysql.cts.studupt.xyz');
define('DB_USERNAME', 'ctsstuduptxyz');
define('DB_PASSWORD', 'hh433Yi3kl4');
define('DB_NAME', 'ctsstuduptxyz');





/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
