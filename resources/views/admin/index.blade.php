<?php $path = "Πίνακας ελέγχου" ?>
<?php $active = "check" ?>


@extends('layouts.admin')


@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-12">
            <h3>Κεντρική σελίδα Admin </h3>
            <br><hr>

            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-university"></i>
                            </div>
                            <div class="mr-5">
                               Σταθμοί: {{ count($stations) }}
                            </div>
                        </div>
                        <a href=" {{ route('admin.stations.index') }} " class="card-footer text-white clearfix small z-1">
                            <span class="float-left">Δες πληροφορίες</span>
                            <span class="float-right">
                            <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-user"></i>
                            </div>
                            <div class="mr-5">
                                Χρήστες: {{ count($users) }}
                            </div>
                        </div>
                        <a href=" {{ route('admin.users.index') }} " class="card-footer text-white clearfix small z-1">
                            <span class="float-left">Δες πληροφορίες</span>
                            <span class="float-right">
                            <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div><div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-list"></i>
                            </div>
                            <div class="mr-5">
                                Κατηγορίες: {{ count($categories) }}
                            </div>
                        </div>
                        <a href=" {{ route('admin.categories.index') }} " class="card-footer text-white clearfix small z-1">
                            <span class="float-left">Δες πληροφορίες</span>
                            <span class="float-right">
                            <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div><div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-info o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-line-chart" aria-hidden="true"></i>
                            </div>
                            <div class="mr-5">
                                Συλλογές μετρήσεων: {{ $sum }}
                            </div>
                        </div>
                        <a href=" {{ route('admin.history.index') }} " class="card-footer text-white clearfix small z-1">
                            <span class="float-left">Δες πληροφορίες</span>
                            <span class="float-right">
                            <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-8">

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-bar-chart"></i>
                    Στοιχεία
                </div>
                <div class="card-body">
                    <div id="morris-bar-chart"></div>
                </div>
            </div>


        </div>



        <div class="col-sm-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-bar-chart"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-comment fa-fw"></i> Νέος σταθμός
                                <span class="pull-right text-muted small"><em>{{ $stations->last()->created_at->diffForHumans() }}</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-twitter fa-fw"></i> Νέος χρήστης
                                <span class="pull-right text-muted small"><em>{{ $users->last()->created_at->diffForHumans() }}</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-envelope fa-fw"></i> Νέα κατηγορία
                                <span class="pull-right text-muted small"><em>{{ $categories->last()->created_at->diffForHumans() }}</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-tasks fa-fw"></i> Νέα συλλογή μετρήσεων
                                <span class="pull-right text-muted small"><em>{{ $measures->last()->created_at->diffForHumans() }}</em>
                                    </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-bar-chart"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body">
                        <div id="morris-donut-chart"></div>
                    </div>
                </div>

        </div>
    </div>



@endsection

@section('footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>Morris.Donut({
            element: 'morris-donut-chart',
            data: [{
                label: "Διαχειριστές",
                value: "{{ count($users->where('role_id', 1)) }}"
            }, {
                label: "Χρήστες",
                value: "{{ count($users->where('role_id', 2)) }}"
            }, {
                label: "Ενεργοί χρήστες",
                value: "{{ count($users->where('is_active', 1)) }}"
            }, {
                label: "Ανενεργοί χρήστες",
                value: "{{ count($users->where('is_active', 0)) }}"
            }, {
                label: "Μη επιβεβαιωμένοι χρήστες",
                value: "{{ count($users->where('confirmed', 0)) }}"
            }],
            resize: true
        });

        Morris.Bar({
            element: 'morris-bar-chart',
            data: [{
                y: 'Ενεργοί σταθμοί',
                a: "{{ count($stations->where('is_active', 1)) }}"
            }, {
                y: 'Ανενεργοί σταθμοί',
                a: "{{ count($stations->where('is_active', 0)) }}"
            }, {
                y: 'Δημόσιοι σταθμοί',
                a: "{{ count($stations->where('is_private', 0)) }}"
            }, {
                y: 'Ιδιωτικοί σταθμοί',
                a:"{{ count($stations->where('is_private', 1)) }}"
            }, {
                y: 'Σταθμοί διαχειριστών',
                a: "{{ $admin_stations_sum }}"
            }, {
                y: 'Σταθμοί χρηστών',
                a: "{{ $users_stations_sum }}"
            }],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Σύνολο'],
            resize: true
        });


    </script>


@endsection