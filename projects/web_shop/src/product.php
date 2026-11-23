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
   <style>
    body { background: #060F1F !important; color: #fff; }
    .navbar-custom { background: #102B53; border-bottom: 2px solid #CEB5D4; }

    .card { background: #102B53; border: 1px solid #50698D; border-top: 4px solid #4E7AB1; color: #fff; }
    .card-title { color: #fff; }
    .card-text { color: #7D9FC0; }
    .price { color: #CEB5D4; }

    .form-control, .form-select { background-color: #060F1F; border: 1px solid #7D9FC0; color: #fff; }
    .form-control::placeholder { color: #7D9FC0; }
    .form-control:focus, .form-select:focus { background-color: #060F1F; color: #fff; border-color: #CEB5D4; box-shadow: none; }

    .btn-filter { background: #CEB5D4; border: 1px solid #CEB5D4; color: #102B53; font-weight: 600; }
    .btn-filter:hover { background: #fff; border-color: #fff; color: #102B53; }

    .btn-details { background: #4E7AB1; border: 1px solid #4E7AB1; color: #fff; }
    .btn-details:hover { background: #CEB5D4; border-color: #CEB5D4; color: #102B53; }

    .btn-soft { background: transparent; color: #7D9FC0; border: 1px solid #7D9FC0; }
    .btn-soft:hover { background: #CEB5D4; border-color: #CEB5D4; color: #102B53; }

    .badge-category { background: #7D9FC0; color: #060F1F; }
    .stock-in { background: #CEB5D4; color: #102B53; padding: 2px 10px; border-radius: 6px; align-self: flex-start; display: inline-block; }
</style>
</head>
<body>
<nav class="navbar navbar-dark navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">PC Parts Shop</a>
    </div>
</nav>

<div class="container">
    <a href="index.php" class="btn btn-soft mb-3">&larr; Back to catalog</a>

    <?php if (!$product): ?>
        <div class="alert alert-danger">404 - Product not found.</div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <span class="badge badge-category mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
                <h2 class="card-title"><?= htmlspecialchars($product['name']) ?></h2>
                <p class="card-text mt-3"><?= htmlspecialchars($product['description']) ?></p>
                <p class="fs-4 fw-bold price">&euro;<?= number_format($product['price'], 2) ?></p>
                <?php if ($product['stock'] > 0): ?>
                    <p class="stock-in">In stock: <?= $product['stock'] ?></p>
                <?php else: ?>
                    <p class="text-danger">Out of stock</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>