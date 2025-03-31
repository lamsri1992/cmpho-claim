<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block" style="display: none;">
                <form action="{{ route('debtor.search') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" name="vn" type="search" placeholder="ค้นหาจาก VN"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                สวัสดี , {{ Auth::user()->name }} : {{ Auth::user()->hcode }}
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center">
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fa-solid fa-circle-h mr-2"></i>
                    ข้อมูลหน่วยบริการ
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link class="dropdown-item" :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-right-from-bracket mr-2" style="font-size: 16px;"></i>
                        <span style="font-size: 16px;">ออกจากระบบ</span>
                    </x-dropdown-link>
                </form>
            </div>
        </li>
    </ul>
</nav>
