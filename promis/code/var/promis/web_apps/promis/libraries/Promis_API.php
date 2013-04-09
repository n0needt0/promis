<?php
/*this class wraps api to promis*/

Class Promis_API
{
    public function __construct(){
        $this->user = '70623DBE-35CD-4DAD-97FE-7621D828F8FE'; //this is registration key
        $this->token = 'F31578FA-0C5D-4625-B470-BDD546044500';
        $this->output_format = 'json';
        $this->protocol = 'https';

        $this->api_errors = array('Document is null'=>'Document is null', 'Could not find form.'=>'Could not find form.');

    }

    /*
     * format result
     */
    private function result($result)
    {
        if(empty($result))
        {
            return array('error'=>'Empty Document');
        }

        if(isset($this->api_errors[$result]) )
        {
            return array('error'=>$this->api_errors[$result]);
        }

        return json_decode($result);
    }

    /*
     * get list of instruments
     */
    public function get_forms()
    {
        $url = "www.assessmentcenter.net/ac_api/2012-01/Forms/";
        $url = $this->protocol . "://" . $this->user . ":" . $this->token . '@' . $url . "." . $this->output_format;
        utils::log_message(LOG_DEBUG, __FUNCTION__ . " called with " . $url);
        $res = utils::do_curl( $url );

        return $this->result($res);
    }

    /*
     * get calibrations
     */
    public function get_calibrations()
    {
        $url = "www.assessmentcenter.net/ac_api/2012-01/Calibrations/";
        $url = $this->protocol . "://" . $this->user . ":" . $this->token . '@' . $url . "." . $this->output_format;
        utils::log_message(LOG_DEBUG, __FUNCTION__ . " called with " . $url);
        $res = utils::do_curl( $url );

        return $this->result($res);
    }

    /*
     * initialize instrument
     * args char instrumentid, [char uid], [int expire_in_days]
     * returns token
     */
    public function get_token($instrument_id, $uid='', $expire_in_days=7)
    {
        $url = sprintf("www.assessmentcenter.net/ac_api/2012-01/Assessments/%s", $instrument_id);
        $url = $this->protocol . "://" . $this->user . ":" . $this->token . '@' . $url . "." . $this->output_format;
        utils::log_message(LOG_DEBUG, __FUNCTION__ . " called with " . $url);
        $post_data = array('UID'=>$uid, 'Expiration' => $expire_in_days);
        $res = utils::do_curl( $url, 'POST' , $post_data);

        return $this->result($res);
    }


    /*
     * ask questions
     * params token from get token, items from a document
     */
    public function get_ask($token,$ItemResponseOID='',$Response='')
    {
      $url = sprintf("www.assessmentcenter.net/ac_api/2012-01/Participants/%s", $token);
      $url = $this->protocol . "://" . $this->user . ":" . $this->token . '@' . $url . "." . $this->output_format;
      utils::log_message(LOG_DEBUG, __FUNCTION__ . " called with " . $url);

      $post_data = array();

      if(!empty($ItemResponseOID) && !empty($Response))
      {
          $post_data = array('ItemResponseOID'=>$ItemResponseOID, 'Response'=>$Response);
      }

      $res = utils::do_curl( $url,'POST', $post_data);

      return $this->result($res);
    }

    /*
     * once all questions are asked and finish date s received, results can be processed
     * args token
     */
    public function get_result($token)
    {
      $url = sprintf("www.assessmentcenter.net/ac_api/2012-01/Results/%s", $token);
      $url = $this->protocol . "://" . $this->user . ":" . $this->token . '@' . $url . "." . $this->output_format;

      utils::log_message(LOG_DEBUG, __FUNCTION__ . " called with " . $url);

      $res = utils::do_curl( $url);

      return $this->result($res);
    }

    /*
     * returns api usage
     */
    public function get_usage()
    {
      $url = sprintf("www.assessmentcenter.net/ac_api/2012-01/Usage/%s", $this->user);
      $url = $this->protocol . "://" . $this->user . ":" . $this->token . '@' . $url . "." . $this->output_format;

      utils::log_message(LOG_DEBUG, __FUNCTION__ . " called with " . $url);

      $res = utils::do_curl( $url);

      return $this->result($res);
    }
}