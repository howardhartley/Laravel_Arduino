<?php $path = "Κατηγορίες" ?>
<?php $active = "category" ?>

@extends('layouts.admin')




@section('content')
    <br>

    <div class="row">

        <div class="col-sm-3"></div>

            <div class="col-sm-6 text-center">

                <h3>Επεξεργασία κατηγορίας</h3>
                <hr>


                @include('errors.errors')
                <br>

                {!! Form::model($category, ['method' => 'PATCH', 'action' => ['AdminCategoriesController@update', $category->id]]) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Όνομα κατηγορίας:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'attr' => 'Όνομα κατηγορίας']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Ανανέωση', ['class' => 'btn btn-info']) !!}
                </div>

                {!! Form::close() !!}

            </div>

        <div class="col-sm-3"></div>

    </div>


@endsection