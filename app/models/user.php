<?php
namespace App\Models;
use App\Model;
class User extends Model{
    protected $_tablename = 'users_tbl';
    public function __construct(){
        parent::__construct();
        $this->_fields = ['id'=>'NULL' , 'username' => null , 'password' => null , 'email' => null ];
    }
}