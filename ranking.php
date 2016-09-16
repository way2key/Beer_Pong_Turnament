<html>
	<head>
		<title>Beer Pong</title>
		<meta charset="utf-8"> 
		<style rel="stylesheet" type="text/css">
		 	body{
		 		%background-image: url("bg.png");
		 		font-family: Lucida Console;
		 		%color:red;
		 		%font-variant: small-caps;
		 	}
		 	 @font-face 
		 	 {
		 	 	font-family: 'ballplay';
		 		src:url('ballplay.ttf') format('truetype');
		 	 }
		 	.title{
		 		font-family: 'ballplay';
		 		font-size: 37px;
		 		text-decoration: none;
		 		line-height:1;
		 		letter-spacing: 3px;
		 	}
		 	.img{
		 		aposition: absolute;
		 		right: auto;
     			top: auto;

		 	}
			#arbre{
				position:static;
				 width:auto;
				 %background-image: url("leaderboard.png");
				 %background-size: cover;
				 %	background-repeat: no-repeat;

			}
			#M1{
				display: flex;
				justify-content: space-around;
			}
			#M2{
				display: flex;
				justify-content: space-around;
			}
			#M3{
				display: flex;
				justify-content: space-around;
			}
			#M4{
				display: flex;
				justify-content: space-around;
			}
			.Pool
			{
				justify-content: space-around;
				border: 2px solid black;
			}
			.Match
			{
				display:inline-flex;
				
			}
			.Equipe
			{	
				display:inline-flex;
				border: 2px solid red;
				justify-content: space-around;
				width: 50%;
			}
			.Win
			{
				border: 2px solid green;
			}
		</style>
	</head>
	<body>
	<div class="title">Classement du tournoi de </div>

	<div class="img">
		<img src="BP.png">
	</div> 

	<?php
		session_start();
		include "database.php";
		include "functions.php";
			$m1=$_SESSION['m1'];
			$m2=$_SESSION['m2'];
			$m3=$_SESSION['m3'];
			$m4=$_SESSION['m4'];
	?>

	<div id="arbre">
		<div id="M1">
			<?php
			for($a=1;$a<=Howmanypools($m1);$a++){
				echo"<div class='Pool'> Pool $a<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool=$a");
				echo "<div class='match'>";
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Equipe'>".$name."</div>";
				}
				echo "<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool=$a AND MANCHE1=1");
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Win'>".$name."</div>";
				}
				echo "</div></div>";

			}

			?>	
			
		</div>
		<div id="M2">
			<?php
			for($a=1;$a<=Howmanypools($m2);$a++){
				echo"<div class='Pool'> Pool $a<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool2=$a AND MANCHE1=1");
				echo "<div class='match'>";
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Equipe'>".$name."</div>";
				}
				echo "<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool2=$a AND MANCHE2=1");
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Win'>".$name."</div>";
				}
				echo "</div></div>";
			}
			?>		
		</div>
		<div id="M3">
			<?php
				for($a=1;$a<=Howmanypools($m3);$a++){
					echo"<div class='Pool'> Pool $a<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool3=$a AND MANCHE2=1");
				echo "<div class='match'>";
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Equipe'>".$name."</div>";
				}
				echo "<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool3=$a AND MANCHE3=1");
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Win'>".$name."</div>";
				}
				echo "</div></div>";
				}
			?>
		</div>
		<div id="M4">
			<?php
			for($a=1;$a<=Howmanypools($m4);$a++){
				echo"<div class='Pool'> Pool $a<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool4=$a AND MANCHE3=1");
				echo "<div class='match'>";
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Equipe'>".$name."</div>";
				}
				echo "<br>";
				$q=$db->query("SELECT * FROM `equipes` WHERE Pool4=$a AND FINALE=1");
				while($row =$q->fetch()){ 
					$name=$row['NAME'];
					echo "<div class='Win'>".$name."</div>";
				}
				echo "</div></div>";
			}
			?>
		</div>
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
		?>
	</div>

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
		?>
	</div>
</body>
</html>

<?php
/*
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
			?>
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
			?>
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
<?php
			$q=$db->query("SELECT * FROM `equipes` WHERE Finale=0");
			while($row =$q->fetch()){ 
				$teamm4[]=$row['NAME'];
			}
			$m4=floor($m3/2);
			for($i=0;$i<$m4;$i++){
				echo $teamm4[$i]," ";
			}
			echo "<br>";
			?>
		*/		
?>	
