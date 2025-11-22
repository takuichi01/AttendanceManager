<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <title>勤怠管理</title>
</head>

<body>
    @include('partial.header')
    <main class="attendance-main">
        <div class="status-badge">
            <span class="badge">{{ $status }}</span>
        </div>
        <div class="date-time">
            <p class="date"></p>
            <p class="time"></p>
        </div>
        <script>
            function updateClock() {
            const days = ['日', '月', '火', '水', '木', '金', '土'];
            const now = new Date();
            // 年月日
            const dateStr = now.getFullYear() + '年' +
                ('0' + (now.getMonth()+1)).slice(-2) + '月' +
                ('0' + now.getDate()).slice(-2) + '日' +
                ('(' + days[now.getDay()] + ')');
            // 時刻
            const timeStr = ('0' + now.getHours()).slice(-2) + ':' +
                ('0' + now.getMinutes()).slice(-2);
        
            document.querySelector('.date').textContent = dateStr;
            document.querySelector('.time').textContent = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();
        </script>
        <div class="action-button">
            @if ($status === '勤務外')
            <form method="POST" action="{{ route('attendance.clockIn') }}">
                @csrf
                <button type="submit" class="btn-clock-in">出勤</button>
            </form>
            @elseif ($status === '出勤中')
            <div class="button-row">
                <form method="POST" action="{{ route('attendance.clockOut') }}">
                    @csrf
                    <button type="submit" class="btn-clock-out">退勤</button>
                </form>
                <form method="POST" action="{{ route('attendance.breakIn') }}">
                    @csrf
                    <button type="submit" class="btn-break-in">休憩入</button>
                </form>
            </div>
            @elseif ($status === '休憩中')
            <form method="POST" action="{{ route('attendance.breakOut') }}">
                @csrf
                <button type="submit" class="btn-break-out">休憩戻</button>
            </form>
            @elseif ($status === '退勤済')
            <div class="after-work-sentence">お疲れ様でした。</div>
            @endif
        </div>
    </main>
</body>

</html>