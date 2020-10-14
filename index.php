<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Player.php';
require 'Dealer.php';
require 'Blackjack.php';


//--------------------- Setting the game


session_start();

if (!isset($_SESSION["blackjack"])) {
    $_SESSION["blackjack"] = new Blackjack();
}
if (!isset($_SESSION["chip"])) {
    $_SESSION["chip"] = 100;
}
if (!isset($_SESSION["bet"])) {
    $_SESSION["bet"] = 0;
}
$game = $_SESSION["blackjack"];
$chip = $_SESSION["chip"];

$deck = $game->getDeck();
$player = $game->getPlayer();
$dealer = $game->getDealer();

$statusMessage = "";

//--------------------- Adding bet

if (isset($_POST['bet'])) {
    $_SESSION["bet"] = $_POST['bet'];
    $chip = $_SESSION['chip'];
}
//--------------------- First turn rule
const AUTO_WIN=10;
const AUTO_LOOSE=5;
//if ( $player->getScore()==21 || $dealer->getScore()!=21){
//    $dealer->hasLost();
//    $statusMessage = '<div class="alert alert-info" role="alert">You win already, congrats!</div>';
//
//    $chip += AUTO_WIN ;
//    $_SESSION["chip"] = $chip;
//}
//if ( $player->getScore()!=21 || $dealer->getScore()==21){
//    $player->hasLost();
//    $chip += -AUTO_LOOSE ;
//    $_SESSION["chip"] = $chip;
//    $statusMessage = '<div class="alert alert-info" role="alert">Oh no, you loose already!</div>';
//}
//if ( $player->getScore()==21 && $dealer->getScore()==21){
//    $player->hasLost();
//    $dealer->hasLost();
//    $statusMessage = '<div class="alert alert-info" role="alert">It is a tie!</div>';
//}



//--------------------- Actions

//---- Hit
if (!isset($_POST['action'])) {
    $statusMessage = '<div class="alert alert-info" role="alert">The game starts</div>';
} else {
    if ($_SESSION['bet']==0){
        $statusMessage = '<div class="alert alert-info" role="alert">You have to bet at least 5 Chips to play !</div>';
    }
    else {
        if ($_POST['action'] === 'hit') {
            $player->hit($deck);
            $_SESSION["score"] = $player->getScore();
            if ($player->isLost() == true) {
                $statusMessage = '<div class="alert alert-info" role="alert">You exceed 21, you loose!</div>';
            }

        } //---- Stand

        elseif ($_POST['action'] === 'stand') {
            $dealer->hit($deck);
            if ($dealer->isLost() == false) {
                if ($player->getScore() < $dealer->getScore()) {
                    $statusMessage = '<div class="alert alert-info" role="alert">The dealer made : ' . $dealer->getScore() . '. Too bad, you loose !</div>';
                    $player->hasLost();

                } elseif ($player->getScore() == $dealer->getScore()) {
                    $statusMessage = '<div class="alert alert-info" role="alert">Ex Aequo ... The dealer win!</div>';
                    $player->hasLost();
                } else {
                    $statusMessage = '<div class="alert alert-info" role="alert">The dealer made : ' . $dealer->getScore() . '. Well done, you win !</div>';
                    $dealer->hasLost();
                }
            } else {
                $statusMessage = '<div class="alert alert-info" role="alert">The dealer made : ' . $dealer->getScore() . '. Well done, you win !</div>';
                $dealer->hasLost();
            }
        } //---- Surrender

        elseif ($_POST['action'] === 'surrender') {
            $player->hasLost();
            $statusMessage = '<div class="alert alert-info" role="alert">Too bad!</div>';
        }
    }
    }


//---------------------Bet results

if (isset($_POST['action'])) {

    if ($player->isLost() == true) {
        $chip = $chip - $_SESSION["bet"];
        $_SESSION["chip"] = $chip;
    }
    if ($dealer->isLost() == true) {

        $chip += 2 * ($_SESSION["bet"]);
        $_SESSION["chip"] = $chip;
    }
}



//--------------------- Reset


if (isset ($_POST['reset'])) {
    unset($_SESSION["blackjack"]);
    unset($_SESSION["bet"]) ;
    $_SESSION["blackjack"] = new Blackjack();
    $game = $_SESSION["blackjack"];

    $deck = $game->getDeck();
    $player = $game->getPlayer();
    $dealer = $game->getDealer();
    $_SESSION["score"] = $player->getScore();
}


?>

<!doctype html>
<html lang="en">
<head>
    <title>Blackjack</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<section class="container">
    <section>
        <p> <?php echo $statusMessage ?></p>
    </section>
    <section>
        <div class="row">
            <div class="col-md-6">
                <h2>Player</h2>
                <h3>Your cards : </h3>
                <?php foreach ($player->getCards() as $card): ?>
                    <p class="display-1"><?php
                        echo $card->getUnicodeCharacter(true);
                        echo '<br>'; ?> </p>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <h2>Dealer</h2>
                <h3>Cards : </C></h3>
                <p class="display-1"><?php
                    if ($player->isLost() == true || $dealer->isLost() == true) {
                        foreach ($dealer->getCards() as $card) {
                            echo $card->getUnicodeCharacter(true);
                            echo '<br>';
                        }
                    } else {
                        echo $dealer->getCards()[0]->getUnicodeCharacter(true);
                    }

                    ?> </p>
            </div>
        </div>
        <div>
            <h2>Bet</h2>
            <h3>Your chips :</h3>
            <p><?php echo $chip; ?></p>
            <form method="post" action="index.php">
                <label for="quantity">How much do you want to bet ?:</label>
                <input type="number" id="bet" name="bet" value="<?php if (isset ($_SESSION["bet"])) {
                    echo $_SESSION["bet"];
                } ?>" min="5" max="<?php echo $chip; ?>">
                <input type="submit" name="submit" value="Bet">
            </form>

        </div>


    </section>
    <form method="post" action="index.php">
        <?php if ($player->isLost() == true || $dealer->isLost() == true) {
            echo "<p>End of the game, play again !</p>";
        } else {
            echo '<button type="submit" name="action" value="hit" class="btn btn-primary">Hit</button>
        <button type="submit" name="action" value="stand" class="btn btn-primary">Stand</button>
        <button type="submit" name="action" value="surrender" class="btn btn-primary">Surrender</button>';
        }
        ?>


        <button type="submit" name="reset" class="btn btn-primary">Reset</button>


    </form>

    <div>
        <h2>Scores :</h2>
        <div class="row">

            <div class="col-md-6">
                <h3>Player</h3>
                <p><?php if (isset($_SESSION["score"])) {
                        echo $player->getScore();
                    } ?></p>
            </div>
            <div class="col-md-6">
                <?php if ($player->isLost() == true || $dealer->isLost() == true) {
                    echo '<h3>Dealer</h3> <p>' . $dealer->getScore() . '</p>';
                }
                ?>

            </div>

        </div>
    </div>


</section>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>



