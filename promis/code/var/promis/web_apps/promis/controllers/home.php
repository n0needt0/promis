<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct()
    {
      parent::__construct();
      self::set_template('main');
    }

	public function index()
	{
	    $data = array();
	    $data['html_title'] = 'Survey';
		$this->load->view('home',$data);
	}
}