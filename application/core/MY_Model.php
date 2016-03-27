<?php defined('BASEPATH') OR exit('No direct script access allowed');
#ref: http://stackoverflow.com/questions/32052488/codeigniter-eloquent-superclass

use \Illuminate\Database\Eloquent\Model as Eloquent;

class MY_Model extends Eloquent {
    public $timestamps = false;

    function __construct() {
        parent::__construct();
    }

    protected function getDateFormat() {
        return 'U';
    }
}