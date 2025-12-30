
function custom_search_input(element, opts) {
    let height = 0;
    let heightButtonSearch = 0;
    let input = document.getElementById(element);
    let div = document.createElement('div');
    let span = document.createElement('span');
    div.id = `div-options-${input.id}`;
    div.style.position = 'absolute';
    div.style.maxHeight = '400px';
    div.style.overflowY = 'scroll'
    div.classList.add("dropdown-menu");
    let inFocus = false;
    span.style.position = 'absolute';
    let findInput = false;

    if (input.tagName.toUpperCase() != 'INPUT') {
        console.log(`el elemento ${element} no se puede utilizar para como campo de busqueda`);
        return;
    }

    if ((typeof opts).toUpperCase() != 'OBJECT') {
        console.log(`No es un tipo valido`);
        return;
    }

    if (!opts.formatResult) {
        console.log('no hay clave formatResult');
        return;
    }

    if (!opts.search) {
        console.log('no hay clave search');
        return;
    }

    let parentInput = input.parentNode;
    parentInput.style.position = 'relative';


    [...parentInput.children].map(e => {
        if (!findInput) {
            height += e.offsetHeight;
            heightButtonSearch += e.offsetHeight;
            if (e == input) {
                findInput = true;
                heightButtonSearch -= e.offsetHeight;
            }
        }
    });

    div.style.top = `${height + 1}px`;
    div.style.left = 0;
    div.style.paddingLeft = window.getComputedStyle(parentInput, null).getPropertyValue('padding-left');
    div.style.paddingRight = window.getComputedStyle(parentInput, null).getPropertyValue('padding-right');
    div.style.width = `100%`;
    div.style.border = 'none';

    span.style.top = `${heightButtonSearch + 3}px`;
    span.style.right = 0;
    span.style.height = `${input.offsetHeight}px`;
    span.style.lineHeight = `${input.offsetHeight + 2}px`;
    span.style.cursor = 'pointer';
    span.style.paddingLeft = window.getComputedStyle(parentInput, null).getPropertyValue('padding-left');
    span.style.paddingRight = window.getComputedStyle(parentInput, null).getPropertyValue('padding-right');
    span.style.background.hob

    if (opts.searchButton && opts.searchButton.display) {
        span.innerHTML = `<i class="${opts.searchButton.icon}"></i>`;
        span.style.width = `${opts.searchButton.width}px`;
        span.style.right = window.getComputedStyle(parentInput, null).getPropertyValue('padding-right');
    }

    input.insertAdjacentElement("afterend", div);
    if (opts.searchButton && opts.searchButton.display) {
        input.insertAdjacentElement("afterend", span);
        span.addEventListener('click', () => {
            opts.searchButton.eventClick();
        });
    }


    span.addEventListener("mouseenter", function (event) {
        event.target.style.backgroundColor = "#ccc";
    }, false);
    span.addEventListener("mouseleave", function (event) {
        event.target.style.backgroundColor = "";
    }, false);

    input.addEventListener('keydown', e => {


        let valuesItems = [...div.querySelectorAll('a.dropdown-item')];
        if (e.key == 'ArrowUp') {
            if (!div.classList.contains('show'))
                return;
            let changeValue = false;
            valuesItems.map((v, i) => {
                if (v.classList.contains('active') && !changeValue) {
                    v.classList.remove('active');
                    if (i == 0)
                        i = valuesItems.length;
                    valuesItems[i - 1].classList.add('active');
                    changeValue = true;
                }
            });
        } else if (e.key == 'ArrowDown') {
            if (!div.classList.contains('show'))
                return;
            let changeValue = false;
            valuesItems.map((v, i) => {
                if (v.classList.contains('active') && !changeValue) {
                    v.classList.remove('active');
                    if (i == valuesItems.length - 1)
                        i = -1;
                    valuesItems[i + 1].classList.add('active');
                    changeValue = true;
                }
            });
        } else if (e.key == 'Enter') {
            changeValueInput();
            e.preventDefault();
        }

    });

    input.addEventListener('keyup', e => {
        if (!input.readOnly && e.key != 'ArrowUp' && e.key != 'ArrowDown' && e.key != 'Enter') {
            div.classList.remove("show");
            div.innerHTML = "";
            e.target.dataset.value = '';

            if (e.target.value.trim() != "") {
                let value = e.target.value.trim();
                setTimeout(() => {
                    if (e.target.value.trim() == value.trim()) {
                        div.innerHTML = `<a class="dropdown-item" style="overflow: hidden; text-overflow: ellipsis; border: 1px solid #e1e5ef; white-space: normal;">${input.dataset.wait_search ? input.dataset.wait_search : 'Espere...'}</a>`;
                        opts.search(value, getResults);
                        div.classList.add("show");
                    }
                }, 750);
            }
        }
    });



    function getResults(data) {
        div.innerHTML = "";

        [...data].map((v, i) => {
            let format = opts.formatResult(v);
            let datasetsList = "";
            if (opts.datasets) {
                const datasetReg = opts.datasets(v);
                Object.keys(datasetReg).forEach(function (key) {
                    datasetsList += `data-${key}="${datasetReg[key]}" `;
                });
            }

            div.innerHTML += `<a class="dropdown-item ${i == 0 ? 'active' : ''}" ${datasetsList} tabindex="-1" data-text = '${format.text}' data-value='${format.value}' style="overflow: hidden; text-overflow: ellipsis; border: 1px solid #e1e5ef; white-space: normal;">${format.html}</a>`;
        });
        if (data.length == 0) {
            div.innerHTML = `<a class="dropdown-item" style="overflow: hidden; text-overflow: ellipsis; border: 1px solid #e1e5ef; white-space: normal;">${input.dataset.noresults_text ? input.dataset.noresults_text : 'Sin Resultados'}</a>`;
        } else {
            eventsItemsList();
        }
        div.classList.add("show");
    }

    function eventsItemsList() {
        let valuesInput = div.querySelectorAll('a.dropdown-item');
        [...valuesInput].map(v => {
            v.addEventListener('mouseover', (e) => {
                let activeInput = div.querySelector('a.dropdown-item.active');
                activeInput.classList.remove('active');
                e.target.classList.add('active');
            });
            v.addEventListener('click', (e) => {
                changeValueInput();
            })
        });
    }

    function changeValueInput() {
        let activeInput = div.querySelector('a.dropdown-item.active');
        if (activeInput) {
            input.dataset.value = activeInput.dataset.value;
            input.dataset.text = activeInput.dataset.text;
            input.value = activeInput.dataset.text;
            for (const [name, value] of Object.entries(activeInput.dataset)) {
                if (name != 'value' && name != 'text') {
                    input.dataset[name] = value;
                }
            }
            div.classList.remove("show");
            let event = new Event("changeAsing", { bubbles: true });
            input.dispatchEvent(event);
            input.blur();
        }
    }

    input.addEventListener('focus', (e) => {
        if (!input.readOnly && input.dataset.value)
            input.value = "";
    });

    input.addEventListener('blur', (e) => {
        if (!inFocus)
            div.classList.remove("show");
        if (input.dataset.value)
            input.value = input.dataset.text;
    });

    div.addEventListener('mouseover', (e) => {
        inFocus = true;
    });

    div.addEventListener('mouseout', (e) => {
        inFocus = false;
    });


}