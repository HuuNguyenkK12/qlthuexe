<?php
    class Database{
        private $servername = "localhost";
        private $username = "root";
        private $password = "s2dttx2806";
        private $dbname = "qlthuexe";
        private $connection = null;
        public $s = null;
        public $c = null;
        public $r = null;
        public function __construct()
        {
            $this->s = new Session();
            $this->c = new Cookie();
            $this->r = new Redirect();
        }
        public function __destruct()
        {
            if(!is_null($this->connection)){
                $this->disconnectDatabase();
            }
        }
        public function connectDatabase(){
            try{    
                if(is_null($this->connection)){ 
                    $this->connection = new PDO("mysql:host=$this->servername;dbname=$this->dbname;", $this->username, $this->password);
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                }
            }catch(PDOException $ex){
                die($ex->getMessage());
            }
        }
        public function disconnectDatabase(){
            if(!is_null($this->connection)){
                $this->connection = null;
            }
        }
        public function dbExecute($sql = "", $param = array()){
            $this->connectDatabase();
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($param);
            if($stmt->rowCount() > 0)
                return true;
            return false;
        }
        public function insert($sql = "", $data = array()){
            if($this->dbExecute($sql, $data))
                return true;
            else
                return false;
        }
        public function delete($sql, $condition = array()){
            if($this->dbExecute($sql, $condition))
                return true;
            else
                return false;
        }
        public function update($sql = "", $data = array()){
            if($this->dbExecute($sql, $data))
                return true;
            else
                return false;
        }
        public function select($sql = ""){
            $this->connectDatabase();
            $stmt = $this->connection->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch()){
                    $table[] = $row;
                }
                return $table;
            }
            return false;
        }
        public function convertSecond($seconds){
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $day = floor($seconds / (24 * 3600));
            $seconds = $seconds % (24*3600);
            
            $hour = floor($seconds / 3600);
            $seconds = $seconds % 3600;

            $minute = floor($seconds / 60);
            $seconds = $seconds % 60;

            return array(
                'day' => $day,
                'hour' => $hour,
                'minute' => $minute,
                'second' => $seconds
            );
        }
        public function formatMoney($number){
            $money = floor($number / 1000);
            $hundred = $number % 1000;
            if($hundred > 500){
                $money++;
            }
            return $money * 1000;
        }
        public function uploadImage($file = array()) : bool{
            $check = 1;
            $target_dir = 'uploads/';
            $allowed_extention = ['.png', '.jpg', '.jpeg'];
            $extention_file = '.'. pathinfo($file['name'], PATHINFO_EXTENSION);
            if(!in_array($extention_file, $allowed_extention)){
                $check = 0;
                echo "<script>alert('Bạn chỉ được phép upload file định dạng '.png', '.jpg', '.jpeg')</script>";
            }
            if($file['size'] > 5242880){
                $check = 0;
                echo "<script>alert('Bạn chỉ được phép upload file <= 5MB')</sript>";
            }
            if($check === 1){
                move_uploaded_file($file['tmp_name'], $target_dir.$file['name']);
                return true;
            }
            return false;       
    }
}
?>
