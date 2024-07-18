<?php
function formatTimestamp($timestamp)
{
    // Get the current time
    $currentTime = time();

    // Calculate the start of today and yesterday
    $startOfToday = strtotime("today", $currentTime);
    $startOfYesterday = strtotime("yesterday", $currentTime);

    // Convert the input timestamp to a Unix timestamp
    $inputTime = strtotime($timestamp);

    // Format the output based on the timestamp
    if ($inputTime >= $startOfToday) {
        // If the timestamp is from today, return the time only
        return date("H:i", $inputTime);
    } elseif ($inputTime >= $startOfYesterday) {
        // If the timestamp is from yesterday, return "Yesterday"
        return "Yesterday";
    } else {
        // If the timestamp is older, return the date
        return date("Y-m-d", $inputTime);
    }
}
// Function to sanitize a string
function sanitize_string($message)
{
    // Strip HTML and PHP tags
    $message = strip_tags($message);
    // Convert special characters to HTML entities
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    // Remove any remaining harmful text
    $message = filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    return $message;
}

// function to sanitize an int
function sanitize_integer($input)
{
    // Remove any non-digit characters
    $sanitized = filter_var($input, FILTER_SANITIZE_NUMBER_INT);

    // Validate the sanitized input
    $validated = filter_var($sanitized, FILTER_VALIDATE_INT);

    // Return the validated integer, or false if validation fails
    if ($validated) {
        return $sanitized;
    } else {
        return $validated;
    }
}
function sanitize_email($email)
{
    // Remove illegal characters from the email
    $sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate the sanitized email
    $validated = filter_var($sanitized, FILTER_VALIDATE_EMAIL);

    // Return the validated email, or false if validation fails
    if ($validated) {
        return $sanitized;
    } else {
        return $validated;
    }
}
