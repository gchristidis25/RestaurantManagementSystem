function createLogoutButtonFunctionality()
{
    let logOutButton = document.getElementById("logout-button");
    logOutButton.addEventListener("click", ()=> {
        window.location.assign("../php/main_page.php");
    });
}

function saveDate()
{
    const dateInput = document.getElementById("date");
    dateInput.addEventListener("change", function () {
        const selectedDate = this.value;
        console.log("Date changed to:", selectedDate);
        localStorage.setItem("selectedDate", selectedDate);
    });
}

function saveTimeslot()
{
    const timeslotInput = document.getElementById("timeslot");
    timeslotInput.addEventListener("change", function () {
        selectedTimeslot = this.value;
        console.log("Timeslot selected:", selectedTimeslot);
        localStorage.setItem("selectedTimeslot", selectedTimeslot);
    });
}

function saveStatus()
{
    const statusInput = document.getElementById("status");
    statusInput.addEventListener("change", function () {
        selectedStatus = this.value;
        console.log("Status selected:", selectedStatus);
        localStorage.setItem("selectedStatus", selectedStatus);
    });
}

async function getReservations(date, timeslot, status)
{
    const API_URL = `http://localhost:80/RestaurantManagementSystem/api/reservation_api.php?action=WAITER_RESERVATIONS&date=${encodeURIComponent(date)}&timeslot=${encodeURIComponent(timeslot)}&status=${encodeURIComponent(status)}`;
    const response = await fetch(API_URL, {
        method: "GET",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"}
    });

    const message = await response.json();
    console.log(message["reservations"]);
    return message["reservations"];
}

async function changeStatus(reservationID, newStatus) {
    const API_URL = "http://localhost:80/RestaurantManagementSystem/api/reservation_api.php";
    
    const response = await fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'PATCH',
            id: reservationID,
            status: newStatus
        })
    });

    const message = await response.json();
    console.log(message["message"]);
}

function createConfirmButton(reservationID)
{
    const confirmButton = document.createElement("button");
    confirmButton.textContent = "Confirm";
    confirmButton.classList.add("confirm-btn");

    confirmButton.addEventListener("click", async () => {
        // remains pressed
        confirmButton.classList.add("confirm-btn-pressed");
        // changes the status
        await changeStatus(reservationID, "Confirmed");

    });

    return confirmButton;
}

function createDenyButton(reservationID)
{
    const denyButton = document.createElement("button");
    denyButton.textContent = "Deny";
    denyButton.classList.add("deny-btn");
    denyButton.addEventListener("click", async () => {
        // remains pressed
        denyButton.classList.add("deny-btn-pressed");
        // changes the status
        await changeStatus(reservationID, "Denied");
    });

    return denyButton;
}

function display(reservations)
{
    const reservationStatus = localStorage.getItem("selectedStatus");
    //create table
    const table = document.createElement('table');
    //create table header
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    const headers = ['Name', 'Surname', 'Guests', 'Notes'];
    // add Pending and Denied headers based on reservationStatus
    if (reservationStatus === "Pending" || reservationStatus === "Denied")
    {
        headers.push("Confirm");
    }

    if (reservationStatus === "Pending" || reservationStatus === "Confirmed")
    {
        headers.push("Deny");
    }

    // populate table
    for (let i = 0; i < headers.length; i++) {
        const th = document.createElement('th');
        th.textContent = headers[i];
        headerRow.appendChild(th);
    }

    thead.appendChild(headerRow);
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    for (let reservation of reservations) 
    {
        console.log(reservation);
        const row = document.createElement('tr');
        const nameCell = row.insertCell();
        nameCell.textContent = reservation["Customer_name"];
        const surnameCell = row.insertCell();
        surnameCell.textContent = reservation["Customer_surname"];
        const guestCell = row.insertCell();
        guestCell.textContent = reservation["NumberOfGuests"];

        const notesCell = row.insertCell();
        notesCell.textContent = reservation["Reservation_notes"];
        if (reservationStatus === "Pending" || reservationStatus === "Denied")
        {
            const confirmCell = row.insertCell();
            const confirmButton = createConfirmButton(reservation["ReservationID"])
            confirmCell.appendChild(confirmButton);
        }

        if (reservationStatus === "Pending" || reservationStatus === "Confirmed")
        {
            const denyCell = row.insertCell();
            const denyButton = createDenyButton(reservation["ReservationID"])
            denyCell.appendChild(denyButton);
        }
        tbody.appendChild(row);
    }
    table.appendChild(tbody);
    const main = document.querySelector("main");
    //clear main first
    main.innerHTML = "";
    // Append the table to main
    main.appendChild(table);
}



function addQueryButtonFunctionality()
{
    const queryButton = document.getElementById("query-button");
    queryButton.addEventListener("click", async () => {
        const selectedDate = localStorage.getItem("selectedDate");
        const selectedTimeslot = localStorage.getItem("selectedTimeslot");
        const selectedStatus = localStorage.getItem("selectedStatus");

        const reservations = await getReservations(selectedDate, selectedTimeslot, selectedStatus);
        display(reservations);
    })
}

document.addEventListener("DOMContentLoaded", () => {
    createLogoutButtonFunctionality();
    saveDate();
    saveTimeslot();
    saveStatus();
    addQueryButtonFunctionality();
});