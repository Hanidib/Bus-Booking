<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bus Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Logout Button -->
    <button class="btn btn-danger logout-btn" onclick="logout()">
        Logout
    </button>

    <script>
        // Redirect to login if token is missing
        if (!localStorage.getItem('token') || !localStorage.getItem('userId')) {
            alert("You must be logged in to access this page.");
            window.location.href = "/login.html";
        }
    </script>

    <div class="container py-5">
        <h2 class="mb-4 text-primary">Find a Route</h2>

        <div class="mb-3">
            <input type="text" class="form-control mb-2" id="departure" placeholder="Enter Departure Location">
            <input type="text" class="form-control mb-2" id="destination" placeholder="Enter Destination Location">
            <button class="btn btn-primary" onclick="searchRoutes()">Search Routes</button>
        </div>

        <div id="routes" class="mb-4"></div>
        <div id="buses" class="mb-4"></div>
        <div id="seats" class="mb-4"></div>
        <div id="pnr" class="alert alert-success d-none"></div>
    </div>

    <script>
        const token = localStorage.getItem("token");
        const userId = localStorage.getItem("userId");

        async function logout() {
            try {
                // Call logout API endpoint
                const response = await fetch('/api/user/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                // Clear local storage regardless of API response
                localStorage.removeItem('token');
                localStorage.removeItem('userId');
                localStorage.removeItem('userType');

                // Redirect to login page
                window.location.href = '/login.html';

            } catch (error) {
                console.error('Logout error:', error);
                // Still clear storage and redirect even if API fails
                localStorage.clear();
                window.location.href = '/login.html';
            }
        }

        async function searchRoutes() {
            const departure = document.getElementById("departure").value.trim();
            const destination = document.getElementById("destination").value.trim();

            if (!departure || !destination) {
                alert("Please enter both departure and destination.");
                return;
            }

            try {
                const res = await fetch(`/api/routes/search?departure=${encodeURIComponent(departure)}&destination=${encodeURIComponent(destination)}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!res.ok) {
                    throw new Error("Failed to fetch routes.");
                }

                const routes = await res.json();

                let html = "<h4 class='text-success'>Available Routes:</h4>";
                routes.forEach(route => {
                    html += `<button class="btn btn-outline-primary m-1" onclick="buses(${route.routeId})">
                        ${route.departure} → ${route.destination} | Departure Time: ${route.departureTime}
                    </button>`;
                });

                document.getElementById("routes").innerHTML = html;
                document.getElementById("buses").innerHTML = "";
                document.getElementById("seats").innerHTML = "";
                document.getElementById("pnr").classList.add("d-none");

            } catch (error) {
                console.error("Route search error:", error);
                document.getElementById("routes").innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
            }
        }

        async function buses(routeId) {
            try {
                const res = await fetch(`/api/routes/${routeId}/buses`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!res.ok) {
                    throw new Error("Failed to fetch buses.");
                }

                const buses = await res.json();

                let html = "<h4 class='text-info'>Select a Bus:</h4>";
                buses.forEach(bus => {
                    html += `<button class="btn btn-outline-secondary m-1" onclick="getSeats(${bus.busId}, ${routeId})">
                        ${bus.busNumber} - ${bus.busType}
                    </button>`;
                });

                document.getElementById("buses").innerHTML = html;
                document.getElementById("seats").innerHTML = "";
                document.getElementById("pnr").classList.add("d-none");

            } catch (error) {
                console.error("Buses fetch error:", error);
                document.getElementById("buses").innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
            }
        }

        async function getSeats(busId, routeId) {
            try {
                const res = await fetch(`/api/buses/${busId}/seats`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!res.ok) {
                    throw new Error("Failed to fetch seats.");
                }

                const seats = await res.json();

                let html = "<h4 class='text-warning'>Choose a Seat:</h4>";
                seats.forEach(seat => {
                    if (seat.isAvailable) {
                        html += `<button class="btn btn-outline-success m-1" onclick="bookSeat(${seat.seatId}, ${routeId})">${seat.seatNumber}</button>`;
                    }
                });
                document.getElementById("seats").innerHTML = html;
                document.getElementById("pnr").classList.add("d-none");

            } catch (error) {
                console.error("Seats fetch error:", error);
                document.getElementById("seats").innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
            }
        }

        async function bookSeat(seatId, routeId) {
            if (!token || !userId) {
                alert("User not authenticated. Please log in.");
                return;
            }

            const today = new Date().toISOString().split("T")[0];

            try {
                const bookingRes = await fetch(`/api/bookings`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        userId,
                        routeId,
                        seatId,
                        bookingDate: today,
                        status: "confirmed"
                    })
                });

                if (!bookingRes.ok) {
                    const errorData = await bookingRes.json().catch(() => ({}));
                    throw new Error(errorData.message || "Booking failed");
                }

                const data = await bookingRes.json();
                const booking = data.booking;
                const pnr = data.pnr;

                if (!booking?.bookingId || !pnr?.pnrCode) {
                    throw new Error("Missing booking ID or PNR code.");
                }

                document.getElementById("pnr").classList.remove("d-none");
                document.getElementById("pnr").classList.replace("alert-danger", "alert-success");
                document.getElementById("pnr").innerHTML = `
                    <strong>Booking Confirmed!</strong><br>
                    PNR Code: ${pnr.pnrCode}
                `;

            } catch (error) {
                console.error("Booking failed:", error);
                document.getElementById("pnr").classList.remove("d-none");
                document.getElementById("pnr").classList.replace("alert-success", "alert-danger");
                document.getElementById("pnr").innerHTML = "Booking failed! " + error.message;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>