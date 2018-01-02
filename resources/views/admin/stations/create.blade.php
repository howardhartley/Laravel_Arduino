<?php $path = "Σταθμοί" ?>
<?php $active = "station" ?>

@extends('layouts.admin')



@section('content')
    <br>

    <div class="row">

        <div class="col-sm-1"></div>
        <div class="col-sm-10 text-center">

            <h3>Δημιουργία σταθμού</h3>
            <hr>


            @include('errors.errors')
            <br>

            <div class="row">
                <div class="col-sm-5 text-center">
                    <h5>Πληροφορίες</h5>
                    <hr><br>

                    {!! Form::open(['method' => 'POST', 'action' => 'AdminStationsController@store']) !!}

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
                        {!! Form::select('user_id', [$user->id => 'Ο ίδιος'] + $collection, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('location', 'Τοποθεσία:') !!}
                        {!! Form::text('location', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_active', 'Ενεργός:') !!}
                        {!! Form::select('is_active', ['' => 'Διαλέξτε κατηγορία', 0 => 'Ανενεργός', 1 => 'Ενεργός' ], null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('is_private', 'Προβολή:') !!}
                        {!! Form::select('is_private', ['' => 'Διαλέξτε κατηγορία', 0 => 'Δημόσιος', 1 => 'Ιδιωτικός' ], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Περιγραφή: (Προαιρετικό)') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>

                </div>

                <div class="col-sm-1"></div>
                <div class="col-sm-6 text-center">

                    <h5>Λίστα κατηγοριών</h5>
                    <hr><br>

                    @if(count($categories) > 0)

                        <div class="form-check form-check-inline">
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col-xl-6 text-left">
                                        {!! Form::checkbox('checkbox_array[]', $category->id) !!}
                                        {!! Form::label('category', $category->name, ['class' => 'form-check-label']) !!}
                                    </div>
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
                {!! Form::submit('Δημιουργία', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}


        </div>



    </div><br>



@endsection

