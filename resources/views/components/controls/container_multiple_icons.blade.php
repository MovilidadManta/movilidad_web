<div class="{{$classContainerCards}}" id="{{$idContainerCards}}">
</div>
<script>
    window.addEventListener("load", function (event) {
        let multipleSelect = {{$multipleSelect}};
        let idContainerClass = document.getElementById('{{$idContainerCards}}');
        let valuesAsignados = [];      

        idContainerClass.renderCards = ((cards) => {
            idContainerClass.innerHTML = '';
            valuesAsignados = [];
            idContainerClass.dataset.value = "";
            cards.map( c => {
                idContainerClass.innerHTML += `
                <div class="{{$classCard}} {{$classCardClick}}" data-value="${c.value}">
                    <i class="{{$classCardIcon}} ${c.icon}"></i>
                    <span class="{{$classCardText}}">${c.text}</span>
                </div>
                `;
            });
            setElementsEventsClick();
        });

        idContainerClass.setActive = ((cards) => {
            let controlsCard = idContainerClass.querySelectorAll('.{{$classCardClick}}');
            controlsCard.forEach( a => a.classList.remove('{{$classCardActive}}'));
            idContainerClass.dataset.value = '';
            valuesAsignados = [];

            if(multipleSelect){
                cards.forEach(c => {
                    let documentSelect = idContainerClass.querySelector(`.{{$classCardClick}}[data-value="${c}"]`);
                    documentSelect.classList.add('{{$classCardActive}}');
                    valuesAsignados.push(c);
                });
            }else{
                let documentSelect = idContainerClass.querySelector(`.{{$classCardClick}}[data-value="${cards}"]`);
                documentSelect.classList.add('{{$classCardActive}}');
                valuesAsignados.push(cards);
            }

            idContainerClass.dataset.value = multipleSelect 
                                                    ? valuesAsignados 
                                                    : valuesAsignados.length == 0 
                                                        ? '' : valuesAsignados[0];
        });

        idContainerClass.clearValues = (() => {
            let controlsCard = idContainerClass.querySelectorAll('.{{$classCardClick}}');
            valuesAsignados = [];
            idContainerClass.dataset.value = "";

            controlsCard.forEach( a => a.classList.remove('{{$classCardActive}}'));
        });

        function setElementsEventsClick(){
            idContainerClass.dataset.value = '';
            let controlsCard = idContainerClass.querySelectorAll('.{{$classCardClick}}');
            controlsCard.forEach(c => {
                c.addEventListener('click', e => {
                    e.stopPropagation();
                    if(c.classList.contains('{{$classCardActive}}')){
                        c.classList.remove('{{$classCardActive}}');
                        valuesAsignados = valuesAsignados.filter( e => e != c.dataset.value);
                    } else{
                        if(!multipleSelect){
                            controlsCard.forEach( a => a.classList.remove('{{$classCardActive}}'));
                            valuesAsignados = [];
                        }
                        c.classList.add('{{$classCardActive}}');
                        valuesAsignados.push(c.dataset.value);
                    }

                    idContainerClass.dataset.value = multipleSelect 
                                                    ? valuesAsignados 
                                                    : valuesAsignados.length == 0 
                                                        ? '' : valuesAsignados[0];

                });
            });
        }
    });

    
</script>