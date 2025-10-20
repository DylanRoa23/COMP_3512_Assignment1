<?php
/**
 * Fetches and displays Portfolio data from the stocks.db database.
 */
class PortfolioControl
{

    /**
     * Returns a JSON string containing portfolio data. 
     * @param int The userId of the portfolios to fetch.
     * @return string A JSON string of portfolio data.
     */
    public static function getPortfolioJSON(int $uid): string
    {

        // Set the arguments.
        $sql =
            "SELECT id, userId, guid, symbol, amount
            FROM portfolio 
            WHERE userId = :userId";
        $paramArray = ["userId" => $uid];

        // Query the data.
        $statement = PDOControl::query($sql, $paramArray);

        // Get all
        $data = json_encode($statement->fetchAll(), JSON_NUMERIC_CHECK);

        // Return
        return $data;

    }

}

?>