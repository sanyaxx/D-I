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

function increment(button, itemID) {
    const quantityDiv = button.parentNode;
    const minusButton = quantityDiv.querySelector('.minus');
    const input = quantityDiv.querySelector('input[type="text"]');
    const cartIcon = document.querySelector("#shopping-cart");

    minusButton.style.display = 'inline-block';
    input.style.display = 'inline-block';
    input.value = parseInt(input.value) + 1;

    // Trigger animation
    cartIcon.classList.add('pulse');
    setTimeout(() => {
        cartIcon.classList.remove('pulse');
    }, 1000);

    // Increase cart counter
    updateCartCounter;

    // Send itemID and quantity to cart.php via AJAX
    updateCartOnServer(itemID, input.value);
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

    // Send itemID and quantity to cart.php via AJAX
    updateCartOnServer(itemID, input.value);

    // Decrease cart counter
    updateCartCounter;
}


function updateCartOnServer(itemID, quantity) {
    // Construct the request body
    const formData = new FormData();
    formData.append('itemID', itemID);
    formData.append('quantity', quantity);

    // Send AJAX request to manageCart.php
    fetch('manageCart.php', {
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