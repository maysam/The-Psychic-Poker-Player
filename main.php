<?php

require_once("constants.php");
require_once("card.php");
require_once("hand.php");
require_once("deck.php");
require_once("game.php");

class Main {
	public function run() {
		//	first we cache all the combinatories, so we don't need to calculate them each time
		global $combinations;
		$data = array(0,1,2,3,4);
		$result = array(array()); // We need to start with one empty element, we add or not add one element from data array each time
		foreach ($data as $arr)
		{
		    // This is the cartesian product:
		    $new_result = array();
		    foreach ($result as $old_element) { 
		    	// add item or not add, to all produced combinations
		   		$new_result [] = array_merge($old_element,(array)$arr);
		   		$new_result [] = array_merge($old_element,(array)'null');
		    }
		    $result = $new_result;
		}
		
        //  we need this when we what to take f
        //  put all combinations of same size in separate arrays 
		foreach($result as $arr) {
			//	removing null values
			$arr = array_diff($arr, array('null'));
			//	adding each array of items to the list of arrays of same length
			$combinations[count($arr)][]=$arr;
		}
		
		while(true) {
		    $current_line = fgets(STDIN,1024);
		    $current_line = trim($current_line);
            //  read until reaching an empty line
		    if($current_line != '') {
		        $game = new Game($current_line);
                //  assuming input is valid, otherwise php doesnt care anyway
		        printf($game->bestHand()."\r\n");
		        unset($game);
		    } else {
		        exit;
		    }
		}
	}
}

Main::run();

?>