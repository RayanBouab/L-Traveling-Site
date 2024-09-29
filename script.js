// Humberger button
document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("menu");
  
    // Check if elements exist before adding event listeners
    if (hamburger && menu) {
        // Toggle menu visibility and hamburger icon transformation
        hamburger.addEventListener("click", function () {
            menu.classList.toggle("show");
            hamburger.classList.toggle("active");
        });
  
        // Close menu when clicking a link (for better user experience)
        document.querySelectorAll(".menu a").forEach(link => {
            link.addEventListener("click", function () {
                menu.classList.remove("show");
                hamburger.classList.remove("active");
            });
        });
    } else {
        console.error("Hamburger menu or menu not found");
    }
  });
  
  // Date and time
  document.addEventListener("DOMContentLoaded", function () {
      function updateDateTime() {
          const now = new Date();
          const options = { 
              year: 'numeric', 
              month: 'long', 
              day: 'numeric', 
              hour: '2-digit', 
              minute: '2-digit', 
              second: '2-digit', 
              hour12: false 
          };
          const formattedDateTime = now.toLocaleString('fr-FR', options);
          document.getElementById("datetime").textContent = formattedDateTime;
      }
  
      // Met à jour la date et l'heure immédiatement et toutes les secondes
      updateDateTime();
      setInterval(updateDateTime, 1000); // Met à jour chaque seconde
  });
  
  // Show form
  document.addEventListener("DOMContentLoaded", function () {
      var btn = document.getElementById("ouvrirModal");
  
      btn.onclick = function() {
          window.location.href = 'fonction.php';    
      }
  });
  
  // Securite des données
  document.addEventListener("DOMContentLoaded", function () {
      const form = document.querySelector("form");
      
      form.addEventListener("submit", function (event) {
          const nom = document.getElementById("nom").value;
          const prenom = document.getElementById("prenom").value;
          const email = document.getElementById("email").value;
          const tel = document.getElementById("tel").value;
  
          // Vérifier les champs obligatoires
          if (!nom || !prenom || !email || !tel) {
              alert("Tous les champs sont obligatoires !");
              event.preventDefault();
              return;
          }
  
          // Vérifier la validité de l'email
          const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
          if (!emailPattern.test(email)) {
              alert("Veuillez entrer un email valide.");
              event.preventDefault();
              return;
          }
  
          // Vérifier la validité du numéro de téléphone
          const telPattern = /^[0-9]{10,15}$/; // Adapte selon ton pays
          if (!telPattern.test(tel)) {
              alert("Veuillez entrer un numéro de téléphone valide.");
              event.preventDefault();
              return;
          }
      });
  });