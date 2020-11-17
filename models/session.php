<?php
    session_start();
    class Session{
        public function setSession($sessionname, $sessionvalue){
           if(!isset($_SESSION[$sessionname])){
               $_SESSION[$sessionname] = $sessionvalue;
           }
        }
        public function getSession($sessionname){
            if(isset($_SESSION[$sessionname])){
                return $_SESSION[$sessionname];
            }
        }
        public function deleteSession($sessionname){
            if(isset($_SESSION[$sessionname])){
                unset($_SESSION[$sessionname]);
            }
        }
    }
?>