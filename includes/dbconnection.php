<?php

try {
    $conn = new PDO("sqlsrv:server=.; Database=univdb", "sa", "saor1234");
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>