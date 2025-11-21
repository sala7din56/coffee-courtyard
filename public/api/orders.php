<?php
header('Content-Type: application/json');

require_once '../../includes/config.php';
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (empty($data['customerName']) || empty($data['phone']) || empty($data['items'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input. Name, phone, and items are required.']);
    exit;
}

try {
    $db->beginTransaction();

    // Fetch prices from DB to calculate total server-side
    $itemIds = array_map(fn($item) => $item['menuId'], $data['items']);
    $placeholders = implode(',', array_fill(0, count($itemIds), '?'));
    $query = "SELECT id, price FROM menu_items WHERE id IN ($placeholders)";
    $stmt = $db->prepare($query);
    $stmt->bind_param(str_repeat('i', count($itemIds)), ...$itemIds);
    $stmt->execute();
    $result = $stmt->get_result();
    $menuPrices = [];
    while ($row = $result->fetch_assoc()) {
        $menuPrices[$row['id']] = $row['price'];
    }

    $total = 0;
    foreach ($data['items'] as $item) {
        if (!isset($menuPrices[$item['menuId']])) {
            throw new Exception('Invalid menu item in order.');
        }
        $total += $menuPrices[$item['menuId']] * $item['qty'];
    }

    // Insert into orders table
    $query = "INSERT INTO orders (customer_name, phone, total) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssd", $data['customerName'], $data['phone'], $total);
    $stmt->execute();
    $orderId = $db->lastInsertId();

    // Insert into order_items table
    $query = "INSERT INTO order_items (order_id, menu_id, qty, unit_price) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    foreach ($data['items'] as $item) {
        $unitPrice = $menuPrices[$item['menuId']];
        $stmt->bind_param("iiid", $orderId, $item['menuId'], $item['qty'], $unitPrice);
        $stmt->execute();
    }

    $db->commit();

    echo json_encode(['ok' => true, 'orderId' => $orderId]);

} catch (Exception $e) {
    $db->rollback();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to place order.', 'details' => $e->getMessage()]);
}
?>
