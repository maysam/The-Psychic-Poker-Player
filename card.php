<?php

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
    
?>