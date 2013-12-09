<?php

class Score 
{
    public $useTable = false;

    private $score;

    public function __construct() 
    {
        $this->topScore    = 0;
        $this->bottomScore = 0;
    }

    public function set($score) 
    {
        $this->score = $score;
    }

    public function get() 
    {
        return $this->score;
    }

    public function increment() 
    {
        $this->score++;
    }

    public function reset() 
    {
        $this->score = 0;
    }
}
