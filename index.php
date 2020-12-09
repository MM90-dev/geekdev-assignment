<?php

require('character.php');

$carl = new Character("Carl", rand(65, 95), rand(60, 70), rand(40, 50), rand(40, 50), rand(10, 30), "Forta dragonului", "Scutul fermecat");

$beast = new Character("Beast", rand(55, 80), rand(50, 80), rand(35, 55), rand(40, 60), rand(25, 40), null, null);

function presentCharacters($firstPlayer, $secondPlayer)
{
        echo "Present the characters";
        echo "</br>";
        echo "</br>";

        echo $firstPlayer->name . " life: " . $firstPlayer->life;
        echo "</br>";
        echo $firstPlayer->name . " power: " . $firstPlayer->power;
        echo "</br>";
        echo $firstPlayer->name . " defence: " . $firstPlayer->defence;
        echo "</br>";
        echo $firstPlayer->name . " speed: " . $firstPlayer->speed;
        echo "</br>";
        echo $firstPlayer->name . " luck: " . $firstPlayer->luck;
        echo "</br>";
    if (isset($firstPlayer->additionalPower)) {
        echo $firstPlayer->name . " additional power: " . $firstPlayer->additionalPower;
    }
        echo "</br>";
    if (isset($firstPlayer->additionalDefence)) {
        echo $firstPlayer->name . " additional defence: " . $firstPlayer->additionalDefence;
    }
        echo "</br>";
        echo "</br>";
        echo $secondPlayer->name . " life: " . $secondPlayer->life;
        echo "</br>";
        echo $secondPlayer->name . " power: " . $secondPlayer->power;
        echo "</br>";
        echo $secondPlayer->name . " defence: " . $secondPlayer->defence;
        echo "</br>";
        echo $secondPlayer->name . " speed: " . $secondPlayer->speed;
        echo "</br>";
        echo $secondPlayer->name . " luck: " . $secondPlayer->luck;
        echo "</br>";
    if (isset($secondPlayer->additionalPower)) {
        echo $secondPlayer->name . " additional power: " . $secondPlayer->additionalPower;
    }
    echo "</br>";
    if (isset($secondPlayer->additionalDefence)) {
        echo $secondPlayer->name . " additional defence: " . $secondPlayer->additionalDefence;
    }
        echo "</br>";
        echo "</br>";
}


function usesFortaDragonului(Character $character): bool
{
    if (rand(0, 100) < 10 && $character->additionalPower == "Forta dragonului") {
        return true;
    } else {
        return false;
    }
}

function usesScutulFermecat(Character $character): bool
{
    // return true;
    if (rand(0, 100) < 20 && $character->additionalDefence == "Scutul fermecat") {
        return true;
    } else {
        return false;
    }
}

function isLuckyDefender(Character $defender)
{
    if (rand(0, 100) < $defender->luck) {
        return true;
    }
}


function attacker(Character $firstPlayer, Character $secondPlayer): Character
{
    if ($firstPlayer->speed > $secondPlayer->speed) {
        return $firstPlayer;
    } elseif ($firstPlayer->speed < $secondPlayer->speed) {
        return $secondPlayer;
    } elseif ($firstPlayer->speed == $secondPlayer->speed) {
        if ($firstPlayer->luck > $secondPlayer->luck) {
            return $firstPlayer;
        } elseif ($firstPlayer->luck < $secondPlayer->luck) {
            return $secondPlayer;
        }
    } else {
        throw new \Error("Both heroes have the same speed and luck; please try again");
    }
}

function computeAttackDamage($power, $defence)
{
    $damage = $power - $defence;

    if ($damage <= 0) {
        return $damage = 0;
    } elseif ($damage >= 100) {
        return $damage = 100;
    } else {
        return $damage;
    }
}


function performAttack($attacker, $defender)
{
    $attackerPower = $attacker->power;

    if (usesFortaDragonului($attacker)) {
        echo "</br>";
        echo $attacker->name . " has activated Forta Dragonului.";
        echo "</br>";
        $attackerPower = $attacker->power * 2;
    }

    if (isLuckyDefender($defender)) {
        echo "</br>";
        echo $defender->name . " got lucky! " . $attacker->name . " missed!";
        echo "</br>";
    } elseif (usesScutulFermecat($defender)) {
        echo "<br>";
        echo $defender->name . " has activated Scutul Fermecat";
        echo "<br>";
        echo 'damage: ' . (computeAttackDamage($attackerPower, $defender->defence) / 2);
        echo "<br>";
        $defender->life = $defender->life - (computeAttackDamage($attackerPower, $defender->defence) / 2);
    } else {
        echo "</br>";
        echo "damage: " . computeAttackDamage($attackerPower, $defender->defence);
        echo "</br>";
        $defender->life = $defender->life - computeAttackDamage($attackerPower, $defender->defence);
    }
}

function startFight($firstPlayer, $secondPlayer)
{
    presentCharacters($firstPlayer, $secondPlayer);

    $attacker = attacker($firstPlayer, $secondPlayer);
    $numberOfRounds = 20;

    for ($i=1; $i<=$numberOfRounds; $i++) {
        if ($firstPlayer->life <= 0) {
            announceWinner($secondPlayer);
            return;
        }

        if ($secondPlayer->life <= 0) {
            announceWinner($firstPlayer);
            return;
        }

        $defender = $attacker->is($firstPlayer) ? $secondPlayer : $firstPlayer;

        echo "===== Starting round {$i} of $numberOfRounds with {$attacker->name} attacking {$defender->name} =====";
        echo "</br>";
        echo "</br>";

        displayCharactersAttributes($attacker);

        performAttack($attacker, $defender);

        echo "</br>";
        displayCharactersAttributes($defender);

        echo "</br>";
        $attacker = $attacker->is($firstPlayer) ? $secondPlayer : $firstPlayer;
    }

    computeWinnerFromPlayersLives($firstPlayer, $secondPlayer);
}

function displayCharactersAttributes($character)
{
    echo $character->name . " life: " . $character->life;
    echo "</br>";
    echo $character->name . " power: " . $character->power;
    echo "</br>";
    echo $character->name . " defence: " . $character->defence;
    echo "</br>";
}

function computeWinnerFromPlayersLives($firstPlayer, $secondPlayer)
{
    if ($firstPlayer->life < $secondPlayer->life) {
        announceWinner($secondPlayer);
    } elseif ($firstPlayer->life == $secondPlayer->life) {
        announceWinner();
    } else {
        announceWinner($firstPlayer);
    }
}

function announceWinner($winner = null)
{
    if (is_null($winner)) {
        echo "It's a draw.";
    } else {
        echo $winner->name . " won!";
    }
}

startFight($carl, $beast);
