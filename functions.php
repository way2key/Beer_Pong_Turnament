<?php
function amax($array){
    if(is_array($array)){

    	$best=null;
        foreach($array as $key => $value){
            //echo $key;
            //echo $value;
            if($value==max($array)){
            	echo $key;
            }
        }
        return $key;



    }else{
        return $array;
    }
}

function notempty($value,$needle){
if(!empty($value)){
    echo (in_array($needle, $value))? 'checked':'';
    }
}
function wichwin($player1,$player2,$set){
if(in_array($player1, $set)){
    return $player1;
}elseif(in_array($player2,$set)){
    return $player2;
}else{
    return false;
}
}
function wichlose($player1,$player2,$set){
if(in_array($player1, $set)){
    return $player2;
}elseif(in_array($player2,$set)){
    return $player1;
}else{
    return false;
}
}
function winat3($player1,$player2,$player3,$set){
    return True;
}

function Howmanypools($players){
if($players%2==0){return $players/2;}else{return floor($players/2);}
}
?>