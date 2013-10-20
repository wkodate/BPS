<?php

class TeamsController extends AppController {
    //public $scaffold;
    private $app_name = 'BPS';

    public $helper = array('Html', 'Form');

    public function index() {
        $this->set("title_for_layout", $this->app_name . ' - ' . '試合設定');
        $this->set("teams", $this->Team->find('all'));
        $this->set("team_names", $this->Team->find('list', array(
            'fields' =>  array('Team.team_name')
        )));
    }

    public function pennant() {
        $this->set("title_for_layout", $this->app_name . ' - ' . 'ペナント設定');
        $this->set("teams", $this->Team->find('all'));
        $this->set("team_names", $this->Team->find('list', array(
            'fields' =>  array('Team.team_name')
        )));
    }
}
