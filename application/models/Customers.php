<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Model {
    // set database connection (optional, default connection => 'default')
    protected $connection = 'default';
    // set table name (optional, default extract from model name)
    protected $table = 'tblcustomers';

    public function changeConnection($conn = 'default')
    {
        $this->connection = $conn;
    }
}