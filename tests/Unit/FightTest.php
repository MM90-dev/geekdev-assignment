<?php

require('./character.php');
require('./game.php');

it("returns beast a winner when carl has life 1", function () {
    $carl = new Character("Carl", 1, rand(60, 70), rand(40, 50), rand(40, 50), rand(10, 30), "Forta dragonului", "Scutul fermecat");
    $beast = new Character("Beast", rand(55, 80), rand(50, 80), rand(35, 55), rand(40, 60), rand(25, 40), null, null);

    $game = new Game($carl, $beast);

    $winner = $game->startFight();

    $this->assertTrue($beast->is($winner));
});

it("returns carl a winner when beast has life 1", function () {
    $carl = new Character("Carl", rand(55, 80), rand(60, 70), rand(40, 50), rand(40, 50), rand(10, 30), "Forta dragonului", "Scutul fermecat");
    $beast = new Character("Beast", 1, rand(50, 80), rand(35, 55), rand(40, 60), rand(25, 40), null, null);

    $game = new Game($carl, $beast);

    $winner = $game->startFight();

    $this->assertTrue($carl->is($winner));
});
