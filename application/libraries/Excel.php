<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  =======================================
 *  Author     : Renfrid Ngolongolo
 *
 *  =======================================
 */
require_once APPPATH . "/third_party/PHPExcel.php";

class Excel extends PHPExcel
{
    public function __construct()
    {
        parent::__construct();
    }
}
