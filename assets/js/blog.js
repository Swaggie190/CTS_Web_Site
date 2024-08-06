/**
 * registration form
 */
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const consent = document.getElementById('consent').checked;
    
    if (name && email && consent) {
       
        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('consent', consent);

        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('message').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                this.reset(); 
            } else {
                document.getElementById('message').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('message').innerHTML = '<div class="alert alert-danger">An error occurred. Please try again later.</div>';
        });
    } else {
        document.getElementById('message').innerHTML = '<div class="alert alert-danger">Please fill out all fields and agree to receive notifications.</div>';
    }
});