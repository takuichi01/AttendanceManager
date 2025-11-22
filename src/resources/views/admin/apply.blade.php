<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/apply.css') }}">
    <title>勤怠詳細</title>
</head>

<body>
    @include('partial.admin_header')
    <main class="application-main">
        <div class="detail-container">
            <h2 class="detail-title">勤怠詳細</h2>
            <div class="detail-box">
                <table class="detail-table">
                    <tr>
                        <th>名前</th>
                        <td>{{ $application->staffUser->name }}</td>
                    </tr>
                    <tr>
                        <th>日付</th>
                        <td>
                            <span class="date-year">{{
                                \Carbon\Carbon::parse($application->attendance_date)->format('Y年')
                                }}</span>
                            <span class="date-day">{{
                                \Carbon\Carbon::parse($application->attendance_date)->format('n月j日')
                                }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>出勤・退勤</th>
                        <td>
                            <span class="time-input">
                                {{ $application->after_work_start_time ?
                                \Carbon\Carbon::parse($application->after_work_start_time)->format('H:i') : '' }}
                            </span>
                            <span class="time-separator">〜</span>
                            <span class="time-input">
                                {{ $application->after_work_end_time ?
                                \Carbon\Carbon::parse($application->after_work_end_time)->format('H:i') : '' }}
                            </span>
                        </td>
                    </tr>
                    @php($count = 0)
                    @foreach ($application->breakApplications as $break_time)
                    @php($count++)
                    <tr>
                        <th>休憩{{ $break_count==1 ? '' : $count}}</th>
                        <td>
                            <span class="time-input">
                                {{ \Carbon\Carbon::parse($break_time->after_break_start_time)->format('H:i') }}
                            </span>
                            <span class="time-separator">〜</span>
                            <span class="time-input">
                                {{ \Carbon\Carbon::parse($break_time->after_break_end_time)->format('H:i') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @php($count++)
                    <tr>
                        <th>休憩{{$count}}</th>
                        <td>
                            <span class="time-input"></span>
                            <span class="time-separator">〜</span>
                            <span class="time-input"></span>
                        </td>
                    </tr>
                    <tr>
                        <th>備考</th>
                        <td>
                            <span class="remark-text">{{$application->remarks}}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <form method="POST" action="{{ route('admin.approve', ['id' => $application->id]) }}">
                @csrf
                @if ($application->approval_flag == 0)
                <div class="button-wrapper">
                    <button type="submit" class="submit-button">承認</button>
                </div>
                @else
                <div class="button-wrapper">
                    <button class="submit-button approved" disabled>承認済み</button>
                </div>
                @endif
            </form>
        </div>
    </main>
</body>

</html>