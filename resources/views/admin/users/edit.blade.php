<?php $path = "Χρήστες" ?>
<?php $active = "user" ?>

@extends('layouts.admin')



@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-2"></div>
        <div class="col-sm-8">

            <h3>Επεξεργασία χρήστη</h3>
            <hr>


            @include('errors.errors')
            <br>
            <div style="overflow-x:auto;">
                <table class="table table-striped table-responsive">

                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Όνομα</th>
                        <th>Επώνυμο</th>
                        <th>Email</th>
                        <th>Κατηγορία</th>
                        <th>Ενεργός</th>
                        <th>Επιβεβαιωμένος</th>
                        <th>Σταθμοί</th>
                        <th>Ημ. δημιουργίας</th>
                        <th>Ημ. ανανέωσης</th>

                    </tr>
                    </thead>
                    <tbody>


                    <tr>
                        <td> {{ $user->id }} </td>
                        <td> {{ $user->name }}</td>
                        <td> {{ $user->surname }}</td>
                        <td> {{ $user->email }}</td>
                        <td> {{ $user->role->name }}</td>
                        <td> {{ $user->is_active == 1 ? 'Ναι' : 'Οχι' }}</td>
                        <td> {{ $user->confirmed == 1 ? 'Ναι' : 'Οχι' }}</td>
                        <td>{{ count($user->stations()->get()) > 0 ? count($user->stations()->get()) : 'Κανένας σταθμός'}}</td>
                        <td> {{ $user->created_at->diffForHumans() }}</td>
                        <td> {{ $user->updated_at->diffForHumans() }}</td>

                        </tr>


                    </tbody>
                </table>
            </div>

            {!! Form::model($user, ['method' => 'PATCH', 'action' => ['AdminUsersController@update', $user->id]]) !!}


            <div class="form-group">
                {!! Form::label('role_id', 'Κατηγορία:') !!}
                {!! Form::select('role_id', $roles, null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('is_active', 'Ενεργός:') !!}
                {!! Form::select('is_active', [1 => 'Ναι', 0 => 'Οχι'] , null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Ανανέωση', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}

        </div>


    </div>






@endsection