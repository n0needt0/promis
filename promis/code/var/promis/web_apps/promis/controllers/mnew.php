<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mNew extends MY_Controller {

    public function __construct()
    {
      parent::__construct();
      self::set_template('mobile');
    }

	public function index()
	{
	    $data = array();
		$this->load->view('mobile/mnew',$data);
	}
}