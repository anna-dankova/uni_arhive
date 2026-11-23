<?php

require_once 'db.php';

$search = $_GET['search'] ?? '';
$categoryId = $_GET['category'] ?? '';

$categories = $pdo->query("
    SELECT c.id, c.name, COUNT(p.id) AS product_count
    FROM categories c
    LEFT JOIN products p ON p.category_id = c.id
    GROUP BY c.id, c.name
    ORDER BY c.name
")->fetchAll();

$sql = "
    SELECT p.id, p.name, p.price, p.stock, c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    WHERE 1 = 1
";
$params = [];

if ($search !== '') {
    $sql .= " AND p.name LIKE :search";
    $params[':search'] = "%$search%";
}

if ($categoryId !== '') {
    $sql .= " AND p.category_id = :category_id";
    $params[':category_id'] = $categoryId;
}

$stmt = $pdo->prepare($sql);
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-dark navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">PC Parts Shop</a>
    </div>
</nav>

<div class="container">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $categoryId == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?> (<?= $cat['product_count'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-filter w-100">Filter</button>
            <a href="index.php" class="btn btn-soft">Reset</a>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <span class="badge badge-category align-self-start mb-2"><?= htmlspecialchars($product['category_name']) ?></span>
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="fs-5 fw-bold price mt-auto mb-2">&euro;<?= number_format($product['price'], 2) ?></p>
                        <p class="mb-3 <?= $product['stock'] > 0 ? 'stock-in' : 'text-danger' ?>">
                            <?= $product['stock'] > 0 ? 'In stock: ' . $product['stock'] : 'Out of stock' ?>
                        </p>
                        <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-details">View details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>