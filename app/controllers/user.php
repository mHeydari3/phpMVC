<?php
namespace App\Controllers;
use App\Controller;
use App\Models\User as UserModel;
class User extends Controller {
    public function showAction(){
        $this->render('user.show'  , ['name' => 'mohammad']);
    }
}