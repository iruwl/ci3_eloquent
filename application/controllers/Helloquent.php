<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// use Illuminate\Database\Capsule\Manager as DB;

class Helloquent extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // echo DB::getDatabaseName();
        
        // echo Elo::connection('default')->getDatabaseName();
        // echo Elo::connection('other')->getDatabaseName();
        
        // $data = Elo::table('tblcustomers')->take(100)->get();
        // var_dump($data);
        
        // $customer = Customers::all();
        // var_dump($customer);
    }
}