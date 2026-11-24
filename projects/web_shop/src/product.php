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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-dark navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">PC Parts Shop</a>
        <div class="d-flex align-items-center gap-2">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="me-2"><?= htmlspecialchars($_SESSION['user_name']) ?> (<?= htmlspecialchars($_SESSION['user_role']) ?>)</span>
                <a href="logout.php" class="btn btn-soft btn-sm">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-soft btn-sm">Login</a>
                <a href="register.php" class="btn btn-filter btn-sm">Register</a>
            <?php endif; ?>
        </div>
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
                <p class="<?= $product['stock'] > 0 ? 'stock-in' : 'text-danger' ?>">
                    <?= $product['stock'] > 0 ? 'In stock: ' . $product['stock'] : 'Out of stock' ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>