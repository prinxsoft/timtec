<?php
// fetch_row.php

// Assuming you have a database connection established

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the row data from the database based on the provided id
    $stmt = $conn->prepare("SELECT * FROM timtec WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Return the row data as a JSON response
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        echo "No row found with the provided ID.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
