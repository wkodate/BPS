<?php

class GameResult extends AppModel {

    //試合中に変動する情報
    private $count;
    private $runner;

    //試合前に決定する情報
    var $gameInfo;
    var $teamInfo;

    //試合後に必要な情報
    var $score;
    var $batterStat;
    var $pitcherStat;
    var $batterStatsMatrix;
    var $batterInningMx;

    const HITS = 12;
    const MISHITS = 35; 
    const OTHERS = 6;
    // 和
    const TOTAL_PLATE_APPEARANCES = 53;
     
    //0~100: 本塁打, 101~120: 3塁打, 121~300: 2塁打, 301~1200: 単打
    const HOMERUNS = 100;
    const TRIPLES  = 20; 
    const DOUBLES  = 180;
    const SINGLES  = 900;
    // 和
    const HITS_TOTAL = 1200;
    // HITS_TOTAL - SINGLES
    const SINGLES_RANGE = 300;
    // HITS_TOTAL - (SINGLES+DOUBLES)
    const DOUBLES_RANGE = 120;
    // HITS_TOTAL - (SINGLES+DOUBLES+TRIPLES)
    const TRIPLES_RANGE = 100;

    ////凡打の内訳
    ////ゴロ、フライ、ライナー、併殺、三振
    const STRIKEOUTS = 25; 
    const GROUND_OUTS = 40; 
    const LINER_OUTS = 8;
    const FLY_OUTS = 27; 
    const GROUNDED_INTO_DOUBLE_PLAYS = 0;
    // 和
    const MISHITS_TOTAL = 100;
    //その他の内訳
    //四球、死球、犠打、犠飛、失策、野手選択
    const BASES_ON_BALLS = 18; 
    const HIT_BY_PITCH = 2;
    const SACRIFICE_BUNTS = 0;
    const SACRIFICE_FLIES = 0;
    const ERRORS = 0;
    const FIELDERS_CHOICE = 0;
    // 和
    const OTHERS_TOTAL = 20;

    /**
     * コンストラクタ
     */
    public function __construct() {
        parent::__construct();

        $this->gameInfo = array(
            'gameid'    => 1, 
            'inning'    => 9, 
            'topTeamId'       => '1',
            'bottomTeamId'    => '2',
            'DH'        => 1,
            'error'     => 1,
            'mercyRule' => 0
        );
        $this->teamInfo = array(
            'order' => array(
                'top' => array(
                    1 => array (
                        'name' => 'Nakai',
                        'position' => 4
                    ),
                    2 => array(
                        'name' => 'Kamei',
                        'position' => 9
                    ),
                    3 => array(
                        'name' => 'Sakamoto',
                        'position' => 6
                    ),
                    4 => array(
                        'name' => 'Abe',
                        'position' => 2
                    ),
                    5 => array(
                        'name' => 'Chono',
                        'position' => 8
                    ),
                    6 => array(
                        'name' => 'Takahashi',
                        'position' => 7
                    ),
                    7 => array(
                        'name' => 'Bowker',
                        'position' => 3
                    ),
                    8 => array(
                        'name' => 'Murata',
                        'position' => 5
                    ),
                    9 => array(
                        'name' => 'Utsumi',
                        'position' => 1
                    ),
                ),
                'bottom' => array(
                    1 => array (
                        'name' => 'Nishioka',
                        'position' => 4
                    ),
                    2 => array(
                        'name' => 'Yamato',
                        'position' => 8
                    ),
                    3 => array(
                        'name' => 'Toritani',
                        'position' => 6
                    ),
                    4 => array(
                        'name' => 'Murton',
                        'position' => 7
                    ),
                    5 => array(
                        'name' => 'Fukudome',
                        'position' => 9
                    ),
                    6 => array(
                        'name' => 'T.Arai',
                        'position' => 3
                    ),
                    7 => array(
                        'name' => 'R.Arai',
                        'position' => 5
                    ),
                    8 => array(
                        'name' => 'Fujii',
                        'position' => 2
                    ),
                    9 => array(
                        'name' => 'Nohmi',
                        'position' => 1
                    ),
                )
            )
        );

        // 試合開始
        $this->start();
    }

    public function start() {

        $inning = 1;
        $topBottom = 'top';
        $orderNum;
        $orderTimes;
        $this->count['ball'] = 0;
        $this->count['strike'] = 0;
        $this->count['out'] = 0;
        for($i=1; $i<=3; $i++) {
            $this->runner[$i] = false; 
        }

        foreach (array('top', 'bottom') as $tb) {
            $orderNum[$tb] = 1; 
            $orderTimes[$tb] = 1; 
            for ($i=1; $i<=9; $i++) {
                $this->score[$tb][$i] = 0; 
                $this->batterStat[$tb][$i] = array();
                for ($p=1; $p<=9; $p++) {
                    $this->batterInningMx[$tb][$p][$i] = false;
                }
            }
        }

        //試合開始
        while(1) {
            //
            //打撃結果
            $resultAtBat = rand(0, self::TOTAL_PLATE_APPEARANCES-1);

            if ($resultAtBat < self::HITS ) {
                //安打の種類を決定
                $direction;
                $kind_of_hits = rand(1, self::HITS_TOTAL);

                if ($kind_of_hits < self::SINGLES) {

                    //単打
                    if ($this->runner[3] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    for ($i=3; $i>=1; $i--) {
                        if ($this->runner[$i] == true) {
                            $this->runner[$i] = false; 
                            if($i <= 2) {
                                $this->runner[$i+1] = true; 
                            } 
                        }
                    }
                    $this->runner[1] = true; 

                    $direction_rand = rand(0,3);
                    if ($direction_rand >= 0 && $direction_rand <= 2) {
                        $direction = $direction_rand + 7;
                    } else {
                        $direction = rand(1,6);
                    }
                    $kind_of_hits = 1;

                } else if ($kind_of_hits < (self::SINGLES + self::DOUBLES)) {

                    //二塁打
                    if($this->runner[3] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    if($this->runner[2] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    for ($i=3; $i>=1; $i--) {
                        if($this->runner[$i] == true) {
                            $this->runner[$i] = false; 
                            if($i == 1) {
                                $this->runner[$i+2] = true; 
                            } 
                        }
                    }
                    $this->runner[2] = true; 

                    $direction = rand(7,9);
                    $kind_of_hits = 2;

                } else if ($kind_of_hits < (self::SINGLES + self::DOUBLES + self::TRIPLES)) {

                    //三塁打
                    if($this->runner[3] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    if($this->runner[2] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    if($this->runner[1] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    for($i=3; $i>=1; $i--) {
                        if($this->runner[$i] == true) {
                            $this->runner[$i] = false; 
                        }
                    }
                    $this->runner[3] = true; 

                    $direction = rand(8,9);
                    $kind_of_hits = 3;

                } else {
                    //本塁打
                    if($this->runner[3] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    if($this->runner[2] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    if($this->runner[1] == true) {
                        $this->score[$topBottom][$inning]++;
                    }
                    $this->score[$topBottom][$inning]++;
                    for($i=3; $i>=1; $i--) {
                        if($this->runner[$i] == true) {
                            $this->runner[$i] = false; 
                        }
                    }

                    $direction = rand(7,9);
                    $kind_of_hits = 4;
                }

                $result_in_detail = 10 * $direction + $kind_of_hits;

            } else if ($resultAtBat < (self::HITS + self::MISHITS)) { 
                //凡打の種類を決定
                $kind_of_mishits_rand = rand(1, self::MISHITS_TOTAL);
                $kind_of_mishits;
                $direction;

                if ($kind_of_mishits_rand < self::STRIKEOUTS) {
                    //三振の種類
                    //振り逃げは今後
                    $direction = 10;
                    $kind_of_mishits = 1;

                } else {
                    //凡打の方向を決定
                    if ($kind_of_mishits_rand < (self::STRIKEOUTS + self::GROUND_OUTS)) {

                        //ゴロ
                        $direction_rand = rand(2, 6);
                        if ($direction_rand >= 3 && $direction_rand < 6) {
                            $direction = $direction_rand;
                        } else {
                            $direction = 1;
                        }
                        $kind_of_mishits = 5;

                    } else if ($kind_of_mishits_rand 
                        < (self::STRIKEOUTS + self::GROUND_OUTS + self::LINER_OUTS)) {

                            //ライナー
                            $direction_rand = rand(2, 6);
                            if ($direction_rand >= 3 && $direction_rand < 6) {
                                $direction = $direction_rand;
                            } else {
                                $direction = 1;
                            }
                            $direction_rand = rand(0, 4);
                            $kind_of_mishits = 6;

                        } else {

                            //フライ
                            $direction = rand(1, 9);
                            $kind_of_mishits = 7;

                        }
                }

                $this->count['out'] += 1;
                $result_in_detail = 10 * $direction + $kind_of_mishits;

            } else {
                //四死球、犠打犠飛、失策、野選

                if(($this->runner[1] == true) 
                    && ($this->runner[2] == true)
                    && ($this->runner[3] == true)) {

                        $this->score[$topBottom][$inning]++;

                    }

                if($this->runner[1] == true) {
                    if($this->runner[2] == true) {
                        if($this->runner[3] == true) {
                            $this->runner[3] = true; 
                        }
                    } else {
                        $this->runner[2] = true; 
                    }
                } else {
                    $this->runner[1] = true; 
                }

                $result_in_detail = 104;

            } 

            //スコアを登録
            //最初は数字だけ入れて表示の時に変換したい
            $tb = $topBottom;
            $this->batterStat[$tb][$orderNum[$tb]][$orderTimes[$tb]] = $result_in_detail;
            if (!$this->batterInningMx[$tb][$orderNum[$tb]][$inning]) {
                $this->batterInningMx[$tb][$orderNum[$tb]][$inning] 
                    = $this->getStringOfHittingStats($result_in_detail);
            } else {
                $this->batterInningMx[$tb][$orderNum[$tb]][$inning] 
                    .= "\t" . $this->getStringOfHittingStats($result_in_detail);

            }

            //次のバッター
            if ($orderNum[$topBottom] == 9) {
                $orderNum[$topBottom] = 1;
                $orderTimes[$topBottom]++;
            } else {
                $orderNum[$topBottom]++;
            }

            if ($this->count['out'] >= 3) {
                //ランナーリセット
                for($i=1; $i<=3; $i++) {
                    $this->runner[$i] = false; 
                }
                //アウトカウントリセット
                $this->count['out'] = 0;
                //チェンジ

                if(!($inning == 9 && $topBottom == 'bottom')) {
                    if ($topBottom == 'bottom') {
                        $inning += 1;
                        $topBottom = 'top';
                    } else {
                        $topBottom = 'bottom';
                    }
                } else {
                    break;
                }
            }
        }

        //合計のスコアを計算
        $this->score['top']['total'] = 0;
        $this->score['bottom']['total'] = 0;
        for ($i=1; $i<=9; $i++) {
            $this->score['top']['total'] += $this->score['top'][$i];
            $this->score['bottom']['total'] += $this->score['bottom'][$i];
        }

    }

    //打席記録を文字列で返す
    function getStringOfHittingStats($result)
    {

        if (intval($result / 10) < 10) {

            $dire = intval($result / 10); 
            $kind = $result % 10;

            //方向の文字
            switch ($dire) {
            case 1:
                $first_string = '投';
                break;
            case 2:
                $first_string = '捕';
                break;
            case 3:
                $first_string = '一';
                break;
            case 4:
                $first_string = '二';
                break;
            case 5:
                $first_string = '三';
                break;
            case 6:
                $first_string = '遊';
                break;
            case 7:
                $first_string = '左';
                break;
            case 8:
                $first_string = '中';
                break;
            case 9:
                $first_string = '右';
                break;
            }

            //打撃の種類の文字
            switch ($kind) {
            case 1:
                $second_string = '安';
                break;
            case 2:
                $second_string = '２';
                break;
            case 3:
                $second_string = '３';
                break;
            case 4:
                $second_string = '本';
                break;
            case 5:
                $second_string = 'ゴ';
                break;
            case 6:
                $second_string = '直';
                break;
            case 7:
                $second_string = '飛';
                break;
            case 8:
                $second_string = '併';
                break;
            case 9:
                $second_string = '失';
                break;
            case 0:
                $second_string = '犠';
                break;
            }

            $result_string = $first_string . $second_string;

        } else {

            $kind = $result % 10;

            //打撃の種類の文字
            switch ($kind) {
            case 1:
                $result_string = '三振';
                break;
            case 2:
                $result_string = '空振';
                break;
            case 3:
                $result_string = '振逃';
                break;
            case 4:
                $result_string = '四球';
                break;
            case 5:
                $result_string = '死球';
                break;
            case 6:
                $result_string = '敬遠';
                break;
            case 7:
                $result_string = '野選';
                break;
            }

        }

        return $result_string; 

    }
}
