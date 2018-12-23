<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fundraise extends CI_Controller {

    private $data;
    
    public function neenufar() {
        $this->data['styles_to_load'] = array();
        $this->data['scripts_to_load'] = array('app/fundraise/neenufar');
        
        $this->template->write('title', SITE_NAME);
        $this->template->write_view('content', 'fundraise/neenufar', $this->data);
        $this->template->render();
    }
}