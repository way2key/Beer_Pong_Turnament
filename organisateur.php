<html>
	<head>
		<title>Management of the Turnament</title>
		<meta charset="utf-8"> 
	</head>
	<body>
		<h1>Fenêtre secrète de l'organisateur</h1>
		<?php
			//initialisation
			session_start();
			require "functions.php";
			include "database.php";
			$m1=$_SESSION['people'];
			$m2=$_SESSION['m2'];
			$m3=$_SESSION['m3'];
			$m4=$_SESSION['m4'];
			$poolst1=array();
			$teamm1=$_SESSION['equipe'];


			//premiere Manche
			//répartition des joueurs dans les pools au 1er tour
			if($m1%2==0){
				$j=0;
				for($i=0;$i<($m1/2);$i++){
					$l=$i+1;
					for($k=0;$k<2;$k++){
						$poolst1[$i][]=$teamm1[$j]; 
						$j++;
					}
				}
				$j=1;
				$l=1;
				for($i=0;$i<$m1;$i++){
					for($k=0;$k<2;$k++){
						$q=$db->prepare("UPDATE `equipes` SET POOL='$j' WHERE ID=$l"); 
						$q->execute(); 
						$q->closeCursor();
						$l++;
					}
					$j++;
				}
				// questionnaire sur les qualifications du T1:
				echo "<h2>Tour 1: </h2><br><form method='post'>";
				for($i=0;$i<$m1/2;$i++){
					if(empty($_POST['t1'])){$_POST['t1']=[];}
					echo $poolst1[$i][0]." VS ".$poolst1[$i][1],"<br>";
					echo "<input type='checkbox' name='t1[]' value='",$poolst1[$i][0],"' ",notempty1($_POST['t1'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='checkbox' name='t1[]' value='",$poolst1[$i][1],"' ",notempty1($_POST['t1'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";
					//if(!empty($_POST['t1'])){echo (in_array($poolst1[$i][0], $_POST['t1']))? 'checked':'';}

				}
				echo "<input type='submit' name='Qui a gagné?'></form>";
				if(!empty($_POST['t1'])){
						$teamm2=$_POST['t1'];
						$_SESSION['teamm2']=$_POST['t1'];
					}
			}else{
				$j=0;
				for($i=0;$i<(floor($m1/2)-1);$i++){
					$l=$i+1;
					for($k=0;$k<2;$k++){
						$poolst1[$i][]=$teamm1[$j];
						$j++;
					}
				}
				$j=1;
				$l=1;
				for($i=0;$i<$m1/2-2;$i++){
					for($k=0;$k<2;$k++){
						$q=$db->prepare("UPDATE `equipes` SET POOL='$j' WHERE ID=$l"); 
						$q->execute(); 
						$q->closeCursor();
						$l++;
					}
					$j++;
				}	
				$s=$j;
				$p=$l;
				$j=$m1-3;
				for($i=$i;$i<($m1/2)-1;$i++){
					for($k=0;$k<3;$k++){
						$poolst1[$i][]=$teamm1[$j];
						$j++;
						$q=$db->prepare("UPDATE `equipes` SET POOL='$s' WHERE ID=$p"); 
						$q->execute(); 
						$q->closeCursor();
						$p++;
					}		
				}
				// questionnaire sur les qualifications du T1:
				echo "<h2>Tour 1: </h2><br><form method='post'>";
				if(empty($_POST['t1'])){$_POST['t1']=[];}
				for($i=0;$i<($m1-3)/2;$i++){
					echo $poolst1[$i][0]." VS ".$poolst1[$i][1],"<br>";
					echo "<input type='checkbox' name='t1[]' value='",$poolst1[$i][0],"' ",notempty1($_POST['t1'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='checkbox' name='t1[]' value='",$poolst1[$i][1],"' ",notempty1($_POST['t1'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";
				}
				for($i=($m1-3)/2;$i<(($m1-3)/2)+1;$i++){
					
					echo $poolst1[$i][0]." VS ".$poolst1[$i][1],"<br>";
					echo "<input type='checkbox' name='ti1[]' value='",$poolst1[$i][0],"' ",notempty1($_POST['t1'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='checkbox' name='ti1[]' value='",$poolst1[$i][1],"' ",notempty1($_POST['t1'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";

					echo $poolst1[$i][1]." VS ".$poolst1[$i][2],"<br>";
					echo "<input type='checkbox' name='ti1[]' value='",$poolst1[$i][1],"' ",notempty1($_POST['t1'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";
					echo "<input type='checkbox' name='ti1[]' value='",$poolst1[$i][2],"' ",notempty1($_POST['t1'],$poolst1[$i][2]),"> ",$poolst1[$i][2],"<br>";

					echo $poolst1[$i][0]." VS ".$poolst1[$i][2],"<br>";
					echo "<input type='checkbox' name='ti1[]' value='",$poolst1[$i][0],"' ",notempty1($_POST['t1'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='checkbox' name='ti1[]' value='",$poolst1[$i][2],"' ",notempty1($_POST['t1'],$poolst1[$i][2]),"> ",$poolst1[$i][2],"<br>";
				}
				echo "<input type='submit' name='Qui a gagné?'></form>";

				if(!empty($_POST['ti1'])){
					$ti1=$_POST['ti1'];
					$a=array_count_values($ti1);
					if(max($a)==1){
						$teamm2=$_POST['t1'];
						$teamm2[]=$ti1[rand(0,2)];
						$_SESSION['teamm2']=$teamm2;					
					}
					else{
						$b=array_search(max($a),$a);
						$teamm2=$_POST['t1'];
						$teamm2[]=$b;
						$_SESSION['teamm2']=$teamm2;
					}
				}
			}
			$test=count($poolst1,COUNT_RECURSIVE);
			

			//Deuxième manche
			$poolst2=array();
			//répartition des équipes dans les pools au 2eme tour
			if(!empty($_SESSION['teamm2'])&&$test>=4){
				if($m2%2==0){
					$j=0;
					for($i=0;$i<($m3);$i++){
						for($k=0;$k<2;$k++){
							$poolst2[$i][]=$_SESSION['teamm2'][$j]; 
							$j++;
						}
					}
					$j=1;
					$l=1;
					for($i=0;$i<$m2/2;$i++){
						for($k=0;$k<2;$k++){
							$q=$db->prepare("UPDATE `equipes` SET POOL2='$j' WHERE ID=$l"); 
							$q->execute(); 
							$q->closeCursor();
							$l++;
						}
						$j++;
					}
					// questionnaire sur les qualifications du T2:
					echo "<h2>Tour 2: </h2><br><form method='post'>";
					if(empty($_POST['t2'])){$_POST['t2']=[];}
					for($i=0;$i<$m2/2;$i++){
						echo $poolst2[$i][0]." VS ".$poolst2[$i][1],"<br>";
						echo "<input type='checkbox' name='t2[]' value='",$poolst2[$i][0],"' ",notempty2($_POST['t2'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
						echo "<input type='checkbox' name='t2[]' value='",$poolst2[$i][1],"' ",notempty2($_POST['t2'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";
					}
					echo "<input type='submit' name='Qui a gagné?'></form><br>";
					if(!empty($_POST['t2'])){
						$teamm3=$_POST['t2'];
						$_SESSION['teamm3']=$_POST['t2'];
					}
				}else{
					$j=0;
					for($i=0;$i<(floor($m2/2)-1);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst2[$i][]=$_SESSION['teamm2'][$j];
							$j++;
						}
					}
					$j=1;
					$l=1;
					for($i=0;$i<$m2/2-2;$i++){
						for($k=0;$k<2;$k++){
							$q=$db->prepare("UPDATE `equipes` SET POOL2='$j' WHERE ID=$l"); 
							$q->execute(); 
							$q->closeCursor();
							$l++;
						}
						$j++;
					}	
					$s=$j;
					$p=$l;
					$j=$m2-3;
					for($i=$i;$i<($m2/2)-1;$i++){
						for($k=0;$k<3;$k++){
							$poolst2[$i][]=$_SESSION['teamm2'][$j];
							$j++;
							$q=$db->prepare("UPDATE `equipes` SET POOL2='$s' WHERE ID=$p"); 
							$q->execute(); 
							$q->closeCursor();
							$p++;
						}		
					}
					// questionnaire sur les qualifications du T2:
					echo "<h2>Tour 2: </h2><br><form method='post'>";
					if($m2>3){
						if(empty($_POST['t2'])){$_POST['t2']=[];}
						for($i=0;$i<($m2-3)/2;$i++){
							echo $poolst2[$i][0]." VS ".$poolst2[$i][1],"<br>";
							echo "<input type='checkbox' name='t2[]' value='",$poolst2[$i][0],"' ",notempty2($_POST['t2'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
							echo "<input type='checkbox' name='t2[]' value='",$poolst2[$i][1],"' ",notempty2($_POST['t2'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";
						}
					}else{
					$_POST['t2']=[];
					}
					if(empty($_POST['ti2'])){$_POST['ti2']=[];}
					for($i=($m2-3)/2;$i<(($m2-3)/2)+1;$i++){
						
						echo $poolst2[$i][0]." VS ".$poolst2[$i][1],"<br>";
						echo "<input type='checkbox' name='ti2[]' value='",$poolst2[$i][0],"' ",notempty2($_POST['ti2'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
						echo "<input type='checkbox' name='ti2[]' value='",$poolst2[$i][1],"' ",notempty2($_POST['ti2'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";

						echo $poolst2[$i][1]." VS ".$poolst2[$i][2],"<br>";
						echo "<input type='checkbox' name='ti2[]' value='",$poolst2[$i][1],"' ",notempty2($_POST['ti2'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";
						echo "<input type='checkbox' name='ti2[]' value='",$poolst2[$i][2],"' ",notempty2($_POST['ti2'],$poolst2[$i][2]),"> ",$poolst2[$i][2],"<br>";

						echo $poolst2[$i][0]." VS ".$poolst2[$i][2],"<br>";
						echo "<input type='checkbox' name='ti2[]' value='",$poolst2[$i][0],"' ",notempty2($_POST['ti2'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
						echo "<input type='checkbox' name='ti2[]' value='",$poolst2[$i][2],"' ",notempty2($_POST['ti2'],$poolst2[$i][2]),"> ",$poolst2[$i][2],"<br>";
					}
					echo "<input type='submit' name='Qui a gagné?'></form>";
					if(!empty($_POST['ti2'])){
						$ti2=$_POST['ti2'];
						$a=array_count_values($ti2);
						if(max($a)==1){
							$teamm3=$_POST['t2'];
							$teamm3[]=$ti2[rand(0,2)];
							$_SESSION['teamm3']=$teamm3;
						}
						else{
							$b=array_search(max($a),$a);
							$teamm3=$_POST['t2'];
							$teamm3[]=$b;
							$_SESSION['teamm3']=$teamm3;
							
						}
					}
				}
				$test=count($poolst2,COUNT_RECURSIVE);
			}


			//Troisième manche
			$poolst3=array();
			//répartition des équipes dans les pools au 3eme tour
			if(!empty($_SESSION['teamm3'])&&$test>=4){
				if($m3%2==0){
					$j=0;
					for($i=0;$i<($m3/2);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst3[$i][]=$_SESSION['teamm3'][$j]; 
							$j++;
						}
					}
					$j=1;
					$l=1;
					for($i=0;$i<$m3/2;$i++){
						for($k=0;$k<2;$k++){
							$q=$db->prepare("UPDATE `equipes` SET POOL3='$j' WHERE ID=$l"); 
							$q->execute(); 
							$q->closeCursor();
							$l++;
						}
						$j++;
					}	
					// questionnaire sur les qualifications du T3:
					echo "<h2>Tour 3: </h2><br><form method='post'>";
					if(empty($_POST['t3'])){$_POST['t3']=[];}
					for($i=0;$i<$m3/2;$i++){
						echo $poolst3[$i][0]." VS ".$poolst3[$i][1],"<br>";
						echo "<input type='checkbox' name='t3[]' value='",$poolst3[$i][0],"' ",notempty3($_POST['t3'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
						echo "<input type='checkbox' name='t3[]' value='",$poolst3[$i][1],"' ",notempty3($_POST['t3'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";
					}
					echo "<input type='submit' name='Qui a gagné?'></form>";
					if(!empty($_POST['t3'])){
						$teamm4=$_POST['t3'];
						$_SESSION['teamm4']=$teamm4;
					}
				}else{
					$j=0;
					for($i=0;$i<(floor($m3/2)-1);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst3[$i][]=$_SESSION['teamm3'][$j];
							$j++;
						}
					}
					$j=1;
					$l=1;
					for($i=0;$i<$m3/2-2;$i++){
						for($k=0;$k<2;$k++){
							$q=$db->prepare("UPDATE `equipes` SET POOL3='$j' WHERE ID=$l"); 
							$q->execute(); 
							$q->closeCursor();
							$l++;
						}
						$j++;
					}	
					$s=$j;
					$p=$l;
					$j=$m3-3;
					for($i=$i;$i<($m3/2)-1;$i++){
						for($k=0;$k<3;$k++){
							$poolst3[$i][]=$_SESSION['teamm3'][$j];
							$j++;
							$q=$db->prepare("UPDATE `equipes` SET POOL3='$s' WHERE ID=$p"); 
							$q->execute(); 
							$q->closeCursor();
							$p++;
						}		
					}
					// questionnaire sur les qualifications du T3:
					echo "<h2>Tour 3: </h2><br><form method='post'>";
					if($m3>3){
						if(empty($_POST['t3'])){$_POST['t3']=[];}
						for($i=0;$i<($m3-3)/2;$i++)
						{
							echo $poolst3[$i][0]." VS ".$poolst3[$i][1],"<br>";
							echo "<input type='checkbox' name='t3[]' value='",$poolst3[$i][0],"' ",notempty3($_POST['t3'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
							echo "<input type='checkbox' name='t3[]' value='",$poolst3[$i][1],"' ",notempty3($_POST['t3'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";
						}
					}else{
						$_POST['t3']=[];
					}
					if(empty($_POST['ti3'])){$_POST['ti3']=[];}
					for($i=($m3-3)/2;$i<(($m3-3)/2)+1;$i++){
						
						echo $poolst3[$i][0]." VS ".$poolst3[$i][1],"<br>";
						echo "<input type='checkbox' name='ti3[]' value='",$poolst3[$i][0],"' ",notempty3($_POST['ti3'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
						echo "<input type='checkbox' name='ti3[]' value='",$poolst3[$i][1],"' ",notempty3($_POST['ti3'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";

						echo $poolst3[$i][1]." VS ".$poolst3[$i][2],"<br>";
						echo "<input type='checkbox' name='ti3[]' value='",$poolst3[$i][1],"' ",notempty3($_POST['ti3'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";
						echo "<input type='checkbox' name='ti3[]' value='",$poolst3[$i][2],"' ",notempty3($_POST['ti3'],$poolst3[$i][2]),"> ",$poolst3[$i][2],"<br>";

						echo $poolst3[$i][0]." VS ".$poolst3[$i][2],"<br>";
						echo "<input type='checkbox' name='ti3[]' value='",$poolst3[$i][0],"' ",notempty3($_POST['ti3'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
						echo "<input type='checkbox' name='ti3[]' value='",$poolst3[$i][2],"' ",notempty3($_POST['ti3'],$poolst3[$i][2]),"> ",$poolst3[$i][2],"<br>";
					}
					echo "<input type='submit' name='Qui a gagné?'></form>";
					if(!empty($_POST['ti3'])){
						$ti3=$_POST['ti3'];
						$a=array_count_values($ti3);
						if(max($a)==1){
							$teamm4=$_POST['t3'];
							$teamm4[]=$ti3[rand(0,2)];
							$_SESSION['teamm4']=$teamm4;
						}
						else{
							$b=array_search(max($a),$a);
							$teamm4=$_POST['t3'];
							$teamm4[]=$b;
							$_SESSION['teamm4']=$teamm4;	
						}
					}
				}
				$test=count($poolst3,COUNT_RECURSIVE);
			}


			//Quattrième manche
			$poolst4=array();
			//répartition des équipes dans les pools au 4eme tour
			if(!empty($_SESSION['teamm4'])&&$test>=4){
				if($m4%2==0){
					$j=0;
					for($i=0;$i<($m4/2);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst4[$i][]=$_SESSION['teamm4'][$j]; 
							$j++;
						}
					}
					$j=1;
					$l=1;
					for($i=0;$i<$m4/2;$i++){
						for($k=0;$k<2;$k++){
							$q=$db->prepare("UPDATE `equipes` SET POOL4='$j' WHERE ID=$l"); 
							$q->execute(); 
							$q->closeCursor();
							$l++;
						}
						$j++;
					}
					// questionnaire sur les qualifications du T4:
					echo "<h2>Tour 4: </h2><br><form method='post'>";
					if(empty($_POST['t3'])){$_POST['t3']=[];}
					for($i=0;$i<$m4/2;$i++){
						echo $poolst4[$i][0]." VS ".$poolst4[$i][1],"<br>";
						echo "<input type='checkbox' name='t4[]' value='",$poolst4[$i][0],"' ",notempty4($_POST['t4'],$poolst4[$i][0]),"> ",$poolst4[$i][0],"<br>";
						echo "<input type='checkbox' name='t4[]' value='",$poolst4[$i][1],"' ",notempty3($_POST['t3'],$poolst3[$i][1]),"> ",$poolst4[$i][1],"<br>";
					}
					echo "<input type='submit' name='Qui a gagné?'></form><br><br><br>";
				}else{
					$j=0;
					for($i=0;$i<(floor($m4/2)-1);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst4[$i][]=$_SESSION['teamm4'][$j];
							$j++;
						}
					}
					$j=1;
					$l=1;
					for($i=0;$i<$m4/2-2;$i++){
						for($k=0;$k<2;$k++){
							$q=$db->prepare("UPDATE `equipes` SET POOL4='$j' WHERE ID=$l"); 
							$q->execute(); 
							$q->closeCursor();
							$l++;
						}
						$j++;
					}	
					$s=$j;
					$p=$l;
					$j=$m4-3;
					for($i=$i;$i<($m4/2)-1;$i++){
						for($k=0;$k<3;$k++){
							$poolst4[$i][]=$_SESSION['teamm4'][$j];
							$j++;
							$q=$db->prepare("UPDATE `equipes` SET POOL4='$s' WHERE ID=$p"); 
							$q->execute(); 
							$q->closeCursor();
							$p++;
						}		
					}
				}
				$test=count($poolst2,COUNT_RECURSIVE);	
			}

		echo "<br><br>";
		?>	

		<?php
		//Gestion des pools
		//t1
		$t1=count($poolst1);
		for($i=0;$i<$t1;$i++){
			var_dump($poolst1[$i]);
			for($j=0;$j<count($poolst1[$j]);$j++){
				echo $j;
			}
		}
		//t2
		
		$t2=count($poolst2);
		for($i=0;$i<$t2;$i++){
			var_dump($poolst1[$i]);
			for($j=0;$j<count($poolst2[$j]);$j++){
				echo $j;
			}
		}
		//t3
		$t3=count($poolst3);
		for($i=0;$i<$t3;$i++){
			var_dump($poolst1[$i]);
			for($j=0;$j<count($poolst3[$j]);$j++){
				echo $j;
			}
		}
		//t4
		$t4=count($poolst4);
		for($i=0;$i<$t4;$i++){
			var_dump($poolst1[$i]);
			for($j=0;$j<count($poolst4[$j]);$j++){
				echo $j;
			}
		}
		?>
	</body>
</html>
