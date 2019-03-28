//Mobile Side nav
document.addEventListener("DOMContentLoaded", function() {
  var elems = document.querySelectorAll(".sidenav");
  var instances = M.Sidenav.init(elems, { edge: "right", draggable: !0 });
});

// Contact Form
function FORMrequest(url, formData, callback) {
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
    if (xhr.readyState !== 4) return;
    callback(JSON.parse(xhr.responseText));
  };

  xhr.open("POST", url, true);
  xhr.send(formData);
}

const contact_form = formElement => {
  let formData = new FormData(formElement);

  formData.append("subject", "Formulier || Website");
  formData.append("body", "WIP");

  FORMrequest("/mail.php", formData, function(response) {
    console.log(response);
    // if (response.success) {
    //   M.toast({
    //     html: "Uw bericht is verstuurd!"
    //   });
    // } else {
    //   M.toast({
    //     html: "Oeps, er ging iets mis!"
    //   });
    // }
  });
};
