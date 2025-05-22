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

function getCustomerID() {
  const customerID = document.querySelector(".customer-info").id;
  return customerID;
}

async function getReservations() {
  const customerID = getCustomerID();
  console.log(customerID);
  const API_URL = `http://localhost:80/RestaurantManagementSystem/api/reservation_api.php?action=CUSTOMER_RESERVATIONS&customerID=${encodeURIComponent(customerID)}`;
  const response = await fetch(API_URL, {
    method: "GET",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
    },
  });

  const reservations = await response.json();
  return [reservations["confirmed"], reservations["pending"]];
}

function createTable() {
  const table = document.createElement("table");

  const thead = document.createElement("thead");
  const headerRow = document.createElement("tr");
  const headers = [
    "Reservation Date",
    "Start Time",
    "End Time",
    "Number of Guests",
    "Notes",
  ];

  headers.forEach((headerText) => {
    const th = document.createElement("th");
    th.textContent = headerText;
    headerRow.appendChild(th);
  });

  thead.appendChild(headerRow);
  table.appendChild(thead);

  return table;
}

function displayReservations(pendingReservations) {
  if (pendingReservations.length === 0) return null;
  const table = createTable();
  const tbody = document.createElement("tbody");

  for (const pendingReservation of pendingReservations) {
    const row = document.createElement("tr");
    const dateCell = document.createElement("td");
    dateCell.textContent = pendingReservation["Reservation_date"];
    row.appendChild(dateCell);

    const startTimeCell = document.createElement("td");
    startTimeCell.textContent = pendingReservation["Start_time"];
    row.appendChild(startTimeCell);

    const endTimeCell = document.createElement("td");
    endTimeCell.textContent = pendingReservation["End_time"];
    row.appendChild(endTimeCell);

    const guestNumberCell = document.createElement("td");
    guestNumberCell.textContent = pendingReservation["NumberOfGuests"];
    row.appendChild(guestNumberCell);

    const notesCell = document.createElement("td");
    notesCell.textContent = pendingReservation["Reservation_notes"];
    row.appendChild(notesCell);

    tbody.appendChild(row);
  }
  table.appendChild(tbody);

  return table;
}

async function display() {
  const [confirmedReservations, pendingReservations] = await getReservations();
  if (
    !displayReservations(confirmedReservations) &&
    !displayReservations(pendingReservations)
  )
    return;

  const content = document.querySelector(".content");
  content.innerHTML = "";

  if (pendingReservations) {
    const pendingTitle = document.createElement("h2");
    pendingTitle.textContent = "Pending Reservations";
    content.appendChild(pendingTitle);

    const pendingReservationsTable = displayReservations(pendingReservations);
    content.appendChild(pendingReservationsTable);
  }

  if (confirmedReservations) {
    const confirmedTitle = document.createElement("h2");
    confirmedTitle.textContent = "Confirmed Reservations";
    content.appendChild(confirmedTitle);

    const confirmedReservationsTable = displayReservations(
      confirmedReservations,
    );
    content.appendChild(confirmedReservationsTable);
  }
}

document.addEventListener("DOMContentLoaded", async () => {
  addMakeReservationButtonFunctionality();
  addLogoutButtonFunctionality();
  await display();
});
