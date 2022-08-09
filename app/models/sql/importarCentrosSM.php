<?php

$path = 'app/models/sql/Centros.csv';
$centros = array_map('str_getcsv', file($path));
$headers = array_shift($centros);
array_walk($centros, function(&$a) use ($headers) {
  $a = array_combine($headers, $a);
});


require_once 'app/models/CentrosDAO.class.php';
(new CentrosDAO())->bulkInsert($centros);


