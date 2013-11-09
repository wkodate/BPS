<?php

class Game extends AppModel {

    //試合中に変動する情報
    private $count;
    private $runner;

    //試合前に決定する情報
    private $gameInfo;
    private $teamInfo;

    //試合後に必要な情報
    var $score;
    var $batterStat;
    var $pitcherStat;
    var $batterStatsMatrix;
    var $batterInningMx;

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
        /**
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
         */

        // 試合開始 コンストラクタで実行しない
        $this->start();
    }


    public function start() {

        # 試合開始時の初期化
        $pa      = Configure::read("pa");
        $hits    = Configure::read("hits");
        $mishits = Configure::read("mishits");
        $others  = Configure::read("others");

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
            $resultAtBat = rand(0, $pa['PLATE_APPEARANCES']-1);

            if ($resultAtBat < $pa['HITS']) {
                //安打の種類を決定
                $direction;
                $kind_of_hits = rand(1, $hits['HITS_TOTAL']);

                if ($kind_of_hits < $hits['SINGLES']) {

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

                } else if ($kind_of_hits < ($hits['SINGLES'] + $hits['DOUBLES'])) {

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

                } else if ($kind_of_hits < ($hits['SINGLES'] + $hits['DOUBLES'] + $hits['TRIPLES'])){

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

            } else if ($resultAtBat < ($pa['HITS'] + $pa['MISHITS'])) { 
                //凡打の種類を決定
                $kind_of_mishits_rand = rand(1, $mishits['MISHITS_TOTAL']);
                $kind_of_mishits;
                $direction;

                if ($kind_of_mishits_rand < $mishits['STRIKEOUTS']) {
                    //三振の種類
                    //振り逃げは今後
                    $direction = 10;
                    $kind_of_mishits = 1;

                } else {
                    //凡打の方向を決定
                    if ($kind_of_mishits_rand < ($mishits['STRIKEOUTS'] + $mishits['GROUND_OUTS'])) {

                        //ゴロ
                        $direction_rand = rand(2, 6);
                        if ($direction_rand >= 3 && $direction_rand < 6) {
                            $direction = $direction_rand;
                        } else {
                            $direction = 1;
                        }
                        $kind_of_mishits = 5;

                    } else if ($kind_of_mishits_rand 
                        < ($mishits['STRIKEOUTS'] + $mishits['GROUND_OUTS'] + $mishits['LINER_OUTS'])) {

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
