function addMakeReservationButtonFunctionality() {
  const makeReservationButton = document.getElementById("reservation-button");
  makeReservationButton.addEventListener("click", () => {
    window.location.href = "../php/reservation.php";
  });
}

function addLogoutButtonFunctionality() {
  const logoutButton = document.getElementById("logout-button");
  logoutButton.addEventListener("click", () => {
    window.location.replace("main_page.php");
  });
}

document.addEventListener("DOMContentLoaded", () => {
  addMakeReservationButtonFunctionality();
  addLogoutButtonFunctionality();
});
