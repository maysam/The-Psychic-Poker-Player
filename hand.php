<?php

class Hand {
	public $cards;
	
	function __construct () {
		$this->cards = array();
	}
	
	public function addCard (Card $card) {
		$this->cards[$card->getHash()] = $card;
	}
	
	public function removeCard (Card $card) {
		unset($this->cards[$card->getHash()]);
	}
	
	public function getValue() {
	//	ksort($cards);
		foreach ($this->cards as $card) {
			$suits[$card->suit] ++;
			$values[$card->value] ++;
		}
		foreach ($suits as $suit => $count) {
			if ($count==5) {
				$flush = true;
			}
		}
		$previous_value = 0;
		//sort values for `straight` calculation
		ksort($values);
		foreach ($values as $value => $count) {
			if ($count == 4) {
				$fourkind = true;
			}
			if ($count == 3) {
				$threekind = true;
			}
			if ($count==2) {
				if ($pair) {
					$twopair = true;
				} else {
					$pair = true;
				}
			}
			if ($count>1) {
				$previous_value = -10;
			} elseif ($previous_value == 0) {
				$previous_value = $value;
			} elseif ($previous_value > 0) {
				if ($value==$previous_value+1) {
					//	normal sequence
					$previous_value = $value;
				} elseif ($value==10 && $previous_value==1) {
					//	A T J Q K sequence
					$previous_value = $value;
				} else {
					//	no sequence
					$previous_value = -10;
				}
			}
		}
		if ($previous_value>0) {
			$straight = true;
			if ($flush) {
				return straight_flush;
			}
		}
        if  ($fourkind) {
            return four_of_a_kind;
        }
		if ( $threekind && $pair ) {
			$fullhouse = true;
            return full_house;
		}
        if ($flush) {
            return flush;
        }
        if ($straight) {
            return straight;
        }
		if ( $threekind ) {
            return three_of_a_kind;
		}
		if ( $twopair ) {
            return two_pairs;
		}
		if ( $pair ) {
            return one_pair;
		}
        return highest_card;
	}

    public function toString() {
        foreach($this->cards as $card) {
            $str[] = $card->toString();
        }
        return implode(' ', $str);
    }
}
?>