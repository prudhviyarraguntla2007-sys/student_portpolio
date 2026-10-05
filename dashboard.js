// ==============================
// Welcome Message
// ==============================

window.onload = function () {
    console.log("Student Dashboard Loaded Successfully!");
};

// ==============================
// Bar Chart (CGPA Performance)
// ==============================

const ctx = document.getElementById('barChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: subjects,

        datasets: [{

            label: 'Marks',

            data: marks,

            backgroundColor: '#2563eb',

            borderRadius: 10,

            maxBarThickness: 50

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true,

                max: 100

            }

        }

    }

});
const attendanceCtx = document.getElementById("attendanceChart");

new Chart(attendanceCtx, {

    type: "bar",

    data: {

        labels: attendanceSubjects,

        datasets: [{

            label: "Attendance %",

            data: attendancePercentages,

            backgroundColor: "#10B981",

            borderRadius: 10,

            maxBarThickness: 45

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true,

                max: 100

            }

        }

    }

});
// ==============================
// Card Hover Animation
// ==============================

const cards = document.querySelectorAll(".card");

cards.forEach(card => {

    card.addEventListener("mouseenter", () => {

        card.style.transform = "translateY(-10px) scale(1.03)";

    });

    card.addEventListener("mouseleave", () => {

        card.style.transform = "translateY(0px)";

    });

});

// ==============================
// Greeting
// ==============================

const hour = new Date().getHours();

let message = "";

if (hour < 12)
    message = "🌞 Good Morning";

else if (hour < 17)
    message = "☀ Good Afternoon";

else
    message = "🌙 Good Evening";

console.log(message);

// ==============================
// Login Streak Animation
// ==============================

const stars = document.querySelector(".stars");

if (stars) {

    setInterval(() => {

        stars.style.transform = "scale(1.1)";

        setTimeout(() => {

            stars.style.transform = "scale(1)";

        }, 500);

    }, 1500);

}

// ==============================
// Notification
// ==============================

setTimeout(() => {

    alert("🎉 Welcome Back! Don't forget today's homework.");

}, 1000);