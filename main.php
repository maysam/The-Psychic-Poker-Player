<?php

//	Hand: TH JH QC QD QS Deck: QH KH AH 2S 6S Best hand: 
const straight_flush	=	1;
//	Hand: 2H 2S 3H 3S 3C Deck: 2D 3D 6C 9C TH Best hand: 
const four_of_a_kind	=	2;
//	Hand: 2H 2S 3H 3S 3C Deck: 2D 9C 3D 6C TH Best hand: 
const full_house		=	3;
//	Hand: 2H AD 5H AC 7H Deck: AH 6H 9H 4H 3C Best hand: 
const flush				=	4;
//	Hand: AC 2D 9C 3S KD Deck: 5S 4D KS AS 4C Best hand: 
const straight			=	5;
//	Hand: KS AH 2H 3C 4H Deck: KC 2C TC 2D AS Best hand: 
const three_of_a_kind	=	6;
//	Hand: AH 2C 9S AD 3C Deck: QH KS JS JD KD Best hand: 
const two_pairs			=	7;
//	Hand: 6C 9C 8C 2D 7C Deck: 2H TC 4C 9S AH Best hand: 
const one_pair			=	8;
//	Hand: 3D 5S 2H QD TD Deck: 6S KH 9H AD QH Best hand: 
const highest_card		=	9;

class Card {
	public $value;	//	A	1	2-9	T	10	J	11	Q	12	K	13
	public $suit;	//	C	0	D	1	H	2	S	3
	public $text;
    
	function __construct($str) {
        $this->text = $str; 
		$this->value = $str[0];
		$this->suit = $str[1];
		switch($this->value) {
			case 'A':
				$this->value = 1;
				break;
			case 'T':
				$this->value = 10;
				break;
			case 'J':
				$this->value = 11;
				break;
			case 'Q':
				$this->value = 12;
				break;
			case 'K':
				$this->value = 13;
				break;
		}
		switch($this->suit) {
			case 'C':
				$this->suit = 0;
				break;
			case 'D':
				$this->suit = 1;
				break;
			case 'H':
				$this->suit = 2;
				break;
			case 'S':
                $this->suit = 3;
				break;
		}
	}
	
	public function getHash() {
		return $this->suit*13+$this->value;
	}

    public function toString() {
        return $this->text;
    }
    
}


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
	
	public function bestValue() {
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
					$previous_value = $value;
				} else {
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

class Deck {
	public $cards;
	
	function __construct () {
		$this->cards = array();
	}
	
	public function addCard (Card $card) {
		array_push($this->cards, $card);
	}
	
	public function removeCard () {
		return array_shift($this->cards);
	}

    public function toString() {
        foreach($this->cards as $card) {
            $str[] = $card->toString();
        }
        return implode(' ', $str);
    }
}

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
            $this->cards[$card->getHash()] = $card;
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
				 	straight_flush	=>	'straight flush',
					four_of_a_kind	=>	'four of a kind',
					full_house		=>	'full house',
					flush			=>	'flush',
					straight		=>	'straight',
					three_of_a_kind	=>	'three of a kind',
					two_pairs		=>	'two pairs',
					one_pair		=>	'one pair',
					highest_card	=>	'highest card'
				);
        $str = 'Hand: ';
        $str.= $this->hand->toString();
        $str.= ' Deck: ';
        $str.= $this->deck->toString();
        $str.= ' Best hand: ';
        $str.= $result[$this->hand->bestValue()];
        return $str;
    }
}


while(true) {
    $current_line = fgets(STDIN,1024);
    $current_line = trim($current_line);
    if($current_line) {
//    	printf("$current_line\r\n");
        $game = new Game($current_line);
        printf($game->bestHand()."\r\n\r\n");
    } else {
        exit;
    }
}
?>