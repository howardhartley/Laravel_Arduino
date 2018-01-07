<?php $path = "Πίνακας ελέγχου" ?>
<?php $active = "check" ?>


@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection


@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-12">
            <h3>Home Admin </h3>
            <br><hr>

            <div class="row wow fadeIn" data-wow-duration="2s" data-wow-delay="1s">
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

            <div class="card mb-3 wow slideInLeft"  data-wow-duration="0.6s" data-wow-delay="1.4s">
                <div class="card-header">
                    <i class="fa fa-level-up" aria-hidden="true"></i>
                    Τελευταία ενημέρωση συλλογής μετρήσεων απο σταθμό
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Χρήστη</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Όλων</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent"><br>
                        @if(empty($last_user_log))
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">Δεν υπάρχει συλλογή μετρήσεων</div>
                        @else
                            <div class="tab-pane fade show active @if($last_user_log->goodtobad == 1) text-success @elseif($last_user_log->goodtobad == 2) text-warning @else text-danger @endif " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">{{ $last_user_log->note }}  ({{$last_user_log->created_at->diffForHumans()}})</div>
                        @endif

                        @if(empty($last_all_log))
                            <div class="tab-pane fade show" id="nav-contact" role="tabpanel" aria-labelledby="nav-home-tab">Δεν υπάρχει συλλογή μετρήσεων</div>
                        @else
                            <div class="tab-pane fade @if($last_all_log->goodtobad == 1) text-success @elseif($last_all_log->goodtobad == 2) text-warning @else text-danger @endif" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">{{ $last_all_log->note }}  ({{$last_all_log->created_at->diffForHumans()}})</div>

                        @endif

                    </div>
                </div>
            </div>

            <div class="card mb-3 wow slideInLeft" data-wow-duration="1.2s" data-wow-delay="1.7s">
                <div class="card-header">
                    <i class="fa fa-bar-chart"></i>
                    Στοιχεία σταθμών
                </div>
                <div class="card-body">
                    <div id="morris-bar-chart"></div>
                </div>
            </div>


        </div>



        <div class="col-sm-4">
                <div class="card mb-3 wow zoomIn" data-wow-duration="1.2s" data-wow-delay="2.2s">
                    <div class="card-header">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        Ειδοποιήσεις
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-fw fa-university"></i> Νέος σταθμός
                                <span class="pull-right text-muted small"><em>{{ $stations->last() ? $stations->last()->created_at->diffForHumans() : '-' }}</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-fw fa-user"></i> Νέος χρήστης
                                <span class="pull-right text-muted small"><em>{{ $users->last() ? $users->last()->created_at->diffForHumans() : '-' }}</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-fw fa-list"></i> Νέα κατηγορία
                                <span class="pull-right text-muted small"><em>{{ $categories->last() ? $categories->last()->created_at->diffForHumans() : '-' }}</em>
                                    </span>
                            </a>
                            <a href="#" class="list-group-item inactive-link">
                                <i class="fa fa-fw fa-line-chart" aria-hidden="true"></i> Νέα συλλογή μετρήσεων
                                <span class="pull-right text-muted small"><em>{{ $measures->last() ? $measures->last()->created_at->diffForHumans() : '-' }}</em>
                                    </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 wow zoomIn" data-wow-duration="1.2s" data-wow-delay="2.4s">
                    <div class="card-header">
                        <i class="fa fa-bar-chart"></i>
                        Στοιχεία χρηστών
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
                y: 'Ενεργοί',
                a: "{{ count($stations->where('is_active', 1)) }}"
            }, {
                y: 'Ανενεργοί',
                a: "{{ count($stations->where('is_active', 0)) }}"
            }, {
                y: 'Δημόσιοι',
                a: "{{ count($stations->where('is_private', 0)) }}"
            }, {
                y: 'Ιδιωτικοί',
                a:"{{ count($stations->where('is_private', 1)) }}"
            }, {
                y: 'Σταθ. διαχειριστών',
                a: "{{ $admin_stations_sum }}"
            }, {
                y: 'Σταθ. χρηστών',
                a: "{{ $users_stations_sum }}"
            }],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Σύνολο'],
            resize: true
        });


    </script>


@endsection