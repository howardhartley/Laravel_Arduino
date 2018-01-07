<?php $path = "Κατηγορίες" ?>
<?php $active = "category" ?>

@extends('layouts.user')




@section('content')
        <br>

        <div class="row">

            <div class="col-sm-2"></div>
            <div class="col-sm-8 text-center">

                <h3 class="text-center">Προβολή όλων των κατηγοριών</h3>
                <hr><br>

                @if(count($categories) > 0)
                    <div class="wow fadeIn"  data-wow-duration="1.2s" data-wow-delay="1.3s" style="overflow-x:auto;">
                        <table class="table table-striped table-responsive">


                            <thead>
                            <tr>
                                <th>Όνομα</th>
                                <th>Συσχέτιση με σταθμούς μου</th>
                                <th>Ημ. δημιουργίας</th>
                                <th>Ημ. ανανέωσης</th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach($categories as $category)

                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ count($category->stations()->where('user_id', Auth::user()->id)->get()) > 0 ? count($category->stations()->where('user_id', Auth::user()->id)->get()) : 'Κανένας σταθμός' }}</td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                    <td>{{ $category->updated_at->diffForHumans() }}</td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                @else

                    <div class="alert alert-warning">
                        <h3 class="text-center">Δεν υπάρχει καμία κατηγορία.</h3>
                    </div>

                @endif

            </div>
        </div><br>


            <div class="form-group">
                {{ $categories->render()  }}
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