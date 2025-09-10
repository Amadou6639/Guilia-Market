// credit.js - Scripts pour le simulateur de crédit

/**
 * Calcule les mensualités d'un prêt avec une formule simple.
 * @param {number} principal - Le montant du capital emprunté.
 * @param {number} rate - Le taux d'intérêt annuel.
 * @param {number} term - La durée du prêt en mois.
 * @returns {number} Le montant de la mensualité.
 */
function calculateLoanPayment(principal, rate, term) {
  if (rate === 0) {
    return principal / term;
  }
  const monthlyRate = rate / 12 / 100;
  const numerator = principal * monthlyRate * Math.pow(1 + monthlyRate, term);
  const denominator = Math.pow(1 + monthlyRate, term) - 1;
  return numerator / denominator;
}

/**
 * Met à jour dynamiquement l'affichage des mensualités sur la page.
 */
function updatePayment() {
  // Récupère les valeurs des champs du formulaire
  const vehiclePrice = parseFloat(
    document.getElementById("vehicle-price").value
  );
  const downPayment = parseFloat(document.getElementById("down-payment").value);
  const loanTerm = parseInt(document.getElementById("loan-term").value, 10);
  const interestRate = parseFloat(
    document.getElementById("interest-rate").value
  );

  // Vérifie si les valeurs sont valides
  if (
    isNaN(vehiclePrice) ||
    isNaN(downPayment) ||
    isNaN(loanTerm) ||
    isNaN(interestRate) ||
    loanTerm <= 0
  ) {
    document.getElementById("monthly-payment").textContent =
      "Veuillez remplir tous les champs valides.";
    return;
  }

  // Calcule le montant du prêt
  const principal = vehiclePrice - downPayment;
  if (principal <= 0) {
    document.getElementById("monthly-payment").textContent =
      "L'apport doit être inférieur au prix du véhicule.";
    return;
  }

  // Calcule le paiement mensuel
  const monthlyPayment = calculateLoanPayment(
    principal,
    interestRate,
    loanTerm
  );

  // Affiche le résultat
  document.getElementById("monthly-payment").textContent =
    monthlyPayment.toFixed(2) + " €";
}

// Ajoute des écouteurs d'événements pour les changements dans le formulaire
document.addEventListener("DOMContentLoaded", () => {
  const formElements = [
    "vehicle-price",
    "down-payment",
    "loan-term",
    "interest-rate",
  ];
  formElements.forEach((id) => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener("input", updatePayment);
    }
  });

  // Appel initial pour afficher un résultat par défaut
  updatePayment();
});
