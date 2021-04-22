<?php
class Index{
    public function indexAction(){
     echo "SALAM MAN index az CONTROLLER INDEX";


    }
    public function saywelcomeAction ($params = null) {
        echo "welcome "  . $params;
    }
    public function salamAction (){
        echo "<h1>SALAM</h1>";
    }
    public function forceinputAction(){
        echo "<h3>  Force inputttt  </h3>";
    }

}