<?php

APP::import('Model', 'Runner');
APP::import('Model', 'Score');
class Bat {

    const FIRST  = 0;
    const SECOND = 1;
    const THIRD  = 2;

    private $Score;
    private $Runner;

    public function __construct() {
        $this->Score  = new Score();
        $this->Runner = new Runner();
    }

    # 共通の変数
    public function hits() {
        $runner = $this->Runner->getAllRunner();
        for($i=self::THIRD; $i>=self::THIRD; $i--) {
            if ($runner[$i]) $this->Score->incrementScore();
        }
        $this->Runner->singleRun();
    }

    public function doubles() {
        $runner = $this->Runner->getAllRunner();
        for($i=self::THIRD; $i>=self::SECOND; $i--) {
            if ($runner[$i]) $this->Score->incrementScore();
        }
        $this->Runner->doubleRun();
    }

    public function triples() {
        $runner = $this->Runner->getAllRunner();
        for($i=self::THIRD; $i>=self::FIRST; $i--) {
            if ($runner[$i]) $this->Score->incrementScore();
        }
        $this->Runner->tripleRun();
    }

    public function getAllRunner() {
        return $this->Runner->getAllRunner();
    }

    public function getScore() {
        return $this->Score->getScore();
    }
    
    public function printRunner() {
        $runner = $this->Runner->getAllRunner();
        echo '[1]' . $runner[self::FIRST] . "\n"
            .'[2]' . $runner[self::SECOND] . "\n"
            .'[3]' . $runner[self::THIRD] . "\n";
    }
    public function printScore() {
        echo '[SCORE]' . $this->Score->getScore(), "\n";
    }
}
