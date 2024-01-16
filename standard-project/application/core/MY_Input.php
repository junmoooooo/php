<?php if( !defined('BASEPATH') )
{
    exit('No direct script access allowed');
}

    class MY_Input extends CI_Input
    {
        function post($index = NULL, $xss_clean = FALSE, $default_value = NULL)
        {
            // Check if a field has been provided
            if( $index === NULL AND !empty($_POST) )
            {
                $post = [];

                // Loop through the full _POST array and return it
                foreach( array_keys($_POST) as $key )
                {
                    $post[$key] = $this->_fetch_from_array($_POST, $key, $xss_clean);
                }

                return $post;
            }

            $ret_val = $this->_fetch_from_array($_POST, $index, $xss_clean);

            if( !isset($ret_val) || $ret_val == "" )
            {
                $ret_val = $default_value;
            }

            return $ret_val;
        }
    }
    // END Input Class

    /* End of file Input.php */
    /* Location: ./system/core/input.php */