let clone = null;
let offsetX = 0, offsetY = 0;
let preview = null;

//Lee los elementos que pueden ser arrastrados
function readDraggagles() {
    let draggables = document.querySelectorAll('.draggable');
    draggables.forEach(draggable => {
        if (!draggable.classList.contains('drag_item')) {
            const handle = draggable.querySelector(':scope > .drag-handle');
            if (handle && !handle._hasMouseDownListener) {
                handle.addEventListener('mousedown', handleMouseDown);
                handle._hasMouseDownListener = true;
            }
        } else {
            if (!draggable._hasMouseDownListener) {
                draggable.addEventListener('mousedown', handleMouseDown);
                draggable._hasMouseDownListener = true;
            }
        }
    });
}

function handleMouseDown(e) {
    const draggable = e.target.closest('.draggable');
    if (!draggable) return;
    if (!draggable.classList.contains('drag_item') && !e.target.closest('.drag-handle')) return;
    if (!draggable.classList.contains('dropzone')) {
        clone = draggable.cloneNode(true);
        clone.classList.add('dragging');
        clone.style.width = `${draggable.offsetWidth}px`;
        document.body.appendChild(clone);

        offsetX = e.clientX - draggable.getBoundingClientRect().left;
        offsetY = e.clientY - draggable.getBoundingClientRect().top;

        moveAt(e.pageX, e.pageY);

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);

        draggable.classList.add('dragging-original');
    }
}

function onMouseMove(e) {
    moveAt(e.pageX, e.pageY);

    const elements = document.elementsFromPoint(e.clientX, e.clientY);
    let dropzone = null;
    for (const element of elements) {
        if (element.classList.contains('dropzone')) {
            dropzone = element;
            break;
        }
    }

    if (dropzone) {
        if (!preview) {
            preview = createPreview();
        }
        let beforeElement = null;
        const children = Array.from(dropzone.children).filter(child => child !== preview);
        for (const child of children) {
            const rect = child.getBoundingClientRect();
            if (e.clientY < rect.top + rect.height / 2) {
                beforeElement = child;
                break;
            }
        }
        if (beforeElement) {
            dropzone.insertBefore(preview, beforeElement);
        } else {
            dropzone.appendChild(preview);
        }
    } else {
        if (preview && preview.parentElement) {
            preview.parentElement.removeChild(preview);
        }
        preview = null;
    }
}

function onMouseUp(e) {
    document.removeEventListener('mousemove', onMouseMove);
    document.removeEventListener('mouseup', onMouseUp);

    const original = document.querySelector('.dragging-original');

    if (preview && preview.parentElement) {
        if (original.classList.contains('drag_item')) {
            const newElement = createContainerPlantilla(original.dataset.content);
            preview.parentElement.insertBefore(newElement, preview);
            configureContainersFromPlantilla(newElement.dataset.type, newElement.dataset.cod);
            preview.remove();
            preview = null;
            clone.remove();
            readDraggagles();
        }
        else {
            preview.parentElement.insertBefore(original, preview);
            preview.remove();
            preview = null;
        }
    }

    let clonesElements = document.querySelectorAll('.dragging');

    clonesElements.forEach(c => {
        c.remove();
    });

    if (original) {
        original.classList.remove('dragging-original');
    }
}

function moveAt(pageX, pageY) {
    if (clone) {
        clone.style.left = `${pageX - offsetX}px`;
        clone.style.top = `${pageY - offsetY}px`;
    }
}

//Crea  preview dentro del contenedor
function createPreview() {
    const preview = document.createElement('div');
    preview.classList.add('preview');
    return preview;
}

