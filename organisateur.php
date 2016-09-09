<html>
	<head>
		<title>Management of the Tournament</title>
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
			$m5=$_SESSION['m5'];
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
				for($i=0;$i<$m1/2;$i++){
					for($k=0;$k<2;$k++){
						$q=$db->prepare("UPDATE `equipes` SET POOL='$j' WHERE ID=$l"); 
						$q->execute(); 
						$q->closeCursor();
						$l++;
					}
					$j++;
				}
				// questionnaire sur les qualifications du T1:
				echo "<div id='t1'><h2>Tour 1: </h2><br><form method='post'>";
				for($i=0;$i<$m1/2;$i++){
					if(empty($_POST['t1'])){$_POST['t1']=[];}
					echo $poolst1[$i][0]." VS ".$poolst1[$i][1],"<br>";
					echo "<input type='radio' name='t1[]",$i+1,"' value='",$poolst1[$i][0],"' ",notempty($_POST['t1'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='radio' name='t1[]",$i+1,"' value='",$poolst1[$i][1],"' ",notempty($_POST['t1'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";
					if(!empty($_POST['t1'])){
						$winner=wichwin($poolst1[$i][0],$poolst1[$i][1],$_POST['t1']);
						$loser=wichlose($poolst1[$i][0],$poolst1[$i][1],$_POST['t1']);
						$q=$db->prepare("UPDATE `equipes` SET Manche1='1' WHERE NAME='$winner' "); 
						$q->execute(); 
						$q=$db->prepare("UPDATE `equipes` SET Manche1='0' WHERE NAME='$loser' "); 
						$q->execute();
						$q->closeCursor();
					}
				}
				echo "<input type='submit' name='Qui a gagné?'></form></div>";
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
				echo "<div id='t1'><h2>Tour 1: </h2><br><form method='post'>";
				if(empty($_POST['t1'])){$_POST['t1']=[];}
				for($i=0;$i<($m1-3)/2;$i++){
					echo $poolst1[$i][0]." VS ".$poolst1[$i][1],"<br>";
					echo "<input type='radio' name='t1[]",$i+1,"' value='",$poolst1[$i][0],"' ",notempty($_POST['t1'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='radio' name='t1[]",$i+1,"' value='",$poolst1[$i][1],"' ",notempty($_POST['t1'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";
					$winner=wichwin($poolst1[$i][0],$poolst1[$i][1],$_POST['t1']);
					$loser=wichlose($poolst1[$i][0],$poolst1[$i][1],$_POST['t1']);
					$q=$db->prepare("UPDATE `equipes` SET Manche1='1' WHERE NAME='$winner' "); 
					$q->execute(); 
					$q=$db->prepare("UPDATE `equipes` SET Manche1='0' WHERE NAME='$loser' ");
					$q->execute();  
					$q->closeCursor();
				}
				if(empty($_POST['ti11'])){$_POST['ti11']=[];}
				if(empty($_POST['ti12'])){$_POST['ti12']=[];}
				if(empty($_POST['ti13'])){$_POST['ti13']=[];}
				for($i=($m1-3)/2;$i<(($m1-3)/2)+1;$i++){
					$p=$i+1;
					echo $poolst1[$i][0]." VS ".$poolst1[$i][1],"<br>";
					echo "<input type='radio' name='ti11[]",$p,"' value='",$poolst1[$i][0],"' ",notempty($_POST['ti11'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='radio' name='ti11[]",$p,"' value='",$poolst1[$i][1],"' ",notempty($_POST['ti11'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";

					echo $poolst1[$i][1]." VS ".$poolst1[$i][2],"<br>";
					echo "<input type='radio' name='ti12[]",$p+1,"' value='",$poolst1[$i][1],"' ",notempty($_POST['ti12'],$poolst1[$i][1]),"> ",$poolst1[$i][1],"<br>";
					echo "<input type='radio' name='ti12[]",$p+1,"' value='",$poolst1[$i][2],"' ",notempty($_POST['ti12'],$poolst1[$i][2]),"> ",$poolst1[$i][2],"<br>";

					echo $poolst1[$i][0]." VS ".$poolst1[$i][2],"<br>";
					echo "<input type='radio' name='ti13[]",$p+2,"' value='",$poolst1[$i][0],"' ",notempty($_POST['ti13'],$poolst1[$i][0]),"> ",$poolst1[$i][0],"<br>";
					echo "<input type='radio' name='ti13[]",$p+2,"' value='",$poolst1[$i][2],"' ",notempty($_POST['ti13'],$poolst1[$i][2]),"> ",$poolst1[$i][2],"<br>";
				}
				echo "<input type='submit' name='Qui a gagné?'></form></div>";
				if(!empty($_POST['ti11'])&&!empty($_POST['ti12'])&&!empty($_POST['ti13'])){
					$ti11=$_POST['ti11'];
					$ti12=$_POST['ti12'];
					$ti13=$_POST['ti13'];
					$a=array_count_values($ti11);
					$b=array_count_values($ti12);
					$c=array_count_values($ti13);
					$total=array_merge($ti11,$ti12,$ti13);
					$vovo=array_count_values($total);
					if(max($vovo)==1){
						$teamm2=$_POST['t1'];
						$random=$total[rand(0,2)];
						$winner=$random;
						$q=$db->prepare("UPDATE `equipes` SET Manche1='0' WHERE POOL='$m2'"); 
						$q->execute(); 
						$q=$db->prepare("UPDATE `equipes` SET Manche1='1' WHERE NAME='$winner' "); 
						$q->execute(); 
						$q->closeCursor();
						$teamm2[]=$random;
						$_SESSION['teamm2']=$teamm2;					
					}
					else{
						$d=array_search(max($vovo),$vovo);
						$teamm2=$_POST['t1'];
						$teamm2[]=$d;
						//$q=$db->prepare("UPDATE `equipes` SET Manche1='0' WHERE POOL='$m2'"); 
						//$q->execute(); 
						$q=$db->prepare("UPDATE `equipes` SET Manche1='1' WHERE NAME='$d' "); 
						$q->execute(); 
						$_SESSION['teamm2']=$teamm2;
					}
				}
			}
			$test=count($poolst1,COUNT_RECURSIVE);
			

			//Deuxième manche
			$poolst2=array();
			//répartition des équipes dans les pools au 2eme tour
			if(isset($_SESSION['teamm2'])){$count=count($_SESSION['teamm2']);}else{$count=0;}
			if(!empty($_SESSION['teamm2'])&&$test>=4&&$count==$m2){
				if($m2%2==0){
					$j=0;
					for($i=0;$i<($m2/2);$i++){
						for($k=0;$k<2;$k++){
							$poolst2[$i][]=$_SESSION['teamm2'][$j]; 
							$j++;
						}
					}
					$ko=1;
					for($i=0;$i<$m3;$i++){
						for($j=0;$j<2;$j++){
							$name=$poolst2[$i][$j];
							$q=$db->prepare("UPDATE `equipes` SET POOL2='$ko' WHERE NAME='$name'");
							$q->execute(); 
							$q->closeCursor();
						}
						$ko++;
					}
					// questionnaire sur les qualifications du T2:
					echo "<div id='t2'><h2>Tour 2: </h2><br><form method='post'>";
					if(empty($_POST['t2'])){$_POST['t2']=[];}
					for($i=0;$i<$m2/2;$i++){
						echo $poolst2[$i][0]." VS ".$poolst2[$i][1],"<br>";
						echo "<input type='radio' name='t2[]",$i+1,"' value='",$poolst2[$i][0],"' ",notempty($_POST['t2'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
						echo "<input type='radio' name='t2[]",$i+1,"' value='",$poolst2[$i][1],"' ",notempty($_POST['t2'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";
						if(!empty($_POST['t2'])){
							$winner=wichwin($poolst2[$i][0],$poolst2[$i][1],$_POST['t2']);
							$loser=wichlose($poolst2[$i][0],$poolst2[$i][1],$_POST['t2']);
							$q=$db->prepare("UPDATE `equipes` SET Manche2='1' WHERE NAME='$winner' "); 
							$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Manche2='0' WHERE NAME='$loser' "); 
							$q->execute();
							$q->closeCursor();
						}
					}
					echo "<input type='submit' name='Qui a gagné?'></form><br></div>";
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
					$ko=1;
					for($i=0;$i<$m2/2-2;$i++){
						for($k=0;$k<2;$k++){
							$name=$poolst2[$i][$k];
							$q=$db->prepare("UPDATE `equipes` SET POOL2='$ko' WHERE NAME='$name'"); 
							$q->execute(); 
							$q->closeCursor();
						}
						$ko++;
					}	
					$j=$m2-3;
					for($i=$i;$i<($m2/2)-1;$i++){
						for($k=0;$k<3;$k++){
							$poolst2[$i][]=$_SESSION['teamm2'][$j];
							$j++;
							$name=$poolst2[$i][$k];
							$q=$db->prepare("UPDATE `equipes` SET POOL2='$ko' WHERE NAME='$name'"); 
							$q->execute();
							$q->closeCursor();
						}		
					}
					// questionnaire sur les qualifications du T2:
					echo "<div id='t2'><h2>Tour 2: </h2><br><form method='post'>";
					if($m2>3){
						if(empty($_POST['t2'])){$_POST['t2']=[];}
						for($i=0;$i<($m2-3)/2;$i++){
							echo $poolst2[$i][0]." VS ".$poolst2[$i][1],"<br>";
							echo "<input type='radio' name='t2[]",$i+1,"' value='",$poolst2[$i][0],"' ",notempty($_POST['t2'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
							echo "<input type='radio' name='t2[]",$i+1,"' value='",$poolst2[$i][1],"' ",notempty($_POST['t2'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";
							$winner=wichwin($poolst2[$i][0],$poolst2[$i][1],$_POST['t2']);
							$loser=wichlose($poolst2[$i][0],$poolst2[$i][1],$_POST['t2']);
							$q=$db->prepare("UPDATE `equipes` SET Manche2='1' WHERE NAME='$winner' "); 
							$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Manche2='0' WHERE NAME='$loser' "); 
							$q->execute();
							$q->closeCursor();
						}
					}else{
					$_POST['t2']=[];
					}
					if(empty($_POST['ti21'])){$_POST['ti21']=[];}
					if(empty($_POST['ti22'])){$_POST['ti22']=[];}
					if(empty($_POST['ti23'])){$_POST['ti23']=[];}
					for($i=($m2-3)/2;$i<(($m2-3)/2)+1;$i++){
						$p=$i+1;
						echo $poolst2[$i][0]." VS ".$poolst2[$i][1],"<br>";
						echo "<input type='radio' name='ti21[]",$p,"' value='",$poolst2[$i][0],"' ",notempty($_POST['ti21'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
						echo "<input type='radio' name='ti21[]",$p,"' value='",$poolst2[$i][1],"' ",notempty($_POST['ti21'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";

						echo $poolst2[$i][1]." VS ".$poolst2[$i][2],"<br>";
						echo "<input type='radio' name='ti22[]",$p+1,"' value='",$poolst2[$i][1],"' ",notempty($_POST['ti22'],$poolst2[$i][1]),"> ",$poolst2[$i][1],"<br>";
						echo "<input type='radio' name='ti22[]",$p+1,"' value='",$poolst2[$i][2],"' ",notempty($_POST['ti22'],$poolst2[$i][2]),"> ",$poolst2[$i][2],"<br>";

						echo $poolst2[$i][0]." VS ".$poolst2[$i][2],"<br>";
						echo "<input type='radio' name='ti23[]",$p+2,"' value='",$poolst2[$i][0],"' ",notempty($_POST['ti23'],$poolst2[$i][0]),"> ",$poolst2[$i][0],"<br>";
						echo "<input type='radio' name='ti23[]",$p+2,"' value='",$poolst2[$i][2],"' ",notempty($_POST['ti23'],$poolst2[$i][2]),"> ",$poolst2[$i][2],"<br>";
					}
					echo "<input type='submit' name='Qui a gagné?'></form></div>";
					if(!empty($_POST['ti21'])&&!empty($_POST['ti22'])&&!empty($_POST['ti23'])){
						$ti21=$_POST['ti21'];
						$ti22=$_POST['ti22'];
						$ti23=$_POST['ti23'];
						$a=array_count_values($ti21);
						$b=array_count_values($ti22);
						$c=array_count_values($ti23);
						$total=array_merge($ti21,$ti22,$ti23);
						$vovo=array_count_values($total);
						if(max($vovo)==1){
							$teamm3=$_POST['t2'];
							$random=$total[rand(0,2)];
							$teamm3[]=$random;
							$winner=$random;
							$q=$db->prepare("UPDATE `equipes` SET Manche2='0' WHERE POOL='$m3'"); 
							$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Manche2='1' WHERE NAME='$winner' "); 
							$q->execute(); 
							$q->closeCursor();
							$_SESSION['teamm3']=$teamm3;					
						}
						else{
							$d=array_search(max($vovo),$vovo);
							$teamm3=$_POST['t2'];
							$teamm3[]=$d;
							//$q=$db->prepare("UPDATE `equipes` SET Manche2='0' WHERE POOL='$m3'"); 
							//$q->execute();
							$q=$db->prepare("UPDATE `equipes` SET Manche2='1' WHERE NAME='$d' "); 
							$q->execute();
							$_SESSION['teamm3']=$teamm3;
						}
					}
				}
				$test=count($poolst2,COUNT_RECURSIVE);
			}

			//Troisième manche
			$poolst3=array();
			//répartition des équipes dans les pools au 3eme tour
			if(isset($_SESSION['teamm3'])){$count=count($_SESSION['teamm3']);}else{$count=0;}
			if(!empty($_SESSION['teamm3'])&&$test>=4&&$count==$m3){
				if($m3%2==0){
					$j=0;
					for($i=0;$i<($m3/2);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst3[$i][]=$_SESSION['teamm3'][$j]; 
							$j++;
						}
					}
					$ko=1;
					for($i=0;$i<$m4;$i++){
						for($j=0;$j<2;$j++){
							$name=$poolst3[$i][$j];
							$q=$db->prepare("UPDATE `equipes` SET POOL3='$ko' WHERE NAME='$name'");
							$q->execute(); 
							$q->closeCursor();
						}
						$ko++;
					}	
					// questionnaire sur les qualifications du T3:
					echo "<div id='t3'><h2>Tour 3: </h2><br><form method='post'>";
					if(empty($_POST['t3'])){$_POST['t3']=[];}
					for($i=0;$i<$m3/2;$i++){
						echo $poolst3[$i][0]." VS ".$poolst3[$i][1],"<br>";
						echo "<input type='radio' name='t3[]",$i+1,"' value='",$poolst3[$i][0],"' ",notempty($_POST['t3'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
						echo "<input type='radio' name='t3[]",$i+1,"' value='",$poolst3[$i][1],"' ",notempty($_POST['t3'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";
						if(!empty($_POST['t3'])){
							$winner=wichwin($poolst3[$i][0],$poolst3[$i][1],$_POST['t3']);
							$loser=wichlose($poolst3[$i][0],$poolst3[$i][1],$_POST['t3']);
							$q=$db->prepare("UPDATE `equipes` SET Manche3='1' WHERE NAME='$winner' "); 
							$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Manche3='0' WHERE NAME='$loser' "); 
							$q->execute();
							$q->closeCursor();
						}
					}
					echo "<input type='submit' name='Qui a gagné?'></form></div>";
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
					$ko=1;
					for($i=0;$i<$m3/2-2;$i++){
						for($k=0;$k<2;$k++){
							$name=$poolst3[$i][$k];
							$q=$db->prepare("UPDATE `equipes` SET POOL3='$ko' WHERE NAME='$name'"); 
							$q->execute(); 
							$q->closeCursor();
						}
						$ko++;
					}	
					$j=$m3-3;
					for($i=$i;$i<($m3/2)-1;$i++){
						for($k=0;$k<3;$k++){
							$poolst3[$i][]=$_SESSION['teamm3'][$j];
							$j++;
							$name=$poolst3[$i][$k];
							$q=$db->prepare("UPDATE `equipes` SET POOL3='$ko' WHERE NAME='$name'"); 
							$q->execute();
							$q->closeCursor();
						}		
					}
					// questionnaire sur les qualifications du T3:
					echo "<div id='t3'><h2>Tour 3: </h2><br><form method='post'>";
					if($m3>3){
						if(empty($_POST['t3'])){$_POST['t3']=[];}
						for($i=0;$i<($m3-3)/2;$i++)
						{
							echo $poolst3[$i][0]." VS ".$poolst3[$i][1],"<br>";
							echo "<input type='radio' name='t3[]",$i+1,"' value='",$poolst3[$i][0],"' ",notempty($_POST['t3'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
							echo "<input type='radio' name='t3[]",$i+1,"' value='",$poolst3[$i][1],"' ",notempty($_POST['t3'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";
							$winner=wichwin($poolst3[$i][0],$poolst3[$i][1],$_POST['t3']);
							$loser=wichlose($poolst3[$i][0],$poolst3[$i][1],$_POST['t3']);
							$q=$db->prepare("UPDATE `equipes` SET Manche3='1' WHERE NAME='$winner' "); 
							$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Manche3='0' WHERE NAME='$loser' "); 
							$q->execute();
							$q->closeCursor();
						}
					}else{
						$_POST['t3']=[];
					}
					if(empty($_POST['ti31'])){$_POST['ti31']=[];}
					if(empty($_POST['ti32'])){$_POST['ti32']=[];}
					if(empty($_POST['ti33'])){$_POST['ti33']=[];}
					for($i=($m3-3)/2;$i<(($m3-3)/2)+1;$i++){
						$p=$i+1;
						echo $poolst3[$i][0]." VS ".$poolst3[$i][1],"<br>";
						echo "<input type='radio' name='ti31[]",$p,"' value='",$poolst3[$i][0],"' ",notempty($_POST['ti31'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
						echo "<input type='radio' name='ti31[]",$p,"' value='",$poolst3[$i][1],"' ",notempty($_POST['ti31'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";

						echo $poolst3[$i][1]." VS ".$poolst3[$i][2],"<br>";
						echo "<input type='radio' name='ti32[]",$p+1,"' value='",$poolst3[$i][1],"' ",notempty($_POST['ti32'],$poolst3[$i][1]),"> ",$poolst3[$i][1],"<br>";
						echo "<input type='radio' name='ti32[]",$p+1,"' value='",$poolst3[$i][2],"' ",notempty($_POST['ti32'],$poolst3[$i][2]),"> ",$poolst3[$i][2],"<br>";

						echo $poolst3[$i][0]." VS ".$poolst3[$i][2],"<br>";
						echo "<input type='radio' name='ti33[]",$p+2,"' value='",$poolst3[$i][0],"' ",notempty($_POST['ti33'],$poolst3[$i][0]),"> ",$poolst3[$i][0],"<br>";
						echo "<input type='radio' name='ti33[]",$p+2,"' value='",$poolst3[$i][2],"' ",notempty($_POST['ti33'],$poolst3[$i][2]),"> ",$poolst3[$i][2],"<br>";
					}
					echo "<input type='submit' name='Qui a gagné?'></form></div>";
					if(!empty($_POST['ti31'])&&!empty($_POST['ti32'])&&!empty($_POST['ti33'])){
						$ti31=$_POST['ti31'];
						$ti32=$_POST['ti32'];
						$ti33=$_POST['ti33'];
						$a=array_count_values($ti31);
						$b=array_count_values($ti32);
						$c=array_count_values($ti33);
						$total=array_merge($ti31,$ti32,$ti33);
						$vovo=array_count_values($total);
						if(max($vovo)==1){
							$teamm4=$_POST['t3'];
							$random=$total[rand(0,2)];
							$teamm4[]=$random;
							$winner=$random;
							$q=$db->prepare("UPDATE `equipes` SET Manche3='0' WHERE POOL='$m4'"); 
							$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Manche3='1' WHERE NAME='$winner' "); 
							$q->execute(); 
							$q->closeCursor();
							$_SESSION['teamm4']=$teamm4;					
						}
						else{
							$d=array_search(max($vovo),$vovo);
							$teamm4=$_POST['t3'];
							$teamm4[]=$d;
							//$q=$db->prepare("UPDATE `equipes` SET Manche3='0' WHERE POOL='$m4'"); 
							//$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Manche3='1' WHERE NAME='$d' "); 
							$q->execute();
							$_SESSION['teamm4']=$teamm4;
						}
					}
				}
				$test=count($poolst3,COUNT_RECURSIVE);
			}


			//Quatrième manche
			$poolst4=array();
			//répartition des équipes dans les pools au 4eme tour
			if(isset($_SESSION['teamm4'])){$count=count($_SESSION['teamm4']);}else{$count=0;}
			if(!empty($_SESSION['teamm4'])&&$test>=4&&$count==$m4){
				if($m4%2==0){
					$j=0;
					for($i=0;$i<($m4/2);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst4[$i][]=$_SESSION['teamm4'][$j]; 
							$j++;
						}
					}
					$ko=1;
					for($i=0;$i<$m5;$i++){
						for($j=0;$j<2;$j++){
							$name=$poolst4[$i][$j];
							$q=$db->prepare("UPDATE `equipes` SET POOL4='$ko' WHERE NAME='$name'");
							$q->execute(); 
							$q->closeCursor();
						}
						$ko++;
					}	
					// questionnaire sur les qualifications du T4:
					echo "<div id='t4'><h2>Tour 4: </h2><br><form method='post'>";
					if(empty($_POST['t4'])){$_POST['t4']=[];}
					for($i=0;$i<$m4/2;$i++){
						echo $poolst4[$i][0]." VS ".$poolst4[$i][1],"<br>";
						echo "<input type='radio' name='t4[]",$i+1,"' value='",$poolst4[$i][0],"' ",notempty($_POST['t4'],$poolst4[$i][0]),"> ",$poolst4[$i][0],"<br>";
						echo "<input type='radio' name='t4[]",$i+1,"' value='",$poolst4[$i][1],"' ",notempty($_POST['t4'],$poolst4[$i][1]),"> ",$poolst4[$i][1],"<br>";
						if(!empty($_POST['t4'])){
							$winner=wichwin($poolst4[$i][0],$poolst4[$i][1],$_POST['t4']);
							$loser=wichlose($poolst4[$i][0],$poolst4[$i][1],$_POST['t4']);
							$q=$db->prepare("UPDATE `equipes` SET Finale='1' WHERE NAME='$winner' "); 
							$q->execute(); 
							$q=$db->prepare("UPDATE `equipes` SET Finale='0' WHERE NAME='$loser' "); 
							$q->execute();
							$q->closeCursor();
						}
					}
					echo "<input type='submit' name='Qui a gagné?'></form></div>";
				}else{
					$j=0;
					for($i=0;$i<(floor($m4/2)-1);$i++){
						$l=$i+1;
						for($k=0;$k<2;$k++){
							$poolst4[$i][]=$_SESSION['teamm4'][$j];
							$j++;
						}
					}
					$ko=1;
					for($i=0;$i<$m4/2-2;$i++){
						for($k=0;$k<2;$k++){
							$name=$poolst4[$i][$k];
							$q=$db->prepare("UPDATE `equipes` SET Finale='$ko' WHERE NAME='$name'"); 
							$q->execute(); 
							$q->closeCursor();
						}
						$ko++;
					}	
					$j=$m4-3;
					for($i=$i;$i<($m4/2)-1;$i++){
						for($k=0;$k<3;$k++){
							$poolst4[$i][]=$_SESSION['teamm4'][$j];
							$j++;
							$name=$poolst4[$i][$k];
							$q=$db->prepare("UPDATE `equipes` SET Finale='$ko' WHERE NAME='$name'"); 
							$q->execute();
							$q->closeCursor();
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
/*
		var_dump($poolst1);
		if($m1%2==0){
			for($i=0;$i<$m2;$i++){
				echo "match",$i+1,"<br>";
				for($j=0;$j<2;$j++){
					echo $poolst1[$i][$j],"<br>";
				}
			}
		}else{
			for($i=0;$i<$m2-1;$i++){
				echo "match",$i+1,"<br>";
				for($j=0;$j<2;$j++){
					echo $poolst1[$i][$j],"<br>";
				}
			}
			for($i=$m2-3;$i<$m2-2;$i++){
			$j=1;
			}
		}
		
/*
		$t1=count($poolst1);
		for($i=0;$i<$t1;$i++){
			//var_dump($poolst1[$i]);
			for($j=0;$j<count($poolst1[$j]);$j++){
				echo $j;
			}
		}
		//t2
		
		$t2=count($poolst2);
		for($i=0;$i<$t2;$i++){
			//var_dump($poolst1[$i]);
			for($j=0;$j<count($poolst2[$j]);$j++){
				echo $j;
			}
		}
		//t3
		$t3=count($poolst3);
		for($i=0;$i<$t3;$i++){
			//var_dump($poolst1[$i]);
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
		*/
		?>
	</body>
</html>
