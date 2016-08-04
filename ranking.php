<html>
	<head>
		<title>Beer Pong</title>
		<meta charset="utf-8"> 
	</head>
	<body>
	<h1>Classement du tournoi</h1>

	<div class="img">
		<img src="BP.png">
	</div> 

	<div class="arbre">
		<div class="Manche1">
			<?php
			session_start();
			include "database.php";
			$teamm1=$_SESSION['equipe'];
			$m1=$_SESSION['m1'];
			$m2=$_SESSION['m2'];
			$m3=$_SESSION['m3'];
			$m4=$_SESSION['m4'];
			for ($i=0;$i<$m1;$i++){
				echo $teamm1[$i]," ";
			}
			echo "<br";
			?></div>
		<div class="Manche2">
			<?php
			$q=$db->query("SELECT * FROM `equipes` WHERE Manche2=0");
			while($row =$q->fetch()){ 
				$teamm2[]=$row['NAME'];
			}
			$m2=floor($m1/2);
			for($i=0;$i<$m2;$i++){
				echo $teamm2[$i]," ";
			}
			echo "<br>";
			?></div>
		<div class="Manche3">
			<?php
			$q=$db->query("SELECT * FROM `equipes` WHERE Manche3=0");
			while($row =$q->fetch()){ 
				$teamm3[]=$row['NAME'];
			}
			$m3=floor($m2/2);
			for($i=0;$i<$m3;$i++){
				echo $teamm3[$i]," ";
			}
			echo "<br>";
			?>
			</div>
		<div class="Manche4">
			<?php
			$q=$db->query("SELECT * FROM `equipes` WHERE Manche4=0");
			while($row =$q->fetch()){ 
				$teamm4[]=$row['NAME'];
			}
			$m4=floor($m3/2);
			for($i=0;$i<$m4;$i++){
				echo $teamm4[$i]," ";
			}
			echo "<br>";
			?>
			</div>
		
	<div class="live">
		<h1> Match en cours </h1>
		<?php
		$count=0;
		$q=$db->query("SELECT * FROM `equipes` WHERE LIVE=1");
		while($row =$q->fetch()){ 
			$live=$row['NAME'];
			echo $live;
			echo ($count<1)? " <img src='vs.png'> ":"";
			$count++;
		}
		?></div>
	
	<div class="nextMatch">
		<h1> Prochain Match </h1>
		<?php
		$count=0;
		$q=$db->query("SELECT * FROM `equipes` WHERE NEXT=1");
		while($row =$q->fetch()){ 
			$next=$row['NAME'];
			echo $next;
			echo ($count<1)? " <img src='vs.png'> ":"";
			$count++;
		}
		?></div>
</body>
</html>

<?php
/*
		session_start();
		$equipe=$_SESSION['equipe'];
		$people=$_SESSION['people'];
		$pools=array();

		//logique
		if($people%2==0){
			//pair
			$j=0;
			for($i=0;$i<($people/2);$i++){
				for($k=0;$k<2;$k++){
					$pools[$i][]=$equipe[$j];
					$j++;
				}
			}
			//affichage des pools
			for($o=0;$o<($people/2);$o++){
				echo "Pool ",$o+1,": <br>";
				for($ol=0;$ol<2;$ol++){
					echo $pools[$o][$ol];
					echo ($ol==0)?  " vs ":  "";
				}
				echo "<br><br>";
			}
			//premier tour
			for($i=0;$i<$people/2;$i++){
				$match=(string)$pools[$i][0]." VS ".$pools[$i][1];
				$pmatch="Pas encore disponible";
			}
		} elseif(($people-1)%2==0){
			//impair
			if($people%3==0){
				//multiple de 3
			} else{
				//non divisible par 3
			}
		}
		*/		
?>	