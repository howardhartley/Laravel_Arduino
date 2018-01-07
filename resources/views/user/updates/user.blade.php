<?php $path = "Ενημερώσεις" ?>
<?php $active = "update" ?>

@extends('layouts.user')



@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-1"></div>
        <div class="col-sm-10">

            <h3>Προβολή ενημερώσεων των σταθμών του χρήστη</h3>
            <hr><br>

            @if(count($logs) > 0)

                @if(Session::has('delete'))
                    <div class="alert alert-success">
                        {{ session('delete') }}
                    </div><br>
                @endif

                <div class="list-group">
                    @foreach($logs as $log)
                        <a class="list-group-item list-group-item-action flex-column align-items-start bg-custom">
                            <p class="mb-1 @if($log->goodtobad == 1) text-success @elseif($log->goodtobad == 2) text-warning @else text-danger @endif">{{ $log->note }}</p>
                            <small class="test-dark">{{ $log->created_at->diffForHumans() }}</small>
                            <span>
                                {!! Form::open(['method' => 'DELETE', 'action' => ['UserUpdatesController@destroy', $log->id]]) !!}

                                {!! Form::submit('Διαγραφή', ['class' => 'btn btn-light text-danger']) !!}

                                {!! Form::close() !!}
                            </span>
                        </a>
                    @endforeach
                </div><br>




            @else

                <div class="alert alert-warning">
                    <h3 class="text-center">Δεν υπάρχουν ενημερώσεις.</h3>
                </div>

            @endif

            <div class="form-group">
                {{ $logs->render()  }}
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