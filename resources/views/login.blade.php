
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTub - Административная панель</title>
    <link href="{{asset('assets/css/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <style>
        :root {
            --primary-orange: #FF6B35;
            --primary-dark: #2C2C2C;
            --secondary-gray: #F5F5F5;
            --border-gray: #E0E0E0;
            --text-dark: #333333;
            --text-light: #666666;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #FAFAFA;
            color: var(--text-dark);
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #FFFFFF 0%, #F5F5F5 100%);
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 48px;
            width: 100%;
            max-width: 440px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .login-logo .brand-accent {
            color: var(--primary-orange);
        }

        .login-logo p {
            color: var(--text-light);
            font-size: 14px;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 1px solid var(--border-gray);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-control.is-invalid {
            border-color: #DC3545;
        }

        .invalid-feedback {
            display: block;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn-primary {
            background-color: var(--primary-orange);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #E85A2A;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .alert {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-danger {
            background-color: #FFEBEE;
            color: #C62828;
        }
    </style>
</head>

<body>

<div class="login-wrapper" id="loginPage">
    <div class="login-card">

        <div class="login-logo">
            <h1>R<span class="brand-accent">Tub</span></h1>
            <p>Административная панель</p>
        </div>

        <form method="post" action="/rtub_admin/auth">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>

                <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="admin@rtub.com"
                    name="email"
                >
                @error('email')
                <div class="invalid-feedback">
                   {{$message}}
                </div>
                @enderror
            </div>


            <div class="mb-4">
                <label for="password" class="form-label">Пароль</label>

                <input
                    type="password"
                    class="form-control"
                    id="password"
                    placeholder="••••••••"
                    name="password"
                >
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>


           @error('error')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror

            <button type="submit" class="btn btn-primary w-100">
                Войти
            </button>

        </form>
    </div>
</div>

</body>
</html>
