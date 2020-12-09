<?php

class Character
{
    public $name;
    public $life;
    public $power;
    public $defence;
    public $speed;
    public $luck;
    public $additionalPower;
    public $additionalDefence;

    public function __construct($name, $life, $power, $defence, $speed, $luck, $additionalPower, $additionalDefence)
    {
        $this->name = $name;
        $this->life = $life;
        $this->power = $power;
        $this->defence = $defence;
        $this->speed = $speed;
        $this->luck = $luck;
        $this->additionalPower = $additionalPower;
        $this->additionalDefence = $additionalDefence;
    }

    public function is(Character $character)
    {
        return $this->name === $character->name;
    }
}