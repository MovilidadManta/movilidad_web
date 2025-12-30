function set_type_input(element, type) {
    let input = document.getElementById(element);
    input.addEventListener('input', (e) => {
        switch (type) {
            case 'number': // Solo números enteros
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                break;
            case 'decimal': // Números con decimales
                e.target.value = e.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
                break;
            case 'ipv4': // Formato IPv4
                let value = e.target.value;

                // Limitar caracteres a números y puntos
                value = value.replace(/[^0-9.]/g, '');

                // Dividir en segmentos por puntos
                let segments = value.split('.');

                // Limitar a cuatro segmentos y validar cada segmento
                segments = segments.slice(0, 4).map(segment => {
                    // Limitar cada segmento a un máximo de tres dígitos
                    segment = segment.slice(0, 3);

                    // Si el valor del segmento supera 255, ajustarlo a 255
                    if (parseInt(segment) > 255) {
                        segment = '255';
                    }

                    return segment;
                });

                // Reconstruir el valor del input, asegurando un solo punto entre segmentos
                e.target.value = segments.join('.');

                // Evitar que termine con un punto
                if (e.target.value.endsWith('.') && segments.length === 5) {
                    e.target.value = e.target.value.slice(0, -1);
                }
                break;
            default:
                break;
        }
    });
}