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

    public static function getUserPortfolios(int $uid): PDOStatement {

        // Initialize
        $statement = null;
        $sql = 
            "SELECT u.id, u.firstname, p.symbol, p.amount, c.name, c.sector
            FROM users u
            INNER JOIN portfolio p ON u.id = p.userId
            INNER JOIN companies c ON p.symbol = c.symbol
            WHERE u.id = :uid";
        $paramArray = ["uid" => $uid];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Return
        return $statement;
    }

    /**
     * Returns a PDOStatement containing the latest history data on a company.
     * @param int $symbol The symbol of the company to get history data from.
     * @return array A 1D associative array containing the latest history.
     */
    public static function getLatestHistory(string $symbol): array {

        // Initialize
        $statement = null;
        $sql = 
            "SELECT symbol, date, close
            FROM history
            WHERE symbol = :symbol
            ORDER BY date DESC
            LIMIT 1";
        $paramArray = ["symbol" => $symbol];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Convert to array.
        $dataArray = $statement->fetch(PDO::FETCH_ASSOC);

        // Return
        return $dataArray;

    }
}
?>
