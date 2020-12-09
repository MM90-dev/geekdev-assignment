<?php

require('character.php');
require('game.php');

$carl = new Character("Carl", rand(65, 95), rand(60, 70), rand(40, 50), rand(40, 50), rand(10, 30), "Forta dragonului", "Scutul fermecat");
$beast = new Character("Beast", rand(55, 80), rand(50, 80), rand(35, 55), rand(40, 60), rand(25, 40), null, null);

$game = new Game($carl, $beast);

$game->startFight();
