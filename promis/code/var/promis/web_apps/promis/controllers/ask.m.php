<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ask extends MY_Controller {

    public function __construct()
    {
      parent::__construct();
      self::set_template('main');
      $this->load->model('survey_model');
    }

	public function index()
	{

	  $data = array();

	  foreach($_POST as $k=>$v)
	  {
	      $data[$k] = $v;
	  }

	  //initialize questioneer data locally,dump all we have
	  $this->survey_model->set_token( $data );

	  $data['html_title'] = 'Survey';
	  $this->load->view('ask',$data);
	}
}