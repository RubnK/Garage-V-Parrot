// Scroll fluide pour les liens d'ancrage
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});


// script.js








document.addEventListener("DOMContentLoaded", function() {
    var closeModal = document.getElementsByClassName("close")[0];
    var contactBtn = document.getElementById("contactBtn");
    var contactForm = document.getElementById("contactForm");
    var closeForm = document.getElementById("closeForm");



    contactBtn.onclick = function() {
        contactForm.style.display = "block";
    }

    closeForm.onclick = function() {
        contactForm.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == contactForm) {
            contactForm.style.display = "none";
        }
    }
});






// Gestion des témoignages soumis
const form = document.getElementById("temoignageForm");
const pendingContainer = document.getElementById("pendingTemoignages");
const approvedContainer = document.getElementById("approvedTemoignages");

form.addEventListener("submit", function(event) {
    event.preventDefault();

    // Récupérer les données du formulaire
    const nom = document.getElementById("nom").value;
    const commentaire = document.getElementById("commentaire").value;
    const note = document.getElementById("note").value;

    // Créer un nouveau témoignage en attente
    const temoignageBox = document.createElement("div");
    temoignageBox.classList.add("moderation-box");
    temoignageBox.innerHTML = `
        <p>"${commentaire}"</p>
        <h3>- ${nom}</h3>
        <div class="stars">${'⭐'.repeat(note)}</div>
        <button class="approve-button">Approuver</button>
    `;

    // Ajouter à la section de modération
    pendingContainer.appendChild(temoignageBox);

    // Réinitialiser le formulaire
    form.reset();

    // Ajouter l'événement de validation
    temoignageBox.querySelector(".approve-button").addEventListener("click", function() {
        // Transférer le témoignage approuvé vers la section des témoignages approuvés
        approvedContainer.appendChild(temoignageBox);
        temoignageBox.querySelector(".approve-button").remove(); // Supprimer le bouton d'approbation
    });
});









let currentIndex = 1;

function prevTestimonial() {
    currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
    updateTestimonials();
}

function nextTestimonial() {
    currentIndex = (currentIndex + 1) % testimonials.length;
    updateTestimonials();
}

document.addEventListener('DOMContentLoaded', updateTestimonials);
