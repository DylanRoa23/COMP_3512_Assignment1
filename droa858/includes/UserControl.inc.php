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

    /**
     * Returns a PDOStatement containing portfolio data for a user.
     * @param int $uid The user id of the user to get portfolio data from.
     * @return PDOStatement A PDOStatement pointing to the user's portfolios.
     */
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

    
    /**
     * Returns a PDOStatement containing the the count/sum of how many companies are in the user's portfolio
     * @param int $uid The user ID whose portfolio will be analyzed.
     * @return int The number of unique companies in the user's portfolio.
     */    
    public static function countUserCompanies(int $uid): int {
    
        //Initialize
        $statement = null;
        $sql = "SELECT COUNT(DISTINCT symbol) AS company_count 
                FROM portfolio 
                WHERE userId = :uid";
        $paramArray = ["uid" => $uid];

        //query
        $statement = PDOControl::query($sql, $paramArray);

        //convert to array
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        //Return
        return $result ? (int)$result['company_count'] : 0;
    }
}
?>
