<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Player.php';
require  'Dealer.php';
require 'Blackjack.php';


//--------------------- Setting the game


session_start();

//-------------- Putting score in a session variable

if (!isset($_SESSION["score"])) {
    $_SESSION["score"] = 0;
}

if (!isset($_SESSION["blackjack"])) {
    $_SESSION["blackjack"] = new Blackjack();
}

$game=$_SESSION["blackjack"];

$deck =$game->getDeck();
$player = $game->getPlayer();
$dealer = $game->getDealer();
$_SESSION["score"] = $player->getScore();


//--------------------- Actions

//---- Hit

if (isset ($_POST['hit'])) {
        $player->hit($deck);
        $_SESSION["score"] = $player->getScore();
        if ($player->isLost()==true){
    echo 'You exceed 21, you loose, play again !';
    }

}

//---- Stand

elseif (isset ($_POST['stand'])) {
        $dealer->hit($deck);
        if ($dealer->isLost()==false){
            if ($player->getScore()<$dealer->getScore()){
                echo 'The dealer made : '.$dealer->getScore().'. Too bad, you loose !';
            }
            elseif ($player->getScore()==$dealer->getScore()){
                echo 'Ex Aequo ... The dealer win, play again !';
            }
            else {echo 'The dealer made : '.$dealer->getScore().'. Well done, you win !';}
        }
}

//---- Surrender

elseif (isset ($_POST['surrender'])) {
        $player->hasLost();
}


//--------------------- Reset
if (isset ($_POST['reset'])) {
    session_unset();
    $_SESSION["blackjack"] = new Blackjack();
    $game=$_SESSION["blackjack"];

    $deck =$game->getDeck();
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

        <div class="row">
            <div class="col-md-6">
                <h1>Player</h1>
                <h2>Your cards : </C></h2>
                <?php foreach ($player->getCards() as $card): ?>
                    <p><?php
                        echo $card->getUnicodeCharacter(true);
                        echo '<br>'; ?> </p>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <h1>Dealer</h1>
                <h2>Cards : </C></h2>
                    <p><?php
                        echo $dealer->getCards()[0]->getUnicodeCharacter(true);
                        echo '<br>'; ?> </p>

            </div>
            <div>
                <h2>Score :</h2>
                <p><?php if(isset($_SESSION["score"])){echo $_SESSION["score"];} ?>
                </p>
            </div>
        </div>


    </section>
    <form method="post" action="index.php">

        <button type="submit" name="hit" class="btn btn-primary">Hit</button>
        <button type="submit" name="stand" class="btn btn-primary">Stand</button>
        <button type="submit" name="surrender" class="btn btn-primary">Surrender</button>
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



