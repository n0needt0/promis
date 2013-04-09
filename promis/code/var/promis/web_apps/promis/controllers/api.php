<?php
require APPPATH.'/libraries/REST_Controller.php';
require APPPATH.'/libraries/Promis_API.php';

/*this class wraps api to promis*/
Class api extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('survey_model');
        $this->promis= new Promis_API();
        $this->lang = 'en';

        $jsonp = $this->get('callback');

        if(!empty($jsonp))
        {
            $this->response->format = 'jsonp';
        }
          else
        {
            $this->response->format = 'json';
        }

        $this->raw = $this->get("raw");
    }

    public function response($data)
    {
        if(!empty($this->raw))
        {
            print_r($data);
            die;
        }
          else
        {
            parent::response($data);
        }
    }

    public function index()
    {
        die;
    }

    public function token_data_get($token)
    {
        $res =  $this->survey_model->get_token_data($token);

        $expire = strtotime($res['expire']);

        if($expire < time())
        {
            $res['status'] = 'expired';
        }

        $this->response($res);
        die;
    }

    public function token_delete_get($token)
    {
      $res =  $this->survey_model->delete_token($token);
      $this->response($res);
      die;
    }

    public function promis_forms_get()
    {

        $forms = $this->survey_model->get_instruments();
        $forms = unserialize(apc_fetch('promis_instruments',$r));

        if(count($forms))
        {

             $forms = array();

             $res = $this->promis->get_forms();

             if(isset($res->error))
             {
                 utils::error_echo_die($res->error);
             }

             foreach( $res->Form as $k=>$rec)
             {
                 $forms[$rec->OID] = $rec->Name;
             }

             $this->survey_model->set_instruments($forms);
             apc_store('promis_instruments', serialize($forms), 3000);
         }

        $this->response($forms);
        die;
    }

    public function promis_calibrations_get()
    {
        $res = $this->promis->get_calibrations();
        $this->response($res);
        die;
    }

    public function promis_token_get($instrument_id, $uid='', $expire_in_days=7)
    {
        $res = $this->promis->get_token($instrument_id, $uid, $expire_in_days);
        $this->response($res);
        die;
    }

    public function promis_ask_get($token,$ItemResponseOID='',$Response='')
    {
      $this->lang = 'e';
        //enter answers
        if(!empty($ItemResponseOID) && !empty($Response))
        {
             $this->survey_model->set_answer($token, $ItemResponseOID, $Response);
        }

        try{


              $res = $this->promis->get_ask($token,$ItemResponseOID,$Response);

              foreach($res->Items as $ik=>&$iv)
              {

                      foreach($iv->Elements as $k=>&$v)
                      {
                          if(isset($v->Description))
                          {
                            $v->Description = $this->survey_model->get_translate($v->Description, $this->lang);
                          }

                          if(isset($v->Map))
                          {
                              foreach($v->Map as $km=>&$vm)
                              {
                                  if(isset($vm->Description))
                                  {
                                    $vm->Description = $this->survey_model->get_translate($vm->Description, $this->lang);
                                  }
                              }
                        }
                  }
              }

            $this->response($res);
            die;
        }
         catch(Exception $e)
        {
            utils::log_message(LOG_ERROR, __FUNCTION__ . " Exception " . $e->getMessage());
            $this->response(array());
            die;
        }
    }

    public function promis_result_get($token)
    {
        $res = $this->promis->get_result($token);

        if(isset($res) && empty($res->error))
        {
             $this->survey_model->set_result($token, $res);
        }

        $this->response($res);
        die;
    }

    public function promis_usage_get()
    {
        $res = $this->promis->get_usage();
        $this->response($res);
        die;
    }
}