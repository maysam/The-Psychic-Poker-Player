<?php

class Game {
        
    public $cards;
 	public $hand;
 	public $deck;
    
    function __construct ($input) {
        $parts = explode(' ',$input);
        if(count($parts) != 10)
            return false;
        $this->hand = new Hand();
        $this->deck = new Deck();
        foreach($parts as $part) {
            $card = new Card($part);
            $this->cards[] = $card;
            $i++;
            if ($i <= 5) {
                $this->hand->addCard($card);
            } else {
                $this->deck->addCard($card);
            }
        }
    }
    
    function bestHand() {
		$result = array(
				 	straight_flush	=>	'straight-flush',
					four_of_a_kind	=>	'four-of-a-kind',
					full_house		=>	'full-house',
					flush			=>	'flush',
					straight		=>	'straight',
					three_of_a_kind	=>	'three-of-a-kind',
					two_pairs		=>	'two-pairs',
					one_pair		=>	'one-pair',
					highest_card	=>	'highest-card'
				);
		global $combinations;
		$bestValue = highest_card;
    	for($i=0;$i<=5;$i++) {
    		//	take i number from hand and take the rest from the deck
    		//	cards on deck are fixed, so we shuffle from the hand $i! combinations
    		//	choose (5-i) cards from first 5 cards (0-4) and (i) cards in order from second 5 cards (5-9)
    		foreach($combinations[$i] as $comb) {
    			$hand = new Hand();
    			foreach($comb as $id) {
    				$hand->addCard($this->cards[$id]);
    			}
	    		for($j=5;$j<10-$i;$j++)
	    			$hand->addCard($this->cards[$j]);
	    		$value = $hand->getValue();
	    		if ($value < $bestValue)
	    			$bestValue = $value;
	    		if ($bestValue == straight_flush)
	    			break 2;
    		}    		
    	}

        $str = 'Hand: '.$this->hand->toString().' Deck: '.$this->deck->toString().' Best hand: '.$result[$bestValue];
        return $str;
    }
}

?>