<header class="site-header">
    <div class="header-logo">
        <img src="{{ asset('img/logo/logo.svg') }}" alt="COACHTECHロゴ" class="logo-img">
    </div>
    <nav class="header-nav">
        <ul>
            <li><a href="{{route('admin.attendances')}}">勤怠一覧</a></li>
            <li><a href="{{route('admin.index.staffs')}}">スタッフ一覧</a></li>
            <li><a href="{{route('admin.index.applies')}}">申請一覧</a></li>
            <li>
                <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
</header>