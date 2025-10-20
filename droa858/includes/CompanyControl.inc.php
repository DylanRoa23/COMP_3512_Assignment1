<?php
/**
 * Fetches and displays company data from the stocks.db database.
 */
class CompanyControl
{

    /**
     * Returns a PDOStatement containing the company's data. 
     * @param string $companySymbol The symbol of the company to get data from.
     * @return array A 1D associative array containing the company's data. 
     *  Array layout: [symbol, name, sector, subindustry, address, exchange, website, description, financials]
     */
    public static function getCompanyData(string $companySymbol): array
    {

        // Set the arguments.
        $sql =
            "SELECT symbol, name, sector, subindustry, address, exchange, website, description, financials
            FROM companies
            WHERE symbol = :symbol";
        $paramArray = ["symbol" => $companySymbol];

        // Query the data.
        $statement = PDOControl::query($sql, $paramArray);

        // Get the data.
        if (isset($statement)) {

            // Get the first and only row.
            $data = $statement->fetch(PDO::FETCH_ASSOC);

        }

        // Return
        return $data;

    }

    /**
     * Returns a PDOStatement pointing to all the history entries from a given company.
     * @param string $companySymbol The symbol of the company to fetch history from.
     * @return PDOStatement The PDOStatement pointing to all the history entries.
     *  Each row has [symbol, date, volume, open, close, high, low]
     */
    public static function getCompanyHistory(string $companySymbol): PDOStatement
    {

        // Set the arguments.
        $sql =
            'SELECT symbol, date, volume, open, close, high, low
            FROM history
            WHERE symbol = :symbol
            ORDER BY date DESC';
        $paramArray = ["symbol" => $companySymbol];

        // Query the data.
        $statement = PDOControl::query($sql, $paramArray);

        // Return
        return $statement;

    }

    /**
     * Returns a JSON string containing all company data. 
     * @return string A JSON string of all company data.
     */
    public static function getAllCompanies(): string
    {

        // Set the arguments.
        $sql =
            "SELECT symbol, name, sector, subindustry, address, exchange, website, description, latitude, longitude, financials
            FROM companies";

        // Query the data.
        $statement = PDOControl::query($sql);

        // Get all
        $data = json_encode($statement->fetchAll(), JSON_NUMERIC_CHECK);

        // Return
        return $data;

    }

}

?>