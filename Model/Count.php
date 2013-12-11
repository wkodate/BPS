<?php

class Count 
{

    private $ball;
    private $strike;
    private $out;

    public function __construct() 
    {
        $this->ball   = 0; 
        $this->strike = 0; 
        $this->out    = 0; 
    }

    public function ball() 
    {
        $this->ball++;
    }

    public function strike() 
    {
        $this->strike++;
    }

    public function out() 
    {
        $this->ball   = 0; 
        $this->strike = 0; 
        $this->out++;
    }

    public function resetBallCount() 
    {
        $this->ball   = 0; 
        $this->strike = 0; 
    }

    public function resetOutCount() 
    {
        $this->ball   = 0; 
        $this->strike = 0; 
        $this->out = 0; 
    }

    public function getBall() 
    {
        return $this->ball;
    }

    public function getStrike() 
    {
        return $this->strike;
    }

    public function getOut() 
    {
        return $this->out;
    }

    public function getCount() 
    {
        return array($this->ball, $this->strike, $this->out);
    }

}
