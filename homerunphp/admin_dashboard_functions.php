<?php
// Initialize variables
$currentMonth = date('m');
$currentYear = date('Y');
$currentMonthFull = date('F');

// Function to get the total earnings for admins (from employee_commissions)
function getAdminEarnings($conn)
{
    // Query to fetch total earnings from employee_commissions (summed 'amount' for each admin)
    $sqlAdmin = "SELECT SUM(amount) AS total_earned 
                 FROM employee_commissions";
    $resultAdmin = $conn->query($sqlAdmin);

    if ($resultAdmin->num_rows > 0) {
        $row = $resultAdmin->fetch_assoc();
        // Return total earnings (formatted to 2 decimal places)
        echo $row['total_earned'];
        $formated_amount = number_format($row['total_earned'], 2);
        return $formated_amount;
    }

    return 0;  // Return 0 if no data found
}   
// Function to get the number of new employees added this month
function getNewEmployees($conn, $currentMonth, $currentYear)
{
    // Update the query to use the `joined_at` field instead of `dob`
    $sqlNewEmployees = "SELECT COUNT(*) AS new_employees 
                        FROM admin_table 
                        WHERE MONTH(joined_at) = $currentMonth AND YEAR(joined_at) = $currentYear";
    $resultNewEmployees = $conn->query($sqlNewEmployees);
    return $resultNewEmployees->fetch_assoc()['new_employees'] ?? 0;
}

// Function to get total and new agents (employees in the agents table)
function getAgentData($conn, $currentMonth, $currentYear)
{
    $sqlAgents = "SELECT COUNT(*) AS total_agents, 
                         SUM(CASE WHEN MONTH(date_joined) = $currentMonth AND YEAR(date_joined) = $currentYear THEN 1 ELSE 0 END) AS new_agents 
                  FROM agents";
    $resultAgents = $conn->query($sqlAgents);
    return $resultAgents->fetch_assoc();
}

// Function to fetch house data
function getHouseData($conn, $currentMonth, $currentYear)
{
    $sqlHouses = "SELECT COUNT(*) AS total_houses, 
                         SUM(CASE WHEN verified = 1 THEN 1 ELSE 0 END) AS verified_houses, 
                         SUM(CASE WHEN available = 1 THEN 1 ELSE 0 END) AS available_houses, 
                         SUM(CASE WHEN MONTH(date_joined) = $currentMonth AND YEAR(date_joined) = $currentYear THEN 1 ELSE 0 END) AS new_houses 
                  FROM homerunhouses";
    $resultHouses = $conn->query($sqlHouses);
    return $resultHouses->fetch_assoc();
}

// Function to fetch total landlord and agent houses
function getLandlordAgentHouses($conn)
{
    $sqlLandlordAgentHouses = "SELECT 
        SUM(CASE WHEN agent_id IS NOT NULL THEN 1 ELSE 0 END) AS agent_houses,
        SUM(CASE WHEN admin_id IS NOT NULL THEN 1 ELSE 0 END) AS landlord_houses 
        FROM homerunhouses";
    $resultLandlordAgentHouses = $conn->query($sqlLandlordAgentHouses);
    return $resultLandlordAgentHouses->fetch_assoc();
}

// Function to fetch new landlords this month
function getNewLandlords($conn, $currentMonth, $currentYear)
{
    $sqlNewLandlords = "SELECT COUNT(DISTINCT home_id) AS new_landlords 
                        FROM homerunhouses 
                        WHERE MONTH(date_joined) = $currentMonth AND YEAR(date_joined) = $currentYear";
    $resultNewLandlords = $conn->query($sqlNewLandlords);
    return $resultNewLandlords->fetch_assoc()['new_landlords'] ?? 0;
}

// Function to get the total commission for an employee (employee's commission earnings)
function getEmployeeCommission($conn, $employeeId)
{
    $sqlCommission = "SELECT SUM(commission_amount) AS total_commission
                      FROM employee_commissions
                      WHERE employee_id = $employeeId";
    $resultCommission = $conn->query($sqlCommission);
    return $resultCommission->fetch_assoc()['total_commission'] ?? 0;
}

// Function to get total commission for all employees in a specific month (based on the transactions)
function getMonthlyCommissionReport($conn, $currentMonth, $currentYear)
{
    $sqlCommissionReport = "SELECT employee_id, 
                            SUM(commission_amount) AS monthly_commission
                            FROM employee_commissions
                            JOIN transactions ON employee_commissions.transaction_id = transactions.transaction_id
                            WHERE MONTH(transactions.transaction_date) = $currentMonth
                            AND YEAR(transactions.transaction_date) = $currentYear
                            GROUP BY employee_id";
    $resultReport = $conn->query($sqlCommissionReport);
    $commissionReport = [];
    while ($row = $resultReport->fetch_assoc()) {
        $commissionReport[$row['employee_id']] = number_format($row['monthly_commission'], 2);
    }
    return $commissionReport;
}

// Fetch data
$adminEarnings = getAdminEarnings($conn);
$newEmployees = getNewEmployees($conn, $currentMonth, $currentYear);
$agentData = getAgentData($conn, $currentMonth, $currentYear);
$houseData = getHouseData($conn, $currentMonth, $currentYear);
$landlordAgentData = getLandlordAgentHouses($conn);
$newLandlords = getNewLandlords($conn, $currentMonth, $currentYear);

// Close connection
$conn->close();

// Example usage
