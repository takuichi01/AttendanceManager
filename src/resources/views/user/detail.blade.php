<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <title>勤怠詳細</title>
</head>

<body>
    @include('partial.header')
    <main class="attendance-main">
        <div class="detail-container">
            <h2 class="detail-title">勤怠詳細</h2>
            @if (!$applying_flg)
            <form method="POST" action="{{ route('attendance.apply', ['id' => $attendance->id]) }}">
                @csrf
                <div class="detail-box">
                    <table class="detail-table">
                        <tr>
                            <th>名前</th>
                            <td>{{ $attendance->staff_name }}</td>
                        </tr>
                        <tr>
                            <th>日付</th>
                            <td>
                                <span class="date-year">{{ \Carbon\Carbon::parse($attendance->date)->format('Y年')
                                    }}</span>
                                <span class="date-day">{{ \Carbon\Carbon::parse($attendance->date)->format('n月j日')
                                    }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>出勤・退勤</th>
                            <td>
                                <input type="text" name="work_start_time" class="time-input" value={{
                                    $attendance->work_start_time ?
                                \Carbon\Carbon::parse($attendance->work_start_time)->format('H:i') : null }}>
                                <span class="time-separator">〜</span>
                                <input type="text" name="work_end_time" class="time-input" value={{
                                    $attendance->work_end_time ?
                                \Carbon\Carbon::parse($attendance->work_end_time)->format('H:i') : null }}>
                                @error('work_time')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        @php($count = 0)
                        @foreach ($attendance->breakTimes as $i => $break_time)
                        @php($count++)
                        <tr>
                            <th>休憩{{ $break_count==1 ? '' : $count}}</th>
                            <td>
                                <input type="text" name="break_start_time[]" class="time-input"
                                    value={{\Carbon\Carbon::parse($break_time->break_start_time)->format('H:i')}}>
                                <span class="time-separator">〜</span>
                                <input type="text" name="break_end_time[]" class="time-input"
                                    value={{\Carbon\Carbon::parse($break_time->break_end_time)->format('H:i')}}>
                                @error("break_start_time.$i")
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                                @error("break_end_time.$i")
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        @endforeach
                        @php($count++)
                        <tr>
                            <th>休憩{{$count}}</th>
                            <td>
                                <input type="text" name="add_break_start_time" class="time-input" value="">
                                <span class="time-separator">〜</span>
                                <input type="text" name="add_break_end_time" class="time-input" value="">
                                @error('add_break_start_time')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                                @error('add_break_end_time')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>備考</th>
                            <td>
                                <textarea name="remarks" class="remark-input"
                                    rows="3">{{$attendance->remarks}}</textarea>
                                @error('remarks')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="button-wrapper">
                    <button type="submit" class="submit-button">修正</button>
                </div>
            </form>
            @else
            <div class="detail-box">
                <table class="detail-table">
                    <tr>
                        <th>名前</th>
                        <td>{{ $attendance->staff_name }}</td>
                    </tr>
                    <tr>
                        <th>日付</th>
                        <td>
                            <span class="date-year">{{ \Carbon\Carbon::parse($attendance->date)->format('Y年')
                                }}</span>
                            <span class="date-day">{{ \Carbon\Carbon::parse($attendance->date)->format('n月j日')
                                }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>出勤・退勤</th>
                        <td>
                            <input type="text" name="work_start_time" class="time-input" value={{
                                $attendance->work_start_time ?
                            \Carbon\Carbon::parse($attendance->work_start_time)->format('H:i') : null }} readonly>
                            <span class="time-separator">〜</span>
                            <input type="text" name="work_end_time" class="time-input" value={{
                                $attendance->work_end_time ?
                            \Carbon\Carbon::parse($attendance->work_end_time)->format('H:i') : null }} readonly>
                        </td>
                    </tr>
                    @php($count = 0)
                    @foreach ($attendance->breakTimes as $break_time)
                    @php($count++)
                    <tr>
                        <th>休憩{{ $break_count==1 ? '' : $count}}</th>
                        <td>
                            <input type="text" name="break_start_time[]" class="time-input"
                                value={{\Carbon\Carbon::parse($break_time->break_start_time)->format('H:i')}} readonly>
                            <span class="time-separator">〜</span>
                            <input type="text" name="break_end_time[]" class="time-input"
                                value={{\Carbon\Carbon::parse($break_time->break_end_time)->format('H:i')}} readonly>
                        </td>
                    </tr>
                    @endforeach
                    @php($count++)
                    <tr>
                        <th>休憩{{$count}}</th>
                        <td>
                            <input type="text" name="add_break_start_time" class="time-input" value="" readonly>
                            <span class="time-separator">〜</span>
                            <input type="text" name="add_break_end_time" class="time-input" value="" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>備考</th>
                        <td>
                            <span class="remark-text">{{$attendance->remarks}}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="button-wrapper">
                <span class="wait-approve">*承認待ちのため修正はできません。</span>
            </div>
            @endif
        </div>
    </main>
</body>

</html>