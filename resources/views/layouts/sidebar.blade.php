@if(Auth::user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.trainees.*') ? 'active' : '' }}" href="{{ route('admin.trainees.index') }}">
            <i class="fas fa-users"></i> Trainees
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
            <i class="fas fa-book"></i> Courses
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
            <i class="fas fa-file-alt"></i> Reports
        </a>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('trainee.dashboard') ? 'active' : '' }}" href="{{ route('trainee.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('trainee.courses.*') ? 'active' : '' }}" href="{{ route('trainee.courses.index') }}">
            <i class="fas fa-graduation-cap"></i> My Courses
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('trainee.quizzes.*') ? 'active' : '' }}" href="{{ route('trainee.quizzes.index') }}">
            <i class="fas fa-question-circle"></i> My Quizzes
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('trainee.certificates.*') ? 'active' : '' }}" href="{{ route('trainee.certificates.index') }}">
            <i class="fas fa-certificate"></i> Certificates
        </a>
    </li>
@endif
