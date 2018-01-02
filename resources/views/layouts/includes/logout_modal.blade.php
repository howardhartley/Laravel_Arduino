<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Αποσύνδεση</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Είστε σίγουρος ότι θέλετε να πραγματοποιήσετε αποσύνδεση απο το σύστημα;
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
                <a class="btn btn-primary" href=" {{ url('/logout') }} ">Αποσύνδεση</a>
            </div>
        </div>
    </div>
</div>