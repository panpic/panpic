<?php
/**
 * Class Mycallback
 * Callback method in Class
 *
 * @copyright Panpic.vn
 * @author bang.nguyen@panpic.vn
 */
class Mycallback
{


    function __construct(){

    }

    public function processCallback(callable $callback) {

        return $callback();
    }

    function doSomething(){

        $function_name = "myFunction";
        $this->processCallback([$this, $function_name]);
    }

    function myFunction() {

        echo "Hello Callback method of class";
    }

}