<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href=" {{ route('user.index') }} ">Arduino CMS&nbsp;&nbsp;&nbsp;User</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item {{ $active == 'check' ? 'active' : ''}}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link" href=" {{ route('user.index') }} ">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">
                Πίνακας ελέγχου</span>
                </a>
            </li>
            <li class="nav-item {{ $active == 'station' ? 'active' : ''}}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
                    <i class="fa fa-university"></i>
                    <span class="nav-link-text">
                Σταθμοί</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseComponents">
                    <li>
                        <a href=" {{ route('user.stations.index') }} ">Οι σταθμοί μου</a>
                    </li>
                    <li>
                        <a href=" {{ route('user.stations.create') }} ">Δημιουργία σταθμού</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ $active == 'category' ? 'active' : ''}}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link" href=" {{ route('user.categories.index') }} ">
                    <i class="fa fa-pencil-square-o"></i>
                    <span class="nav-link-text">
                Κατηγορίες</span>
                </a>
            </li>
            <li class="nav-item {{ $active == 'measure' ? 'active' : ''}}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link" href=" {{ route('user.measures.index') }} ">
                    <i class="fa fa-area-chart"></i>
                    <span class="nav-link-text">
                Μετρήσεις</span>
                </a>
            </li>
            <li class="nav-item {{ $active == 'history' ? 'active' : ''}}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link" href=" {{ route('user.history.index') }}">
                    <i class="fa fa-history"></i>
                    <span class="nav-link-text">
                Ιστορικό</span>
                </a>
            </li>
            <li class="nav-item {{ $active == 'update' ? 'active' : ''}}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link" href=" {{ route('user.updates.user') }} ">
                    <i class="fa fa-level-up" aria-hidden="true"></i>
                    <span class="nav-link-text">
                Ενημερώσεις</span>
                </a>
            </li>
            <li class="nav-item {{ $active == 'profile' ? 'active' : ''}}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link" href=" {{ route('user.profile.index') }} ">
                    <i class="fa fa-user"></i>
                    <span class="nav-link-text">
                Προφίλ</span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link inactive-link">Χρήστης:&nbsp;{{Auth::user()->name}}&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>
                    Αποσύνδεση</a>
            </li>
        </ul>
    </div>
</nav>