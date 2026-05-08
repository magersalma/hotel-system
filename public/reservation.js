let currentRoom = null;
document.addEventListener("DOMContentLoaded", function () {
    console.log("Reservation JS Loaded");
    // Confirm booking button
const confirmBtn = document.getElementById("confirm-booking");
if (confirmBtn) {
    confirmBtn.addEventListener("click", function () {

        const formData = new FormData();
        formData.append("action",    "book");
        formData.append("firstname", document.getElementById("book-firstname").value);
        formData.append("lastname",  document.getElementById("book-lastname").value);
        formData.append("email",     document.getElementById("book-email").value);
        formData.append("phone",     document.getElementById("book-phone").value);
        formData.append("checkin",   document.getElementById("book-checkin").value);
        formData.append("checkout",  document.getElementById("book-checkout").value);
        formData.append("room_num",  currentRoom.room_num);
        formData.append("room_rate", currentRoom.price);

        fetch("http://localhost:8080/hotel-system/controllers/reservationcontrollers.php", {
            method: "POST",
            body:   formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Booking confirmed! Reservation ID: " + data.res_id);
                // Go back to rooms
                document.getElementById("page-booking").classList.remove("active");
                document.getElementById("page-rooms").classList.add("active");
            } else {
                alert("Booking failed: " + data.message);
            }
        })
        .catch(error => console.error("Booking error:", error));
    });
}

    // Search button
    const searchButton = document.getElementById("search-rooms");
    if (searchButton) {
        searchButton.addEventListener("click", function () {
            const type = document.getElementById("filter-type").value;

            const formData = new FormData();
            formData.append("action", "search");
            formData.append("type",   type);

            fetch("http://localhost:8080/hotel-system/controllers/reservationcontrollers.php", {
                method: "POST",
                body:   formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                renderRooms(data);
            })
            .catch(error => console.log(error));
        });
    }

    // Back button
    const backBtn = document.getElementById("back-to-rooms");
    if (backBtn) {
        backBtn.addEventListener("click", function () {
            document.getElementById("page-booking").classList.remove("active");
            document.getElementById("page-rooms").classList.add("active");
        });
    }

});

function renderRooms(rooms) {
    const container = document.getElementById("rooms-container");
    container.innerHTML = "";

    if (!rooms || rooms.length === 0) {
        container.innerHTML = "<p>No rooms found.</p>";
        return;
    }

    const roomPhotos = {
        "standard":  "https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400",
        "deluxe":    "https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=400",
        "suite":     "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=400",
        "penthouse": "https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?w=400"
    };

    rooms.forEach(room => {
        const card = document.createElement("div");
        card.className = "room-card";

        const photo = roomPhotos[room.type] ?? "https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400";

        card.innerHTML = `
            <img src="${photo}" alt="${room.type}" style="width:100%; height:180px; object-fit:cover; border-radius:8px; margin-bottom:10px;">
            <div class="room-type">${room.type}</div>
            <div class="room-name">Room ${room.room_num}</div>
            <div class="room-price">$${room.price}/night</div>
            <button class="btn btn-g book-btn">Book Now</button>
        `;

        card.querySelector(".book-btn").addEventListener("click", function () {
            openBooking(room);
        });

        container.appendChild(card);
    });
}

function openBooking(room) {
    currentRoom = room;  // ← add this
    document.getElementById("page-rooms").classList.remove("active");
    document.getElementById("page-rooms").classList.remove("active");
    document.getElementById("page-booking").classList.add("active");

    document.getElementById("summary-type").textContent  = room.type;
    document.getElementById("summary-name").textContent  = "Room " + room.room_num;
    document.getElementById("summary-price").textContent = "$" + room.price;

    const checkin  = document.getElementById("filter-checkin").value;
    const checkout = document.getElementById("filter-checkout").value;
    if (checkin)  document.getElementById("book-checkin").value  = checkin;
    if (checkout) document.getElementById("book-checkout").value = checkout;
}