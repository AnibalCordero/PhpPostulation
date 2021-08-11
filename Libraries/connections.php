<?php 
    class Connection{
        private $SERVER = 'localhost';
        private $DB = 'phppostulation';
        private $USER = 'root';
        private $PASS = '';
        private $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        public function connect(){
            try {
                $DSN = 'mysql:host='.$this->SERVER.';dbname='.$this->DB;
                $pdoObj = new PDO($DSN, $this->USER, $this->PASS, $this->options);
                return $pdoObj;
            } catch (PDOException $err) {
                echo '<pre>';
                echo "error de conexión ".$err;
                echo '</pre>';
            }
        }
   
    }
    

?>