// admin.js - Scripts généraux pour l'interface d'administration

/**
 * Gère la modale (fenêtre pop-up) d'ajout/modification de catégorie.
 * Rend la modale visible et invisible.
 * @param {boolean} show - Si true, la modale est affichée; sinon, elle est masquée.
 */
function toggleModal(show) {
  const modal = document.getElementById("category-modal");
  if (modal) {
    if (show) {
      modal.classList.remove("hidden");
    } else {
      modal.classList.add("hidden");
    }
  }
}

/**
 * Gère l'action de suppression d'un élément (utilisateur, véhicule, etc.).
 * Affiche une confirmation avant de procéder.
 * @param {string} type - Le type d'élément (ex: 'utilisateur', 'catégorie').
 * @param {string} name - Le nom ou l'identifiant de l'élément.
 */
function handleDelete(type, name) {
  // Utilisation d'un message box personnalisé au lieu de `confirm()`
  // C'est une meilleure pratique pour les interfaces web modernes.
  const message = `Êtes-vous sûr de vouloir supprimer ${type} "${name}" ?`;

  // Une implémentation réelle utiliserait une modale personnalisée ici.
  // Pour cet exemple, nous utiliserons une simple alerte console.
  if (confirm(message)) {
    console.log(`Suppression de ${type} "${name}"...`);
    // Logique de suppression à implémenter ici
    // Ex: Appel à une API pour supprimer l'élément de la base de données.
    // Côté frontend, on retirerait la ligne correspondante du tableau.
  }
}

/**
 * Gère l'action de modification d'un élément.
 * Redirige ou ouvre une modale avec les informations pré-remplies.
 * @param {string} type - Le type d'élément (ex: 'véhicule', 'utilisateur').
 * @param {string} id - L'identifiant unique de l'élément à modifier.
 */
function handleEdit(type, id) {
  console.log(`Modification de ${type} avec l'ID: ${id}`);
  // Logique de modification à implémenter ici.
  // Ex: Redirection vers le formulaire de modification avec l'ID en paramètre.
  // window.location.href = `vehicle-form.html?id=${id}`;
}

// Événement pour lier les fonctions aux boutons (ex: page catégories)
document.addEventListener("DOMContentLoaded", () => {
  // Écouteur pour le bouton 'Ajouter une catégorie'
  const addCategoryBtn = document.getElementById("add-category-btn");
  if (addCategoryBtn) {
    addCategoryBtn.addEventListener("click", () => toggleModal(true));
  }

  // Écouteur pour le bouton 'Annuler' de la modale
  const closeModalBtn = document.getElementById("close-modal-btn");
  if (closeModalBtn) {
    closeModalBtn.addEventListener("click", () => toggleModal(false));
  }
});
