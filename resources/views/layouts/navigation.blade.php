<div class="container-xxl topbar">
    <nav class="navbar navbar-expand-lg border-bottom fixed-top">
        <div class="container-xxl px-md-4">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ asset('static/img/SDRC_logo-02.png') }}" alt="" height="40"
                    class="d-inline-block align-text-top" />
            </a>
            <div class="align-items-center">
                @if ($nickname != '')
                    <button class="navbar-toggler notfiy_bell" type="button" data-bs-toggle="tooltip"
                        data-bs-title="通知" data-bs-placement="bottom">
                        <i class="fas fa-bell ct-txt-1"></i>
                        <!--如有新通知 顯示紅點-->
                        @if (session('notifications'))
                            <span id="reddot"
                                class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle">
                            </span>
                        @endif
                    </button>
                @endif
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
                            <a class="dropdown-item" href="{{ route('treatment_qa', ['article' => '聊療小產']) }}">聊療小產</a>
                            <a class="dropdown-item"
                                href="{{ route('treatment_qa', ['article' => '聊療婦科保健']) }}">聊療婦科保健</a>
                            <a class="dropdown-item" href="{{ route('treatment_qa', ['article' => '聊療備孕']) }}">聊療備孕</a>
                            <a class="dropdown-item" href="{{ route('treatment_qa', ['article' => '聊療懷孕']) }}">聊療懷孕</a>
                            <a class="dropdown-item"
                                href="{{ route('treatment_qa', ['article' => '聊療日常保健']) }}">聊療日常保健</a>
                        </ul>
                    </li>
                    <li class="nav-item"><a role="button" id="chats-button" class="nav-link active">暢聊咖啡廳</a></li>
                    <li class="nav-item"><a role="button" id="consult-button" class="nav-link active">營養師諮詢</a></li>
                    @if (session('is_rd'))
                        <li class="nav-item">
                            <a href="#" class="nav-link active" data-bs-toggle="dropdown">文章管理</a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item"
                                    href="{{ route('article_report', ['category' => 'knowledge']) }}">知識圖書館</a>
                                <a class="dropdown-item"
                                    href="{{ route('article_report', ['category' => 'treatment']) }}">療心室</a>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="{{ route('blacklist_manage') }}" role="button" id="chats-button"
                                class="nav-link active">檢舉管理</a></li>
                    @endif
                    @if ($nickname != '')
                        <li class="nav-item notfiy_bell d-none d-lg-block" data-bs-toggle="tooltip" data-bs-title="通知"
                            data-bs-placement="bottom">
                            <a class="nav-link" style="cursor: pointer">
                                <i class="fas fa-bell"></i>
                                <!--如有新通知 顯示紅點-->
                                @if (session('notifications'))
                                    <span
                                        class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropstart order-first order-lg-last">
                        <!--如有會員登入 顯示會員名稱-->
                        <a href="#" class="nav-link" data-bs-toggle="dropdown">
                            @if (empty($user_image))
                                <i class="fas fa-user-circle"><span
                                        id="user_nickname">{{ !empty($nickname) ? $nickname : '未登入' }}</span></i>
                            @else
                                <i class="fas"><img src="{{ $user_image }}"
                                        style="height: 18px; width: 18px; border-radius:50%" />
                                    <span id="user_nickname">{{ !empty($nickname) ? $nickname : '未登入' }}</span></i>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('user_info') }}">個人資料</a></li>
                            <li><a class="dropdown-item" href="{{ route('CalendarIndex') }}">專屬月曆</a></li>
                            <li class="dropdown-submenu">
                                <a role="button" data-bs-toggle="dropdown" class="dropdown-item">點數錢包</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('point_task') }}">任務專區</a></li>
                                    <li><a href="{{ route('point_exchange') }}" class="dropdown-item">點數兌換</a></li>
                                    <li><a href="{{ route('point_gift1') }}" class="dropdown-item">點數轉贈</a></li>
                                    <li><a href="{{ route('point_get_record') }}" class="dropdown-item">點數獲得紀錄</a>
                                    </li>
                                    <li><a href="{{ route('point_use_record') }}" class="dropdown-item">點數使用紀錄</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('my_mind') }}">我的心事</a></li>
                            <li class="dropdown-submenu">
                                <a role="button" data-bs-toggle="dropdown" class="dropdown-item">收藏與追蹤</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('article_saved_list') }}">文章收藏</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('author_saved') }}">作者追蹤</a></li>
                                    <li><a class="dropdown-item" href="{{ route('topic_saved') }}">話題追蹤</a></li>
                                </ul>
                            </li>
                            @if (empty($nickname))
                                <li><a class="dropdown-item" href="{{ route('user_login') }}">登入</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('user.signout') }}">登出</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>

            <!--通知欄區塊-->
            @if ($nickname != '')
                <div class="notifications border" id="notifications_box">
                    <div class="d-flex justify-content-between align-items-center"><a
                            href="{{ route('notifications') }}" class="text-dark text-decoration-none">全部通知
                            @if (session('notifications'))
                                <span id="reddotNumber"
                                    class="badge bg-danger rounded-circle">{{ session('notifications') ? count(session('notifications')) : 0 }}</span>
                            @endif
                        </a>
                        <button onclick="all_read()"
                            class="btn btn-link text-muted text-decoration-none fw-normal fs-12">全部已讀
                        </button>
                    </div>
                    @if (session('notifications'))
                        @foreach (session('notifications') as $notify)
                            <a href="{{ URL::to($notify['url']) }}" id="notify_{{ $notify['id'] }}"
                                class="notifications-item btn btn-link text-decoration-none text-start">
                                <span class="p-1 bg-danger border border-light rounded-circle"
                                    style="height: 1px;width: 1px;margin: auto 8px auto 0;">
                                </span>
                                <div class="text">
                                    <h4 class="d-flex align-items-center">
                                        {{ $notify['action'] }}
                                    </h4>
                                    <p>{{ $notify['content'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p class="notifications-item"
                            style="font-size: 14px;color: #999;justify-content: center;padding: 25px;">
                            尚無通知</p>
                    @endif
                </div>
            @endif
        </div>
    </nav>
</div>

<script>
    $('.notifications-item').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('id').split("_")[1];
        var href = this.href;
        var notifications = @json(session('notifications'));
        usersocket.send(
            JSON.stringify({
                action: "read",
                id: id,
            })
        );
        if ($("#notifications_box .rounded-circle").text() == 1) {
            $("#notifications_box .rounded-circle").remove();
            $(".notfiy_bell span").remove();
        } else {
            $("#notify_" + id +
                " .rounded-circle").remove();
        }
        notifications.forEach((element, index) => {
            if (element["id"] == id) {
                notifications.splice(index, 1);
            }
        });
        console.log(notifications)
        if (notifications.length > 0) {
            $.ajax({
                type: "POST",
                url: "/setNotifications",
                dataType: "json",
                data: {
                    notifications: notifications,
                },
                success: function(result) {
                    console.log(result);
                    window.location.replace(href)
                },
            });
        } else {
            $.ajax({
                type: "POST",
                url: "/setNotifications",
                success: function(result) {
                    console.log(result);
                    window.location.replace(href)
                },
            });
        }
    });
</script>
