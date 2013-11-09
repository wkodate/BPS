<?php

class GameResultsController extends AppController {
    //public $scaffold;
    private $app_name = 'BPS';
    public $helper = array('Html', 'Form');
    public $uses = array('GameResult', 'Team', 'Game');
    public $Game;

    public function index() {
        $this->set("title_for_layout", $this->app_name . ' - ' . '試合結果');
        $this->setGame();
        $this->set('game_result_detail', $this->Game);

        if (isset($this->request->data['GameResult'])) {
            if ($this->GameResult->save($this->request->data)) {
                $this->Session->setFlash('Success!!');
                $this->redirect(array('controller'=>'homes', 'action'=>'index'));
            } else {
                $this->Session->setFlash('Failed!!');
            }
        } else {
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
        }
    }

    # Gameオブジェクト生成
    public function setGame() {
        # Gameモデルの呼び出し
        App::import('Model', 'Game');
        $this->Game = new Game(); 
    }

}
