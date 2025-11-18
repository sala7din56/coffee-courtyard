<?php
header('Content-Type: application/json');

require_once '../../includes/config.php';
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

$db = new Database();
$query = "SELECT id, name, description, price, image_path FROM menu_items ORDER BY category, name";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($menu);
?>
