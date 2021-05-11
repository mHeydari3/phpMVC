<?php
namespace App\Models;
use App\Model;
class User extends Model{
    protected $_tablename = 'users_tbl';
    public function __construct(){
        parent::__construct();
        $this->setInitialFields([
            'id' => ['default'=>null , 'editable' => true , 'readable' => true , 'rule' => 'required|max:10'],
            'username' => ['readable' => false , 'rule' => 'required'],
            'password' ,
            'email'
        ]);
    }
}