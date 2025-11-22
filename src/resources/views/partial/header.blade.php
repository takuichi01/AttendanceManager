<header class="site-header">
    <div class="header-logo">
        <img src="{{ asset('img/logo/logo.svg') }}" alt="COACHTECHロゴ" class="logo-img">
    </div>
    <nav class="header-nav">
        <ul>
            <li><a href="{{ route('attendance.show') }}">勤怠</a></li>
            <li><a href="{{ route('attendance.list') }}">勤怠一覧</a></li>
            <li><a href="{{ route('attendance.indexApply') }}">申請</a></li>
            <li>
                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
</header>