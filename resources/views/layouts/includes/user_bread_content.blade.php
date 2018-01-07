<div class="content-wrapper">

    <div class="container-fluid container-fluid-relative">

        <div id='load-screen'><div id='loading'></div></div>
        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href=" {{ route('user.index') }} ">User</a>
            </li>
            <li class="breadcrumb-item active">{{ $path }}</li>
        </ol>


        @yield('content')

    </div>

</div>