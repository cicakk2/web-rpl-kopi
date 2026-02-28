<?php
/**
 * Database Configuration File
 * 
 * This file contains all database connection settings for the coffee business website.
 * Make sure to update these settings according to your server environment.
 */

// Database connection constants
define('DB_HOST', 'localhost');        // Database host (usually 'localhost')
define('DB_USER', 'root');             // Database username
define('DB_PASS', '');                 // Database password
define('DB_NAME', 'coffee_business');  // Database name

// Character set
define('DB_CHARSET', 'utf8mb4');

// Error reporting (set to false in production)
define('DB_DEBUG', true);

// Create database connection
$conn = mysqli_init();

// Set connection options
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 5);

// Attempt to connect to database
try {
    $connection = mysqli_real_connect(
        $conn,
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME
    );
    
    if (!$connection) {
        throw new Exception('Database connection failed: ' . mysqli_connect_error());
    }
    
    // Set character set
    mysqli_set_charset($conn, DB_CHARSET);
    
    if (DB_DEBUG) {
        // Enable error reporting in development
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
    
} catch (Exception $e) {
    if (DB_DEBUG) {
        die('Database Error: ' . $e->getMessage());
    } else {
        die('Unable to connect to database. Please try again later.');
    }
}

/**
 * Function to safely close database connection
 */
function closeDatabase() {
    global $conn;
    if ($conn) {
        mysqli_close($conn);
    }
}

/**
 * Function to execute safe queries with prepared statements
 * 
 * @param string $query SQL query with placeholders
 * @param array $params Parameters to bind
 * @param string $types Parameter types (e.g., 'ssi' for string, string, integer)
 * @return mixed Result set or boolean
 */
function executeQuery($query, $params = [], $types = '') {
    global $conn;
    
    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        if (DB_DEBUG) {
            die('Query preparation failed: ' . mysqli_error($conn));
        }
        return false;
    }
    
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    if (!mysqli_stmt_execute($stmt)) {
        if (DB_DEBUG) {
            die('Query execution failed: ' . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
        return false;
    }
    
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    return $result;
}

/**
 * Function to sanitize input data
 * 
 * @param string $data Input data to sanitize
 * @return string Sanitized data
 */
function sanitizeInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return mysqli_real_escape_string($conn, $data);
}

/**
 * Function to check if database connection is active
 * 
 * @return boolean Connection status
 */
function isDatabaseConnected() {
    global $conn;
    return mysqli_ping($conn);
}

// Register shutdown function to close connection
register_shutdown_function('closeDatabase');

?>