<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class All extends CI_Controller {

    private $data;

    /**
     * Home page
     */
    public function home() {
        $this->template->set_template('home');
        
        $this->data['styles_to_load'] = array();
        $this->data['scripts_to_load'] = array('app/all/home');
        
        $this->template->write('title', SITE_NAME);
        $this->template->write_view('content', 'all/home', $this->data);
        $this->template->render();
    }

}
