<?php

class HomesController extends AppController {
    private $app_name = 'BPS';

    public function index() {
        $this->set("title_for_layout", $this->app_name);
    }

}
