<?php
namespace App\Controllers;
use App\Controller;
use App\Models\User as UserModel;
class User extends Controller {
    public function showAction(){
        $this->render('user.show'  , ['name' => 'mohammad']);
        $usermodel = new UserModel();
        $usermodel->username = "moha";
        $usermodel->password = "pass";
        $usermodel->email = "test@t.com";
        $usermodel->save();
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