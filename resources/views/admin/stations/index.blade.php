<?php $path = "Σταθμοί" ?>
<?php $active = "station" ?>

@extends('layouts.admin')



@section('content')
    <br>

    <div class="row text-center">


        <div class="col-sm-12">

            <h3>Προβολή όλων των σταθμών</h3>
            <hr><br>

            @if(count($stations) > 0)

                    <div style="overflow-x:auto;">
                        <table class="table table-striped table-responsive">

                            @if(Session::has('complete'))
                                <div class="alert alert-success">
                                    {{ session('complete') }}
                                </div>
                            @endif

                            @if(Session::has('delete'))
                                <div class="alert alert-success">
                                    {{ session('delete') }}
                                </div>
                            @endif

                            @if(Session::has('update'))
                                <div class="alert alert-success">
                                    {{ session('update') }}
                                </div>
                            @endif

                            @if(Session::has('nothing'))
                                <div class="alert alert-warning">
                                    {{ session('nothing') }}
                                </div>
                            @endif

                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Όνομα</th>
                                <th>Μοναδικός κωδικός</th>
                                <th>Ιδιοκτησία</th>
                                <th>Σύνολο κατηγοριών</th>
                                <th>Συλλογές μετρήσεων</th>
                                <th>Ενεργός</th>
                                <th>Προβολή</th>
                                <th>Τοποθεσία</th>
                                <th>Περιγραφή</th>
                                <th>Ημ. δημιουργίας</th>
                                <th>Ημ. ανανέωσης</th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach($stations as $station)
                                <?php
                                $num_of_collections = 0;

                                if(count($station->measures()->get())){
                                   $collection_series_min = $station->measures()->min('collection');
                                   $collection_series_max = $station->measures()->max('collection');

                                   for($i = $collection_series_min; $i <= $collection_series_max; $i++){
                                       if(count($station->measures()->where('collection', $i)->get())){
                                           $num_of_collections++;
                                       }
                                   }
                               }

                                ?>

                                <tr @if( $station->user->id == Auth::user()->id ) class="table-success" @endif>
                                    <td> {{ $station->id }} </td>
                                    <td><a title="κάνε κλικ για επεξεργασία" href=" {{ route('admin.stations.edit', $station->id) }} ">{{ $station->name }}</a> </td>
                                    <td>{{ $station->unique }}</td>
                                    <td>{{ $station->user->email }}</td>
                                    <td>{{ count($station->categories()->get()) > 0 ? count($station->categories()->get()) : 'Καμία κατηγορία' }}</td>
                                    <td>{{ $num_of_collections > 0 ? $num_of_collections : 'Καμία συλλογή' }}</td>
                                    <td>{{ $station->is_active == 1 ? 'Ναι' : 'Οχι' }}</td>
                                    <td>{{ $station->is_private == 1 ? 'Ιδιωτικός' : 'Δημόσιος' }}</td>
                                    <td>{{ $station->location }}</td>
                                    <td>{{ str_limit($station->description, 15) }}</td>
                                    <td>{{ $station->created_at->diffForHumans() }}</td>
                                    <td>{{ $station->updated_at->diffForHumans() }}</td>
                                    <td>@if( Auth::user()->id == 1 || (Auth::user()->id != 1 && $station->user->id != 1) )

                                            {!! Form::open(['method' => 'DELETE', 'action' => ['AdminStationsController@destroy', $station->id]]) !!}

                                            <div class="form-group">
                                                {!! Form::submit('Διαγραφή', ['class' => 'btn btn-danger']) !!}
                                            </div>

                                            {!! Form::close() !!}

                                        @else

                                            <div class="form-group"><br></div>

                                        @endif

                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>


            @else

                <div class="alert alert-warning">
                    <h3 class="text-center">Δεν υπάρχει κανένας σταθμός.</h3>
                </div>

            @endif

            <div class="form-group">
                {{ $stations->render()  }}
            </div>


        </div>

    </div>




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