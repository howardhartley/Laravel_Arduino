@extends('layouts.app')

@section('style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@endsection

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
                    <h2 class="element text-center"></h2>
                    <h2 class="text-center white-margin wow zoomIn" data-wow-duration="1.2s" data-wow-delay="2s">Δημιούργησε σταθμούς, πραγματοποίησε μετρήσεις, εμφάνισε αποτελέσματα.</h2>
                </div>
            </div>
        </div>
@endsection


@section('footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.6/typed.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <script>
        $(document).ready(function () {

            var options = {
                strings: ["<em>Arduino</em> CMS"]
                , typeSpeed: 70
                , showCursor: false
            }


            var typed = new Typed(".element", options);


            new WOW().init();


        });



    </script>
@endsection
