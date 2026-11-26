
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTub - Административная панель</title>
    <link href="{{asset('assets/css/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/fonts/fontawesome/css/all.min.css')}}" rel="stylesheet">

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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI',
            Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #FAFAFA;
            color: var(--text-dark);
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid var(--border-gray);
            padding: 24px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 0 24px 24px;
            border-bottom: 1px solid var(--border-gray);
            margin-bottom: 24px;
        }

        .sidebar-brand h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .brand-accent {
            color: var(--primary-orange);
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a.active {
            background-color: rgba(255, 107, 53, 0.08);
            color: var(--primary-orange);
        }

        .sidebar-nav li a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 24px 32px;
        }

        .top-bar {
            background: white;
            border-radius: 12px;
            padding: 16px 24px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .page-title h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logout-btn {
            background: none;
            border: 1px solid var(--border-gray);
            border-radius: 8px;
            padding: 8px 16px;
            color: var(--text-light);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            border-color: var(--primary-orange);
            color: var(--primary-orange);
        }

        .content-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .search-bar {
            margin-bottom: 24px;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            gap: 8px;
        }

        .search-form {
            display: flex;
            gap: 8px;
            width: 100%;
            justify-content: space-between;
        }

        .search-input-wrapper {
            position: relative;
            flex: 1;
        }

        .search-input {
            border: 1px solid var(--border-gray);
            border-radius: 8px;
            padding: 12px 16px 12px 44px;
            font-size: 14px;
            width: 100%;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .btn-search {
            background-color: var(--primary-orange);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-search:hover {
            background-color: #E85A2A;
        }

        .video-table {
            width: 100%;
            margin-bottom: 24px;
            border-collapse: collapse;
        }

        .video-table thead th {
            background-color: var(--secondary-gray);
            border: none;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .video-table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--border-gray);
            vertical-align: middle;
        }

        .video-player {
            width: 200px;
            height: 112px;
            border-radius: 6px;
            background: #000;
        }

        .video-cell {
            min-width: 200px;
        }

        .video-title {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .video-author {
            font-size: 13px;
            color: var(--text-light);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-moderation {
            background-color: #FFF3E0;
            color: #F57C00;
        }

        .btn-approve {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-right: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-approve:hover {
            background-color: #45A049;
        }

        .btn-reject {
            background-color: #F44336;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-reject:hover {
            background-color: #D32F2F;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }

        .pagination {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination .page-item .page-link {
            border: 1px solid var(--border-gray);
            border-radius: 6px;
            padding: 8px 14px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            display: block;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
            color: white;
        }

        .pagination .page-item .page-link:hover {
            background-color: rgba(255, 107, 53, 0.08);
            border-color: var(--primary-orange);
        }

        .preview {
            max-width: 200px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
<div class="admin-wrapper">

    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>R<span class="brand-accent">Tub</span></h2>
        </div>

        <ul class="sidebar-nav">
            <li>
                <a href="#" class="active">
                    <i class="fas fa-video"></i>
                    Модерация видео
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">

        <div class="top-bar">
            <div class="page-title">
                <h1>Модерация видео</h1>
            </div>

            <div class="admin-info">
                <form action="/rtub_admin/logout" method="GET">
                    <button class="logout-btn" type="submit"> <i class="fas fa-sign-out-alt"></i>
                        Выйти</button>
                </form>
            </div>
        </div>

        <div class="content-card">

            <div class="search-bar">
                <div class="search-wrapper">
                    <form action="{{url()->current()}}" method="GET" class="search-form">

                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>

                            <input
                                type="text"
                                name="query"
                                class="search-input"
                                placeholder="Поиск по названию видео..."
                            >
                        </div>

                        <button type="submit" class="btn-search">
                            Искать
                        </button>

                    </form>
                </div>
            </div>

            <table class="video-table">
                <thead>
                <tr>
                    <th>ВИДЕО</th>
                    <th>ПРЕВЬЮ</th>
                    <th>НАЗВАНИЕ</th>
                    <th>АВТОР</th>
                    <th>ДАТА СОЗДАНИЯ</th>
                    <th>ДАТА РЕДАКТИРОВАНИЯ</th>
                    <th>ДЕЙСТВИЯ</th>
                </tr>
                </thead>

                <tbody>
                @foreach($videos as $video)

                    <tr>
                        <td class="video-cell">
                            <video
                                src="{{\Illuminate\Support\Facades\Storage::disk('public')->url($video->preview)}}"
                                class="video-player"
                                controls
                            ></video>
                        </td>

                        <td>
                            <img
                                src="{{\Illuminate\Support\Facades\Storage::disk('public')->url($video->preview)}}"
                                alt="Превью"
                                class="preview"
                            >
                        </td>

                        <td>
                            <div class="video-title">
                                {{$video->name}}
                            </div>
                        </td>

                        <td>{{$video->user()->first()->nickname}}</td>

                        <td>{{$video->created_at->format('Y-m-d')}}</td>

                        <td>{{$video->updated_at->format('Y-m-d')}}</td>

                        <td>
                            <form action="{{route('videos.approve', $video->id)}}" method="post">
                                <button type="submit" class="btn-approve">
                                    <i class="fas fa-check"></i>
                                    Одобрить
                                </button>
                            </form>

                            <form action="{{route('videos.reject', $video->id)}}" method="post">
                                <button type="submit" class="btn-reject">
                                    <i class="fas fa-times"></i>
                                    Отклонить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{$videos->links()}}
        </div>
    </main>
</div>
</body>
</html>
