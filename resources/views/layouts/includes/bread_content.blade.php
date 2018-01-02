<div class="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href=" {{ route('admin.index') }} ">Admin</a>
            </li>
            <li class="breadcrumb-item active">{{ $path }}</li>
        </ol>



        @yield('content')

    </div>

</div>