<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Διαγραφή λογαριασμού</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Είστε σίγουρος ότι θέλετε να διαγράψετε οριστικά τον λογαριασμό σας;
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary delete-form-margin delete-form-margin-red" data-dismiss="modal">Ακύρωση</button>

                {!! Form::open(['method' => 'DELETE', 'action' => ['AdminProfileController@destroy', $user->id]]) !!}

                    {!! Form::submit('Διαγραφή λογαριασμού', ['class' => 'btn btn-danger']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>