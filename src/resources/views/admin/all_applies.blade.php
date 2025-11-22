<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/all_applies.css') }}">
    <title>申請一覧</title>
</head>

<script src="{{ asset('js/stamp_correction_request_tab.js') }}"></script>

<body>
    @include('partial.admin_header')
    <main class="request-main">
        <h2 class="request-title">申請一覧</h2>
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('pending')">承認待ち</button>
            <button class="tab-btn" onclick="showTab('approved')">承認済み</button>
        </div>
        <div class="tab-content" id="pending-tab">
            <!-- 承認待ちの内容 -->
            <table class="request-table">
                <thead>
                    <tr>
                        <th>状態</th>
                        <th>名前</th>
                        <th>対象日時</th>
                        <th>申請理由</th>
                        <th>申請日時</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                    @if ($application->approval_flag == 1)
                    @continue
                    @endif
                    <tr>
                        <td>{{ $application->approval_flag == 0 ? '承認待ち' : '承認済み' }}</td>
                        <td>{{$application->staffUser->name}}</td>
                        <td>{{$application->attendance_date}}</td>
                        <td>{{$application->remarks}}</td>
                        <td>{{\Carbon\Carbon::parse($application->created_at)->format('Y-m-d')}}</td>
                        <td><a href="{{ route('admin.show.application', ['id'=> $application->id]) }}"
                                class="detail-link">詳細</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-content" id="approved-tab" style="display:none;">
            <!-- 承認済みの内容 -->
            <table class="request-table">
                <thead>
                    <tr>
                        <th>状態</th>
                        <th>名前</th>
                        <th>対象日時</th>
                        <th>申請理由</th>
                        <th>申請日時</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                    @if ($application->approval_flag == 0)
                    @continue
                    @endif
                    <tr>
                        <td>{{ $application->approval_flag == 1 ? '承認済み' : '承認待ち' }}</td>
                        <td>{{$application->staffUser->name}}</td>
                        <td>{{$application->attendance_date}}</td>
                        <td>{{$application->remarks}}</td>
                        <td>{{\Carbon\Carbon::parse($application->created_at)->format('Y-m-d')}}</td>
                        <td><a href="{{route('admin.show.application', ['id'=> $application->id])}}"
                                class="detail-link">詳細</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr class="tab-divider">

    </main>
</body>

</html>