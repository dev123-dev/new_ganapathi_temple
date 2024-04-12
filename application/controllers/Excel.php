<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Excel {
    
    function Excel()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/excel_reader2';
        include_once APPPATH.'/third_party/SpreadsheetReader.php';
         
        if ($params == NULL)
        {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';         
        }
         
        return new SpreadsheetReader($param);
    }
}