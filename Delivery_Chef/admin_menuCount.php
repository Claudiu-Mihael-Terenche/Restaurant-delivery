<?php 
  require_once "dbConnect.php";

$sql = "SELECT COUNT(*) AS menu FROM menu";
$result = $db->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    // Step 3: Fetch the result and display it
    $row = $result->fetch();
    $menuCount = $row['menu'];
}

?>