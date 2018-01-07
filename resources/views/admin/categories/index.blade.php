<?php $path = "Κατηγορίες" ?>
<?php $active = "category" ?>

@extends('layouts.admin')




@section('content')
   <br>

   <div class="row">

      <div class="col-sm-1"></div>
      <div class="col-sm-3 text-center">

            <h3>Δημιουργία κατηγορίας</h3>
            <hr>

            @if(Session::has('complete'))
               <div class="alert alert-success">
                  {{ session('complete') }}
               </div>
            @endif

            @include('errors.errors')
            <br>

            {!! Form::open(['method' => 'POST', 'action' => 'AdminCategoriesController@store']) !!}

               <div class="form-group">
                  {!! Form::label('name', 'Όνομα κατηγορίας:') !!}
                  {!! Form::text('name', null, ['class' => 'form-control']) !!}
               </div>

               <div class="form-group">
                  {!! Form::submit('Δημιουργία', ['class' => 'btn btn-primary']) !!}
               </div>

            {!! Form::close() !!}

      </div>


      <div class="col-sm-1"></div>
      <div class="col-sm-6">

            <h3 class="text-center">Προβολή όλων των κατηγοριών</h3>
            <hr><br>

         @if(count($categories) > 0)
              <div class="wow fadeIn"  data-wow-duration="1.2s" data-wow-delay="1.3s" style="overflow-x:auto;">
                    <table class="table table-striped table-responsive">

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
                           <th>Συσχέτιση με σταθμούς</th>
                          <th>Ημ. δημιουργίας</th>
                          <th>Ημ. ανανέωσης</th>
                       </tr>
                       </thead>
                       <tbody>


                       @foreach($categories as $category)

                       <tr>
                          <td> {{ $category->id }} </td>
                          <td><a title="κάνε κλικ για επεξεργασία" href=" {{ route('admin.categories.edit', $category->id) }} ">{{ $category->name }}</a></td>
                           <td>{{ count($category->stations()->get()) > 0 ? count($category->stations()->get()) : 'Κανένας σταθμός' }}</td>
                          <td>{{ $category->created_at->diffForHumans() }}</td>
                          <td>{{ $category->updated_at->diffForHumans() }}</td>
                          <td>

                             {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCategoriesController@destroy', $category->id]]) !!}

                             <div class="form-group">
                                {!! Form::submit('Διαγραφή', ['class' => 'btn btn-danger']) !!}
                             </div>

                             {!! Form::close() !!}



                          </td>
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

          <div class="form-group">
               {{ $categories->render()  }}
          </div>



      </div>

      <div class="col-sm-1"></div>

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