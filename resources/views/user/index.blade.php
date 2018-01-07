<?php $path = "Πίνακας ελέγχου" ?>
<?php $active = "check" ?>


@extends('layouts.user')


@section('content')
    <br>

    <div class="row text-center">

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-7">

                    <h4 class="text-left">Home</h4>
                    <h2 class="welcome wow fadeIn" data-wow-duration="1s" data-wow-delay="1.3s">Καλώς ήρθατε στο Arduino CMS</h2><hr class="style-two">

                    <div class="welcome-text wow zoomIn" data-wow-duration="1s" data-wow-delay="1.5s">
                       <p class="text-left change wow fadeIn" data-wow-duration="1.2s" data-wow-delay="2s">&#10004;&nbsp;&nbsp;&nbsp;Μπορείτε απο το μενού να δημιουργήσετε τους δικούς σας σταθμούς, επιλέγοντας απο την λίστα κατηγοριών, τα είδη των μετρήσεων που θα πραγματοποιεί ο σταθμός σας.</p>
                       <p class="text-left change wow fadeIn" data-wow-duration="1.2s" data-wow-delay="2.1s">&#10004;&nbsp;&nbsp;&nbsp;Παρακολουθήστε την πιο πρόσφατη συλλογή μετρήσεων των σταθμών σας, καθώς και τις συλλογές απο τους δημόσιους σταθμούς των άλλων χρηστών.</p>
                       <p class="text-left change wow fadeIn" data-wow-duration="1.2s" data-wow-delay="2.2s">&#10004;&nbsp;&nbsp;&nbsp;Μέσω του ιστορικού, αναζητήστε και προβάλετε την συλλογή μετρήσεων που επιθυμείτε.</p>
                       <p class="text-left change wow fadeIn" data-wow-duration="1.2s" data-wow-delay="2.3s">&#10004;&nbsp;&nbsp;&nbsp;Ενημερωθείτε για την εξέλιξη αποστολής και αποθήκευσης των μετρήσεων, που αποστέλλουν οι σταθμοί σας στο σύστημα.</p>
                    </div>


                </div>


                <div class="col-sm-5">

                    <div class="card mb-3 marg-top-first wow slideInRight" data-wow-duration="1.4s" data-wow-delay="2.5s">
                        <div class="card-header">
                            <i class="fa fa-level-up" aria-hidden="true"></i>
                            Τελευταία ενημέρωση συλλογής μετρήσεων απο σταθμό
                        </div>
                        <div class="card-body">

                            <div>
                                @if(empty($last_user_log))
                                    <div>Δεν υπάρχει συλλογή μετρήσεων</div>
                                @else
                                    <div class=" @if($last_user_log->goodtobad == 1) text-success @elseif($last_user_log->goodtobad == 2) text-warning @else text-danger @endif ">{{ $last_user_log->note }}  ({{$last_user_log->created_at->diffForHumans()}})</div>
                                @endif

                            </div>
                        </div>
                    </div>



                    <div class="card marg-top-second text-white bg-success o-hidden h-40 wow slideInRight" data-wow-duration="1.2s" data-wow-delay="2.9s">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-university"></i>
                            </div>
                            <div class="mr-5">
                                Οι σταθμοί μου: {{ count($user_stations) }}
                            </div>
                        </div>
                        <a href=" {{ route('user.stations.index') }} " class="card-footer text-white clearfix small z-1">
                            <span class="float-left">Δες πληροφορίες</span>
                            <span class="float-right">
                            <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>

                </div>
            </div>
            <br>
        </div>


    </div>


@endsection