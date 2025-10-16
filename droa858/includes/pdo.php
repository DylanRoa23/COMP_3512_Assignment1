<?php
/* This class controls all PDO functions. */
class PDOControl {

    /* Constants */
    private const ERRMODE = PDO::ERRMODE_EXCEPTION;

    /* Fields */
    private string $connString;
    private string $user;
    private string $pass;
    private ?PDO $pdo;

    /**
     * Constructor
     * 
     * Initialize fields and connects to the database
     * 
     * @param string $connString Connection string
     * @param string $user Username
     * @param string $pass Password
     */
    public function __construct(string $connString, string $user, string $pass) {

        /* Save data */
        $this->connString = $connString;
        $this->user = $user;
        $this->pass = $pass;
        
        /* Connect to database */
        try {
            $pdo = new PDO($this->connString, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, self::ERRMODE);
            $this->pdo = $pdo;
        }
        catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        
    }

    /* Functions */

    /**
     * 
     * Queries the database with an SQL string and parameters.
     * 
     * @param string $sql An SQL query string with named parameters.
     *  Format: "SELECT * FROM table WHERE column = :paramName AND column2 = :paramName2"
     * @param ?array $paramArray A parameter array or null if no parameters. 
     *  Format: ['paramName' => 'paramValue', 'paramName2' => 'paramValue2']
     * @return ?PDOStatement Returns a PDOStatement on success or null on failure.
     */
    public function query(string $sql, ?array $paramArray): ?PDOStatement {

        /* Initialize. */
        $statement = null;

        /* Try */
        try {

            /* Prepare and execute. */
            $statement = $this->pdo->prepare($sql);
            $statement->execute($paramArray);

        }
        /* If failed, */
        catch (PDOException $e){

            /* Die */
            die("Query failed: " . $e->getMessage());

        }

        /* Return */
        return $statement;
    }

    /**
     * 
     * Closes the connection to the database. This Pdo instance is no longer usable.
     * 
     * @return void
     */
    public function close(): void {
        
        /* Try */
        try {
            
            /* Close */
            $this->pdo = null;

        }
        /* If failed, */
        catch (PDOException $e) {

            /* Die */
            die("Close failed: " . $e->getMessage());

        }
    }


}

?>
