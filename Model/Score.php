<?php

class Score 
{
    public $useTable = false;

    private $score;

    public function __construct() 
    {
        $this->score    = 0;
    }

    public function setScore($score) 
    {
        $this->score = $score;
    }

    public function getScore() 
    {
        return $this->score;
    }

    public function incrementScore() 
    {
        $this->score++;
    }

    public function resetScore() 
    {
        $this->score = 0;
    }
}
