<?php
/**
 * Fetches and displays user names from the stocks.db database.
 */
class UserNames {

    /**
     * Returns all user names from the database.
     * @return array An array of associative arrays containing user data.
     */
    public static function getAllUsers(): array {
        $data = [];

        $sql = "SELECT lastname, firstname 
        FROM users";
        $statement = PDOControl::query($sql);

        if ($statement) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
}
?>