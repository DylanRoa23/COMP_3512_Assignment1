<?php

require_once "PDOControl.inc.php";
require_once "Names.inc.php";

// Initialize
const CONNSTRING = "sqlite:data/stocks.db";

// Connect to the database
PDOControl::connect(CONNSTRING);

?>