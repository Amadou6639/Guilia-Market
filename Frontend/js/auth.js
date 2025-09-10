document.addEventListener("DOMContentLoaded", () => {
  const authLinksDesktop = document.getElementById("auth-links-desktop");
  // Note : Vous pouvez aussi cibler un conteneur pour le menu mobile si nécessaire.

  const token = localStorage.getItem("token");

  if (token) {
    // L'utilisateur est connecté
    try {
      // Décoder le payload du token pour obtenir les informations de l'utilisateur
      // C'est une méthode simple et non sécurisée pour lire le payload.
      // Ne stockez jamais d'informations sensibles dans le payload JWT.
      const payload = JSON.parse(atob(token.split(".")[1]));
      const userFirstname = payload.firstname || "Utilisateur";

      // Mettre à jour l'en-tête pour l'utilisateur connecté
      authLinksDesktop.innerHTML = `
                <span class="text-gray-600">Bonjour, ${userFirstname}</span>
                <a href="profil.html" class="text-gray-600 hover:text-blue-600 transition-colors duration-300">Mon Compte</a>
                <button id="logout-button" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300">
                    Déconnexion
                </button>
            `;

      // Ajouter l'événement de déconnexion au nouveau bouton
      const logoutButton = document.getElementById("logout-button");
      if (logoutButton) {
        logoutButton.addEventListener("click", () => {
          // 1. Supprimer le token du localStorage
          localStorage.removeItem("token");

          // 2. Afficher un message de confirmation
          alert("Vous avez été déconnecté avec succès.");

          // 3. Rediriger vers la page d'accueil
          window.location.href = "index.html";
        });
      }
    } catch (e) {
      console.error("Erreur lors du décodage du token:", e);
      // En cas de token invalide, on le supprime
      localStorage.removeItem("token");
    }
  } else {
    // L'utilisateur n'est pas connecté, on affiche les liens par défaut
    authLinksDesktop.innerHTML = `
            <a href="connexion.html" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                Connexion
            </a>
            <a href="inscription.html" class="text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg transition-colors duration-300">
                Inscription
            </a>
        `;
  }
});
