@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        @if(Session::has('register_user'))

            <div class="form-group">

                <div class="alert alert-success">

                    {{ session('register_user') }}

                </div>

            </div>

        @endif

            @if(Session::has('fail'))

                <div class="form-group">

                    <div class="alert alert-warning">

                        {{ session('fail') }}

                    </div>

                </div>

            @endif

            @if(Session::has('Deleted'))

                <div class="form-group">

                    <div class="alert alert-danger">

                        {{ session('Deleted') }}

                    </div>

                </div>

            @endif

            @if(Session::has('Activated'))

                <div class="form-group">

                    <div class="alert alert-success">

                        {{ session('Activated') }}

                    </div>

                </div>

            @endif

            @if(Session::has('Inactive'))

                <div class="form-group">

                    <div class="alert alert-danger">

                        {{ session('Inactive') }}

                    </div>

                </div>

            @endif

            @if(Session::has('Regenerate'))

                <div class="form-group">

                    <div class="alert alert-success">

                        {{ session('Regenerate') }}

                    </div>

                </div>

            @endif

    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
