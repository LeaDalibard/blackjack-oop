<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Player.php';
require 'Blackjack.php';



//--------------------- Setting the game

$blackjack=new Blackjack();

session_start();
if (!isset($_SESSION["blackjack"] )){
    $_SESSION["blackjack"]="";
}
if (isset ($blackjack)){
    $_SESSION["blackjack"] =$blackjack;
}

$deck=$blackjack->getDeck();
$player=$blackjack->getPlayer();
$dealer=$blackjack->getDealer();



var_dump($player);

//--------------------- Actions

//---- Hit

if (isset ($_POST['hit'])){
    if(isset($_SESSION["blackjack"])) {
        $blackjack=$_SESSION["blackjack"];
        $deck=$deck=$blackjack->getDeck();
        $player=$blackjack->getPlayer();
        $dealer=$blackjack->getDealer();
        $player->hit($deck);
    }


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
                <?php foreach ($player->getCards() AS $card): ?>
                <p><?php
                    echo $card->getUnicodeCharacter(true);
                    echo '<br>';?> </p>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <h1>Dealer</h1>
                <h2>Cards : </C></h2>
                <?php foreach ($dealer->getCards() AS $card): ?>
                    <p><?php
                        echo $card->getUnicodeCharacter(true);
                        echo '<br>';?> </p>
                <?php endforeach; ?>
            </div>
        </div>


    </section>
    <form method="post" action="index.php">

        <button type="submit" name="hit" class="btn btn-primary">Hit</button>
        <button type="submit" name="stand" class="btn btn-primary">Stand</button>
        <button type="submit" name="surrender" class="btn btn-primary">Surrender</button>


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



