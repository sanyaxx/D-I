document.addEventListener('DOMContentLoaded', function() {
    console.log("clicked");
    const editIcons = document.querySelectorAll('.edit-icon');
    editIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const field = this.dataset.field;
            const span = this.previousElementSibling;
            span.contentEditable = 'true';
            span.focus();
            span.textContent = ''; // Clear the text
            span.classList.add('editing');
        });
    });

    // Event listener for confirming edits
    const confirmButton = document.querySelector('.confirm-button');
    confirmButton.addEventListener('click', function() {
        const editableField = document.querySelector('.editing');
        const newValue = editableField.textContent.trim();
        const field = editableField.id.substring(8); // Remove 'profile-' from id to get the field name
        updateProfile(field, newValue);
        editableField.contentEditable = 'false';
        editableField.classList.remove('editing');
    });

    // Event listener for closing the modal
    const closeButton = document.querySelector('.close-button');
    closeButton.addEventListener('click', function() {
        const editableField = document.querySelector('.editing');
        editableField.textContent = ''; // Clear the text
        editableField.contentEditable = 'false';
        editableField.classList.remove('editing');
    });
});

// Function to update profile
function updateProfile(field, value) {
    // Send AJAX request to PHP file to update the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/updateProfile.php');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Handle success
            console.log(xhr.responseText);
        } else {
            // Handle error
            console.error('Error occurred.');
        }
    };
    const data = `field=${field}&value=${value}`;
    xhr.send(data);
};

