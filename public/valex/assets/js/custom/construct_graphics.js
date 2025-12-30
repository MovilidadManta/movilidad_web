function generarColorHexadecimalAleatorio(i) {
    // Generar un valor hexadecimal aleatorio de 6 dígitos
    let color = '#' + Math.floor(Math.random() * 16777215).toString(16);
    if (i == 0) color = '#3C6494';
    if (i == 1) color = '#963D3B';
    if (i == 2) color = '#799244';
    if (i == 3) color = '#634D7E';
    if (i == 4) color = '#39869B';
    if (i == 5) color = '#C27535';

    return color;
}

const optionpie = {
    maintainAspectRatio: false,
    responsive: true,
    plugins: {
        legend: {
            display: true,
        }
    },
    animation: {
        animateScale: true,
        animateRotate: true
    }
};

/** PIE */
function prepareGraphicPie(id) {
    let myPieChart;
    const ctxId = document.getElementById(id);
    return {
        id: ctxId,
        render: function (datapie) {
            if (myPieChart) {
                myPieChart.destroy();
            }
            myPieChart = new Chart(ctxId, {
                type: 'pie',
                data: datapie,
                options: optionpie
            });
        }
    };
}
/** FIN PIE */