<?php $path = "Χρήστες" ?>
<?php $active = "user" ?>

@extends('layouts.admin')



@section('content')
    <br>

    <div class="row text-center">


        <div class="col-sm-12">

            <h3>Προβολή όλων των χρηστών</h3>
            <hr><br>
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


                    @foreach($users as $user)

                        <tr @if( $user->id == Auth::user()->id ) class="table-success" @endif>
                            <td> {{ $user->id }} </td>
                            <td>@if( $user->id == 1 || $user->id == Auth::user()->id ) {{ $user->name }}  @else <a title="κάνε κλικ για επεξεργασία" href=" {{ route('admin.users.edit', $user->id) }} ">{{ $user->name }}</a>  @endif</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td>{{ $user->is_active == 1 ? 'Ναι' : 'Οχι' }}</td>
                            <td>{{ $user->confirmed == 1 ? 'Ναι' : 'Οχι' }}</td>
                            <td>{{ count($user->stations()->get()) > 0 ? count($user->stations()->get()) : 'Κανένας σταθμός'}}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td>{{ $user->updated_at->diffForHumans() }}</td>
                            <td>@if( $user->id == 1 || $user->id == Auth::user()->id )
                                <div class="form-group"><br></div>
                                @else

                                {!! Form::open(['method' => 'DELETE', 'action' => ['AdminUsersController@destroy', $user->id]]) !!}

                                <div class="form-group">
                                    {!! Form::submit('Διαγραφή', ['class' => 'btn btn-danger']) !!}
                                </div>

                                {!! Form::close() !!}

                                @endif

                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>

            <div class="form-group">
                {{ $users->render()  }}
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