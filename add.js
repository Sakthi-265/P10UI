document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="create.php"]');
    
    form.addEventListener('submit', function(event) {
        // Prevent form submission for validation
        event.preventDefault();

        // Get form values
        const line = document.getElementById('line').value;
        const message = document.getElementById('message').value;
        const effect = document.getElementById('effect').value;

        // Validate inputs
        if (line === '' || message === '' || effect === '') {
            alert('All fields are required!');
            return; // Stop form submission
        }

        if (line < 1 || line > 3) {
            alert('Line number must be between 1 and 3!');
            return; // Stop form submission
        }

        if (message.length < 5) {
            alert('Message must be at least 5 characters long!');
            return; // Stop form submission
        }

        // If all validations pass, submit the form
        form.submit();
    });
});
