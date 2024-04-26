// Include functions.js
document.write('<script src="functions.js"></script>');

// code to update visibility of quantity elements based on initial value
const quantityInputs = document.querySelectorAll('.quantity-bar input[type="text"]');
quantityInputs.forEach(input => {
    const quantityValue = parseInt(input.value);
    const quantityDiv = input.parentNode;
    const minusButton = quantityDiv.querySelector('.minus');
    const plusButton = quantityDiv.querySelector('.plus');

    if (quantityValue > 0) {
        minusButton.style.display = 'inline-block';
        input.style.display = 'inline-block';
        plusButton.style.display = 'inline-block';
    } else if (quantityValue == 0) {
        minusButton.style.display = 'none';
        input.style.display = 'none';
        plusButton.style.display = 'none';
    }
});


function increment(button, itemID, stock) {
    // Get the input field containing the quantity
    var inputField = button.parentElement.querySelector('input[type="text"]');
    
    // Parse the current quantity value as an integer
    var currentQuantity = parseInt(inputField.value);
    
    // If the current quantity is less than the stock, increment the quantity
    if (currentQuantity < stock) {
        // Increment the quantity by one
        inputField.value = currentQuantity + 1;
        
        // Increase cart counter
        document.querySelector("#cart-counter").value = updateCartCounter;
        
        // Call the function to update the cart on the server
        updateCartOnServer(itemID, inputField.value);
        
        // Reload the page to reflect the updated quantity in the cart
        location.reload();
    } else {
        // If the current quantity is already at the maximum stock level, alert the user
        alert('Maximum quantity reached!');
    }
}

function decrement(button, itemID) {
    // Get the input field containing the quantity
    var inputField = button.parentElement.querySelector('input[type="text"]');
    
    // Parse the current quantity value as an integer
    var currentQuantity = parseInt(inputField.value);
    
    // If the current quantity is less than the stock, increment the quantity
    if (currentQuantity > 0) {
        // Increment the quantity by one
        inputField.value = currentQuantity - 1;
        // Increase cart counter
        document.querySelector("#cart-counter").value = updateCartCounter;
    } 
    // Call the function to update the cart on the server
    updateCartOnServer(itemID, inputField.value);
        
    // Reload the page to reflect the updated quantity in the cart
    location.reload();
}


function updateCartOnServer(itemID, quantity) {
    // Construct the request body
    const formData = new FormData();
    formData.append('itemID', itemID);
    formData.append('quantity', quantity);

    // Send AJAX request to manageCart.php
    fetch('../php/manageCart.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                console.error('Failed to update cart on the server');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
