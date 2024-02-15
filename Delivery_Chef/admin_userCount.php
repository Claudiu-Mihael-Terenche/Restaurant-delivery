<?php 
  require_once "dbConnect.php";

$sql = "SELECT COUNT(*) AS users FROM users";
$result = $db->query($sql);

if ($result === false) {
    echo "Error: " . $db->error;
} else {
    // Step 3: Fetch the result and display it
    $row = $result->fetch();
    $userCount = $row['users'];
}

?>