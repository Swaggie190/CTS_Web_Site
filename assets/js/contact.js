/**
 * contact form client side
 */


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.php-email-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const loadingElement = form.querySelector('.loading');
        const errorElement = form.querySelector('.error-message');
        const sentElement = form.querySelector('.sent-message');
        
        loadingElement.style.display = 'block';
        errorElement.style.display = 'none';
        sentElement.style.display = 'none';
        
        const formData = new FormData(form);
        
        fetch('../../forms/contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            loadingElement.style.display = 'none';
            if (data.success) {
                sentElement.style.display = 'block';
                form.reset();
            } else {
                errorElement.textContent = data.message || 'An error occurred. Please try again.';
                errorElement.style.display = 'block';
            }
        })
        .catch(error => {
            loadingElement.style.display = 'none';
            errorElement.textContent = 'An error occurred. Please try again.';
            errorElement.style.display = 'block';
            console.error('Error:', error);
        });
    });
});