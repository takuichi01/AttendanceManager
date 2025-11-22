<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
    <title>会員登録</title>
</head>

<body>
    <header>
        <img src="img/logo/logo.svg" alt="COACHTECH">
    </header>
    <main>
        <h1>会員登録</h1>
        <form method="POST" action="/register">
            @csrf
            <div class=form-group>
                <label for="name">名前</label>
                <input type="text" id="name" name="name">
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class=form-group>
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email">
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class=form-group>
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password">
                @php
                $passwordErrors = $errors->get('password');
                @endphp
                @if ($passwordErrors)
                @foreach ($passwordErrors as $error)
                @if (!Str::contains($error, '一致'))
                <div class="error-message">{{ $error }}</div>
                @endif
                @endforeach
                @endif
            </div>
            <div class=form-group>
                <label for="password_confirmation">パスワード確認</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
                @php
                $passwordErrors = $errors->get('password');
                $hasMinError = false;
                $confirmedError = null;
                if ($passwordErrors) {
                foreach ($passwordErrors as $error) {
                if (Str::contains($error, '8文字以上')) {
                $hasMinError = true;
                }
                if (Str::contains($error, '一致')) {
                $confirmedError = $error;
                }
                }
                }
                @endphp

                @if ($confirmedError && !$hasMinError)
                <div class="error-message">{{ $confirmedError }}</div>
                @endif
            </div>
            <div>
                <button type="submit">登録する</button>
            </div>
        </form>
        <div class=login-link>
            <a href="/login">ログインはこちら</a>
        </div>
    </main>
</body>

</html>