<?php

function getAllProducts($field, $from, $where, $orderBy) {
    global $conn;
    $getProds = $conn->prepare("SELECT $field FROM $from WHERE $where ORDER BY $orderBy;");
    $prodsResponse = $getProds->execute();
    $allRes = $prodsResponse->fetchAll();

    return $allRes;
}

function getLimitedProducts($from, $where, $orderBy, $limit = 15) {
    global $conn;
    $getLimitedProductsQuery = $conn->prepare("SELECT * FROM $from WHERE $where ORDER BY $orderBy DESC LIMIT $limit;");
    $getLimitedProductsQuery->execute();
    $getLastProducts = $getLimitedProductsQuery->fetchAll();

    return $getLastProducts;
}

function getProductById($field, $from, $where, $id) {
    global $conn;
    $getProdQuery = $conn->prepare("SELECT $field FROM $from WHERE $where PRODUCT_ID=$id;");
    $prodRes = $getProdQuery->execute();
    $product = $prodRes->fetchAll();

    return $product;
}


?>

