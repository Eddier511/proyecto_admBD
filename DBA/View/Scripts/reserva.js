// View/Scripts/reserva.js

/**
 * Maneja el formulario de reservas
 */
document.addEventListener('DOMContentLoaded', function() {
    const formReserva = document.getElementById('formReserva');
    const errorMessage = document.getElementById('error-message');
    
    if (formReserva) {
        formReserva.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const action = document.activeElement.dataset.action;
            
            fetch('../controller/ReservaController.php', {
                method: 'POST',
                body: new URLSearchParams(formData) + '&action=' + action
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (action === 'consultar_disponibilidad') {
                        actualizarDropdownHabitaciones(data.habitaciones);
                    } else if (action === 'crear_reserva') {
                        window.location.href = data.redirect;
                    }
                } else {
                    mostrarError(data.message);
                }
            })
            .catch(error => {
                mostrarError('Error al comunicarse con el servidor');
                console.error('Error:', error);
            });
        });
    }

    /**
     * Actualiza el dropdown de habitaciones
     */
    function actualizarDropdownHabitaciones(habitaciones) {
        const dropdown = document.getElementById('id_habitacion');
        dropdown.innerHTML = '<option value="">Seleccione una habitación</option>';
        
        habitaciones.forEach(hab => {
            const option = document.createElement('option');
            option.value = hab.ID_HABITACION;
            option.textContent = `${hab.TIPO} - $${hab.PRECIO_NOCHE}/noche (Total: $${hab.TOTAL_ESTANCIA})`;
            dropdown.appendChild(option);
        });
        
        dropdown.disabled = false;
        document.querySelector('button[name="reservar"]').disabled = false;
    }

    /**
     * Muestra mensajes de error
     */
    function mostrarError(mensaje) {
        errorMessage.textContent = mensaje;
        errorMessage.style.display = 'block';
    }
});