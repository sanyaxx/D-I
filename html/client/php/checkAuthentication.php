<?php
session_start();
if (isset($_SESSION['userID'])) {
    echo 'authenticated';
} else {
    echo 'not_authenticated';
}
?>