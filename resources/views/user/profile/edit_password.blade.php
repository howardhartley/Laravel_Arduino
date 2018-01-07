<?php $path = "Προφίλ" ?>
<?php $active = "profile" ?>

@extends('layouts.user')



@section('content')
    <br>

    <div class="row">

        <div class="col-sm-2"></div>
        <div class="col-sm-8 text-center">


            <h3>Αλλαγή κωδικού πρόσβασης</h3>
            <hr>

            @if(Session::has('no_update_password'))
                <div class="alert alert-danger">
                    {{ session('no_update_password') }}
                </div>
            @endif

            @include('errors.errors')
            <br>


            {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserProfileController@update_password', $user->id]]) !!}


            <div class="form-group">
                {!! Form::label('password', 'Κωδικός πρόσβασης:') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('new_password', 'Νέος κωδικός πρόσβασης:') !!}
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('new_password_confirmation', 'Επιβεβαίωση κωδικού:') !!}
                {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Ανανέωση', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

        </div>


    </div>


@endsection