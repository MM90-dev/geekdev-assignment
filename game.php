<?php

class Game
{
    public $firstPlayer;
    public $secondPlayer;

    public function __construct(Character $firstPlayer, Character $secondPlayer)
    {
        $this->firstPlayer = $firstPlayer;
        $this->secondPlayer = $secondPlayer;
    }

    public function startFight()
    {
        $this->presentCharacters();

        $attacker = $this->chooseAttacker();
        $numberOfRounds = 20;

        for ($i=1; $i<=$numberOfRounds; $i++) {
            if ($this->firstPlayer->life <= 0) {
                return $this->announceWinner($this->secondPlayer);
            }

            if ($this->secondPlayer->life <= 0) {
                return $this->announceWinner($this->firstPlayer);
            }

            $defender = $attacker->is($this->firstPlayer) ? $this->secondPlayer : $this->firstPlayer;

            echo "===== Starting round {$i} of $numberOfRounds with {$attacker->name} attacking {$defender->name} =====";
            echo "</br>";
            echo "</br>";

            $this->displayCharactersAttributes($attacker);

            $this->performAttack($attacker, $defender);

            echo "</br>";
            $this->displayCharactersAttributes($defender);

            echo "</br>";
            $attacker = $attacker->is($this->firstPlayer) ? $this->secondPlayer : $this->firstPlayer;
        }

        return $this->computeWinnerFromPlayersLives();
    }

    private function presentCharacters(): void
    {
            echo "Present the characters";
            echo "</br>";
            echo "</br>";

            echo $this->firstPlayer->name . " life: " . $this->firstPlayer->life;
            echo "</br>";
            echo $this->firstPlayer->name . " power: " . $this->firstPlayer->power;
            echo "</br>";
            echo $this->firstPlayer->name . " defence: " . $this->firstPlayer->defence;
            echo "</br>";
            echo $this->firstPlayer->name . " speed: " . $this->firstPlayer->speed;
            echo "</br>";
            echo $this->firstPlayer->name . " luck: " . $this->firstPlayer->luck;
            echo "</br>";
        if (isset($this->firstPlayer->additionalPower)) {
            echo $this->firstPlayer->name . " additional power: " . $this->firstPlayer->additionalPower;
        }
            echo "</br>";
        if (isset($this->firstPlayer->additionalDefence)) {
            echo $this->firstPlayer->name . " additional defence: " . $this->firstPlayer->additionalDefence;
        }
            echo "</br>";
            echo "</br>";
            echo $this->secondPlayer->name . " life: " . $this->secondPlayer->life;
            echo "</br>";
            echo $this->secondPlayer->name . " power: " . $this->secondPlayer->power;
            echo "</br>";
            echo $this->secondPlayer->name . " defence: " . $this->secondPlayer->defence;
            echo "</br>";
            echo $this->secondPlayer->name . " speed: " . $this->secondPlayer->speed;
            echo "</br>";
            echo $this->secondPlayer->name . " luck: " . $this->secondPlayer->luck;
            echo "</br>";
        if (isset($this->secondPlayer->additionalPower)) {
            echo $this->secondPlayer->name . " additional power: " . $this->secondPlayer->additionalPower;
        }
        echo "</br>";
        if (isset($this->secondPlayer->additionalDefence)) {
            echo $this->secondPlayer->name . " additional defence: " . $this->secondPlayer->additionalDefence;
        }
            echo "</br>";
            echo "</br>";
    }

    private function usesFortaDragonului(Character $character): bool
    {
        if (rand(0, 100) < 10 && $character->additionalPower == "Forta dragonului") {
            return true;
        } else {
            return false;
        }
    }

    private function usesScutulFermecat(Character $character): bool
    {
        if (rand(0, 100) < 20 && $character->additionalDefence == "Scutul fermecat") {
            return true;
        } else {
            return false;
        }
    }

    private function isLuckyDefender(Character $defender)
    {
        if (rand(0, 100) < $defender->luck) {
            return true;
        }
    }

    private function chooseAttacker(): Character
    {
        if ($this->firstPlayer->speed > $this->secondPlayer->speed) {
            return $this->firstPlayer;
        } elseif ($this->firstPlayer->speed < $this->secondPlayer->speed) {
            return $this->secondPlayer;
        } elseif ($this->firstPlayer->speed == $this->secondPlayer->speed) {
            if ($this->firstPlayer->luck > $this->secondPlayer->luck) {
                return $this->firstPlayer;
            } elseif ($this->firstPlayer->luck < $this->secondPlayer->luck) {
                return $this->secondPlayer;
            }
        } else {
            throw new \Error("Both heroes have the same speed and luck; please try again");
        }
    }

    private function computeAttackDamage($power, $defence): int
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

    private function performAttack(Character $attacker, Character $defender): void
    {
        $attackerPower = $attacker->power;

        if ($this->usesFortaDragonului($attacker)) {
            echo "</br>";
            echo $attacker->name . " has activated Forta Dragonului.";
            echo "</br>";
            $attackerPower = $attacker->power * 2;
        }

        if ($this->isLuckyDefender($defender)) {
            echo "</br>";
            echo $defender->name . " got lucky! " . $attacker->name . " missed!";
            echo "</br>";
        } elseif ($this->usesScutulFermecat($defender)) {
            echo "<br>";
            echo $defender->name . " has activated Scutul Fermecat";
            echo "<br>";
            echo 'damage: ' . ($this->computeAttackDamage($attackerPower, $defender->defence) / 2);
            echo "<br>";
            $defender->life = $defender->life - ($this->computeAttackDamage($attackerPower, $defender->defence) / 2);
        } else {
            echo "</br>";
            echo "damage: " . $this->computeAttackDamage($attackerPower, $defender->defence);
            echo "</br>";
            $defender->life = $defender->life - $this->computeAttackDamage($attackerPower, $defender->defence);
        }
    }

    private function displayCharactersAttributes(Character $character): void
    {
        echo $character->name . " life: " . $character->life;
        echo "</br>";
        echo $character->name . " power: " . $character->power;
        echo "</br>";
        echo $character->name . " defence: " . $character->defence;
        echo "</br>";
    }

    private function computeWinnerFromPlayersLives()
    {
        if ($this->firstPlayer->life < $this->secondPlayer->life) {
            return $this->announceWinner($this->secondPlayer);
        } elseif ($this->firstPlayer->life == $this->secondPlayer->life) {
            return $this->announceWinner();
        } else {
            return $this->announceWinner($this->firstPlayer);
        }
    }

    private function announceWinner($winner = null)
    {
        if (is_null($winner)) {
            echo "It's a draw.";
            return null;
        } else {
            echo $winner->name . " won!";
            return $winner;
        }
    }
}
