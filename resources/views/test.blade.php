<!DOCTYPE html>
<html lang="en" style="height: 100%">
    <head>
        <link rel="icon" href="static/img/us-icon.ico" type="image/x-icon" />
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!--ICON-->
        <link rel="stylesheet" href="static/bootstrap_icons-1.4.1/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="static/fontawesome-free-5.15.3-web/css/all.css" />
        <!--Calendar-->
        <!-- <link rel="stylesheet" href="static/evo-calendar/css/evo-calendar.css" />
        <link rel="stylesheet" href="static/evo-event-calendar/css/evo-calendar.orange-coral.css" /> -->
        <!--Bootstrap-->
        <link rel="stylesheet" href="static/bootstrap-5.1.3-dist/css/bootstrap.min.css" />
        <!-- Datetime picker -->
        <link rel="stylesheet" href="static/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css" />
        <!-- Sweet Alert -->
        <link rel="stylesheet" href="static/sweetalert2-11.7.1/dist/sweetalert2.min.css" />
        <script src="static/sweetalert2-11.7.1/dist/sweetalert2.all.min.js"></script>
        <!-- jsCalendar -->
        <link rel="stylesheet" type="text/css" href="static/jsCalendar-master/source/jsCalendar.css" />

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
            integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
            crossorigin="anonymous"
        ></script>
        <!-- import self-css -->
        <link rel="stylesheet" href="static/css/master_page.css" />
        <link rel="stylesheet" href="static/css/forum_list.css" />

        <title>優德莎莉 專屬月曆</title>
        <style>
            #calendar {
                font-size: var(--fs-18);
            }
            /* #events .list {
                height: 150px;
                overflow-y: auto;
                border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            }
            #events .list .event-item {
                line-height: 24px;
                min-height: 24px;
                padding: 2px 5px;
                border-top: 1px solid rgba(0, 0, 0, 0.2);
            }
            #events .list .event-item .close {
                font-family: Tahoma, Geneva, sans-serif;
                font-weight: bold;
                font-size: 12px;
                color: #000;
                border-radius: 8px;
                height: 14px;
                width: 14px;
                line-height: 12px;
                text-align: center;
                float: right;
                border: 1px solid rgba(0, 0, 0, 0.5);
                padding: 0px;
                margin: 5px;
                display: block;
                overflow: hidden;
                background: #f44336;
                cursor: pointer;
            } */
        </style>
    </head>
    <body>
        <div class="container-xxl topbar">
            <nav class="navbar navbar-expand-lg border-bottom fixed-top">
                <div class="container-xxl px-md-4">
                    <a class="navbar-brand" href="#">
                        <img src="static/img/us-logo.png" alt="" height="40" class="d-inline-block align-text-top" />
                    </a>
                    <div class="align-items-center">
                        <button class="navbar-toggler notify_bell" type="button" data-bs-toggle="tooltip" data-bs-title="通知" data-bs-placement="bottom">
                            <i class="fas fa-bell ct-txt-1"></i>
                        </button>
                        <button class="navbar-toggler border" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                            <i class="fas fa-bars ct-txt-1"></i>
                        </button>
                    </div>

                    <div class="justify-content-end collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav mb-2 mb-md-0" id="topbar-nav-tabs">
                            <li class="nav-item">
                                <a href="#" class="nav-link active" data-bs-toggle="dropdown">知識圖書館</a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">小產調理</a>
                                    <a class="dropdown-item" href="#">婦科保健</a>
                                    <a class="dropdown-item" href="#">備孕調理</a>
                                    <a class="dropdown-item" href="#">懷孕知識</a>
                                    <a class="dropdown-item" href="#">日常保健</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link active" data-bs-toggle="dropdown">療心室</a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">聊療小產</a>
                                    <a class="dropdown-item" href="#">聊療婦科保健</a>
                                    <a class="dropdown-item" href="#">聊療備孕</a>
                                    <a class="dropdown-item" href="#">聊療懷孕</a>
                                    <a class="dropdown-item" href="#">聊療日常保健</a>
                                </ul>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link active">暢聊咖啡廳</a></li>
                            <li class="nav-item"><a href="#" class="nav-link active">營養師諮詢</a></li>
                            <li class="nav-item notify_bell d-none d-lg-block" data-bs-toggle="tooltip" data-bs-title="通知" data-bs-placement="bottom">
                                <a class="nav-link" style="cursor: pointer">
                                    <i class="fas fa-bell"></i>
                                </a>
                            </li>
                            <li class="nav-item dropstart order-first order-lg-last">
                                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle"></i>
                                    <span id="account_name" class="d-lg-none">Account Name</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item" href="#">個人資料</a>
                                    <a class="dropdown-item" href="#">點數錢包</a>
                                    <a class="dropdown-item" href="#">文章列表</a>
                                    <a class="dropdown-item" href="#">收藏與追蹤</a>
                                    <a class="dropdown-item" href="#">登出</a>
                                </ul>
                            </li>
                        </ul>
                        <p class="py-1 mb-1 border-top border-bottom d-lg-none" style="letter-spacing: 2px; font-weight: 500; color: var(--ct-color-1); font-size: var(--fs-20)">功能選單</p>
                        <ul class="nav flex-column d-lg-none">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-1">會員資料<i class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse" id="sub-class-1">
                                    <a class="dropdown-item" href="#">會員資料</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">專屬月曆</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-2">點數錢包<i class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse" id="sub-class-2">
                                    <a class="dropdown-item" href="#">任務專區</a>
                                    <a class="dropdown-item" href="#">點數兌換</a>
                                    <a class="dropdown-item" href="#">點數轉贈</a>
                                    <a class="dropdown-item" href="#">點數獲得紀錄</a>
                                    <a class="dropdown-item" href="#">點數使用紀錄</a>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">我的心事</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-3">收藏與追蹤<i class="fas fa-angle-down ms-2"></i></a>
                                <ul class="collapse" id="sub-class-3">
                                    <a class="dropdown-item" href="#">文章收藏</a>
                                    <a class="dropdown-item" href="#">作者追蹤</a>
                                    <a class="dropdown-item" href="#">話題追蹤</a>
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
        <div class="container-xxl">
            <div class="row pt-3 px-md-5">
                <div class="col-12 my-2">
                    <nav class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                            <li class="breadcrumb-item active" aria-current="page">專屬月曆</li>
                        </ol>
                    </nav>
                    <div class="row d-flex align-items-center">
                        <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>專屬月曆</h2>
                    </div>
                </div>
            </div>
            <div class="row px-md-5">
                <div class="col-md col-lg-9 pe-md-4">
                    <div class="row mt-2 d-flex align-items-center justify-content-end">
                        <div class="col-sm-12 col-md-auto px-0">
                            <button id="today_btn" type="button" class="btn btn-c2 rounded-pill mx-1">Today</button>
                        </div>
                        <div class="col-md px-0 text-end" style="font-size: var(--fs-15); font-style: italic">
                            <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #ffc64c"></i>生理期</span>
                            <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #f6511d"></i>小產期</span>
                            <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #fe72a9"></i>懷孕期</span>
                            <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #53d2dc"></i>產後期</span>
                            <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #808080"></i>更年期</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md col-lg-auto px-0 d-flex justify-content-center">
                            <div id="calendar" class="material-theme mx-auto" tabindex="-1"></div>
                        </div>
                        <div class="col-md-12 col-lg p-4">
                            <h4 class="fw-bold" id="event-title" style="font-size: var(--fs-24)">生理期再三天就要報到啦！(24px)</h4>
                            <!-- <div class="my-3" id="event-content" style="font-size: var(--fs-16); line-height: var(--fs-28); text-align: justify">
                                我是內文 16px，行高28，字距1px，我是內文 16px，行高28，字距1px，我是內文 16px，行高28，字距1px，我是內文 16px，行高28，字距1px，我是內文 16px，行高28，字距1px，我是內文
                                16px，行高28，字距1px...
                            </div> -->
                            <div class="my-3" id="events" style="font-size: var(--fs-16); line-height: var(--fs-28); text-align: justify">
                                <div class="subtitle badge rounded-pill bg-secondary">No events</div>
                                <div class="my-3 list px-1" id="event-content">
                                    我是內文 16px，行高28，字距1px，我是內文 16px，行高28，字距1px，我是內文 16px，行高28，字距1px，我是內文 16px，行高28，字距1px，我是內文
                                    16px，行高28，字距1px，我是內文 16px，行高28，字距1px
                                </div>
                            </div>

                            <!--判斷用戶是否初次使用-專屬月曆-->
                            <!-- <button data-bs-toggle="modal" data-bs-target="#first_daily_modal" onclick="open_modal()" class="btn btn-c2 rounded-pill me-1">寫下今天的身體日記</button> -->
                            <!--非初次使用-專屬月曆 顯示該按鈕-->
                            <button class="btn btn-c2 rounded-pill me-1" onclick="open_modal()">寫下今天的身體日記</button>
                        </div>
                    </div>
                </div>
                <!--右邊文章選單-->
                <div class="col-md-4 col-lg d-flex align-items-start">
                    <div class="row position-sticky" id="right-sidebar">
                        <div class="mb-3 px-0 col-12 my-auto">
                            <input type="text" class="form-control search-input rounded-pill" placeholder="&#xF52A; 搜尋文章" style="font-family: 'bootstrap-icons'" />
                        </div>
                        <div class="col-12 ct-b ps-2 p-1 rounded">
                            <p class="ct-title-1 my-auto" style="font-weight: 500">個人資料</p>
                        </div>
                        <div class="col-12 px-0">
                            <ul class="nav flex-column" id="info_class_list">
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-1">會員資料<i class="fas fa-angle-down ms-2"></i></a>
                                    <ul class="collapse" id="sub-class-1">
                                        <a class="dropdown-item" href="#">會員資料</a>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">專屬月曆</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-2">點數錢包<i class="fas fa-angle-down ms-2"></i></a>
                                    <ul class="collapse" id="sub-class-2">
                                        <a class="dropdown-item" href="#">任務專區</a>
                                        <a class="dropdown-item" href="#">點數兌換</a>
                                        <a class="dropdown-item" href="#">點數轉贈</a>
                                        <a class="dropdown-item" href="#">點數獲得紀錄</a>
                                        <a class="dropdown-item" href="#">點數使用紀錄</a>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">我的心事</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-3">收藏與追蹤<i class="fas fa-angle-down ms-2"></i></a>
                                    <ul class="collapse" id="sub-class-3">
                                        <a class="dropdown-item" href="#">文章收藏</a>
                                        <a class="dropdown-item" href="#">作者追蹤</a>
                                        <a class="dropdown-item" href="#">話題追蹤</a>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">登出</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="position-fixed bottom-0 end-0 m-2">
                <button class="btn" id="floatButton" data-bs-toggle="tooltip" data-bs-title="營養師諮詢" data-bs-placement="left">
                    <i class="fas fa-comment-dots"></i>
                </button>
            </div>

            <footer class="container-xl mt-5">
                <div class="row p-xs-2 p-md-4 px-lg-5 text-center justify-content-md-center justify-content-lg-evenly">
                    <div class="col-4 col-md-2 col-lg-auto mb-2">
                        <a href="#" class="">關於我們</a>
                    </div>
                    <div class="col-4 col-md-2 col-lg-auto mb-2">
                        <a href="#" class="">聯絡我們</a>
                    </div>
                    <div class="col-4 col-md-2 col-lg-auto mb-2">
                        <a href="#" class="">常見問題</a>
                    </div>
                    <div class="col-4 col-md-2 col-lg-auto mb-2">
                        <a href="#" class="">使用者條款</a>
                    </div>
                    <div class="col-4 col-md-2 col-lg-auto mb-2">
                        <a href="#" class="">隱私權政策</a>
                    </div>
                    <div class="col-4 col-md-2 col-lg-auto mb-2">
                        <a href="#" class="">優德莎莉官網</a>
                    </div>

                    <div class="col-12 col-md-auto mt-2 mt-lg-0 mb-2">
                        <a href="#" class="col-12 ct-txt-2 mx-3 mx-md-2"><i class="fab fa-line"></i></a>
                        <a href="#" class="col-12 ct-txt-2 mx-3 mx-md-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="col-12 ct-txt-2 mx-3 mx-md-2"><i class="fab fa-facebook-square"></i></a>
                    </div>
                </div>
            </footer>
        </div>

        <!--日記彈出視窗-->
        <!--初次記錄-->
        <div class="modal fade" id="first_daily_modal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">歡迎使用<label class="ct-txt-1">專屬月曆</label></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size: var(--fs-18)">
                        <div class="row d-flex justify-content-center py-3">
                            <p class="text-center">
                                每天記錄身體的日記，除了可以追蹤身體變化<br />
                                也可以讓我們為您推薦飲食和運動的建議，一起呵護婦科健康喔！
                            </p>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <label for="health_type" class="col-form-label">請選擇您目前的身體狀態<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select" id="health_type" onchange="daily_select_type(this)">
                                        <option selected value="生理期">生理期：目前有月經；沒有小產或懷孕</option>
                                        <option value="小產期">小產期：已進行小產或準備進行小產，且月經尚未恢復</option>
                                        <option value="懷孕期">懷孕期：正在懷孕</option>
                                        <option value="產後期">產後期：已生產，月經尚未恢復</option>
                                        <option value="更年期">更年期</option>
                                    </select>
                                </div>
                            </div>
                            <form id="first_daily_form">
                                <!--生理期-->
                                <div class="py-3 ps-lg-4 health_type" id="health_type_1">
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="type1_q1" class="col-form-label">・生理期週期(天)</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="number" id="type1_q1" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="type1_q2" class="col-form-label">・上次生理期開始日</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="type1_q2" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="type1_q3" class="col-form-label">・每次月經大約來多少天</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="number" id="type1_q3" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <!--小產期-->
                                <div class="py-3 ps-lg-4 health_type d-none" id="health_type_2">
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="type2_q1" class="col-form-label">・小產的日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="type2_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--懷孕期-->
                                <div class="py-3 ps-lg-4 health_type d-none" id="health_type_3">
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="type3_q1" class="col-form-label">・懷孕的週數</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="type3_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="type3_q2" class="col-form-label">・預產的日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="type3_q2" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--產後期-->
                                <div class="py-3 ps-lg-4 health_type d-none" id="health_type_4">
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="type4_q1" class="col-form-label">・生產的日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="type4_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--更年期-->
                                <div class="py-3 ps-lg-4 health_type d-none" id="health_type_5"></div>
                            </form>

                            <div class="row justify-content-center align-items-center mt-2">
                                <div class="col-auto">
                                    <button class="btn btn-c2 rounded-pill" data-bs-toggle="modal" data-bs-target="#daily_modal" onclick="first_daily_set()" style="font-size: var(--fs-18)">
                                        前往記錄身體日記
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--日常記錄-->
        <div class="modal fade" id="daily_modal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn float-start" data-bs-toggle="modal" data-bs-target="#first_daily_modal"><i class="bi bi-chevron-left"></i></button>
                        <h1 class="modal-title fs-5 ct-txt-1">專屬月曆</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size: var(--fs-18)">
                        <div class="row d-flex justify-content-center mb-2">
                            <form id="daily_form">
                                <!--生理期-->
                                <div class="ps-sm-2 ps-md-4 daily_type" id="daily_type_1">
                                    <div class="row align-items-center mb-1">
                                        <div class="col-auto">
                                            <label for="type1_q1" class="col-form-label fw-bold">狀態</label>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-c1 rounded-pill" id="health_type">生理期</button>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="d_type1_q1" class="col-form-label fw-bold">日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="d_type1_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <label for="d_type1_q2" class="col-form-label fw-bold">月經</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="radio" class="btn-check m-1" name="has_mc_type" id="has_mc" value="有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="has_mc">有月經</label>
                                            <input type="radio" class="btn-check m-1" name="has_mc_type" id="no_mc" value="沒有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="no_mc">沒有月經</label>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type1_q2" class="col-form-label">・月經量</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="mc_amount" id="mc_less" value="量少" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="mc_less">量少🩸</label>
                                                <input type="radio" class="btn-check m-1" name="mc_amount" id="mc_normal" value="量適中" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="mc_normal">量適中🩸🩸</label>
                                                <input type="radio" class="btn-check m-1" name="mc_amount" id="mc_more" value="量多" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="mc_more">量多🩸🩸🩸</label>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type1_q2" class="col-form-label">・經痛程度</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="mc_pain" id="pain_less" value="輕微" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="pain_less">輕微(悶痛可忍)</label>
                                                <input type="radio" class="btn-check m-1" name="mc_pain" id="pain_normal" value="中度" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="pain_normal">中度(止痛藥可緩解)</label>
                                                <input type="radio" class="btn-check m-1" name="mc_pain" id="pain_more" value="嚴重" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="pain_more">嚴重(止痛藥無法緩解)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-auto">
                                            <label for="d_type1_q3" class="col-form-label fw-bold">症狀</label>
                                        </div>
                                        <div class="col-auto mt-0">
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_1" value="頭痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_1">頭痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_2" value="腰痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_2">腰痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_3" value="潮熱" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_3">潮熱</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_4" value="乳房脹痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_4">乳房脹痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_5" value="排卵痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_5">排卵痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_6" value="便秘" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_6">便秘</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_7" value="腹瀉" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_7">腹瀉</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_8" value="分泌物增加" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_8">分泌物增加</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_9" value="點狀出血" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_9">點狀出血</label>
                                            <input type="checkbox" class="btn-check" name="d_type1_q3" id="type1_q3_10" value="其他" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_10">其他：(請在右方填寫症狀)</label>
                                            <div class="d-inline-flex input-group w-auto">
                                                <input
                                                    type="text"
                                                    class="form-control input_underline ms-1"
                                                    style="font-size: var(--fs-16)"
                                                    name="d_type1_q3"
                                                    id="type1_q3_other"
                                                    placeholder="請填寫其他症狀"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="d_type1_q4" class="col-form-label fw-bold">同房</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="radio" class="btn-check" name="d_type1_q4" id="q4_item_1" value="沒有同房" />
                                            <label class="btn btn-outline-c3 rounded-pill my-1" for="q4_item_1">沒有同房</label>
                                            <input type="radio" class="btn-check" name="d_type1_q4" id="q4_item_2" value="有，且有避孕" />
                                            <label class="btn btn-outline-c3 rounded-pill my-1" for="q4_item_2">有同房，有避孕</label>
                                            <input type="radio" class="btn-check" name="d_type1_q4" id="q4_item_3" value="有，但沒有避孕" />
                                            <label class="btn btn-outline-c3 rounded-pill my-1" for="q4_item_3">有同房，沒有避孕</label>
                                        </div>
                                    </div>
                                </div>
                                <!--小產期-->
                                <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_2">
                                    <div class="row align-items-center mb-1">
                                        <div class="col-auto">
                                            <label for="type1_q1" class="col-form-label fw-bold">狀態</label>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-c1 rounded-pill" id="health_type">小產期</button>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="d_type2_q1" class="col-form-label fw-bold">日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="d_type2_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <label for="d_type2_q2" class="col-form-label fw-bold">惡露</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="radio" class="btn-check m-1" name="has_loc_type" id="has_loc" value="有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="has_loc">有惡露</label>
                                            <input type="radio" class="btn-check m-1" name="has_loc_type" id="no_loc" value="沒有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="no_loc">沒有惡露</label>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type1_q2" class="col-form-label">・惡露量</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="loc_amount" id="loc_less" value="量少" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_less">量少🩸</label>
                                                <input type="radio" class="btn-check m-1" name="loc_amount" id="loc_normal" value="量適中" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_normal">量適中🩸🩸</label>
                                                <input type="radio" class="btn-check m-1" name="loc_amount" id="loc_more" value="量多" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_more">量多🩸🩸🩸</label>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type1_q2" class="col-form-label">・惡露顏色</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="loc_color" id="loc_red" value="鮮紅色" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_red">鮮紅色<i class="fas fa-tint ms-1" style="color: red"></i></label>
                                                <input type="radio" class="btn-check m-1" name="loc_color" id="loc_darkred" value="暗紅色" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_darkred">暗紅色<i class="fas fa-tint ms-1" style="color: darkred"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-auto">
                                            <label for="d_type2_q3" class="col-form-label fw-bold">症狀</label>
                                        </div>
                                        <div class="col-auto mt-0">
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_1" value="宮縮陣痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_1">宮縮陣痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_2" value="腰痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_2">腰痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_3" value="大量血塊" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_3">大量的大塊血塊(直徑約5cm)</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_4" value="發燒" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_4">發燒</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_5" value="噁心" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_5">噁心</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_6" value="嘔吐" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_6">嘔吐</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_7" value="暈眩" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_7">暈眩</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_8" value="胸部脹痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_8">胸部脹痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type2_q3" id="type2_q3_9" value="其他" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_9">其他：(請在右方填寫症狀)</label>
                                            <div class="d-inline-flex input-group w-auto">
                                                <input
                                                    type="text"
                                                    class="form-control input_underline ms-1"
                                                    style="font-size: var(--fs-16)"
                                                    name="d_type2_q3"
                                                    id="type2_q3_other"
                                                    placeholder="請填寫其他症狀"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--懷孕期-->
                                <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_3">
                                    <div class="row align-items-center mb-1">
                                        <div class="col-auto">
                                            <label for="type3_q1" class="col-form-label fw-bold">狀態</label>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-c1 rounded-pill">懷孕期</button>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="d_type3_q1" class="col-form-label fw-bold">日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="d_type3_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <label for="d_type3_q2" class="col-form-label fw-bold">出血</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="radio" class="btn-check m-1" name="has_blood_type" id="has_blood" value="有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="has_blood">有出血</label>
                                            <input type="radio" class="btn-check m-1" name="has_blood_type" id="no_blood" value="沒有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="no_blood">沒有出血</label>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type3_q2" class="col-form-label">・出血量</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="blood_amount" id="blood_less" value="量少" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="blood_less">量少🩸</label>
                                                <input type="radio" class="btn-check m-1" name="blood_amount" id="blood_normal" value="量適中" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="blood_normal">量適中🩸🩸</label>
                                                <input type="radio" class="btn-check m-1" name="blood_amount" id="blood_more" value="量多" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="blood_more">量多🩸🩸🩸</label>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type3_q2" class="col-form-label">・出血顏色</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="blood_color" id="blood_pink" value="粉紅色" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="blood_pink">粉紅色<i class="fas fa-tint ms-1" style="color: deeppink"></i></label>
                                                <input type="radio" class="btn-check m-1" name="blood_color" id="blood_red" value="鮮紅色" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="blood_red">鮮紅色<i class="fas fa-tint ms-1" style="color: red"></i></label>
                                                <input type="radio" class="btn-check m-1" name="blood_color" id="blood_darkred" value="暗紅色" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="blood_darkred">暗紅色<i class="fas fa-tint ms-1" style="color: darkred"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-auto">
                                            <label for="d_type3_q3" class="col-form-label fw-bold">症狀</label>
                                        </div>
                                        <div class="col-auto mt-0">
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_1" value="陰道出血" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_1">陰道出血</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_2" value="腰痠背痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_2">腰痠背痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_3" value="胸部脹痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_3">胸部脹痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_4" value="下腹疼痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_4">下腹疼痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_5" value="噁心" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_5">噁心</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_6" value="嘔吐" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_6">嘔吐</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_7" value="頭暈" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_7">頭暈</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_8" value="便秘" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_8">便秘</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_9" value="頻尿" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_9">頻尿</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_10" value="胃部不適" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_10">胃部不適</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_11" value="消化不良" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_11">消化不良</label>
                                            <input type="checkbox" class="btn-check" name="d_type3_q3" id="type3_q3_12" value="其他" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_12">其他：(請在右方填寫症狀)</label>
                                            <div class="d-inline-flex input-group w-auto align-items-center">
                                                <input
                                                    type="text"
                                                    class="form-control input_underline ms-1"
                                                    style="font-size: var(--fs-16)"
                                                    name="d_type3_q3"
                                                    id="type3_q3_other"
                                                    placeholder="請填寫其他症狀"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--產後期-->
                                <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_4">
                                    <div class="row align-items-center mb-1">
                                        <div class="col-auto">
                                            <label for="type4_q1" class="col-form-label fw-bold">狀態</label>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-c1 rounded-pill">產後期</button>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="d_type4_q1" class="col-form-label fw-bold">日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="d_type4_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <label for="d_type4_q2" class="col-form-label fw-bold">惡露</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="radio" class="btn-check m-1" name="has_loc_type1" id="has_loc1" value="有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="has_loc1">有惡露</label>
                                            <input type="radio" class="btn-check m-1" name="has_loc_type1" id="no_loc1" value="沒有" />
                                            <label class="btn btn-outline-c3 rounded-pill" for="no_loc1">沒有惡露</label>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type4_q2" class="col-form-label">・惡露量</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="loc_amount4" id="loc_less4" value="量少" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_less4">量少🩸</label>
                                                <input type="radio" class="btn-check m-1" name="loc_amount4" id="loc_normal4" value="量適中" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_normal4">量適中🩸🩸</label>
                                                <input type="radio" class="btn-check m-1" name="loc_amount4" id="loc_more4" value="量多" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_more4">量多🩸🩸🩸</label>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-1">
                                            <div class="col-auto">
                                                <label for="type4_q2" class="col-form-label">・惡露顏色</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="radio" class="btn-check m-1" name="loc_color4" id="loc_red4" value="鮮紅色" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_red4">鮮紅色<i class="fas fa-tint ms-1" style="color: red"></i></label>
                                                <input type="radio" class="btn-check m-1" name="loc_color4" id="loc_darkred4" value="暗紅色" />
                                                <label class="btn btn-outline-c3 rounded-pill" for="loc_darkred4">暗紅色<i class="fas fa-tint ms-1" style="color: darkred"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-auto">
                                            <label for="d_type4_q3" class="col-form-label fw-bold">症狀</label>
                                        </div>
                                        <div class="col-auto mt-0">
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_1" value="宮縮陣痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_1">宮縮陣痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_2" value="腰痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_2">腰痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_3" value="大量血塊" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_3">大量的大塊血塊(直徑約5cm)</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_4" value="食慾不振" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_4">食慾不振</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_5" value="消化不良" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_5">消化不良</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_6" value="便秘" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_6">便秘</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_7" value="私密處搔癢/異味" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_7">私密處搔癢/異味</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_8" value="胸部脹痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_8">胸部脹痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type4_q3" id="type4_q3_9" value="其他" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_9">其他：(請在右方填寫症狀)</label>
                                            <div class="d-inline-flex input-group w-auto">
                                                <input
                                                    type="text"
                                                    class="form-control input_underline ms-1"
                                                    style="font-size: var(--fs-16)"
                                                    name="d_type4_q3"
                                                    id="type4_q3_other"
                                                    placeholder="請填寫其他症狀"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--更年期-->
                                <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_5">
                                    <div class="row align-items-center mb-1">
                                        <div class="col-auto">
                                            <label for="type5_q1" class="col-form-label fw-bold">狀態</label>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-c1 rounded-pill">更年期</button>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <label for="d_type5_q1" class="col-form-label fw-bold">日期</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <input type="text" id="d_type5_q1" class="form-control datepicker" />
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-auto">
                                            <label for="d_type5_q3" class="col-form-label fw-bold">症狀</label>
                                        </div>
                                        <div class="col-auto mt-0">
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_1" value="熱潮紅" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_1">熱潮紅</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_2" value="盜汗" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_2">盜汗</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_3" value="手腳冰冷" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_3">手腳冰冷</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_4" value="不易入睡" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_4">不易入睡</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_5" value="陰道乾澀" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_5">陰道乾澀</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_6" value="陰道搔癢" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_6">陰道搔癢</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_7" value="頻尿" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_7">頻尿</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_8" value="頭痛" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_8">頭痛</label>
                                            <input type="checkbox" class="btn-check" name="d_type5_q3" id="type5_q3_9" value="其他" />
                                            <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_9">其他：(請在右方填寫症狀)</label>
                                            <div class="d-inline-flex input-group w-auto">
                                                <input
                                                    type="text"
                                                    class="form-control input_underline ms-1"
                                                    style="font-size: var(--fs-16)"
                                                    name="d_type5_q3"
                                                    id="type5_q3_other"
                                                    placeholder="請填寫其他症狀"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row justify-content-center align-items-center mt-2">
                                <div class="col-auto">
                                    <button id="add_daily_btn" class="btn btn-c2 rounded-pill" style="font-size: var(--fs-18)">記錄</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="static/bootstrap-4.6.0-dist/jquery-3.6.0.js"></script>
        <script src="static/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
        <script src="static/evo-event-calendar/js/evo-calendar.js"></script>
        <script type="text/javascript" src="static/jsCalendar-master/source/jsCalendar.js"></script>
        <script type="text/javascript" src="static/jsCalendar-master/source/jsCalendar.lang.zh.js"></script>
        <script src="static/dayjs-1.11.8/package/dayjs.min.js"></script>
        <script src="static/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="static/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.zh-TW.min.js"></script>
        <script src="static/js/master_page.js"></script>
        <script src="static/js/forum_list.js"></script>
        <script src="static/js/calendar_new.js"></script>

        <script></script>
    </body>
</html>
