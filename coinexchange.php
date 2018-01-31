<?php

header('Content-type: application/json');
echo file_get_contents("https://www.coinexchange.io/api/v1/getmarketsummaries");

?>