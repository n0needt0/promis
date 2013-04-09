<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils
{

      public function __construct()
      {
        $this->CI =& get_instance();
      }

    /**
    * Count the number of bytes of a given string.
    * Input string is expected to be ASCII or UTF-8 encoded.
    * Warning: the function doesn't return the number of chars
    * in the string, but the number of bytes.
    * See http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
    * for information on UTF-8.
    *
    * @param string $str The string to compute number of bytes
    *
    * @return The length in bytes of the given string.
    */
    public function str_byte($str){
     // STRINGS ARE EXPECTED TO BE IN ASCII OR UTF-8 FORMAT

     // Number of characters in string
     $strlen_var = strlen($str);

     // string bytes counter
     $d = 0;

     /*
     * Iterate over every character in the string,
     * escaping with a slash or encoding to UTF-8 where necessary
     */
     for($c = 0; $c < $strlen_var; ++$c){
      $ord_var_c = ord($str{$c});
      switch(true){
      case(($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):
       // characters U-00000000 - U-0000007F (same as ASCII)
       $d++;
       break;
      case(($ord_var_c & 0xE0) == 0xC0):
       // characters U-00000080 - U-000007FF, mask 110XXXXX
       $d+=2;
       break;
      case(($ord_var_c & 0xF0) == 0xE0):
       // characters U-00000800 - U-0000FFFF, mask 1110XXXX
       $d+=3;
       break;
      case(($ord_var_c & 0xF8) == 0xF0):
       // characters U-00010000 - U-001FFFFF, mask 11110XXX
       $d+=4;
       break;
      case(($ord_var_c & 0xFC) == 0xF8):
       // characters U-00200000 - U-03FFFFFF, mask 111110XX
       $d+=5;
       break;
      case(($ord_var_c & 0xFE) == 0xFC):
       // characters U-04000000 - U-7FFFFFFF, mask 1111110X
       $d+=6;
       break;
       default:
       $d++;
      };
     };
     return $d;
    }

      function style_change($change)
      {
        if($change < 0)
        {
          return "<span class='negative'> $change</span>";
        }

        if($change > 0)
        {
          return "<span class='positive'> +$change</span>";
        }

        return "";
      }

      function curPageURL()
      {
        $pageURL = 'http';
        if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on")
        {
          $pageURL .= "s";
        }
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        return $pageURL;
      }

      function make_guid()
      {
        srand((double)microtime()*1000000);
        $r = rand() ;
        $u = uniqid(getmypid() . $r . (double)microtime()*1000000,1);
        $m = md5 ($u);
        return($m);
      }

      function do_curl( $url , $method='GET', $postdata=array())
      {
        $ch = curl_init();
        $referrer = 'http://www.google.com';
        $cookiefile = '.cookies.txt';
        $res = "";
        $uagent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6';

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt( $ch, CURLOPT_USERAGENT, $uagent );
        curl_setopt( $ch, CURLOPT_TIMEOUT, '60' );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookiefile );
        curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookiefile );
        curl_setopt( $ch, CURLOPT_COOKIESESSION, 1 );
        curl_setopt( $ch, CURLOPT_REFERER, $referrer );

        if('POST'==$method)
        {
            $post_fields = '';

            foreach($postdata as $key=>$value)
            {
                $post_fields .= $key.'='.$value.'&';
            }

            rtrim($post_fields, '&');

            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $post_fields);
        }
         else
        {
           curl_setopt( $ch, CURLOPT_HTTPGET, 1 );
        }

        $res = curl_exec( $ch );
        curl_close($ch);

        return $res;
      }

      function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
      {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

      switch ($theType) {
        case "text":
          $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
          break;
        case "long":
        case "int":
          $theValue = ($theValue != "") ? intval($theValue) : "NULL";
          break;
        case "double":
          $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
          break;
        case "date":
          $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
          break;
        case "defined":
          $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
          break;
        }
    	return $theValue;
      }

      /**
       * Wrapper around codeignitor's log_message which adds class::function prefixes
       */
      public static function log_message($level, $message)
      {
           log_message($level, $message);
      }

    	/**
    	 * Indents a flat JSON string to make it more human-readable.
    	 *
    	 * @param string $json The original JSON string to process.
    	 *
    	 * @return string Indented version of the original JSON string.
    	 */
    	public function json_indent($json) {

    		$result      = '';
    		$pos         = 0;
    		$strLen      = strlen($json);
    		$indentStr   = '  ';
    		$newLine     = "\n";
    		$prevChar    = '';
    		$outOfQuotes = true;

    		for ($i=0; $i<=$strLen; $i++) {

    				// Grab the next character in the string.
    				$char = substr($json, $i, 1);

    				// Are we inside a quoted string?
    				if ($char == '"' && $prevChar != '\\') {
    						$outOfQuotes = !$outOfQuotes;

    				// If this character is the end of an element,
    				// output a new line and indent the next line.
    				} else if(($char == '}' || $char == ']') && $outOfQuotes) {
    						$result .= $newLine;
    						$pos --;
    						for ($j=0; $j<$pos; $j++) {
    								$result .= $indentStr;
    						}
    				}

    				// Add the character to the result string.
    				$result .= $char;

    				// If the last character was the beginning of an element,
    				// output a new line and indent the next line.
    				if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
    						$result .= $newLine;
    						if ($char == '{' || $char == '[') {
    								$pos ++;
    						}

    						for ($j = 0; $j < $pos; $j++) {
    								$result .= $indentStr;
    						}
    				}

    				$prevChar = $char;
    		}

    		return $result;
    	}

    	public function array_unique_recursive($array = null) {
    		if (!@is_array($array)) {
    			return $array;
    		}
    		foreach ($array as $index => $foo) {
    			$array[$index] = array_unique($array[$index]);
    		}
    		return $array;
    	}

    	public function http_s()
    	{
    	    if($_SERVER['SERVER_PORT'] == 443)
            {
               return 'https';
            }
            return 'http';
    	}

      function make_token($time = null)
      {
         if(empty($time))
         {
           $time = time();
         }

         return crc32($time . PASS);
      }

      function verify_token($token,$timestamp)
      {
        if( ( $timestamp > time() + SESS) || ( $timestamp < time() - SESS ) )
        {
            return false;
        }

        $t = time();
        $t_start = $t - SESS;
        $t_end = $t + SESS;
        while($t_end > $t_start )
        {
           if( crc32($t_start . PASS ) == $token)
           {
               return true;
           }

           $t_start++;
         }

         return false;
      }

      function array_pluck($key, $input, $test=false) {
        if (is_array($key) || !is_array($input)) return array();
        $array = array();
        foreach($input as $v)
        {
            if(array_key_exists($key, $v))
            {
                if(false == $test)
                {
                   $array[]=$v[$key];
                }
                 else
                {
                    if(!array_key_exists($test, $v) || $v[$test] != true)
                    {
                        $array[]=$v[$key];
                    }
                }
            }
        }
        return $array;
     }

     function array_median($data) {
        $c_data = count($data);
        $middle = $c_data / 2;

        if ($c_data == 0) {
            return false;
        }//END IF

        if ($c_data < 2) {

            return $data[0];

        } elseif (is_int($middle)) {

            return (($data[$middle - 1] + $data[$middle]) / 2);

        } else {

            return $data[floor($middle)];

        }//END IF

    }//END FUNCTION

    function sd_square($x, $mean) { return pow($x - $mean,2); }

    function sd($array) {
        if(count($array)<2)
        {
          return;
        }
        // square root of sum of squares devided by N-1
        return sqrt(array_sum(array_map("self::sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
    }

    function valid_date($date, $format = 'YYYY-MM-DD')
    {
        if(strlen($date) >= 8 && strlen($date) <= 10)
        {
            $separator_only = str_replace(array('M','D','Y'),'', $format);
            $separator = $separator_only[0];
            if($separator)
            {
                $regexp = str_replace($separator, "\\" . $separator, $format);
                $regexp = str_replace('MM', '(0[1-9]|1[0-2])', $regexp);
                $regexp = str_replace('M', '(0?[1-9]|1[0-2])', $regexp);
                $regexp = str_replace('DD', '(0[1-9]|[1-2][0-9]|3[0-1])', $regexp);
                $regexp = str_replace('D', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp);
                $regexp = str_replace('YYYY', '\d{4}', $regexp);
                $regexp = str_replace('YY', '\d{2}', $regexp);
                if($regexp != $date && preg_match('/'.$regexp.'$/', $date))
                {
                    foreach (array_combine(explode($separator,$format), explode($separator,$date)) as $key=>$value)
                    {
                        if ($key == 'YY') $year = '20'.$value;
                        if ($key == 'YYYY') $year = $value;
                        if ($key[0] == 'M') $month = $value;
                        if ($key[0] == 'D') $day = $value;
                    }
                    if (checkdate($month,$day,$year))
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function error_echo_die($error)
    {
      echo json_encode(array('error'=>$error));
      die;
    }
}