<?php

header('Content-type: application/json');
echo file_get_contents("http://www.phi-phi-pool.net/api/currencies");

?>