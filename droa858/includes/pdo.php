<?php
/* This class controls all PDO functions. */
class PDOControl {

    /* Constants */
    private const ERRMODE = PDO::ERRMODE_EXCEPTION;

    /* Fields */
    private $connString;
    private $user;
    private $pass;
    private $pdo;

    /* Constructor */
    public function __construct($connString, $user, $pass) {

        /* Save data */
        $this->connString = $connString;
        $this->user = $user;
        $this->pass = $pass;
        
        /* Connect to database */
        try {
            $pdo = new PDO($this->connString, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, self::ERRMODE);
            $this->pdo = $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        
    }

}

?>
