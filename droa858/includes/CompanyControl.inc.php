<?php
/**
 * Fetches and displays company data from the stocks.db database.
 */
class CompanyControl {

    private $db;
    private $connString;
    private $user;
    private $pass;

    public static function getCompanyData($companySymbol): PDOStatement {

        // Set the arguments.
        $sql = 
            "SELECT symbol, name, sector, subindustry, address, exchange, website, description, financials
            FROM companies
            WHERE symbol = :symbol";
        $paramArray = ["symbol" => $companySymbol];

        // Query the data.
        $statement = PDOControl::query($sql, $paramArray);

        // Return
        return $statement;

    }

    public static function getCompanyHistory($companySymbol): PDOStatement {

        // Set the arguments.
        $sql = 
            "SELECT symbol, date, volume, open, close, high, low
            FROM history
            WHERE symbol = :symbol";
        $paramArray = ["symbol" => $companySymbol];

    }

}