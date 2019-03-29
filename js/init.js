//Mobile Side nav
document.addEventListener("DOMContentLoaded", function() {
  var elems = document.querySelectorAll(".sidenav");
  var instances = M.Sidenav.init(elems, { edge: "right", draggable: !0 });
});

// Contact Form
function FORMrequest(url, formData, callback) {
  const xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
    if (xhr.readyState !== 4) return;
    callback(JSON.parse(xhr.responseText));
  };

  xhr.open("POST", url, true);
  xhr.send(formData);
}

const contact_form = formElement => {
  const formData = new FormData(formElement);
  let mail_body = null;

  if (!formData.has("phone")) {
    // Contact
    mail_body = `
        <html>
            <body>
                <h1>Contact Formulier</h1>
                <p>
                    Beste Bart,<br />
                    Je hebt een bericht gekregen.
                </p>
                <p>
                    Naam: <b>${formData.get("name")}</b><br />
                    Email: <b><a href="mailto:${formData.get(
                      "email"
                    )}">${formData.get("email")}</a></b><br />
                    Bericht: <b>${formData.get("message")}</b>
                </p>
            </body>
        </html>
    `;
  } else {
    // Afspraak
    mail_body = `
        <html>
            <body>
                <h1>Afspraak Formulier</h1>
                <p>
                    Beste Bart,<br />
                    Je hebt een afspraak verzoek gekregen.
                </p>
                <p>
                    Naam: <b>${formData.get("name")}</b><br />
                    Email: <b><a href="mailto:${formData.get(
                      "email"
                    )}">${formData.get("email")}</a></b><br />
                    Telefoonnummer: <b><a href="tel:${formData.get(
                      "phone"
                    )}">${formData.get("phone")}</a></b><br />
                    Adres: <b><a href="https://www.google.com/maps/dir/?api=1&travelmode=driving&destination=${formData.get(
                      "adress"
                    )}">${formData.get("adress")}</a></b><br />
                    Bericht: <b>${formData.get("description")}</b>
                </p>
            </body>
        </html>
    `;
  }

  formData.append("subject", "Formulier || Website");
  formData.append("body", mail_body);

  FORMrequest("/mail.php", formData, response => {
    console.log(response);
    if (response.success) {
      alert("Uw bericht is verstuurd!");
      document.querySelector("#form").reset();
    } else {
      alert("Oeps, er ging iets mis!");
    }
  });
};
