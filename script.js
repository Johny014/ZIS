document.addEventListener('DOMContentLoaded', function() {
    // Open registration form
    document.getElementById('openRegisterForm').addEventListener('click', function() {
        document.getElementById('registerFormContainer').style.display = 'block';
    });

    // Close registration form
    document.getElementById('closeRegisterForm').addEventListener('click', function() {
        document.getElementById('registerFormContainer').style.display = 'none';
    });
});
