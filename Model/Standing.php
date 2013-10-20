<?php

class Standing extends AppModel {

    private $team_id;
    private $match_list;
    private $game_total_count;
    private $standings;

    /**
     * コンストラクタ
     */
    public function __construct($teamid) {
        parent::__construct();

        $this->team_id = $teamid;
        $this->game_total_count = 0;
        # 今は一度の対戦のみ
        for ($i=0; $i<count($teamid); $i++) {
            for ($j=$i+1; $j<count($teamid); $j++) {
                $this->match_list[$i][$j] = false;
                $this->game_total_count++;
            }
        }
    }

    /**
     * 順位の初期化
     */
    public function initStandings() {
        for ($i=0; $i<count($this->team_id); $i++) {
            $this->standings[$i] = array(
                "team_id" => $this->team_id[$i],
                "wins" => 0,
                "losses" => 0,
                "ties" => 0,
                "pct" => 0
            );
        }
    }
    /**
     * 対戦するチームを決定
     */
    public function getMatchTeams() {
        for ($i=0; $i<count($this->team_id); $i++) {
            for ($j=$i+1; $j<count($this->team_id); $j++) {
                # match_listからまだ試合を行っていないペアを選択
                if (!$this->match_list[$i][$j]) {
                    $match_team_id = array(
                        'top'    => $this->team_id[$i],
                        'bottom' => $this->team_id[$j]
                    );
                    $this->match_list[$i][$j] = true;
                    break 2;
                }
                # すべての試合が終了してる場合
            }
        }
        return $match_team_id;
    }

    /**
     * scoreから勝敗登録
     */
    public function saveScore($tid, $bid, $t_score, $b_score) {
        $tnum;
        $bnum;
        for ($i=0; $i<count($this->team_id); $i++) {
            if ($this->standings[$i]['team_id'] == $tid) {
               $tnum = $i; 
            }
            if ($this->standings[$i]['team_id'] == $bid) {
               $bnum = $i; 
            }
        } 
        if ($t_score > $b_score) {
            $this->standings[$tnum]['wins']++;
            $this->standings[$bnum]['losses']++;
        } else if ($t_score < $b_score) {
            $this->standings[$tnum]['losses']++;
            $this->standings[$bnum]['wins']++;
        } else {
            $this->standings[$tnum]['ties']++;
            $this->standings[$bnum]['ties']++;
        }
    }

    /**
     * 総対戦数を取得
     */
    public function getGameTotalCount() {
        return $this->game_total_count;
    }

    /**
     * 勝率を計算
     */
    public function calcWinPct() {
        for ($i=0; $i<count($this->team_id); $i++) {
            $wins = $this->standings[$i]['wins'];
            $sum = $wins + $this->standings[$i]['losses'];
            if ($sum != 0) {
                $this->standings[$i]['pct'] = $wins/$sum;
            } else {
                $this->standings[$i]['pct'] = 0;
            }
        }
    }

    /**
     * 勝率でソート
     */
    public function sortByWinPct() {
        $pct_array = array();
        for ($i=0; $i<count($this->team_id); $i++) {
            $pct_array[$i] = $this->standings[$i]['pct'];
        }
        array_multisort($pct_array, SORT_DESC, $this->standings);
    }

    /**
     * ゲーム差を計算
     */
    public function calcGameBehind() {
        $top_wins = $this->standings[0]['wins'];
        $top_losses = $this->standings[0]['losses'];
        $this->standings[0]['gb'] = '-';

        for ($i=1; $i<count($this->team_id); $i++) {
            $team_wins = $this->standings[$i]['wins'];
            $team_losses = $this->standings[$i]['losses'];
            $this->standings[$i]['gb'] 
                = (($top_wins-$top_losses) - ($team_wins-$team_losses)) / 2;
        }
    }

    /*
     * standingsを取得
     */
    public function getStandings() {
        return $this->standings;
    }

}
