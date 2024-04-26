// code to update visibility of quantity elements based on initial value
const quantityInputs = document.querySelectorAll('.quantity input[type="text"]');
quantityInputs.forEach(input => {
    const quantityValue = parseInt(input.value);
    const quantityDiv = input.parentNode;
    const minusButton = quantityDiv.querySelector('.minus');
    const plusButton = quantityDiv.querySelector('.plus');

    if (quantityValue > 0) {
        minusButton.style.display = 'inline-block';
        input.style.display = 'inline-block';
        plusButton.style.display = 'inline-block';
    } else {
        minusButton.style.display = 'none';
        input.style.display = 'none';
        plusButton.style.display = 'inline-block'; // Plus button always visible
    }
});

function increment(button, itemID, maxQuantity) {
    const quantityDiv = button.parentNode;
    const minusButton = quantityDiv.querySelector('.minus');
    const plusButton = quantityDiv.querySelector('.plus');
    const input = quantityDiv.querySelector('input[type="text"]');
    const cartIcon = document.querySelector("#shopping-cart");
    const errorMessage = quantityDiv.querySelector('.error-message');

    const currentValue = parseInt(input.value);

    if (currentValue < maxQuantity) {
        minusButton.style.display = 'inline-block';
        input.style.display = 'inline-block';

        // Check if max quantity is reached after incrementing
        if (currentValue >= maxQuantity) {
            plusButton.style.display = 'none'; // Hide increment button
            errorMessage.style.display = 'block'; // Display error message
        } else {
            // Hide error message if displayed
            errorMessage.style.display = 'none';  

            // Increase the current value
            input.value = currentValue + 1;

            // Trigger animation
            cartIcon.classList.add('pulse');
            setTimeout(() => {
                cartIcon.classList.remove('pulse');
            }, 1000);

            // Increase cart counter
            document.querySelector("#cart-counter").value = updateCartCounter;

            // Send itemID and quantity to cart.php via AJAX
            updateCartOnServer(itemID, input.value);
            }
    }
}



function decrement(button, itemID) {
    const quantityDiv = button.parentNode;
    const input = quantityDiv.querySelector('input[type="text"]');
    const minusButton = quantityDiv.querySelector('.minus');
    const cartIcon = document.querySelector("#shopping-cart");

    if (parseInt(input.value) > 0) {
        input.value = (parseInt(input.value) - 1);

        // Trigger animation
        cartIcon.classList.add('pulse');
        setTimeout(() => {
            cartIcon.classList.remove('pulse');
        }, 1000);
    }

    if (parseInt(input.value) == 0) {
        minusButton.style.display = 'none';
        input.style.display = 'none';
    }

    // Decrease cart counter
    document.querySelector("#cart-counter").value = updateCartCounter;

    // Send itemID and quantity to cart.php via AJAX
    updateCartOnServer(itemID, input.value);
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