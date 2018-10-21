submit.addEventListener("click", function() {
    const name = document.querySelector('#name');
    const email = document.querySelector('#email');
    const phone = document.querySelector('#phone');
    const postalcode = document.querySelector('#postalcode');
    const house = document.querySelector('#house');
    const problem = document.querySelector('#problem');
    const submit = document.querySelector('#submit');
    jQuery.ajax({
        type: "POST",
        url: '/php/afspraak.php',
        dataType: "JSON",
        cache: false,
        data: {
            name: name.value,
            email: email.value,
            phone: phone.value,
            postalcode: postalcode.value,
            house: house.value,
            problem: problem.value,
        },

        success: function() {
            alert("Het formulier is verstuurd");
            window.location.href = "/index.html";
        },

        error: function(response) {
            alert(response.responseJSON.message);
        }
    });
});
