<?php

require_once __DIR__ . '/db.php';

$search = trim($_GET['search'] ?? '');
$categoryId = isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : null;

$categorySql = "
    SELECT c.id, c.name, COUNT(p.id) AS product_count
    FROM categories c
    LEFT JOIN products p ON p.category_id = c.id
    GROUP BY c.id, c.name
    ORDER BY c.name
";
$categories = $pdo->query($categorySql)->fetchAll();

$productSql = "
    SELECT p.id, p.name, p.price, p.stock, c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    WHERE 1 = 1
";
$params = [];

if ($search !== '') {
    $productSql .= " AND p.name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

if ($categoryId !== null) {
    $productSql .= " AND p.category_id = :category_id";
    $params[':category_id'] = $categoryId;
}

$productSql .= " ORDER BY p.id ASC";

$stmt = $pdo->prepare($productSql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Parts Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">PC Parts Shop</a>
    </div>
</nav>

<div class="container">
    <form method="GET" action="index.php" class="row g-2 mb-4">
        <div class="col-md-5">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search products..."
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
            >
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= (int)$cat['id'] ?>" <?= $categoryId === (int)$cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?> (<?= (int)$cat['product_count'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            <a href="index.php" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <?php if (empty($products)): ?>
        <div class="alert alert-info">No products found.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-secondary align-self-start mb-2">
                                <?= htmlspecialchars($product['category_name'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <h5 class="card-title">
                                <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                            </h5>
                            <p class="fs-5 fw-bold mt-auto mb-2">
                                &euro;<?= number_format((float)$product['price'], 2) ?>
                            </p>
                            <p class="mb-3 <?= (int)$product['stock'] > 0 ? 'text-success' : 'text-danger' ?>">
                                <?= (int)$product['stock'] > 0 ? 'In stock: ' . (int)$product['stock'] : 'Out of stock' ?>
                            </p>
                            <a href="product.php?id=<?= (int)$product['id'] ?>" class="btn btn-outline-primary">
                                View details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
