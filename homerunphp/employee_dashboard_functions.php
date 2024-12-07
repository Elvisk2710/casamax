<?php
// Include the database connection

// Function to get the current month and year
function getCurrentMonthAndYear() {
    return [
        'currentMonth' => date('m'),
        'currentYear' => date('Y')
    ];
}

// Function to get the commission for the current month
function getCommission() {
    global $conn;
    
    // Get current month and year
    $currentMonthAndYear = getCurrentMonthAndYear();
    $currentMonth = $currentMonthAndYear['currentMonth'];
    $currentYear = $currentMonthAndYear['currentYear'];

    // SQL to get the total commission for the current month
    $sql = "SELECT SUM(amount) as total_commission FROM employee_commissions WHERE MONTH(date) = ? AND YEAR(date) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $currentMonth, $currentYear);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    return $data['total_commission'] ?? 0;  // Return commission amount, default to 0 if no data
}

// Function to get the number of houses added this month
function getHousesAddedThisMonth() {
    global $conn;
    
    // Get current month and year
    $currentMonthAndYear = getCurrentMonthAndYear();
    $currentMonth = $currentMonthAndYear['currentMonth'];
    $currentYear = $currentMonthAndYear['currentYear'];

    // SQL to get the number of houses added this month
    $sql = "SELECT COUNT(id) as houses_added FROM homerunhouses WHERE MONTH(date_added) = ? AND YEAR(date_added) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $currentMonth, $currentYear);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    return $data['houses_added'] ?? 0;  // Return number of houses added, default to 0 if no data
}

// Function to get the number of verified houses this month
function getVerifiedHousesThisMonth() {
    global $conn;
    
    // Get current month and year
    $currentMonthAndYear = getCurrentMonthAndYear();
    $currentMonth = $currentMonthAndYear['currentMonth'];
    $currentYear = $currentMonthAndYear['currentYear'];

    // SQL to get the number of verified houses this month
    $sql = "SELECT COUNT(id) as verified_houses FROM homerunhouses WHERE MONTH(date_added) = ? AND YEAR(date_added) = ? AND is_verified = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $currentMonth, $currentYear);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    return $data['verified_houses'] ?? 0;  // Return number of verified houses, default to 0 if no data
}

// Function to get the total number of houses added
function getTotalHousesAdded() {
    global $conn;
    
    // SQL to get the total number of houses added
    $sql = "SELECT COUNT(id) as total_houses_added FROM homerunhouses";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    return $data['total_houses_added'] ?? 0;  // Return total number of houses added, default to 0 if no data
}
?>
