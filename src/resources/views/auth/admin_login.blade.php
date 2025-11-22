<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin_login.css') }}">
    <title>管理者ログイン</title>
</head>

<body>
    <header class="site-header">
        <h1 class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="COACHTECHロゴ" class="logo-img">
        </h1>
    </header>
    <main class="login-main">
        <h2 class="login-title">管理者ログイン</h2>
        <form method="POST" class="login-form">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" id="email" name="email" class="form-input">
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" id="password" name="password" class="form-input">
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn-submit">管理者ログインする</button>
            </div>
        </form>
    </main>
</body>

</html>