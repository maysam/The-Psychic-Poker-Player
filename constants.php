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

?>