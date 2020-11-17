<?php
    class Redirect{
        public function getUrl($url){
            return 'http://'.$_SERVER['SERVER_NAME'].'/'.$url;
        }
        public function redirects($url){
            header("Location: $url");
            exit();
        }
    }
?>