async function getMaxCapacity()
{
    const API_URL = `http://localhost:80/RestaurantManagementSystem/api/reservation_api.php?action=MAX_CAPACITY`;
    const response = await fetch(API_URL, {
        method: "GET",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"}
    });

    const message = await response.json()
    return Number(message["max_capacity"]);
}

function getChosenDate()
{
    const allCookies = document.cookie;
    const cookieArray = allCookies.split('; ');

    for (const cookie of cookieArray)
    {
        const [key, value] = cookie.split('=');
        if (key === "reservationDate")
        {
            return decodeURIComponent(value);
        }
    }
    return null;
}

function getGuests()
{
    const allCookies = document.cookie;
    const cookieArray = allCookies.split('; ');

    for (const cookie of cookieArray)
    {
        const [key, value] = cookie.split('=');
        if (key === "numberOfGuests")
        {
            return Number(decodeURIComponent(value));
        }
    }
    return null;
}

async function getCapacities(date)
{
    const API_URL = `http://localhost:80/RestaurantManagementSystem/api/reservation_api.php?action=CURRENT_CAPACITIES&date=${encodeURIComponent(date)}`;
    const response = await fetch(API_URL, {
        method: "GET",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"}
    });

    const message = await response.json()
    const capacities = {
        "09:30": Number(message["09:30"]),
        "13:00": Number(message["13:00"]),
        "16:00": Number(message["16:00"]),
        "20:00": Number(message["20:00"])
    };
    console.log(capacities);
    return capacities;
}

function addTimeSlotButtonFunctionality(timeslotButton) {
    timeslotButton.addEventListener("click", () => {
        let startTime = timeslotButton.textContent.trim();
        const formattedStartTime = `${startTime}:00`;

        const [hours, minutes] = startTime.split(":").map(Number);
        const now = new Date();
        now.setHours(hours, minutes, 0, 0);

        const endDate = new Date(now.getTime() + 3 * 60 * 60 * 1000); // Add 3 hours
        const formattedEndTime = endDate.toTimeString().slice(0, 8); // "HH:MM:SS"

        document.cookie = `startTime=${formattedStartTime}; path=/; max-age=${60 * 60}`;
        document.cookie = `endTime=${formattedEndTime}; path=/; max-age=${60 * 60}`;

        window.location.href = "reservation_details.php";
    });
}

async function addTimeslotButtons()
{
    const max_capacity = await getMaxCapacity();
    const date = getChosenDate();
    const capacities = await getCapacities(date);
    const numberGuests = getGuests();
    const timeslotButtons = document.getElementsByClassName("timeslot-button");

   const timeSlots = ["09:30", "13:00", "16:00", "20:00"];
    for (let i = 0; i < timeslotButtons.length; i++) {
        const time = timeSlots[i];
        const capacity = capacities[time];

        if (capacity <= 0.5 * max_capacity) {
            timeslotButtons[i].classList.add("low-capacity");
            addTimeSlotButtonFunctionality(timeslotButtons[i]);
        } else if (capacity > (0.5 * max_capacity - numberGuests) && capacity < max_capacity) {
            timeslotButtons[i].classList.add("high-capacity");
            addTimeSlotButtonFunctionality(timeslotButtons[i]);
        } else {
            timeslotButtons[i].classList.add("full-booked");
            timeslotButtons[i].disabled = true;
        }
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    await addTimeslotButtons()
});