<?php $path = "Ιστορικό" ?>
<?php $active = "history" ?>


@extends('layouts.user')



@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-1"></div>
        <div class="col-sm-10">

            <h3>Προβολή της συλλογής:  {{ $collection }}</h3>
            <hr><br>
            <h5>Σταθμός:&nbsp;&nbsp;{{ $station_name }}</h5>
            <hr><br><br>
            <div class="row">
                @foreach($measures as $measure)
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
            </div>
            <br><br><br><br>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href=" {{ route('user.history.show', $measures->first()->station_id) }} " class="btn btn-primary">Επιστροφή&nbsp;&nbsp;&nbsp;<i class="fa fa-undo" aria-hidden="true"></i></a>
                </div>
            </div>

        </div>
    </div>
    <br>





@endsection