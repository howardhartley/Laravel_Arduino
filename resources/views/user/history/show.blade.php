<?php $path = "Ιστορικό" ?>
<?php $active = "history" ?>


@extends('layouts.user')



@section('content')
    <br>

    @if(count($pag_num_of_collections) > 0)


        <div class="row text-center">

            <div class="col-sm-2"></div>
            <div class="col-sm-8">

                <h3>Προβολή όλου του ιστορικού μετρήσεων</h3>
                <hr><br>



                <br>
                <h4 class="text-center">Επιλέξτε σταθμό για να δείτε το ιστορικό των μετρήσεων.</h4>
                <br>
                @include('errors.errors')
                <br>


                {!! Form::open(['method' => 'POST', 'action' => 'UserHistoryController@store']) !!}


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

        <br><br>

        <div class="row">
            <div class="col-sm-2"></div>

            <div class="col-sm-8 text-center">


                @if(Session::has('delete'))
                    <br>
                    <div class="alert alert-success">
                        {{ session('delete') }}
                    </div><br>
                @endif

                <div style="overflow-x:auto;">
                    <table class="table table-striped table-responsive">

                        <thead>
                        <tr>
                            <th>Συλογή μετρήσεων</th>
                            <th>Σύνολο κατηγοριών στην μέτρηση</th>
                            <th>Ημ. δημιουργίας</th>

                        </tr>
                        </thead>
                        <tbody>


                        @foreach($pag_num_of_collections as $measure)

                            @if(count($st->measures()->where('collection', $measure)->get()))
                                <tr>
                                    <td><a href=" {{ route('user.history.show.measures', $measure) }} " title="Κάνε κλίκ για προβολή της συλλογής">{{ $measure }}</a></td>
                                    <td>{{ count($st->measures()->where('collection', $measure)->get()) }}</td>
                                    <td>{{ $st->measures()->where('collection', $measure)->first()->created_at }} ({{ $st->measures()->where('collection', $measure)->first()->created_at->diffForHumans() }})</td>
                                    <td>@if($st->user_id == Auth::user()->id)
                                            {!! Form::open(['method' => 'DELETE', 'action' => ['UserHistoryController@destroy', $measure]]) !!}

                                            <div class="form-group">
                                                {!! Form::submit('Διαγραφή', ['class' => 'btn btn-danger']) !!}
                                            </div>

                                            {!! Form::close() !!}
                                        @endif

                                    </td>
                                </tr>

                            @endif

                        @endforeach

                        </tbody>

                    </table>
                </div>
            </div>

        </div>

        <div class="form-group">
            {{ $pag_num_of_collections->render()  }}
            <br>
        </div>



    @else

        <div class="row text-center">

            <div class="col-sm-2"></div>
            <div class="col-sm-8">

                <h3>Προβολή όλου του ιστορικού μετρήσεων</h3>
                <hr><br>
                <div class="alert alert-warning">
                    <h3 class="text-center">Δεν υπάρχει καμία μέτρηση.</h3>
                </div>
            </div>
        </div>


    @endif





@endsection


@section('footer')

    <script>

        $(document).ready(function(){
            $('ul.pagination').addClass('justify-content-center');
            $('ul.pagination li').addClass('page-item');
            $('ul.pagination li a, ul.pagination li span').addClass('page-link');
        })

    </script>

@endsection