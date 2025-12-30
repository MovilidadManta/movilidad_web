function configure_select_two_dates(dateStart, dateEnd) {
    const inputDateInit = document.getElementById(dateStart);
    const inputDateEnd = document.getElementById(dateEnd);

    inputDateInit.addEventListener('change', (e) => {
        let dateParse = Date.parse(e.target.value);
        let dateParseFin = Date.parse(inputDateEnd.value);

        inputDateEnd.setAttribute('min', e.target.value);

        if (dateParseFin < dateParse) {
            inputDateEnd.value = e.target.value;
        }
    });

    inputDateEnd.addEventListener('change', (e) => {
        let dateParse = Date.parse(e.target.value);
        let dateParseInicio = Date.parse(inputDateInit.value);

        if (dateParse < dateParseInicio) {
            e.target.value = inputDateInit.value;
        }
    });


    function configureInitialDate(inputDateInit, inputDateEnd) {
        const fecha = new Date();
        let mes = fecha.getMonth() + 1; //obteniendo mes
        let dia = fecha.getDate(); //obteniendo dia
        const ano = fecha.getFullYear(); //obteniendo año
        if (dia < 10)
            dia = '0' + dia; //agrega cero si el menor de 10
        if (mes < 10)
            mes = '0' + mes //agrega cero si el menor de 10

        inputDateInit.value = ano + "-" + mes + "-" + dia;
        inputDateEnd.value = ano + "-" + mes + "-" + dia;
    }

    configureInitialDate(inputDateInit, inputDateEnd);
}