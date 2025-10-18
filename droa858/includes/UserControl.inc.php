<?php
/**
 * Fetches user names from the stocks.db database.
 */
class UserControl {

    /**
     * Returns a PDOStatement pointing to all user data from the database.
     * @return PDOStatement A PDOStatement pointing to user data with 'firstname' and 'lastname' keys.
     */
    public static function getAllUsers(): PDOStatement {
        
        // Initialize
        $sql = "SELECT id, firstname, lastname 
            FROM users";

        // Query
        $statement = PDOControl::query($sql);

        // Return
        return $statement;

    }

    /**
     * Returns a PDOStatement containing portfolio data for a user.
     * @param int $uid The user id of the user to get portfolio data from.
     * @return PDOStatement A PDOStatement pointing to the user's portfolios.
     */
    public static function getUserPortfolios(int $uid): PDOStatement {

        // Initialize
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
        $sql = "SELECT COUNT(DISTINCT symbol) AS company_count 
                FROM portfolio 
                WHERE userId = :uid";
        $paramArray = ["uid" => $uid];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Convert to array
        $result = $statement->fetch();

        //Return
        return $result['company_count'];

    }

    /**
     * Returns the total number of shares owned by a user and then sums the 'amount' column for all entries in the user's portfolio.
     * @param int $uid The user ID whose total shares will be calculated.
     * @return int The total number of shares owned by the user.
     */
    public static function countUserShares(int $uid): int {

        // Initialize
        $sql = "SELECT SUM(amount) AS total_shares 
                FROM portfolio 
                WHERE userId = :uid";
        $paramArray = ["uid" => $uid];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Convert to array
        $result = $statement->fetch();

        // Return
        return $result['total_shares'];
    }

    /**
     * Calculates the total value of a user's portfolio.
     * The value is determined by summing (latest closing price * amount of stock owned) for each company the user owns.
     * @param int $uid The user ID whose portfolio value will be calculated.
     * @return float The total portfolio value.
     */
    public static function getUserPortfolioValue(int $uid): float {

        // Initialize
        $totalValue = 0.0;
        $sql = "SELECT symbol, amount  
        FROM portfolio 
        WHERE userId = :uid";
        $paramArray = ["uid" => $uid];

        //query
        $statement = PDOControl::query($sql, $paramArray);

        // Loop through each owned company
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $symbol = $row['symbol'];
            $amount = (int)$row['amount'];

            // Fetch latest close price from history
            $history = self::getLatestHistory($symbol);

            if ($history && isset($history['close'])) {
                $price = (float)$history['close'];
                $totalValue += $price * $amount;
            }
        }

        //Return
        return $totalValue;
    }

    /**
     * Returns all company symbols in the user's portfolio.
     * @param int $uid The user ID whose company symbols will be retrieved.
     * @return string HTML string of clickable company symbols.
     */
    public static function getUserSymbol(int $uid): string {

        // Initialize
        $html = "";
        $sql = "SELECT DISTINCT symbol 
                FROM portfolio 
                WHERE userId = :uid
                ORDER BY symbol ASC";
        $paramArray = ["uid" => $uid];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Echoes a link for each symbol
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $symbol = htmlspecialchars($row['symbol']);
            $html .= "<div class='details'>
                        <a href='company.php?symbol=$symbol'>$symbol</a>
                    </div>";
        }

        // Return
        if ($html) {
            return $html;
        } else {
            return "<p>No companies found.</p>";
        }
    }

    /**
     * Returns HTML links for all companies symbol in the user's portfolio.
     * Each company symbol is clickable and links to its company page.
     * @param int $uid The user ID whose companies will be listed.
     * @return string HTML string containing <a> tags for each company.
     */
    public static function getUserCompanyName(int $uid): string {

        // Initialize
        $html = "";
        $sql = "SELECT c.symbol, c.name 
                FROM portfolio p
                INNER JOIN companies c ON p.symbol = c.symbol
                WHERE p.userId = :uid
                GROUP BY p.symbol, c.name
                ORDER BY p.symbol ASC";
        $paramArray = ["uid" => $uid];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Echoes the HTML links
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $symbol = $row['symbol'];
            $name = $row['name'];
            $html .= "<div class='details'>
                        <a href='company.php?symbol=$symbol'>$name</a>
                    </div>";
        }

        // Return
        if ($html) {
            return $html;
        } else {
            return "<p>No companies found.</p>";
        }
    }


    /**
     * Returns the sectors for all companies in a user's portfolio.
     * Each sector corresponds to the sector of a company the user owns.
     * @param int $uid The user ID whose company sectors will be retrieved.
     * @return string HTML string of company sectors.
     */
    public static function getSector(int $uid): string {

        // Initialize
        $html = "";
        $sql = "SELECT c.sector 
                FROM portfolio p
                INNER JOIN companies c ON p.symbol = c.symbol
                WHERE p.userId = :uid
                ORDER BY c.symbol ASC";
        $paramArray = ["uid" => $uid];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Echoes the HTML output
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sector = $row['sector'];
            $html .= "<div class='details'>
                        <p>$sector</p>
                    </div>";
        }

        // Return
        if ($html) {
            return $html;
        } else {
            return "<p>No sectors found.</p>";
        }
    }

    /**
     * Returns the sum of shares the user owns for each company individually.
     * For each unique symbol in the user's portfolio, this method/function calculates the total number of shares owned.
     * @param int $uid The user ID whose shares will be calculated.
     * @return string HTML string displaying the total shares for each company symbol.
     */
    public static function getSymbolAmount(int $uid): string {

        // Initialize
        $html = "";
        $sql = "SELECT symbol, SUM(amount) AS total_shares
                FROM portfolio 
                WHERE userId = :uid
                GROUP BY symbol
                ORDER BY symbol ASC";
        $paramArray = ["uid" => $uid];

        // Query
        $statement = PDOControl::query($sql, $paramArray);

        // Build HTML
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $symbol = $row['symbol'];
            $shares = (int)$row['total_shares'];
            $html .= "<div class='details'>
                        <p>$shares</p>
                    </div>";
        }

        // Return
        if ($html) {
            return $html;
        } else {
            return "<p>No shares found.</p>";
        }
    }
    
}
?>
