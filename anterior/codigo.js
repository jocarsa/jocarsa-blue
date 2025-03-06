 /********************************************************
     * 1) Generate random data and render charts
     ********************************************************/
    // Simple arrays for demonstration
    const barData = Array.from({ length: 5 }, () => Math.floor(Math.random() * 50) + 10);
    const lineData = Array.from({ length: 5 }, () => Math.floor(Math.random() * 50) + 10);
    const pieData = Array.from({ length: 5 }, () => Math.floor(Math.random() * 50) + 10);

    // Stacked bar example: each sub-array is a "layer" for the same bar indices
    const stackedData = [
      Array.from({ length: 5 }, () => Math.floor(Math.random() * 30) + 5),
      Array.from({ length: 5 }, () => Math.floor(Math.random() * 30) + 5),
      Array.from({ length: 5 }, () => Math.floor(Math.random() * 30) + 5),
    ];

    // Gauge chart value
    const gaugeValue = Math.floor(Math.random() * 100);

    // 1) Bar Chart
    const barChartSVG = myCharts.createBarChart(barData, {
      width: 250,
      height: 150,
      barColor: "#ffffff",
      hoverColor: "#FFD700"
    });
    document.getElementById("barChart").appendChild(barChartSVG);

    // 2) Line Chart
    const lineChartSVG = myCharts.createLineChart(lineData, {
      width: 250,
      height: 150,
      lineColor: "#00FFB3",
      pointColor: "#ffffff",
      hoverColor: "#FFD700"
    });
    document.getElementById("lineChart").appendChild(lineChartSVG);

    // 3) Pie Chart
    const pieChartSVG = myCharts.createPieChart(pieData, {
      width: 200,
      height: 200,
      colors: ["#00bfff", "#f8b400", "#f85c50", "#9cff9c", "#ff00ff"]
    });
    document.getElementById("pieChart").appendChild(pieChartSVG);

    // 4) Ring (Donut) Chart
    const ringChartSVG = myCharts.createRingChart(pieData, {
      width: 200,
      height: 200,
      innerRadius: 50,
      colors: ["#0bd", "#f8b400", "#f85c50", "#9cff9c", "#ff00ff"]
    });
    document.getElementById("ringChart").appendChild(ringChartSVG);

    // 5) Stacked Bar Chart
    const stackedBarSVG = myCharts.createStackedBarChart(stackedData, {
      width: 250,
      height: 150,
      colors: ["#f85c50", "#ffd700", "#00ffb3"],
      barSpacing: 5
    });
    document.getElementById("stackedBarChart").appendChild(stackedBarSVG);

    // 6) Radial Gauge Chart
    const gaugeChartSVG = myCharts.createRadialGaugeChart(gaugeValue, 100, {
      width: 200,
      height: 200,
      color: "#ffd700",
      bgColor: "rgba(255,255,255,0.2)"
    });
    document.getElementById("gaugeChart").appendChild(gaugeChartSVG);


    /********************************************************
     * 2) 3D Parallax Effect
     ********************************************************/
    const gridContainer = document.getElementById("chartGrid");

    // Track mouse movement and rotate the grid
    document.addEventListener("mousemove", (event) => {
      // Get the center of the screen
      const centerX = window.innerWidth / 2;
      const centerY = window.innerHeight / 2;

      // How far the mouse is from center
      const deltaX = event.clientX - centerX;
      const deltaY = event.clientY - centerY;

      // Scale down the rotation to make it subtle
      const rotateX = (deltaY / centerY) * 5; // rotate up to +/-5 deg
      const rotateY = (deltaX / centerX) * 5; // rotate up to +/-5 deg

      // Apply rotation around X and Y axes
      gridContainer.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });
