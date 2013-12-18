<?php

class Runner 
{
    public $useTable = false;

    const FIRST  = 0;
    const SECOND = 1;
    const THIRD  = 2;

    private $runner;

    public function __construct() 
    {
        $this->runner[self::FIRST]  = false; 
        $this->runner[self::SECOND] = false; 
        $this->runner[self::THIRD]  = false; 
    }

    public function setRunner($num) 
    {
        $this->runner[$num] = true;
    }

    public function unsetRunner($num) 
    {
        $this->runner[$num] = false;
    }

    public function resetRunner() 
    {
        $this->runner[self::FIRST]  = false; 
        $this->runner[self::SECOND] = false; 
        $this->runner[self::THIRD]  = false; 
    }

    public function getRunner($num) 
    {
        return $this->runner[$num];
    }

    public function getAllRunner() 
    {
        return $this->runner;
    }

    public function singleRun() 
    {
        $this->runner[self::THIRD] = false; 
        if ($this->runner[self::SECOND]) {
            $this->runner[self::THIRD] = true; 
        }
        if ($this->runner[self::FIRST]) {
            $this->runner[self::SECOND] = true; 
        }
        $this->runner[self::FIRST] = true; 
    }

    public function doubleRun() 
    {
        $this->runner[self::THIRD] = false; 
        if ($this->runner[self::FIRST]) {
            $this->runner[self::THIRD] = true; 
        }
        $this->runner[self::SECOND] = true; 
        $this->runner[self::FIRST]  = false; 
    }

    public function tripleRun() 
    {
        $this->runner[self::THIRD]  = true; 
        $this->runner[self::SECOND] = false; 
        $this->runner[self::FIRST]  = false; 
    }
}
