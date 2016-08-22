<?php
session_start ();
include"database.php";
$people=$_SESSION['people'];
$equipe=$_POST['equipe']; 
$_SESSION['equipe']=$equipe;
for($i=1;$i<21;$i++){
$q=$db->prepare("UPDATE`equipes`SET`NAME`=0,`Manche1`=0,`Manche2`=0,`Manche3`=0,`Finale`=0,`LIVE`=0,`NEXT`=0,`POOL`=0,`POOL2`=0,`POOL3`=0,`POOL4`=0 WHERE ID='$i' "); 
$q->execute(); 
}
for($i=1;$i<$people+1;$i++){
	$l=$i-1;
	$name=$equipe[$l];
	echo $name;
	$q=$db->prepare("UPDATE `equipes` SET NAME='$name' WHERE ID='$i' "); 
	$q->execute(); 
	$q->closeCursor(); 

}

header('Location: http://localhost/BeerPong/ranking.php');
die();
?>

