<?php
namespace App\Controllers;
use App\Controller;
use App\Models\User as UserModel;
class User extends Controller {
    public function showAction(){
        echo 'user controller -> show action';
        dd(new UserModel);
    }
}