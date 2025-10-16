<?php
/**
 * This class controls all PDO requests. 
 * A connection should only be opened once and closed once.
 * Used by other classes that require database data.
 */
class PDOControl {

    // Constants
    private const ERRMODE = PDO::ERRMODE_EXCEPTION;
    
    // Status tracking
    private static bool $connected = false;
    private static bool $closed = false;

    // Fields
    private static string $connString;
    private static ?string $user;
    private static ?string $pass;
    private static ?PDO $pdo;

    // Functions

    /**
     * Initialize fields and connects to the database
     * 
     * @param string $connString Connection string to the database.
     * @param ?string $user Username if needed. Null otherwise.
     * @param ?string $pass Password if needed. Null otherwise.
     * @return void
     * @throws PDOException if the connection fails, the class is already connected, or the class has already been closed.
     */
    public static function connect(string $connString, ?string $user = null, ?string $pass = null): void {

        // If not connected and not closed,
        if (!self::$connected && !self::$closed) {

            // Save data
            self::$connString = $connString;
            self::$user = $user;
            self::$pass = $pass;
            
            // Try
            try {
                
                // Connect to the database
                $pdo = new PDO(self::$connString, self::$user, self::$pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, self::ERRMODE);
                self::$pdo = $pdo;

                // Update status
                self::$connected = true;

            }
            catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }

        }
        // Otherwise, if connected,
        else if (self::$connected) {

            die("Error: Already connected to database.");

        }
        // Otherwise, if closed,
        else if (self::$closed) {

            die("Error: Connection has been closed.");

        }

    }

    /**
     * 
     * Queries the database with an SQL string and parameters.
     * 
     * @param string $sql An SQL query string with named parameters.
     *  Format: "SELECT * FROM table WHERE column = :paramName AND column2 = :paramName2"
     * @param ?array $paramArray A 1D associative parameter array or null if no parameters. 
     *  Format: ['paramName' => 'paramValue', 'paramName2' => 'paramValue2']
     * @return PDOStatement Returns a PDOStatement.
     * @throws PDOException if the query failed, or if this class has not been connected to the database.
     */
    public static function query(string $sql, ?array $paramArray = null): ?PDOStatement {

        // Initialize.
        $statement = null;

        // If connected, and not closed,
        if (self::$connected && !self::$closed) {

            // Try
            try {

                // Prepare and execute.
                $statement = self::$pdo->prepare($sql);
                // foreach($paramArray as $key => $value) {
                //     echo "Key: " . $key;
                //     echo "<br>";
                //     echo "Value: " . $value;
                //     echo "<br>";
                // }
                $statement->execute($paramArray);

            }
            // If failed,
            catch (PDOException $e){

                // Die
                die("Query failed: " . $e->getMessage());

            }

        }
        // Otherwise, if not connected,
        else if (!self::$connected) {

            die("Error: Not connected to database.");

        }

        // Return
        return $statement;
    }

    /**
     * 
     * Closes the connection to the database. This Pdo instance is no longer usable.
     * 
     * @return void
     * @throws PDOException if close failed.
     */
    public static function close(): void {
        
        // Try
        try {
            
            // Close
            self::$pdo = null;

        }
        // If failed,
        catch (PDOException $e) {

            // Die
            die("Close failed: " . $e->getMessage());

        }
    }

    /**
     * Returns the current status of PDO.
     * 
     * @return string Returns one of: Inactive; Active; Closed.
     */
    public static function getStatus(): string {

        // Initialize
        $response = "";

        // Depending on status, set response
        if(self::$connected && self::$closed) {
            $response = "Closed";
        }
        else if(self::$connected && !self::$closed) {
            $response = "Active";
        }
        else if(!self::$connected && !self::$closed){
            $response = "Inactive";
        }
        else{
            $response = "Impossible";
        }

        // Return
        return $response;

    }

}