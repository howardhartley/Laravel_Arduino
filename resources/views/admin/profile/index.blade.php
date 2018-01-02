<?php $path = "Προφίλ" ?>
<?php $active = "profile" ?>

@extends('layouts.admin')



@section('content')


    <div class="row">

        <div class="col-sm-2"></div>

        <div class="col-sm-8">

            @if(Session::has('nothing'))
                <div class="alert alert-warning">
                    {{ session('nothing') }}
                </div>
            @endif

                @if(Session::has('update'))
                    <div class="alert alert-success">
                        {{ session('update') }}
                    </div>
                @endif

                @if(Session::has('update_password'))
                    <div class="alert alert-success">
                        {{ session('update_password') }}
                    </div>
                @endif


            <div class="card text-center">

                    <div class="card-header bg-primary">
                        <h3 class="profile">Προφίλ</h3>
                    </div>
                    <br>

                    <div class="row">

                        <div class="col-md-6">
                                <div><img src="{{ url('images/profile.png') }}" class="rounded-circle img-thumbnail" width="50%"></div>
                                <br>
                                <div>
                                    <div><a href="{{ route('admin.profile.edit.password', $user->id) }}" class ="btn btn-info">Αλλαγή κωδικού πρόσβασης</a></div>
                                    <br>

                                    <div><a href="{{ route('admin.profile.edit', $user->id) }}" class ="btn btn-warning">Επεξεργασία λογαριασμού</a></div>
                                    <br>

                                    @if(Auth::user()->id != 1)
                                    <div><a class="btn btn-danger" class="modal-pointer-default" data-toggle="modal" data-target="#exampleModal1">Διαγραφή λογαριασμού</a></div>
                                    @endif
                                    <br>

                                    <br>
                                </div>

                        </div>

                        <div class="col-md-6">

                            <h4>Στοιχεία</h4><br>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>id:</strong> {{ $user->id }}</li>
                                <li class="list-group-item"><strong>Όνομα:</strong> {{ $user->name }}</li>
                                <li class="list-group-item"><strong>Επίθετο:</strong> {{ $user->surname }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                <li class="list-group-item"><strong>Κατηγορία:</strong> {{ $user->role->name }}</li>
                                <li class="list-group-item"><strong>Ενεργός:</strong> {{ $user->is_active == 1 ? 'Ναι' : 'Οχι' }}</li>
                                <li class="list-group-item"><strong>Επιβεβαιωμένος:</strong> {{ $user->confirmed == 1 ? 'Ναι' : 'Οχι' }}</li>
                                <li class="list-group-item"><strong>Σταθμοί:</strong> {{ count($user->stations()->get()) > 0 ? count($user->stations()->get()) : 'Κανένας σταθμός'}}</li>
                                <li class="list-group-item"><strong>Ημ. δημιουργίας:</strong> {{ $user->created_at->diffForHumans() }}</li>
                                <li class="list-group-item"><strong>Ημ. ανανέωσης:</strong> {{ $user->updated_at->diffForHumans() }}</li>
                            </ul>

                        </div>

                    </div>
                    <br>

            </div>

        </div>

    </div><br>

@endsection


@include('layouts.includes.delete_account')