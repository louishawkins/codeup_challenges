<?php

// complete all "todo"s to build a blackjack game

// create an array for suits
$suits = ['C', 'H', 'S', 'D'];

// create an array for cards
$cards = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

// build a deck (array) of cards
// card values should be "VALUE SUIT". ex: "7 H"
// make sure to shuffle the deck before returning it
function buildDeck($suits, $cards) {
  // $deck = array($card, $suit);
	$deck = array();
		foreach($suits as $suit) {
			foreach($cards as $card) {
				$deck[] = $card . $suit;	
			}
		}	
	shuffle($deck);
	return $deck;
}

// determine if a card is an ace
// return true for ace, false for anything else
function cardIsAce($card) {
    return 11;
  }
// determine the value of an individual card (string)
// aces are worth 11
// face cards are worth 10
// numeric cards are worth their value
function getCardValue($card) {
    $splitCard = str_split($card);
    array_pop($splitCard);
    $cardNumber = implode($splitCard);

    if ($cardNumber == "K" || $cardNumber == "Q" || $cardNumber == "J") {
          $cardValue = 10;
          return $cardValue;
    }
    elseif ($cardNumber == "A") {
          $cardValue = cardIsAce($card);
          return $cardValue;
    }
    else {
          $cardValue = (int)$cardNumber;
          return $cardValue;
    }
}
// get total value for a hand of cards
// don't forget to factor in aces
// aces can be 1 or 11 (make them 1 if total value is over 21)
function getHandTotal($hand) {
    $handValues = array();
    foreach ($hand as $card) {
        $handValues[] = getCardValue($card);
    }
    $handTotal = array_sum($handValues);
    return $handTotal;
 }

// draw a card from the deck into a hand
// pass by reference (both hand and deck passed in are modified)
function drawCard(&$hand, &$deck) {
    $hand[] = array_pop($deck);
  }

// print out a hand of cards
// name is the name of the player
// hidden is to initially show only first card of hand (for dealer)
// output should look like this:
// Dealer: [4 C] [???] Total: ???
// or:
// Player: [J D] [2 D] Total: 12
function echoHand($hand, $hidden = false) {
  switch($hidden){
  	case true:
  		echo '[' . $hand[0] . "]";
      echo " [??]";
      break;
  	case false:
  		for($i = 0; $i < sizeof($hand); $i++){
          echo "[{$hand[$i]}] ";
      }
    break;
  }
return;
}

// build the deck of cards
$deck = buildDeck($suits, $cards);

// initialize a dealer and player hand
$dealer = [];
$player = [];

// dealer and player each draw two cards
for($i = 0; $i < 2; $i++) {
	drawCard($dealer, $deck);
  drawCard($player, $deck);
}
// echo the dealer hand, only showing the first card
echo "\nDealer Hand:";
echoHand($dealer, true);

// get dealer hand total
$dealerTotal = getHandTotal($dealer);
// echo the player hand
echo "\n\nPlayer Hand: ";
echoHand($player);
// get player hand total
echo "\n\nplayer total: ";
$playerTotal = getHandTotal($player);
echo $playerTotal;

// allow player to "(H)it or (S)tay?" till they bust (exceed 21) or stay
while ($playerTotal < 22 && $stay == false) {
    echo "\n\n(H)it or (S)tay? ";
    $choice = strtoupper(trim(fgets(STDIN)));
    if ($choice == "H") {
      // Draw card
      drawCard($player, $deck);
      echoHand($player);
      $playerTotal = getHandTotal($player);
      echo "\nPlayer total: $playerTotal";
    }
    elseif ($choice == "S"){
      $stay = true;
    }
}

// show the dealer's hand (all cards)
echo "Dealer's hand revealed: ";
echoHand($dealer);
// at this point, if the player has more than 21, tell them they busted
// otherwise, if they have 21, tell them they won (regardless of dealer hand)
if($dealerTotal < 17){
  drawCard($dealer);
  echo "Deal draws...\n";
  echoHand($dealer);
  $dealerTotal = getHandTotal($dealer);
  echo "Dealer total is {$dealerTotal}";
}

  if($playerTotal > 21) {
      echo "\nYou exceeded 21, busted.\n";
  }
  elseif ($playerTotal == 21) {
      echo "\nTWENTY-ONE!!!\n";
  }
  elseif ($playerTotal < 21 && $playerTotal > $dealerTotal) {
      echo "\nYou beat the dealer, you win!\n";
  }
  elseif ($playerTotal < 21 && $playerTotal < $dealerTotal) {
      echo "\nThe dealer beat you!\n";
  }
  else {
    echo "blah";
  }

// if neither of the above are true, then the dealer needs to draw more cards
// dealer draws until their hand has a value of at least 17
// show the dealer hand each time they draw a card

// finally, we can check and see who won
// by this point, if dealer has busted, then player automatically wins
// if player and dealer tie, it is a "push"
// if dealer has more than player, dealer wins, otherwise, player wins