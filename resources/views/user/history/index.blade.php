<?php $path = "Ιστορικό" ?>
<?php $active = "history" ?>


@extends('layouts.user')



@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-2"></div>
        <div class="col-sm-8">


            <h3>Προβολή όλου του ιστορικού μετρήσεων</h3>
            <hr><br>

            @if(count($collection) > 0)

                <br>
                <h4 class="text-center">Επιλέξτε σταθμό για να δείτε το ιστορικό των μετρήσεων.</h4>
                <br>
                @include('errors.errors')
                <br>


                {!! Form::open(['method' => 'POST', 'action' => 'UserHistoryController@store']) !!}


                <div class="form-group">
                    {!! Form::label('station_id', 'Σταθμός:') !!}
                    {!! Form::select('station_id', ['' => 'Επιλέξτε σταθμό'] + $collection , null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Εμφάνιση', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}



            @else

                <div class="alert alert-warning">
                    <h3 class="text-center">Δεν υπάρχουν μετρήσεις.</h3>
                </div>

            @endif



        </div>

    </div>



@endsection