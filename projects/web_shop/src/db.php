<?php
session_start();
$pdo = new PDO(
    'mysql:host=db;dbname=shop;charset=utf8mb4',
    'shop_user',
    'StrongPassword123!',
    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);