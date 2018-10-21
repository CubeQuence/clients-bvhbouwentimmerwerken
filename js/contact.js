submit.addEventListener("click", function() {
    const name = document.getElementById('name');
    const email = document.querySelector('#email');
    const message = document.querySelector('#message');
    const submit = document.querySelector('#submit');
    jQuery.ajax({
        type: "POST",
        url: '/php/contact.php',
        dataType: "JSON",
        cache: false,
        data: {
            name: name.value,
            email: email.value,
            message: message.value,
        },

        success: function() {
            alert("Uw bericht is verstuurd");
            window.location.href = "/index.html";
        },

        error: function(response) {
            alert(response.responseJSON.message);
        }
    });
});
