<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Freedom Board</title>
    @vite('resources/css/app.css')
    <style>
                .nav-logout-btn {
                    background: none !important;
                    border: none !important;
                    color: black !important;
                    cursor: pointer;
                    font-size: 0.65rem !important;
                    line-height: 1 !important;
                    padding: 0 4px !important;
                    margin: 0 auto !important;
                    outline: none !important;
                    min-width: 0 !important;
                    min-height: 0 !important;
                    width: auto !important;
                    height: auto !important;
                    box-sizing: content-box !important;
                }
                .nav-logout-btn:focus {
                    outline: none;
                    box-shadow: none;
                }
                .nav-logout-btn:hover {
                    text-decoration: underline;
                }
                .nav-logout-form {
                    padding: 10; !important;
                }
        .form-container, .board-container {
            max-width: 600px;
            margin: 40px auto;
            background: #f9f9f9;
            padding: 0px auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .error {
            color: #d32f2f;
            padding: 10px;
            margin-bottom: 15px;
            background: #ffebee;
            border-radius: 3px;
        }
        .success {
            color: #2e7d32;
            padding: 10px;
            margin-bottom: 15px;
            background: #e8f5e9;
            border-radius: 3px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #1976d2;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 1em;
        }
        button[type="submit"]:hover {
            background: #1565c0;
        }
        .register-link, .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-link a, .login-link a {
            color: #1976d2;
            text-decoration: none;
        }
        .register-link a:hover, .login-link a:hover {
            text-decoration: underline;
        }
        .posts-list {
            margin-top: 30px;
        }
        .post {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 15px;
        }
        .post-header {
            font-size: 0.95em;
            color: #555;
            margin-bottom: 8px;
        }
        .post-date {
            float: right;
            color: #aaa;
        }
        .post-content {
            font-size: 1.1em;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav style="background:#1976d2;padding:10px 0 10px 0;margin-bottom:30px;">
        <div style="max-width:600px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;">
            <span style="color:white;font-size:1.3em;font-weight:bold;padding:0 20px;">Freedom Board</span>
            <div style="padding:0 20px;">
                @guest
                    <a href="{{ route('login') }}" style="color:white;margin-right:15px;text-decoration:none;">Login</a>
                    <a href="{{ route('register') }}" style="color:white;text-decoration:none;">Register</a>
                @else
                    <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                        @csrf
                        <button type="submit" class="nav-logout-btn">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
    @yield('content')
</body>
</html>