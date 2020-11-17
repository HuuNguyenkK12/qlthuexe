<?php
ob_start();
    class Cookie{
        public function setCookie($cookiename, $cookievalue, $cookie_expire){
            if(!isset($_COOKIE[$cookiename])){
                setcookie($cookiename, $cookievalue, $cookie_expire, "/","",0);
            }
        }
        public function getCookie($cookiename){
            if(isset($_COOKIE[$cookiename])){
                return $_COOKIE[$cookiename];
            }
        }
        public function deleteCookie($cookiename){
            if(isset($_COOKIE[$cookiename])){
                setcookie($cookiename, "", 1, "/","",0);
            }
        }

    }
?>