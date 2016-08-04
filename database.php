<?php

define('DB_HOST','localhost');
define('DB_NAME','beerpong');
define('DB_USERNAME','root');
define('DB_PASSWORD','321654');
try{
$db=new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",DB_USERNAME,DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
die(' Une erreur est survenue: '.$e->getMessage());
}
?>
