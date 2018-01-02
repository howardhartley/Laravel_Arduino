<?php $path = "Χρήστες" ?>
<?php $active = "user" ?>

@extends('layouts.admin')



@section('content')
    <br>

    <div class="row">

        <div class="col-sm-3"></div>
        <div class="col-sm-6 text-center">

            <h3>Δημιουργία χρήστη</h3>
            <hr>


            @include('errors.errors')
            <br>

            {!! Form::open(['method' => 'POST', 'action' => 'AdminUsersController@store']) !!}

            <div class="form-group">
                {!! Form::label('name', 'Όνομα:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('surname', 'Επίθετο:') !!}
                {!! Form::text('surname', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::email('email', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Κωδικός πρόσβασης:') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('role_id', 'Κατηγορία:') !!}
                {!! Form::select('role_id', ['' => 'Διαλέξτε κατηγορία'] + $roles, null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::submit('Δημιουργία', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

        </div>



    </div><br>






@endsection