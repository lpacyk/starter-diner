<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Admin extends Application {
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $origin = $_SERVER['HTTP_REFERER'];
        $role = $this->session->userdata('userrole');
        if ($role == 'user') {
            $this->data['content'] = 'Denied Access. Sorry';
        } else {
            $this->data['content'] = 'Welcome to the Admin Page';
        };
        $this->render();
    }
}