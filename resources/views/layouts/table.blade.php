<!DOCTYPE html>
<html lang="en" style="height: 100%">

<head>
    <link rel="icon" href="static/img/us-icon.ico" type="image/x-icon" />
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--ICON-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap_icons-1.4.1/font/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/fontawesome-free-5.15.3-web/css/all.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}" />
    <!--Bootstrap-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap-5.1.3-dist/css/bootstrap.min.css') }}" />
    <!--Calendar-->
    <link rel="stylesheet" href="static/evo-calendar/css/evo-calendar.css" />
    <link rel="stylesheet" href="static/evo-event-calendar/css/evo-calendar.orange-coral.css" />
    <!--BootstrapTable-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap-table-master/dist/bootstrap-table.min.css') }}" />
    <!-- Datetime picker -->
    <link rel="stylesheet"
        href="{{ asset('static/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css') }}" />
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('static/sweetalert2-11.7.1/dist/sweetalert2.min.css') }}" />
    <script src="{{ asset('static/sweetalert2-11.7.1/dist/sweetalert2.all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('static/quill-1.3.6/quill.snow.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/quill-1.3.6/quill.core.css') }}" />
    <!--MultiSelect-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}"
        type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous">
    </script>
    <!-- import self-css -->
    <link rel="stylesheet" href="{{ asset('static/css/article.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/master_page.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/forum_list.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/user.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/css/point.css') }}" />
    <!-- jsCalendar -->
    <link rel="stylesheet" type="text/css" href="{{ asset('static/jsCalendar-master/source/jsCalendar.css') }}" />

    <title>DNLab論壇 - DNLab</title>
    <style>
        #calendar {
            font-size: var(--fs-18);
        }
    </style>
</head>

<body>
    @section('mainmeau')
        <div class="container-xxl topbar">
            <nav class="navbar navbar-expand-lg border-bottom fixed-top">
                <div class="container-xxl px-md-4">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <img src="{{ asset('static/img/us-logo.png') }}" alt="" height="40"
                            class="d-inline-block align-text-top" />
                    </a>
                    <div class="align-items-center">
                        <button class="navbar-toggler notify_bell" type="button" data-bs-toggle="tooltip"
                            data-bs-title="通知" data-bs-placement="bottom">
                            <i class="fas fa-bell ct-txt-1"></i>
                            <!--如有新通知 顯示紅點-->
                            <span
                                class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </button>
                        <button class="navbar-toggler border" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNavDropdown">
                            <i class="fas fa-bars ct-txt-1"></i>
                        </button>
                    </div>

                    <div class="justify-content-end collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav mb-2 mb-md-0" id="topbar-nav-tabs">
                            <li class="nav-item">
                                <a href="#" class="nav-link active" data-bs-toggle="dropdown">知識圖書館</a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('knowledge_library', ['category' => '小產調理', 'subcategory' => '小產知識']) }}">小產調理</a>
                                    <a class="dropdown-item"
                                        href="{{ route('knowledge_library', ['category' => '婦科保健', 'subcategory' => '婦科保健知識']) }}">婦科保健</a>
                                    <a class="dropdown-item"
                                        href="{{ route('knowledge_library', ['category' => '備孕調理', 'subcategory' => '備孕知識']) }}">備孕調理</a>
                                    <a class="dropdown-item"
                                        href="{{ route('knowledge_library', ['category' => '懷孕知識', 'subcategory' => '懷孕知識']) }}">懷孕知識</a>
                                    <a class="dropdown-item"
                                        href="{{ route('knowledge_library', ['category' => '日常保健', 'subcategory' => '日常保健知識']) }}">日常保健</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link active" data-bs-toggle="dropdown">療心室</a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('treatment_qa', ['article' => '聊療小產']) }}">聊療小產</a>
                                    <a class="dropdown-item"
                                        href="{{ route('treatment_qa', ['article' => '聊療婦科保健']) }}">聊療婦科保健</a>
                                    <a class="dropdown-item"
                                        href="{{ route('treatment_qa', ['article' => '聊療備孕']) }}">聊療備孕</a>
                                    <a class="dropdown-item"
                                        href="{{ route('treatment_qa', ['article' => '聊療懷孕']) }}">聊療懷孕</a>
                                    <a class="dropdown-item"
                                        href="{{ route('treatment_qa', ['article' => '聊療日常保健']) }}">聊療日常保健</a>
                                </ul>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link active">暢聊咖啡廳</a></li>
                            <li class="nav-item"><a href="#" class="nav-link active">營養師諮詢</a></li>
                            <li class="nav-item notify_bell d-none d-lg-block" data-bs-toggle="tooltip"
                                data-bs-title="通知" data-bs-placement="bottom">
                                <a class="nav-link" style="cursor: pointer">
                                    <i class="fas fa-bell"></i>
                                    <!--如有新通知 顯示紅點-->
                                    <span
                                        class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <!--如有會員登入 顯示會員名稱-->
                                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle"> {{ !empty($nickname) ? $nickname : '未登入' }}</i>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('user_info') }}">個人資料</a>
                                    <a class="dropdown-item" href="{{ route('CalendarIndex') }}">專屬月曆</a>
                                    <a class="dropdown-item" href="{{ route('point_task') }}">點數錢包</a>
                                    <a class="dropdown-item" href="{{ route('my_mind') }}">我的心事</a>
                                    <a class="dropdown-item" href="#">文章列表</a>
                                    <a class="dropdown-item" href="{{ route('article_saved_list') }}">收藏與追蹤</a>
                                    @if (empty($nickname))
                                        <a class="dropdown-item" href="{{ route('user_login') }}">登入</a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('user.signout') }}">登出</a>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <!--通知欄區塊-->
                    <div class="notifications border" id="notifications_box">
                        <h2>Notifications <span class="badge bg-danger rounded-circle">2</span></h2>
                        <div class="notifications-item">
                            <img src="https://i.imgur.com/uIgDDDd.jpg" alt="img" />
                            <div class="text">
                                <h4>Samso aliao</h4>
                                <p>Samso Nagaro Like your home work</p>
                            </div>
                        </div>
                        <div class="notifications-item">
                            <img src="https://img.icons8.com/flat_round/64/000000/vote-badge.png" alt="img" />
                            <div class="text">
                                <h4>John Silvester</h4>
                                <p>+20 vista badge earned</p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    @show
    <!-- @if (!isset($sidebar))
        @php $sidebar = ''; @endphp
    @endif -->

    @if ($sidebar == 'knowledge')
        @section('knowledge_sidebar')
            <!--右邊欄選單-->
            <div class="col-md-4 col-lg d-flex align-items-start">
                <div class="row position-sticky" id="right-sidebar">
                    <div class="mb-3 px-0 col-12 my-auto">
                        <input type="text" class="form-control rounded-pill search-input" placeholder="&#xF52A; 搜尋文章"
                            style="font-family: 'bootstrap-icons'" />
                    </div>
                    <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                        <p class="ct-title-1 my-auto" style="font-weight: 500">文章類別</p>
                    </div>
                    <div class="col-12 px-0">
                        <ul class="nav flex-column" id="article_class_list">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-1">小產調理<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse {{ $category == '小產調理' ? 'show' : '' }}" id="sub-class-1">
                                    <a class="dropdown-item {{ $subcategory == '小產知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '小產調理', 'subcategory' => '小產知識']) }}">小產知識</a>
                                    <a class="dropdown-item {{ $subcategory == '小產調理知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '小產調理', 'subcategory' => '小產調理知識']) }}">小產調理知識</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-2">婦科保健<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse {{ $category == '婦科保健' ? 'show' : '' }}" id="sub-class-2">
                                    <a class="dropdown-item {{ $subcategory == '婦科保健知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '婦科保健', 'subcategory' => '婦科保健知識']) }}">婦科保健知識</a>
                                    <a class="dropdown-item {{ $subcategory == '婦科保健調理知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '婦科保健', 'subcategory' => '婦科保健調理知識']) }}">婦科保健調理知識</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-3">備孕調理<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse {{ $category == '備孕調理' ? 'show' : '' }}" id="sub-class-3">
                                    <a class="dropdown-item {{ $subcategory == '備孕知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '備孕調理', 'subcategory' => '備孕知識']) }}">備孕知識</a>
                                    <a class="dropdown-item {{ $subcategory == '備孕調理知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '備孕調理', 'subcategory' => '備孕調理知識']) }}">備孕調理知識</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-4">懷孕知識<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse {{ $category == '懷孕知識' ? 'show' : '' }}" id="sub-class-4">
                                    <a class="dropdown-item {{ $subcategory == '懷孕知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '懷孕知識', 'subcategory' => '懷孕知識']) }}">懷孕知識</a>
                                    <a class="dropdown-item {{ $subcategory == '懷孕調理知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '懷孕知識', 'subcategory' => '懷孕調理知識']) }}">懷孕調理知識</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-5">日常保健<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse {{ $category == '日常保健' ? 'show' : '' }}" id="sub-class-5">
                                    <a class="dropdown-item {{ $subcategory == '日常保健知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '日常保健', 'subcategory' => '日常保健知識']) }}">日常保健知識</a>
                                    <a class="dropdown-item {{ $subcategory == '日常保健調理知識' ? 'active' : '' }}"
                                        href="{{ route('knowledge_library', ['category' => '日常保健', 'subcategory' => '日常保健調理知識']) }}">日常保健調理知識</a>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @show
    @endif

    @if ($sidebar == 'treatment')
        @section('treatment_sidebar')
            <!--右邊欄選單-->
            <div class="col-md-4 col-lg d-flex align-items-start">
                <div class="row position-sticky" id="right-sidebar">
                    <div class="mb-3 px-0 col-12 my-auto">
                        <input type="text" class="form-control rounded-pill search-input" placeholder="&#xF52A; 搜尋文章"
                            style="font-family: 'bootstrap-icons'" />
                    </div>
                    <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                        <p class="ct-title-1 my-auto" style="font-weight: 500">聊療類別</p>
                    </div>
                    <div class="col-12 px-0">
                        <ul class="nav flex-column" id="treat_class_list">
                            <li class="nav-item">
                                <a class="nav-link {{ $category == '聊療小產' ? 'active' : '' }}"
                                    href="{{ route('treatment_qa', ['article' => '聊療小產']) }}">聊療小產</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $category == '聊療婦科保健' ? 'active' : '' }}"
                                    href="{{ route('treatment_qa', ['article' => '聊療婦科保健']) }}">聊療婦科保健</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $category == '聊療備孕' ? 'active' : '' }}"
                                    href="{{ route('treatment_qa', ['article' => '聊療備孕']) }}">聊療備孕</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $category == '聊療懷孕' ? 'active' : '' }}"
                                    href="{{ route('treatment_qa', ['article' => '聊療懷孕']) }}">聊療懷孕</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $category == '聊療日常保健' ? 'active' : '' }}"
                                    href="{{ route('treatment_qa', ['article' => '聊療日常保健']) }}">聊療日常保健</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @show
    @endif

    @if ($sidebar == 'user')
        @section('user_sidebar')
            <!--右邊欄選單-->
            <div class="col-md-4 col-lg d-flex align-items-start">
                <div class="row position-sticky" id="right-sidebar">
                    <div class="mb-3 px-0 col-12 my-auto">
                        <input type="text" class="form-control search-input rounded-pill" placeholder="&#xF52A; 搜尋文章"
                            style="font-family: 'bootstrap-icons'" />
                    </div>
                    <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                        <p class="ct-title-1 my-auto" style="font-weight: 500">個人資料</p>
                    </div>
                    <div class="col-12 px-0">
                        <ul class="nav flex-column" id="info_class_list">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-1">會員資料<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse show" id="sub-class-1">
                                    <a class="dropdown-item {{ $title == 'user' ? 'active' : '' }}"
                                        href="{{ route('user_info') }}">會員資料</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $title == 'calendar' ? 'active' : '' }}"
                                    href="{{ route('CalendarIndex') }}">專屬月曆</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-2">點數錢包<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse {{ $title == 'point' ? 'show' : '' }}" id="sub-class-2">
                                    <a class="dropdown-item {{ $web_name == 'point_task' ? 'active' : '' }}"
                                        href="{{ route('point_task') }}">任務專區</a>
                                    <a class="dropdown-item {{ $web_name == 'point_exchange' ? 'active' : '' }}"
                                        href="{{ route('point_exchange') }}">點數兌換</a>
                                    <a class="dropdown-item {{ $web_name == 'point_gift1' ? 'active' : '' }}"
                                        href="{{ route('point_gift1') }}">點數轉贈</a>
                                    <a class="dropdown-item {{ $web_name == 'point_get_record' ? 'active' : '' }}"
                                        href="{{ route('point_get_record') }}">點數獲得紀錄</a>
                                    <a class="dropdown-item {{ $web_name == 'point_use_record' ? 'active' : '' }}"
                                        href="{{ route('point_use_record') }}">點數使用紀錄</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $title == 'my_mind' ? 'active' : '' }}"
                                    href="{{ route('my_mind') }}">我的心事</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-3">收藏與追蹤<i
                                        class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse {{ $title == 'article' ? 'show' : '' }}" id="sub-class-3">
                                    <a class="dropdown-item {{ $web_name == 'article_saved_list' ? 'active' : '' }}"
                                        href="{{ route('article_saved_list') }}">文章收藏</a>
                                    <a class="dropdown-item {{ $web_name == 'author_saved' ? 'active' : '' }}"
                                        href="{{ route('author_saved') }}">作者收藏</a>
                                    <a class="dropdown-item {{ $web_name == 'topic_saved' ? 'active' : '' }}"
                                        href="{{ route('topic_saved') }}">話題收藏</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.signout') }}">登出</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @show
    @endif

    @if ($sidebar == 'mebmerProfile')
        @section('mebmer_profile')
            <!--右邊欄選單-->
            <div class="col-md-4 col-lg d-flex align-items-start">
                <div class="row position-sticky" id="right-sidebar">
                    <div class="mb-3 px-0 col-12 my-auto">
                        <input type="text" class="form-control rounded-pill search-input" placeholder="&#xF52A; 搜尋文章"
                            style="font-family: 'bootstrap-icons'" />
                    </div>
                    <div class="col-12 px-0">
                        <ul class="nav flex-column" id="treat_class_list">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user_info') }}">個人資料</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('point_task') }}">點數錢包</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">文章列表</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('article_saved_list') }}">收藏與追中</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.signout') }}">登出</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @show
    @endif

    @section('about')
        <div class="position-fixed bottom-0 end-0 m-2">
            <button class="btn" id="floatButton" data-bs-toggle="tooltip" data-bs-title="營養師諮詢"
                data-bs-placement="left">
                <i class="fas fa-comment-dots"></i>
            </button>
        </div>

        <footer class="footer-px ct-bg-3 mt-5" style="position: fixed; bottom: 0; left: 0; right: 0;">
            <div class="row p-xs-2 p-md-4 px-lg-5 text-center justify-content-md-center justify-content-lg-evenly">
                <div class="col-4 col-md-2 col-lg-auto mb-2">
                    <a href="#" class="">關於我們</a>
                </div>
                <div class="col-4 col-md-2 col-lg-auto mb-2">
                    <a href="#" class="">聯絡我們</a>
                </div>
                <div class="col-4 col-md-2 col-lg-auto mb-2">
                    <a href=""{{ route('common_qa') }} class="">常見問題</a>
                </div>
                <div class="col-4 col-md-2 col-lg-auto mb-2">
                    <a href="#" class="">使用者條款</a>
                </div>
                <div class="col-4 col-md-2 col-lg-auto mb-2">
                    <a href="#" class="">隱私權政策</a>
                </div>
                <div class="col-4 col-md-2 col-lg-auto mb-2">
                    <a href="#" class="">DNLab官網</a>
                </div>

                <div class="col-12 col-md-auto mt-2 mt-lg-0 mb-sm-2">
                    <a href="#" class="col-12 ct-txt-2 mx-3 mx-md-2"><i class="fab fa-line"></i></a>
                    <a href="#" class="col-12 ct-txt-2 mx-3 mx-md-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="col-12 ct-txt-2 mx-3 mx-md-2"><i class="fab fa-facebook-square"></i></a>
                </div>
            </div>
        </footer>
    @show

    <script src={{ asset('static/bootstrap-4.6.0-dist/jquery-3.6.0.js') }}></script>
    <script src={{ asset('static/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('static/bootstrap-table-master/dist/bootstrap-table.min.js') }}></script>
    <script src={{ asset('static/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}></script>
    <script src={{ asset('static/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js') }}></script>
    <script src={{ asset('static/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.zh-TW.min.js') }}></script>
    <script src={{ asset('static/dayjs-1.11.8/package/dayjs.min.js') }}></script>
    <script src={{ asset('static/tinymce/js/tinymce/tinymce.min.js') }}></script>
    <script src={{ asset('static/quill-1.3.6/quill.js') }}></script>
    <script src={{ asset('static/evo-event-calendar/js/evo-calendar.js') }}></script>

    <script src={{ asset('static/js/master_page.js') }}></script>
    <script src={{ asset('static/js/index.js') }}></script>
    <script src={{ asset('static/js/forum_list.js') }}></script>
    <script src={{ asset('static/js/user.js') }}></script>
    <script src={{ asset('static/js/points.js') }}></script>
    <script src={{ asset('static/js/article.js') }}></script>
    <script src={{ asset('static/js/calendar.js') }}></script>

    <script>
        const myModal = new bootstrap.Modal("#create_modal", {
            focus: false,
        });

        var toolbarOptions = [
            [{
                'font': []
            }],
            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown

            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],

            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'align': []
            }],
            ['link', 'image']
        ];

        var quill = new Quill('#editor-container', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow' // or 'bubble'
        });

        // var patch_quill = new Quill('#patch-editor-container', {
        //     theme: 'snow',
        // });

        var patch_quill = new Quill('#patch-editor-container', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow' // or 'bubble'
        });


        // quill.on('editor-change', function(eventName, ...args) {
        //     if (eventName === 'text-change') {
        //         var editorHTML = quill.root.innerHTML;

        //         // 檢查內容中是否包含圖片
        //         var imgTags = quill.root.querySelectorAll('img');
        //         if (imgTags.length > 0) {
        //             // 取得第一張圖片
        //             var firstImage = imgTags[0];

        //             // 將圖片轉換成 Blob 物件
        //             var imageUrl = firstImage.getAttribute('src');
        //             // console.log(imageUrl);
        //         }
        //     }
        // });


        //取文字編輯器內容
        function get_content() {
            tinymce.activeEditor.dom.addClass(tinymce.activeEditor.dom.select("img"), "w-100");

            let content = tinymce.get("editor").getContent();
            console.log(content);
        }
    </script>
</body>

</html>
