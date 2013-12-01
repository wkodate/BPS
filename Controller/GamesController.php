<?php

class GamesController extends AppController {
    private $app_name = 'BPS';
    private $GameObj;
    public $uses = array('Game', 'Team');

    public function index() {
        $this->set("title_for_layout", $this->app_name);
        
        # 試合情報取得 
        $this->set("gameInfo", $this->getGameInfo);
        
        # チーム情報取得
        $top_team_id = $this->request->data['Team']['top_team_id'];
        $bottom_team_id = $this->request->data['Team']['bottom_team_id'];
        $top_team_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $top_team_id),
            'fields' =>  array('Team.team_name')
        ));
        $bottom_team_name = $this->Team->find('first', array(
            'conditions' =>  array('Team.id'  =>  $bottom_team_id),
            'fields' =>  array('Team.team_name')
        ));
        $this->set('top_team_id', $top_team_id);
        $this->set('bottom_team_id', $bottom_team_id);
        $this->set('top_team_name', $top_team_name['Team']['team_name']);
        $this->set('bottom_team_name', $bottom_team_name['Team']['team_name']);
        $GameObj = new $this->Game();
        $team_info = $GameObj->getTeamInfo();
        $this->set("top_order", $team_info['order']['top']);
        $this->set("bottom_order", $team_info['order']['bottom']);
        $GameObj->init();
        $this->set("GameObj", $GameObj);
        
    }
    
    public function start() {
        $this->set("title_for_layout", $this->app_name);
        $this->set("gameInfo", $this->getGameInfo);
        $GameObj = $This->request->data['Game']['GameObj'];
        #$score = $this->getScore();
        $this->set("GameObj", $GameObj);
        #$this->set("score", $score);


    }

    public function playing() {
        $this->set("title_for_layout", $this->app_name);

        # 1打席実行
        $atBatResult = $this->atBat();
        $this->set("at_bat_result", $atBatResult);
        
    }

}
