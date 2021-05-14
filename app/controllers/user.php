<?php
namespace App\Controllers;
use App\Controller;
use App\Model;
use App\Models\User as UserModel;
class User extends Controller {
    public function showAction(){
        $this->render('user.show'  , ['name' => 'mohammad']);
        //$users = Model::table('user')->find(['id' => '1'] )[0];
        $users = Model::table('user') ;
        $users->username = 'new name';
        $users->password = 'passss';
        $users->email = "test@t.com" ;

        $users->save();


    }

    public function showallAction(){
        $users = [
          ['name'=>'sayad' , 'lastname'=>'azami' , 'age'=>26],
          ['name'=>'ehsan' , 'lastname'=>'charmpishe' , 'age'=>28],
          ['name'=>'hassan' , 'lastname'=>'ghalami' , 'age'=>28],
          ['name'=>'mohammad' , 'lastname'=>'ebrahimi' , 'age'=>22],
        ];
        $this->render('user.showall' , compact('users'));

    }
}