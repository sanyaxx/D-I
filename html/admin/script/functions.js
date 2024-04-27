// Log-out user
function logout() {
    // Make an AJAX request to logout.php
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/logout.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Redirect to the login page
            window.location.href = "../html/login.html";
        } else {
            console.error('Error logging out:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error('Network error occurred');
    };
    xhr.send();
}

function checkAuthentication() {
    fetch('../php/checkAuthentication.php')
        .then(response => response.text())
        .then(result => {
            if (result === 'not_authenticated') {
                // User is not authenticated, redirect to login page
                logout();
            }
        })
        .catch(error => console.error('Error checking authentication:', error));
}


// Call function when page loads
window.onload = checkAuthentication;
