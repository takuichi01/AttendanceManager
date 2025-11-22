<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/user_attendance.css') }}">
    <title>勤怠詳細</title>
</head>

<body>
    @include('partial.admin_header')
    <main class="attendance-main">
        <h2 class="attendance-title">{{$name}}さんの勤怠</h2>
        <div class="attendance-controls-box">
            <div class="attendance-controls">
                <a href="{{ route('admin.user.attendances', ['year' => \Carbon\Carbon::create($year, $month, 1)->subMonth()->year, 'month' => \Carbon\Carbon::create($year, $month, 1)->subMonth()->month, 'id'=>$id]) }}"
                    class="prev-month"><span class="arrow">←</span> 前月</a>
                <span class="current-month"><i class="fa fa-calendar-alt"></i> {{ sprintf('%04d/%02d', $year, $month)
                    }}</span>
                <a href="{{ route('admin.user.attendances', ['year' => \Carbon\Carbon::create($year, $month, 1)->addMonth()->year, 'month' => \Carbon\Carbon::create($year, $month, 1)->addMonth()->month, 'id'=>$id]) }}"
                    class="next-month">翌月 <span class="arrow">→</span></a>
            </div>
        </div>
        <table class="attendance-table">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('m/d') }}({{
                        ['日','月','火','水','木','金','土'][\Carbon\Carbon::parse($attendance->date)->dayOfWeek] }})</td>
                    <td>{{ $attendance->work_start_time ?
                        \Carbon\Carbon::parse($attendance->work_start_time)->format('H:i') : '' }}</td>
                    <td>{{ $attendance->work_end_time ? \Carbon\Carbon::parse($attendance->work_end_time)->format('H:i')
                        : '' }}</td>
                    @php
                    $breakTotal = $attendance->breakTimes->sum('break_duration');
                    $workTotal = $attendance->working_hours - $breakTotal;
                    @endphp
                    <td>
                        @if ($attendance->work_start_time != null && $breakTotal == 0)
                        {{ $breakTotal = "00:00" }}
                        @else
                        {{ $breakTotal ? sprintf('%02d:%02d', intdiv($breakTotal, 60), $breakTotal % 60) : '' }}
                        @endif
                    </td>
                    <td>{{ $workTotal ? sprintf('%02d:%02d', intdiv($workTotal, 60), $workTotal % 60) : '' }}</td>
                    <td><a href="{{ route('admin.attendance.detail', ['id' => $attendance->id]) }}"
                            class="detail-link">詳細</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="csv-export">
            <button class="btn-csv">CSV出力</button>
        </div>
    </main>
</body>

</html>