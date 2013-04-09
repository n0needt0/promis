<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mHome extends MY_Controller {

    public function __construct()
    {
      parent::__construct();
      self::set_template('mobile');
    }

	public function index()
	{
	    $data = array();
	    $data['html_title'] = 'Survey';
		$this->load->view('mhome',$data);
	}
}