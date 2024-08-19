document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const submitButton = document.getElementById("btn");

    form.addEventListener("submit", function (event) {
        let isValid = true;

        // Validate Username Input
        const usernameValue = usernameInput.value.trim();
        if (usernameValue === "") {
            alert("Username cannot be empty.");
            usernameInput.focus();
            isValid = false;
        } else if (usernameValue.length < 3) {
            alert("Username must be at least 3 characters long.");
            usernameInput.focus();
            isValid = false;
        }

        // Validate Password Input
        const passwordValue = passwordInput.value.trim();
        if (passwordValue === "") {
            alert("Password cannot be empty.");
            passwordInput.focus();
            isValid = false;
        } else if (passwordValue.length < 5) {
            alert("Password must be at least 5 characters long.");
            passwordInput.focus();
            isValid = false;
        }

        // If any validation fails, prevent the form from submitting
        if (!isValid) {
            event.preventDefault();
        }
    });
});
