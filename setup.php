<?php
session_start();
$people=$_POST['people'];
$_SESSION['people']=$people;
$m1=$people;
$_SESSION['m1']=$m1;
$m2=floor($m1/2);
$_SESSION['m2']=$m2;
$m3=floor($m2/2);
$_SESSION['m3']=$m3;
$m4=floor($m3/2);
$_SESSION['m4']=$m4;
$m5=floor($m4/2);
$_SESSION['m5']=$m5;
echo "<form method=post action='update.php'>";
for($i=1;$i<$people+1;$i++){

	echo "<input type='text' name='equipe[]' value='équipe ",$i,"'> Equipe ",$i,"<br>";
}
echo "<br><input type='submit' value='Lancer le tournoi!'></form>";

?>

