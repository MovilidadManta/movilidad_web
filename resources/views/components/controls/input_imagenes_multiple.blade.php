<style>

    .dropzone_{{$idInputImage}} {
        border: 2px dashed #ccc;
        border-radius: 12px;
        padding: 30px;
        background-color: #fff;
        text-align: center;
        color: #666;
        cursor: pointer;
        transition: border-color 0.3s;
        position: relative;
    }

    .dropzone_{{$idInputImage}}:hover {
        border-color: #007bff;
    }

    .dropzone-content_{{$idInputImage}} {
        pointer-events: none;
    }

    .preview_{{$idInputImage}} {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-top: 20px;
    }

    .image-container_{{$idInputImage}} {
        position: relative;
        width: 120px;
    }

    .image-container_{{$idInputImage}} img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        cursor: zoom-in;
    }

    .image-container_{{$idInputImage}} button {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 11px;
        cursor: pointer;
    }

    .clear-all_{{$idInputImage}} {
        position: absolute;
        top: 8px;
        right: 8px;
        background: transparent;
        border: none;
        color: #888;
        font-size: 18px;
        cursor: pointer;
    }

    .clear-all_{{$idInputImage}}:hover {
        color: #d00;
    }

    /* Modal */
    .modal_{{$idInputImage}} {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    .modal_{{$idInputImage}} img {
        max-width: 70%;
        max-height: 70%;
        border-radius: 10px;
        box-shadow: 0 0 20px #000;
    }

    .modal-close_{{$idInputImage}} {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }
</style>

<div id="dropzone_{{$idInputImage}}" class="dropzone_{{$idInputImage}}">
    <div id="dropzone-content_{{$idInputImage}}" class="dropzone-content_{{$idInputImage}}">
        <p>Arrastra y suelta tus imágenes aquí o haz clic</p>
    </div>
    <input type="file" id="{{$idImagenes}}" name="{{$nameImagenes}}" accept="image/*" multiple hidden>
    <button id="btnClearAll_{{$idInputImage}}" class="clear-all_{{$idInputImage}}" title="Eliminar todas las imágenes" style="display: none;">×</button>
    <div id="preview_{{$idInputImage}}" class="preview_{{$idInputImage}}"></div>
</div>

<!-- Modal de preview -->
<div id="modal_{{$idInputImage}}" class="modal_{{$idInputImage}}">
    <span id="modalClose_{{$idInputImage}}" class="modal-close_{{$idInputImage}}">&times;</span>
    <img id="modalImg_{{$idInputImage}}" src="">
</div>

<script>
    const dropzone = document.getElementById('dropzone_{{$idInputImage}}');
    const dropzoneContent = document.getElementById('dropzone-content_{{$idInputImage}}');
    const input = document.getElementById('{{$idImagenes}}');
    const preview = document.getElementById('preview_{{$idInputImage}}');
    const btnClearAll = document.getElementById('btnClearAll_{{$idInputImage}}');

    const modal = document.getElementById('modal_{{$idInputImage}}');
    const modalImg = document.getElementById('modalImg_{{$idInputImage}}');
    const modalClose = document.getElementById('modalClose_{{$idInputImage}}');

    let archivosSeleccionados = [];

    dropzone.addEventListener('click', () => input.click());

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.style.borderColor = '#007bff';
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.style.borderColor = '#ccc';
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.style.borderColor = '#ccc';
        agregarArchivos(e.dataTransfer.files);
    });

    input.addEventListener('change', () => {
        agregarArchivos(input.files);
    });

    btnClearAll.addEventListener('click', (event) => {
        event.stopPropagation();
        archivosSeleccionados = [];
        renderizarPrevisualizacion();
    });

    function agregarArchivos(nuevosArchivos) {
        for (let archivo of nuevosArchivos) {
            if (archivo.type.startsWith('image/')) {
                archivosSeleccionados.push(archivo);
            }
        }
        renderizarPrevisualizacion();
    }

    function renderizarPrevisualizacion() {
        preview.innerHTML = '';

        if (archivosSeleccionados.length === 0) {
            dropzoneContent.style.display = 'block';
            btnClearAll.style.display = 'none';
            return;
        }

        dropzoneContent.style.display = 'none';
        btnClearAll.style.display = 'block';

        archivosSeleccionados.forEach((archivo, index) => {
            const reader = new FileReader();
            reader.onload = () => {
                const container = document.createElement('div');
                container.classList.add('image-container_{{$idInputImage}}');

                const img = document.createElement('img');
                img.src = reader.result;

                // 🔒 Detener propagación para que no abra el input
                img.onclick = (event) => {
                    event.stopPropagation();
                    modal.style.display = 'flex';
                    modalImg.src = img.src;
                };

                const btn = document.createElement('button');
                btn.textContent = '×';
                btn.onclick = (event) => {
                    event.stopPropagation();
                    archivosSeleccionados.splice(index, 1);
                    renderizarPrevisualizacion();
                };

                container.appendChild(img);
                container.appendChild(btn);
                preview.appendChild(container);
            };
            reader.readAsDataURL(archivo);
        });
    }

    // Cerrar modal
    modalClose.onclick = () => {
        modal.style.display = 'none';
        modalImg.src = '';
    };

    modal.onclick = (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            modalImg.src = '';
        }
    };

    input.getImagenes =  function (){
        return archivosSeleccionados
    };

    input.clearImagenes =  function (){
        archivosSeleccionados = [];
        input.value = '';
        btnClearAll.dispatchEvent(new Event("click"));
    };
</script>