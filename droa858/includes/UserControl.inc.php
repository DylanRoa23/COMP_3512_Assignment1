<?php
/**
 * Fetches user names from the stocks.db database.
 */
class UserControl {

    /**
     * Returns all user names from the database.
     * @return array An array of associative arrays with 'firstname' and 'lastname' keys.
     */
    public static function getAllUsers(): array {
        $data = [];

        $sql = "SELECT id, firstname, lastname 
        FROM users";
        $statement = PDOControl::query($sql);

        if ($statement) {
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
}
?>
