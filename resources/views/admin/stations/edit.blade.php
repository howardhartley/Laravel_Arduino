<?php $path = "Σταθμοί" ?>
<?php $active = "station" ?>

@extends('layouts.admin')



@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-1"></div>
        <div class="col-sm-10">

            <h3 >Επεξεργασία σταθμού</h3>
            <hr><br>

            <div style="overflow-x:auto;">
                <table class="table table-striped table-responsive">

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


                    <tr>
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
                        <td>{{ $station->id }} </td>
                        <td>{{ $station->name }}</td>
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

                    </tr>


                    </tbody>
                </table>
            </div>

        </div>


    </div>
    <div class="col-sm-1"></div>

    @if(Auth::user()->id == 1 || $station->user_id != 1)

        <div class="row">

            <div class="col-sm-1"></div>
            <div class="col-sm-10 text-center">


                @include('errors.errors')
                <br>

                <div class="row">
                    <div class="col-sm-5 text-center">
                        <h5>Πληροφορίες</h5>
                        <hr><br>

                        {!! Form::model($station, ['method' => 'PATCH', 'action' => ['AdminStationsController@update', $station->id]]) !!}

                        <div class="form-group">
                            {!! Form::label('name', 'Όνομα:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('unique', 'Μοναδικός κωδικός:') !!}
                            {!! Form::text('unique', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('user_id', 'Ιδιοκτησία:') !!}
                            {!! Form::select('user_id', [$station->user->id => 'Ο ίδιος'] + $collection, null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('location', 'Τοποθεσία:') !!}
                            {!! Form::text('location', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('is_active', 'Ενεργός:') !!}
                            {!! Form::select('is_active', [0 => 'Ανενεργός', 1 => 'Ενεργός' ], null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('is_private', 'Προβολή:') !!}
                            {!! Form::select('is_private', [0 => 'Δημόσιος', 1 => 'Ιδιωτικός' ], null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Περιγραφή: (Προαιρετικό)') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>

                    </div>

                    <div class="col-sm-1"></div>
                    <div class="col-sm-6">

                        <h5 class="text-center">Λίστα κατηγοριών</h5>
                        <hr><br>

                        @if(count($categories) > 0)

                            <div class="form-check form-check-inline">
                                <div class="row">
                                    @foreach($categories as $category)
                                        @if($category->stations()->where('id', '=', $station->id)->first())
                                            <div class="col-xl-6 text-left">
                                                {!! Form::checkbox('checkbox_array[]', $category->id, 'checked') !!}
                                                {!! Form::label('category', $category->name, ['class' => 'form-check-label']) !!}
                                            </div>
                                        @else
                                            <div class="col-xl-6 text-left">
                                                {!! Form::checkbox('checkbox_array[]', $category->id) !!}
                                                {!! Form::label('category', $category->name, ['class' => 'form-check-label']) !!}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>


                        @else

                            <div class="alert alert-warning">
                                <h4 class="text-center">Δεν υπάρχει καμία κατηγορία.</h4>
                            </div>

                        @endif


                    </div>

                </div>

                <br><div class="form-group">
                    {!! Form::submit('Ανανέωση', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}


            </div>



        </div><br>


    @else


        <div class="row">

            <div class="col-sm-1"></div>
            <div class="col-sm-10 text-center">


                @include('errors.errors')
                <br>

                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">

                        <h5 class="text-center">Λίστα κατηγοριών</h5>
                        <hr><br>

                        @if(count($categories) > 0)

                            <div class="form-check form-check-inline">
                                <div class="row">
                                    @foreach($categories as $category)
                                        @if($category->stations()->where('id', '=', $station->id)->first())
                                            <div class="col-xl-6 text-left">
                                                <input type="checkbox" checked disabled>
                                                <label for="checkbox" class="form-check-label">{{ $category->name }}</label>
                                            </div>
                                        @else
                                            <div class="col-xl-6 text-left">
                                                <input type="checkbox" disabled>
                                                <label for="checkbox" class="form-check-label">{{ $category->name }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>


                        @else

                            <div class="alert alert-warning">
                                <h4 class="text-center">Δεν υπάρχει καμία κατηγορία.</h4>
                            </div>

                        @endif


                    </div>

                </div>




            </div>



        </div><br>



    @endif









@endsection