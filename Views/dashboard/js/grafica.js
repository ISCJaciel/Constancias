// Configuración inicial del gráfico con Chart.js
const ctx = document.getElementById('encuestaChart').getContext('2d');
let encuestaChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Malo', 'Regular', 'Bueno', 'Excelente'],
        datasets: [{
            label: 'Número de Respuestas',
            data: [0, 0, 0, 0], // Datos iniciales
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Función para actualizar el gráfico con datos desde el servidor
function updateChart(question) {
    fetch(`../../Models/datos_grafica.php?pregunta=${question}`)
        .then(response => response.json())
        .then(data => {
            encuestaChart.data.datasets[0].data = [
                data.malo || 0,
                data.regular || 0,
                data.bueno || 0,
                data.excelente || 0
            ];
            encuestaChart.update();
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Evento de cambio en el select
document.getElementById('preguntaSelect').addEventListener('change', function() {
    const selectedQuestion = this.value;
    updateChart(selectedQuestion);
});

// Inicializar el gráfico con la primera opción seleccionada
updateChart('pregunta1'); // Ajusta esto según tus necesidades iniciales

function logout() {
    // Cambiar la ubicación actual del navegador a la página principal
    window.location.href = "../home/index.php"; // Cambia "index.php" por la URL de tu página principal
}