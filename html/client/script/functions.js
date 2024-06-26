// Back button
function goBack() {
    window.location.href = "../html/Home.html";
}

// Go-to cart page
function goCart() {
    window.location.href = "../php/displayCart.php";
}

// Go to settings page
function goSettings() {
    window.location.href = "../php/profile.php";
}

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

function updateCartCounter() {
    // Make AJAX request to updateCounter.php
    fetch('../php/updateCounter.php')
      .then(response => response.text())
      .then(totalQuantity => {
        // Update cart counter
        document.getElementById('cart-counter').textContent = totalQuantity;
      })
      .catch(error => console.error('Error updating cart counter:', error));
}


function checkAuthentication() {
    fetch('../php/checkAuthentication.php')
        .then(response => response.text())
        .then(result => {
            if (result === 'authenticated') {
                // User is authenticated, continue loading the page
                updateCartCounter(); // Update cart counter if user is authenticated
            } else {
                // User is not authenticated, redirect to login page
                logout();
            }
        })
        .catch(error => console.error('Error checking authentication:', error));
}


// Call function when page loads
window.onload = checkAuthentication;
