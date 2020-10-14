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

$game = $_SESSION["blackjack"];

$deck = $game->getDeck();
$player = $game->getPlayer();
$dealer = $game->getDealer();
$_SESSION["score"] = $player->getScore();

$statusMessage = "";
//--------------------- Actions

//---- Hit
if (!isset($_POST['action'])) {
    $statusMessage = 'The game starts';
} else {

    if ($_POST['action'] === 'hit') {
        $player->hit($deck);
        $_SESSION["score"] = $player->getScore();
        if ($player->isLost() == true) {
            $statusMessage = 'You exceed 21, you loose!';
        }

    } //---- Stand

    elseif ($_POST['action'] === 'stand') {
        $dealer->hit($deck);
        if ($dealer->isLost() == false) {
            if ($player->getScore() < $dealer->getScore()) {
                $statusMessage = 'The dealer made : ' . $dealer->getScore() . '. Too bad, you loose !';
                $player->hasLost();
            } elseif ($player->getScore() == $dealer->getScore()) {
                $statusMessage = 'Ex Aequo ... The dealer win!';
                $player->hasLost();
            } else {
                $statusMessage = 'The dealer made : ' . $dealer->getScore() . '. Well done, you win !';
                $dealer->hasLost();
            }
        } else {
            $statusMessage = 'The dealer made : ' . $dealer->getScore() . '. Well done, you win !';
            $dealer->hasLost();
        }
    } //---- Surrender

    elseif ($_POST['action'] === 'surrender') {
        $player->hasLost();
        $statusMessage = "Too bad!";
    }
}

//--------------------- Reset


if (isset ($_POST['reset'])) {
    session_unset();
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
                <h1>Player</h1>
                <h2>Your cards : </C></h2>
                <?php foreach ($player->getCards() as $card): ?>
                    <p class="display-1"><?php
                        echo $card->getUnicodeCharacter(true);
                        echo '<br>'; ?> </p>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <h1>Dealer</h1>
                <h2>Cards : </C></h2>
                    <p class="display-1"><?php
                        if ($player->isLost() == true || $dealer->isLost() == true) {
                            foreach ($dealer->getCards() as $card){
                        echo $card->getUnicodeCharacter(true);
                        echo '<br>';
                            }}
                        else{
                            echo $dealer->getCards()[0]->getUnicodeCharacter(true);
                        }

                        ?> </p>
            </div>
            <div>
                <h1>Scores :</h1>
                <div class="row">

                    <div class="col-md-6">
                        <h2>Player</h2>
                        <p><?php if (isset($_SESSION["score"])) {
                                echo $player->getScore();
                            } ?></p>
                    </div>
                    <div class="col-md-6">
                        <?php if ($player->isLost() == true || $dealer->isLost() == true) {
                            echo '<h2>Dealer</h2> <p>'.$dealer->getScore().'</p>';
                        }
                        ?>

                    </div>

                </div>
            </div>
        </div>


    </section>
    <form method="post" action="index.php">
        <?php if ($player->isLost() == true || $dealer->isLost() == true) {
            echo "End of the game, play again !";

        } else {
            echo '<button type="submit" name="action" value="hit" class="btn btn-primary">Hit</button>
        <button type="submit" name="action" value="stand" class="btn btn-primary">Stand</button>
        <button type="submit" name="action" value="surrender" class="btn btn-primary">Surrender</button>';
        }
        ?>


        <button type="submit" name="reset" class="btn btn-primary">Reset</button>


    </form>

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



