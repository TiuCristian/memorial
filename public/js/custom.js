document.addEventListener("DOMContentLoaded", function() {
    const consentBar = document.getElementById("cookie-consent");
    const acceptBtn = document.getElementById("accept-cookies");

    if (!localStorage.getItem("cookiesAccepted")) {
        consentBar.style.display = "block";
    }

    acceptBtn.addEventListener("click", function() {
        localStorage.setItem("cookiesAccepted", "true");
        consentBar.style.display = "none";
    });
});
