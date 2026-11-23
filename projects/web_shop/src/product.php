<?php

require_once 'db.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT p.id, p.name, p.description, p.price, p.stock, c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    WHERE p.id = :id
");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? htmlspecialchars($product['name']) : 'Product Not Found' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">PC Parts Shop</a>
    </div>
</nav>

<div class="container">
    <a href="index.php" class="btn btn-outline-secondary mb-3">&larr; Back to catalog</a>

    <?php if (!$product): ?>
        <div class="alert alert-danger">404 - Product not found.</div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <span class="badge bg-secondary mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
                <h2 class="card-title"><?= htmlspecialchars($product['name']) ?></h2>
                <p class="card-text mt-3"><?= htmlspecialchars($product['description']) ?></p>
                <p class="fs-4 fw-bold">&euro;<?= number_format($product['price'], 2) ?></p>
                <p class="<?= $product['stock'] > 0 ? 'text-success' : 'text-danger' ?>">
                    <?= $product['stock'] > 0 ? 'In stock: ' . $product['stock'] : 'Out of stock' ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>