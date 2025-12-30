<div
    class="modal show"
    id="{{$idModal}}"
    aria-modal="true"
    role="dialog"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input
                    type="hidden"
                    name="csrf-token"
                    value="{{csrf_token()}}"
                    id="csrf-token-{{$idModal}}"
                >
                <form
                    class="form"
                    novalidate
                    id="{{$idFormModal}}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <input type="hidden" id="{{$idDelete}}" name="{{$idDelete}}">
                    <button
                        aria-label="Close"
                        class="close"
                        data-bs-dismiss="modal"
                        type="button"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">{{$messageDelete}}</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button
                        aria-label="Close"
                        class="btn ripple btn-danger pd-x-25"
                        data-bs-dismiss="modal"
                        type="button"
                    >Salir</button>
                    <button class="btn btn-success-gradient" id="{{$idBtnDelete}}" type="button">
                        <i class="fa fa-delete"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>