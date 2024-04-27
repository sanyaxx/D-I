<?php
session_start();
if ($_SESSION['loggedIn'] == true) {
    echo 'authenticated';
} else {
    echo 'not_authenticated';
}
?>