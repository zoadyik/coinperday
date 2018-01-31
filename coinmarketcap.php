<?php

header('Content-type: application/json');
echo file_get_contents("https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=thb");

?>