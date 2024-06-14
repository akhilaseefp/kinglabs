<?php
session_start();

function generate_csrf_token() 
{
    if (empty($_SESSION['csrf_token'])) 
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

function validate_csrf_token($token) 
{
    return hash_equals($_SESSION['csrf_token'], $token);
}
?>
