document.addEventListener("DOMContentLoaded", function() {
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById('time');
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        }
    }

    function updateTemperature() {
        fetch('../PHP/get_latest_temperature.php')
            .then(response => response.json())
            .then(data => {
                const temperatureElement = document.getElementById('temperature');
                if (temperatureElement && data.temperature) {
                    temperatureElement.textContent = `${data.temperature}°C`;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateDate() {
        const fechaCompleta = document.getElementById("fecha__completa");
        const fecha = new Date();
        const semana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
        const mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        
        const diaNuevo = fecha.getDate().toString().padStart(2, '0');
        fechaCompleta.textContent = `${semana[fecha.getDay()]} ${diaNuevo} de ${mes[fecha.getMonth()]} del ${fecha.getFullYear()}`;
    }

    setInterval(updateTime, 1000);
    updateTemperature();
    setInterval(updateTemperature, 5 * 60 * 1000);
    updateDate();
    setInterval(updateDate, 1000);

    function updateRadialChart() {
        fetch('../PHP/get_latest_humidity.php')
            .then(response => response.json())
            .then(data => {
                var options = {
                    series: [data.humedad_externa, data.humedad_tierra],
                    chart: {
                        height: 350,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            dataLabels: {
                                name: {
                                    fontSize: '22px',
                                },
                                value: {
                                    fontSize: '16px',
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        return Math.round((data.humedad_externa + data.humedad_tierra) / 2) + '%'
                                    }
                                }
                            }
                        }
                    },
                    labels: ['Ambiente', 'Interna'],
                    colors: ['#1ab7ea', '#0084ff'],
                    legend: {
                        show: true,
                        floating: false,
                        fontSize: '16px',
                        position: 'bottom',
                        offsetX: 0,
                        offsetY: 0,
                        labels: {
                            useSeriesColors: true,
                        },
                        markers: {
                            size: 0
                        },
                        formatter: function(seriesName, opts) {
                            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex] + '%'
                        },
                        itemMargin: {
                            vertical: 3
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                show: true,
                                position: 'bottom',
                                fontSize: '14px',
                                itemMargin: {
                                    horizontal: 5,
                                    vertical: 2
                                }
                            },
                            plotOptions: {
                                radialBar: {
                                    dataLabels: {
                                        name: {
                                            fontSize: '18px',
                                        },
                                        value: {
                                            fontSize: '14px',
                                        }
                                    }
                                }
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            })
            .catch(error => console.error('Error:', error));
    }

    updateRadialChart();
    setInterval(updateRadialChart, 60000); // Update every minute

    // Weekly Chart
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
            datasets: [{
                label: 'Temperatura',
                data: [],
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1
            }, {
                label: 'Humedad Interna',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }, {
                label: 'Humedad Externa',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Promedios Semanales'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Valores'
                    }
                }
            }
        }
    });

    function fetchWeeklyDataAndUpdateChart() {
        fetch('../PHP/get_weekly_data.php')
            .then(response => response.json())
            .then(data => {
                weeklyChart.data.datasets[0].data = data.temperatura;
                weeklyChart.data.datasets[1].data = data.humedadInterna;
                weeklyChart.data.datasets[2].data = data.humedadExterna;
                weeklyChart.update();
            })
            .catch(error => {
                console.error('Error al obtener datos semanales:', error);
            });
    }

    // Actualizar datos cada minuto
    setInterval(fetchWeeklyDataAndUpdateChart, 60000);

    // Primera actualización inmediata
    fetchWeeklyDataAndUpdateChart();

    document.getElementById("toggleButton").addEventListener("click", function() {
        const table = $("#dataTable");
        const tableTitle = $("#tablaTitulo");
        
        if (table.is(":hidden")) {
            table.slideDown(400);
            tableTitle.slideDown(400);
            this.textContent = "Ocultar tabla";
        } else {
            table.slideUp(400);
            tableTitle.slideUp(400);
            this.textContent = "Ver tabla";
        }
    });

    // Integrated climate chart code
    const climateChart = document.getElementById('climate-chart');
    const svg = climateChart.querySelector('svg');
    const tooltip = document.getElementById('tooltip');
    const selectedValue = document.getElementById('selected-value');
    const realTimeClock = document.getElementById('real-time-clock');
    let data = [];
    const maxDataPoints = 100;
    const margin = { top: 20, right: 50, bottom: 30, left: 50 };
    let animationId;

    function initChart() {
        const width = climateChart.clientWidth;
        const height = climateChart.clientHeight;
        svg.setAttribute('viewBox', `0 0 ${width} ${height}`);

        createAxis('x', 0, height - margin.bottom, width - margin.right, height - margin.bottom);
        createAxis('y', margin.left, margin.top, margin.left, height - margin.bottom);

        ['temperature', 'humidity', 'ambiente'].forEach(key => {
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('class', `line ${key}`);
            path.setAttribute('data-line', key);
            svg.appendChild(path);
        });

        svg.addEventListener('mousemove', handleMouseMove);
        svg.addEventListener('mouseleave', handleMouseLeave);
        window.addEventListener('resize', debounce(updateChart, 250));

        let selectedType = null;

        document.querySelectorAll('.legend-label').forEach(label => {
            label.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                if (selectedType !== type) {
                    selectedType = type;
                    updateSelectedValue(type);
                }
            });
        });

        function updateSelectedValue(type) {
            if (data.length > 0) {
                const latestData = data[data.length - 1];
                const value = latestData[type].toFixed(1);
                const unit = type === 'humidity' ? '%' : '°C';
                let label = type.charAt(0).toUpperCase() + type.slice(1);
                if (type === 'temperature') {
                    label = 'Temperatura';
                } else if (type === 'humidity') {
                    label = 'Interior';
                }
                selectedValue.textContent = `${label}: ${value}${unit}`;
            }
        }

        function animateChart() {
            fetchData().then(newData => {
                if (newData) {
                    data.push(newData);
                    if (data.length > maxDataPoints) {
                        data.shift();
                    }
                    updateChart();
                    if (selectedType) {
                        updateSelectedValue(selectedType);
                    }
                }
                updateRealTimeClock();
                animationId = requestAnimationFrame(animateChart);
            });
        }

        animateChart();
    }

    function createAxis(type, x1, y1, x2, y2) {
        const axis = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        axis.setAttribute('x1', x1);
        axis.setAttribute('y1', y1);
        axis.setAttribute('x2', x2);
        axis.setAttribute('y2', y2);
        axis.setAttribute('class', 'axis');
        svg.appendChild(axis);
    }

    function fetchData() {
        return fetch('../PHP/get_climate_data.php')
            .then(response => response.json())
            .then(data => {
                return {
                    ...data,
                    time: new Date()
                };
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                return null;
            });
    }

    function updateChart() {
        const width = climateChart.clientWidth;
        const height = climateChart.clientHeight;
        svg.setAttribute('viewBox', `0 0 ${width} ${height}`);

        ['temperature', 'humidity', 'ambiente'].forEach(key => {
            const path = svg.querySelector(`.line.${key}`);
            path.setAttribute('d', getPath(key, width, height));
        });

        updateAxisLabels(width, height);
    }

    function getPath(key, width, height) {
        if (data.length === 0) return '';

        const xScale = (_, i) => i / (maxDataPoints - 1) * (width - margin.left - margin.right) + margin.left;
        const yScale = (value) => {
            const min = 0;
            const max = 100;
            return height - margin.bottom - (value - min) / (max - min) * (height - margin.top - margin.bottom);
        };

        return data.map((d, i) => `${i === 0 ? 'M' : 'L'} ${xScale(d, i)} ${yScale(d[key])}`).join(' ');
    }

    function updateAxisLabels(width, height) {
        svg.querySelectorAll('.axis-label').forEach(label => label.remove());

        for (let i = 0; i <= 10; i++) {
            const yLabel = document.createElementNS('http://www.w3.org/2000/svg', 'text');
            yLabel.setAttribute('x', margin.left - 5);
            yLabel.setAttribute('y', height - margin.bottom - i * (height - margin.top - margin.bottom) / 10);
            yLabel.setAttribute('text-anchor', 'end');
            yLabel.setAttribute('alignment-baseline', 'middle');
            yLabel.setAttribute('class', 'axis-label');
            yLabel.textContent = `${i * 10}%`;
            svg.appendChild(yLabel);
        }
    }

    function handleMouseMove(event) {
        const rect = svg.getBoundingClientRect();
        const x = event.clientX - rect.left - margin.left;
        const width = climateChart.clientWidth - margin.left - margin.right;
        const index = Math.round(x / width * (data.length - 1));

        if (index >= 0 && index < data.length) {
            const d = data[index];
            updateTooltip(d, event.clientX, event.clientY);
            updateDataPoint(index);
        }
    }

    function updateTooltip(d, x, y) {
        let tooltipContent = '';
        ['temperature', 'humidity', 'ambiente'].forEach(key => {
            const value = d[key].toFixed(1);
            const unit = key === 'humidity' ? '%' : '°C';
            let label = key.charAt(0).toUpperCase() + key.slice(1);
            if (key === 'temperature') {
                label = 'Temperatura';
            } else if (key === 'humidity') {
                label = 'Interior';
            }
            tooltipContent += `${label}: ${value}${unit}<br>`;
        });

        tooltip.style.display = 'block';
        tooltip.style.left = `${x}px`;
        tooltip.style.top = `${y - 60}px`;
        tooltip.innerHTML = tooltipContent;
    }

    function updateDataPoint(index) {
        svg.querySelectorAll('.data-point').forEach(point => point.remove());

        const d = data[index];
        const width = climateChart.clientWidth;
        const height = climateChart.clientHeight;

        ['temperature', 'humidity', 'ambiente'].forEach(key => {
            const xScale = (_, i) => i / (maxDataPoints - 1) * (width - margin.left - margin.right) + margin.left;
            const yScale = (value) => {
                const min = 0;
                const max = 100;
                return height - margin.bottom - (value - min) / (max - min) * (height - margin.top - margin.bottom);
            };

            const point = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            point.setAttribute('cx', xScale(d, index));
            point.setAttribute('cy', yScale(d[key]));
            point.setAttribute('r', '4');
            point.setAttribute('class', `data-point ${key}`);
            svg.appendChild(point);
        });
    }

    function handleMouseLeave() {
        tooltip.style.display = 'none';
        svg.querySelectorAll('.data-point').forEach(point => point.remove());
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function stopAnimation() {
        if (animationId) {
            cancelAnimationFrame(animationId);
        }
    }

    function updateRealTimeClock() {
        const now = new Date();
        realTimeClock.textContent = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }

    initChart();
});