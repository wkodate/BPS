<?php

class PennantResultsController extends AppController {
    //public $scaffold;
    private $app_name = 'BPS';
    public $helper = array('Html', 'Form');
    public $uses = array('PennantResult', 'GameResult', 'Team');

    public function index() {
        $this->set("title_for_layout", $this->app_name . ' - ' . 'Pennant Result');
        $this->set("pennant_results", $this->PennantResult->find('all'));
        $this->set("game_results", $this->GameResult->find('all'));

        if (isset($this->request->data['PennantResult'])) {
            if ($this->PennantResult->save($this->request->data)) {
                $this->Session->setFlash('Success!!');
                $this->redirect(array('controller'=>'homes', 'action'=>'index'));
            } else {
                $this->Session->setFlash('Failed!!');
            }
            return;
        }

        $games = $this->request->data['Team']['games'];

        for ($lg=1;$lg<=2;$lg++) {
            for ($tm=1;$tm<=6;$tm++) {
                $lgtm = 'lg'.$lg.'tm'.$tm;
                ${$lgtm.'_id'} = $this->request->data['Team'][$lgtm];
                ${$lgtm.'_name'} = $this->Team->find('first', array(
                    'conditions' =>  array('Team.id'  =>  ${$lgtm.'_id'}),
                    'fields' =>  array('Team.team_name')
                ));
            }
        }
        $lg1_team_id = array($lg1tm1_id, $lg1tm2_id, $lg1tm3_id, 
            $lg1tm4_id, $lg1tm5_id, $lg1tm6_id); 
        $lg2_team_id = array($lg2tm1_id, $lg2tm2_id, $lg2tm3_id, 
            $lg2tm4_id, $lg2tm5_id, $lg2tm6_id); 

        $lg1_team_id_name = array(
            $lg1tm1_id => $lg1tm1_name['Team']['team_name'],
            $lg1tm2_id => $lg1tm2_name['Team']['team_name'],
            $lg1tm3_id => $lg1tm3_name['Team']['team_name'],
            $lg1tm4_id => $lg1tm4_name['Team']['team_name'],
            $lg1tm5_id => $lg1tm5_name['Team']['team_name'],
            $lg1tm6_id => $lg1tm6_name['Team']['team_name'],
        );
        $lg2_team_id_name = array(
            $lg2tm1_id => $lg2tm1_name['Team']['team_name'],
            $lg2tm2_id => $lg2tm2_name['Team']['team_name'],
            $lg2tm3_id => $lg2tm3_name['Team']['team_name'],
            $lg2tm4_id => $lg2tm4_name['Team']['team_name'],
            $lg2tm5_id => $lg2tm5_name['Team']['team_name'],
            $lg2tm6_id => $lg2tm6_name['Team']['team_name'],
        );

        $standing_obj = new PennantResult($lg1_team_id);

        # ここからペナント実行
        $game_count = 1;
        $standing_obj->initStandings($games);
        while (1) {
                    
            # 対戦するチームの決定
            $match_team_id = $standing_obj->getMatchTeams();
            $top_id = $match_team_id['top'];
            $bottom_id = $match_team_id['bottom'];

            # 試合結果のスコアを取得
            $game_result = new GameResult();
            $top_score = $game_result->score['top']['total'] ;
            $bottom_score = $game_result->score['bottom']['total'] ;
            
            # 試合結果を登録
            $standing_obj->saveScore(
                $top_id, $bottom_id, $top_score, $bottom_score
            );

            # 全試合終了したらループを抜ける
            $game_count++;
            if($game_count > ($games*count($lg1_team_id)/2)) break;

        }
        # 勝率を計算
        $standing_obj->calcWinPct(); 
        # 勝率でソート
        $standing_obj->sortByWinPct(); 
        # ゲーム差を計算
        $standing_obj->calcGameBehind(); 

        $this->set('games', $games);
        $this->set('standings', $standing_obj->getStandings());
        $this->set('lg1_team_id', $lg1_team_id);
        $this->set('lg2_team_id', $lg2_team_id);
        $this->set('lg1_team_id_name', $lg1_team_id_name);
        $this->set('lg2_team_id_name', $lg2_team_id_name);
    }

}
