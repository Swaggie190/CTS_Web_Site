
var modal = document.getElementById("joinModal");


    var btn = document.getElementById("joinUsBtn");

    var span = document.getElementsByClassName("close")[0];


    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


document.getElementById("joinForm").onsubmit = function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);

    
    fetch('../../forms/JoinUsForm.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Thank you for joining! We'll be in touch soon.");
            modal.style.display = "none";
            document.getElementById("joinForm").reset();
        } else {
            alert("There was an error submitting your form. Please try again.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("There was an error submitting your form. Please try again.");
    });
}