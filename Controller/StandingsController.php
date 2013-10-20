<?php

class StandingsController extends AppController {
    //public $scaffold;
    private $app_name = 'BPS';
    public $helper = array('Html', 'Form');
    public $uses = array('Standing', 'GameResult', 'Team');

    public function index() {
        $this->set("title_for_layout", $this->app_name . ' - ' . 'ペナント結果');
        $this->set("standings", $this->Standing->find('all'));
        $this->set("game_results", $this->GameResult->find('all'));

        if (isset($this->request->data['Standings'])) {
            if ($this->Standings->save($this->request->data)) {
                $this->Session->setFlash('Success!!');
                $this->redirect(array('controller'=>'homes', 'action'=>'index'));
            } else {
                $this->Session->setFlash('Failed!!');
            }
            return;
        }

        $team_1_id = $this->request->data['Team']['team_1_id'];
        $team_1_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $team_1_id),
            'fields' =>  array('Team.team_name')
        ));
        $team_2_id = $this->request->data['Team']['team_2_id'];
        $team_2_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $team_2_id),
            'fields' =>  array('Team.team_name')
        ));
        $team_3_id = $this->request->data['Team']['team_3_id'];
        $team_3_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $team_3_id),
            'fields' =>  array('Team.team_name')
        ));
        $team_4_id = $this->request->data['Team']['team_4_id'];
        $team_4_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $team_4_id),
            'fields' =>  array('Team.team_name')
        ));
        $team_5_id = $this->request->data['Team']['team_5_id'];
        $team_5_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $team_5_id),
            'fields' =>  array('Team.team_name')
        ));
        $team_6_id = $this->request->data['Team']['team_6_id'];
        $team_6_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $team_6_id),
            'fields' =>  array('Team.team_name')
        ));

        $team_id = array(
            $team_1_id,
            $team_2_id,
            $team_3_id,
            $team_4_id,
            $team_5_id,
            $team_6_id
        ); 

        $team_id_name = array(
            $team_1_id => $team_1_name['Team']['team_name'],
            $team_2_id => $team_2_name['Team']['team_name'],
            $team_3_id => $team_3_name['Team']['team_name'],
            $team_4_id => $team_4_name['Team']['team_name'],
            $team_5_id => $team_5_name['Team']['team_name'],
            $team_6_id => $team_6_name['Team']['team_name']
        );

        $standing_obj = new Standing($team_id);

        # ここからペナント実行
        $game_count = 1;
        $standing_obj->initStandings();
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
            if($game_count > $standing_obj->getGameTotalCount()) break;

        }
        # 勝率を計算
        $standing_obj->calcWinPct(); 
        # 勝率でソート
        $standing_obj->sortByWinPct(); 
        # ゲーム差を計算
        $standing_obj->calcGameBehind(); 

        $this->set('standings', $standing_obj->getStandings());
        $this->set('team_id', $team_id);
        $this->set('team_id_name', $team_id_name);
    }

}
