// Example User Data (0-100 scale)
const userData = {
    recreationalProductive: 70, // X-axis value, 0 = Recreational, 100 = Productive
    relaxedAlert: 30            // Y-axis value, 0 = Relaxed, 100 = Alert
};

function plotUserDot() {
    const dot = document.getElementById("userDot");
    const chart = document.querySelector(".chart");

    // Calculate X and Y positions based on user data
    const xPos = (userData.recreationalProductive / 100) * chart.clientWidth;
    const yPos = chart.clientHeight - (userData.relaxedAlert / 100) * chart.clientHeight;

    // Set the dot's position
    dot.style.left = `${xPos}px`;
    dot.style.top = `${yPos}px`;
}

plotUserDot();