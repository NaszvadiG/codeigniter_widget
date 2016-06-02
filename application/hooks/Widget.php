<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Widget Class
 * ========================================================================================
 * Widget Class for Codeigniter
 */
class Widgets {

    protected $CI;

    /**
     * do_replace widget tag to widget element
     */
    function widget_replace() {

        $this->CI =& get_instance();
        // get display content;

        $buffer = $this->CI->output->get_output();

        // searching widget tags;
        $buffer = preg_replace_callback('!<widget([^\>]*)\>!is', array($this,'trans'), $buffer);

        // output replacing data;
        $this->CI->output->set_output($buffer);

        $this->CI->output->_display();
    }

    function trans($matches) {
        // get extra values;
        $vars	= trim($matches[1]);

        // replace array && return to query string
        $vars = preg_replace('/\r\n|\r|\n|\t/',' ',$vars);
        $vars = str_replace( array('"','  '), array('',' '), $vars );
        $vars = trim(str_replace( " ", '&', $vars ));

        // query string to array
        parse_str($vars, $vars_array);

        return $this->get_widget_content($vars_array);
    }

    function get_widget_content( $vars_array ) {
        $return = "";
        if(file_exists( VIEWPATH . "/widget/". $vars_array['type'] . ".php")) {
            $return = $this->CI->load->view( "/widget/".$vars_array['type'] .".php", $vars_array, TRUE );
        }
        return $return;
    }

}