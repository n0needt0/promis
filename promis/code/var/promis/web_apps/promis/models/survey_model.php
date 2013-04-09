<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey_Model extends CI_Model {


   public function set_token($data)
   {
        try{
           $data['updated'] = time();
           $data['status'] = 'incomplete';
          //set token or updateif already was set
           $this->mdb->db->surveys->update(
                 array("token" => $data['token']),
                 $data,
                 array("upsert" => true)
             );
        }
          catch(Exception $e)
        {
           utils::log_message('error',  'Exception: ',  $e->getMessage());
           return false;
        }
   }

   public function get_token_data($token)
   {
     try{
          $res = $this->mdb->db->surveys->findOne(array('token'=>$token));
          return $res;
     }
       catch(Exception $e)
     {
       utils::log_message('error',  'Exception: ',  $e->getMessage());
       return false;
     }
   }

   public function delete_token($token)
   {
     try {
         return $this->mdb->db->surveys->remove(array('token'=>$token));
      }
       catch(Exception $e)
      {
          utils::log_message('error',  'Exception: ',  $e->getMessage());
          return false;
      }

   }

   public function delete_id($id)
   {
     try{
           return $this->mdb->db->surveys->remove(array('_id' => new MongoId($id)));
       }
        catch(Exception $e)
       {
           utils::log_message('error',  'Exception: ',  $e->getMessage());
           return false;
       }
   }

   public function get_surveys($pin, $pkey)
   {

        try{
             $cursor = $this->mdb->db->surveys->find(array('pin'=>$pin, 'pkey'=>$pkey));

             $data = array();

             foreach ($cursor as $doc)
             {

                  $r = array();
                  $r['id'] = $doc['_id']->{'$id'};
                  $r['updated'] = $doc['updated'];
                  $r['token'] = $doc['token'];
                  $r['instrument_name'] = $doc['instrument_name'];
                  $r['instrument_id'] = $doc['instrument_id'];
                  $r['status'] = $doc['status'];
                  $expire = strtotime($doc['expire']);

                  if(('incomplete' == $r['status']) && ($expire < time()))
                  {
                      $r['status'] = 'expired';
                  }

                  $data[] = $r;
             }

             return $data;
        }
          catch(Exception $e)
        {
            utils::log_message('error',  'Exception: ',  $e->getMessage());
            return false;
         }
   }

   public function set_answer($token, $answer, $answer_value)
   {
       try{
               $res = $this->mdb->db->surveys->findOne(array('token'=>$token));
               $res['answers'][$answer] = $answer_value;

               $this->mdb->db->surveys->update(
                   array("token" => $token),
                   $res,
                   array("upsert" => true)
               );

       }catch(Exception $e)
        {
            utils::log_message('error',  'Exception: ',  $e->getMessage());
            return false;
        }

       return;
   }

   public function set_result($token, $result)
   {
     try{
         $res = $this->mdb->db->surveys->findOne(array('token'=>$token));
         $res['result'] = $result;
         $res['status'] = 'completed';
         $this->mdb->db->surveys->update(
             array("token" => $token),
             $res,
             array("upsert" => true)
         );

     }catch(Exception $e)
     {
         utils::log_message('error',  'Exception: ',  $e->getMessage());
         return false;
     }

     return;
   }

   public function set_instruments($instruments)
   {
       $this->mdb->db->surveys->update(
           array("type" => "instruments"),
           array("type" => "instruments",'created'=>time(), 'data' => $instruments),
           array("upsert" => true)
       );
   }

   public function get_instruments()
   {
       $cursor =  $this->mdb->db->surveys->find(array('type'=>'instruments'));

       $res = false;

       foreach ($cursor as $doc)
       {
           if( empty($doc['created']) || ( $doc['created'] < time() - API_TTL ) )
           {
                utils::log_message('debug', 'Updating instrument cache');
                return false;
           }
           $res = $doc['data'];
       }

       return $res;
   }

   public function set_translate($string_en, $translated_string, $lang='en')
   {
     $key = 'translate_' . $lang . '_' . md5($string_en);

     $this->mdb->db->surveys->update(
         array('type' => $key),
         array('type' => $key,'created'=>time(), 'data' => $translated_string),
         array("upsert" => true)
     );
   }

   public function translate($string_en, $lang='en')
   {
         //get translation from google

         $url = "https://www.googleapis.com/language/translate/v2?key=" . GOOGLE_TRANSLATE_KEY . "&q=" . urlencode($string_en) . "&source=en&target=" . $lang;

         utils::log_message(LOG_DEBUG, __FUNCTION__ . " called with " . $url);
         $res = utils::do_curl( $url );


         $translate = json_decode($res,true);

         if(isset($translate['data']) && isset($translate['data']['translations']) && isset($translate['data']['translations'][0]) && isset($translate['data']['translations'][0]['translatedText']))
         {
             $translated_string = $translate['data']['translations'][0]['translatedText'];
             $this->set_translate($string_en, $translated_string, $lang);
             return $translated_string;
         }
         else
         {
             utils::log_message(LOG_ERR, __FUNCTION__ . " CNANOT Translate " . $url);
             return $string_en;
         }
   }

   public function get_translate($string_en, $lang='en')
   {

       if('en' == $lang)
       {
           return $string_en;
       }

       $key = 'translate_' . $lang . '_' . md5($string_en);

       $cursor =  $this->mdb->db->surveys->find(array('type'=>$key));

       $res = false;

       $doc_count =  $cursor->count();

       if(empty($doc_count))
       {
           return $this->translate($string_en,$lang);
       }

       foreach ($cursor as $doc)
       {

           if( empty($doc['data']) || empty($doc['created']) || ( $doc['created'] < time() - TRANSLATE_API_TTL ) )
           {
               return $this->translate($string_en,$lang);
           }
             else
           {
               return $doc['data'];
           }
       }
     }

}