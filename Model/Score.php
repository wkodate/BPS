<?php

class Score 
{
    public $useTable = false;

    const TOP    = 1;
    const BOTTOM = 2;
    private $topScore;
    private $bottomScore;

    public function __construct() 
    {
        $this->topScore    = 0;
        $this->bottomScore = 0;
    }

    public function setScore($score, $topBottom) 
    {
        if ($topBottom == self::TOP) {
            $this->topScore = $score;
        } elseif ($topBottom == self::BOTTOM) {
            $this->bottomScore = $score;
        } 
    }

    public function getScore($topBottom=null) 
    {
        if (is_null($topBottom)) {
            return array($this->topScore, $this->bottomScore);
        } elseif ($topBottom == self::TOP) {
            return $this->topScore;
        } elseif ($topBottom == self::BOTTOM) {
            return $this->bottomScore;
        } 
        return;
    }

    public function incrementScore($topBottom) 
    {
        if ($topBottom == self::TOP) {
            $this->topScore++;
        } elseif ($topBottom == self::BOTTOM) {
            $this->bottomScore++;
        } 
    }
}
