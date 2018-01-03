<?php $path = "Μετρήσεις" ?>
<?php $active = "measure" ?>

@extends('layouts.admin')



@section('content')
    <br>

    @if(count($station_last_coll_of_measures) > 0)

        <div class="row text-center">

            <div class="col-sm-2"></div>
            <div class="col-sm-8">

                <h3>Προβολή όλων των μετρήσεων</h3>
                <hr><br>


                    <br>
                    <h4 class="text-center">Επιλέξτε σταθμό για να δείτε την πιο πρόσφατη συλλογή μετρήσεων.</h4>
                    <br>
                    @include('errors.errors')
                    <br>


                    {!! Form::open(['method' => 'POST', 'action' => 'AdminMeasuresController@store']) !!}


                    <div class="form-group">
                        {!! Form::label('station_id', 'Σταθμός:') !!}
                        {!! Form::select('station_id',  [$st->id => $st->name] + $collection , null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Εμφάνιση', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}


            </div>
        </div>

            <br><br><br>

            <div class="row">
                <div class="col-sm-1"></div>

                <div class="col-sm-10">
                    <div class="row">

                        @foreach($station_last_coll_of_measures as $measure)
                            <div class="col-lg-4 col-sm-6 mb-2">
                                <div class="card text-white bg-info o-hidden h-100">
                                    <div class="card-body">
                                        <div class="card-body-icon">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                        <div class="mr-5">
                                            <h4>{{ $measure->category->name }}:&nbsp;&nbsp;{{ number_format($measure->value) }} {{ $measure->symbol() }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-footer text-white clearfix z-1">
                                        <p>Καταγραφή:&nbsp;&nbsp;{{ strftime("%d %b %Y, %H:%M", strtotime($measure->created_at)) }}&nbsp;&nbsp;({{ $measure->created_at->diffForHumans() }})<br>
                                        <hr>
                                           Συλλογή μετρήσεων:&nbsp;&nbsp;{{ $measure->collection }} </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div><br>
                </div>

            </div>

    @else

        <div class="row text-center">

            <div class="col-sm-2"></div>
            <div class="col-sm-8">

                <h3>Προβολή όλων των μετρήσεων</h3>
                <hr><br>
                <div class="alert alert-warning">
                    <h3 class="text-center">Δεν υπάρχει καμία μέτρηση.</h3>
                </div>
            </div>
        </div>


    @endif



@endsection