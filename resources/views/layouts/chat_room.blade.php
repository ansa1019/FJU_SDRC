@include('layouts.blacklist')

<div class="position-fixed bottom-0 end-0 m-2">
    <button class="btn" id="floatButton" data-bs-toggle="tooltip" data-bs-title="營養師諮詢" data-bs-placement="left">
        <i class="fas fa-comment-dots"></i>
    </button>
</div>

<!-- 聊天室介面 -->
<div class="tab-vertical" style="display: none;">
    <img src="{{ asset('static/img/female.png') }}" alt="..." style="display: none" />
    <img src="{{ asset('static/img/male.png') }}" alt="..." style="display: none" />
    <ul class="nav nav-tabs chats-nav-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="room1-vertical-tab" data-bs-toggle="tab" href="#chat-room1" role="tab"
                aria-controls="home" aria-selected="true">營養師諮詢</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room2-vertical-tab" data-bs-toggle="tab" href="#chat-room2" role="tab"
                aria-controls="profile" aria-selected="false">小產咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room3-vertical-tab" data-bs-toggle="tab" href="#chat-room3" role="tab"
                aria-controls="contact" aria-selected="false">婦科咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room4-vertical-tab" data-bs-toggle="tab" href="#chat-room4" role="tab"
                aria-controls="contact" aria-selected="false">備孕咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room5-vertical-tab" data-bs-toggle="tab" href="#chat-room5" role="tab"
                aria-controls="contact" aria-selected="false">懷孕咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room6-vertical-tab" data-bs-toggle="tab" href="#chat-room6" role="tab"
                aria-controls="contact" aria-selected="false">保健咖啡廳</a>
        </li>
    </ul>

    <ul class="nav nav-tabs chats-nav-tab nav-horizontal-tabs fade show active" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="room1-horizontal-tab" data-bs-toggle="tab" href="#chat-room1" role="tab"
                aria-controls="home" aria-selected="true">營養師諮詢</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room2-horizontal-tab" data-bs-toggle="tab" href="#chat-room2" role="tab"
                aria-controls="profile" aria-selected="false">小產咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room3-horizontal-tab" data-bs-toggle="tab" href="#chat-room3" role="tab"
                aria-controls="contact" aria-selected="false">婦科咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room4-vertical-tab" data-bs-toggle="tab" href="#chat-room4" role="tab"
                aria-controls="contact" aria-selected="false">備孕咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room5-vertical-tab" data-bs-toggle="tab" href="#chat-room5" role="tab"
                aria-controls="contact" aria-selected="false">懷孕咖啡廳</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="room6-vertical-tab" data-bs-toggle="tab" href="#chat-room6" role="tab"
                aria-controls="contact" aria-selected="false">保健咖啡廳</a>
        </li>
    </ul>

    <div class="tab-content card card-bordered chats-card" id="myTabContent3">
        <!-- <div class="bg-none card card-bordered chats-card" id="myTabContent3"> -->
        <div class="tab-pane fade show active" id="chat-room1" role="tabpanel" aria-labelledby="chat-room1">
            <div class="card-header">
                {{-- <div class="img-thumbnail-group">
                    <!-- 小編&用戶 頭像縮圖 -->
                    <img src="https://placehold.co/100/orange/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/dodgerblue/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/hotpink/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                </div> --}}
                <!-- 填入標題 -->
                <h4 class="card-title"><strong>營養師諮詢</strong></h4>
                {{-- @if (Session::get('is_rd') == true)
                <!-- 如果為營養師則顯示下拉式選單 -->
                <select class="card-subtitle" style="width: 150px; font-size: var(--fs-17);">
                    <option>使用者1</option>
                    <option>使用者2</option>
                    <option>使用者3</option>
                </select>
                @else
                <!-- [標題]營養師諮詢: 顯示客服人員上下班狀態 -->
                <p class="card-subtitle"><i class="bi bi-circle-fill pe-1"></i>目前客服人員上班中</p>
                @endif --}}
                <!-- [標題]小產咖啡廳: 顯示該咖啡廳剩餘時間 -->
                <!-- <p class="card-subtitle"><i class="bi bi-clock-fill pe-1"></i>倒數 2小時 20分鐘</p> -->
                <button type="button"
                    class="btn-xs btn-close btn-card-close position-absolute top-0 end-0 p-3"></button>
            </div>

            <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                style="overflow-y: scroll !important; min-height: 427px !important">
                <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                    <i class="bi bi-exclamation-circle float-start px-2"></i>
                    <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                    勿洩漏個資，留意聊天室中潛在的詐騙行為
                </div>

                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                </div>
                <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                </div>

                <!-- 訊息框 -->
                <div class="line">
                    <p>掃描 QR code 後，</p>
                    <p>將可開啟 LINE 進行對話</p>
                    <img src="{{ asset('static/img/Line.png') }}"></img>
                    <a href="https://lin.ee/9uEFur8" class="btn btn-c2 rounded-pill me-1">開啟LINE</a>
                </div>


            </div>

            {{-- <div class="publisher bt-1 border-light">
                <input class="publisher-input" type="text" placeholder="請輸入您想問的" />
                <span class="publisher-btn file-group">
                    <input type="file" />
                    <i class="fas fa-image"></i>
                </span>
                <a class="publisher-btn text-info" role="button" onclick="user_send_msg('chat-room1')"><i
                        class="fa fa-paper-plane"></i></a>
            </div> --}}
        </div>


        <div class="tab-pane fade" id="chat-room2" role="tabpanel" aria-labelledby="chat-room2">
            <div class="card-header">
                {{-- <div class="img-thumbnail-group">
                    <!-- 小編&用戶 頭像縮圖 -->
                    <img src="https://placehold.co/100/orange/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/dodgerblue/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/hotpink/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                </div> --}}
                <!-- 填入標題 -->
                <h4 class="card-title"><strong>小產咖啡廳</strong></h4>
                <!-- [標題]小產咖啡廳: 顯示該咖啡廳剩餘時間 -->
                {{-- <p class="card-subtitle"><i class="bi bi-clock-fill pe-1"></i>倒數 2小時 20分鐘</p> --}}
                <div class="row">
                    <p>發言身分：</p>
                    <select class="form-select chat_name" name="chat_name">
                        @if (!empty($nickname))
                            <option value="{{ $nickname }}">{{ $nickname }}
                            </option>
                        @endif
                        <option value="匿名">匿名
                        </option>
                    </select>
                </div>
                <button type="button"
                    class="btn-xs btn-close btn-card-close position-absolute top-0 end-0 p-3"></button>
            </div>

            @if (!empty($nickname))
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; height: 400px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->

                </div>

                <div class="publisher bt-1 border-light">
                    <input class="publisher-input" type="text" placeholder="請輸入訊息" />
                    <span class="publisher-btn file-group">
                        <input type="file" />
                        <i class="fas fa-image">
                            {{-- <img src="static/img/male.png"> --}}
                        </i>
                    </span>
                    <a class="publisher-btn text-info" role="button" onclick="user_send_msg('chat-room2')"><i
                            class="fa fa-paper-plane"></i></a>
                </div>
            @else
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; min-height: 399px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->
                    <div class="line">
                        <a href="{{ route('user_login') }}">請先登入！</a>
                    </div>
                </div>
            @endif
        </div>


        <div class="tab-pane fade" id="chat-room3" role="tabpanel" aria-labelledby="chat-room3">
            <div class="card-header">
                {{-- <div class="img-thumbnail-group">
                    <!-- 小編&用戶 頭像縮圖 -->
                    <img src="https://placehold.co/100/orange/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/dodgerblue/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/hotpink/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                </div> --}}
                <!-- 填入標題 -->
                <h4 class="card-title"><strong>婦科咖啡廳</strong></h4>
                <!-- [標題]婦科咖啡廳: 顯示該咖啡廳剩餘時間 -->
                {{-- <p class="card-subtitle"><i class="bi bi-clock-fill pe-1"></i>倒數 2小時 20分鐘</p> --}}
                <div class="row">
                    <p>發言身分：</p>
                    <select class="form-select chat_name" name="chat_name">
                        @if (!empty($nickname))
                            <option value="{{ $nickname }}">{{ $nickname }}
                            </option>
                        @endif
                        <option value="匿名">匿名
                        </option>
                    </select>
                </div>
                <button type="button"
                    class="btn-xs btn-close btn-card-close position-absolute top-0 end-0 p-3"></button>
            </div>

            @if (!empty($nickname))
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; height: 400px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->

                </div>

                <div class="publisher bt-1 border-light">
                    <input class="publisher-input" type="text" placeholder="請輸入訊息" />
                    <span class="publisher-btn file-group">
                        <input type="file" />
                        <i class="fas fa-image">
                            {{-- <img src="static/img/male.png"> --}}
                        </i>
                    </span>
                    <a class="publisher-btn text-info" role="button" onclick="user_send_msg('chat-room3')"><i
                            class="fa fa-paper-plane"></i></a>
                </div>
            @else
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; min-height: 399px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->
                    <div class="line">
                        <a href="{{ route('user_login') }}">請先登入！</a>
                    </div>
                </div>
            @endif
        </div>

        <div class="tab-pane fade" id="chat-room4" role="tabpanel" aria-labelledby="chat-room4">
            <div class="card-header">
                {{-- <div class="img-thumbnail-group">
                    <!-- 小編&用戶 頭像縮圖 -->
                    <img src="https://placehold.co/100/orange/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/dodgerblue/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/hotpink/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                </div> --}}
                <!-- 填入標題 -->
                <h4 class="card-title"><strong>備孕咖啡廳</strong></h4>
                <!-- [標題]小產咖啡廳: 顯示該咖啡廳剩餘時間 -->
                {{-- <p class="card-subtitle"><i class="bi bi-clock-fill pe-1"></i>倒數 2小時 20分鐘</p> --}}
                <div class="row">
                    <p>發言身分：</p>
                    <select class="form-select chat_name" name="chat_name">
                        @if (!empty($nickname))
                            <option value="{{ $nickname }}">{{ $nickname }}
                            </option>
                        @endif
                        <option value="匿名">匿名
                        </option>
                    </select>
                </div>
                <button type="button"
                    class="btn-xs btn-close btn-card-close position-absolute top-0 end-0 p-3"></button>
            </div>

            @if (!empty($nickname))
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; height: 400px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->

                </div>

                <div class="publisher bt-1 border-light">
                    <input class="publisher-input" type="text" placeholder="請輸入訊息" />
                    <span class="publisher-btn file-group">
                        <input type="file" />

                    </span>
                    <a class="publisher-btn text-info" role="button" onclick="user_send_msg('chat-room4')"><i
                            class="fa fa-paper-plane"></i></a>
                </div>
            @else
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; min-height: 399px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->
                    <div class="line">
                        <a href="{{ route('user_login') }}">請先登入！</a>
                    </div>
                </div>
            @endif
        </div>

        <div class="tab-pane fade" id="chat-room5" role="tabpanel" aria-labelledby="chat-room5">
            <div class="card-header">
                {{-- <div class="img-thumbnail-group">
                    <!-- 小編&用戶 頭像縮圖 -->
                    <img src="https://placehold.co/100/orange/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/dodgerblue/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/hotpink/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                </div> --}}
                <!-- 填入標題 -->
                <h4 class="card-title"><strong>懷孕咖啡廳</strong></h4>
                <!-- [標題]小產咖啡廳: 顯示該咖啡廳剩餘時間 -->
                {{-- <p class="card-subtitle"><i class="bi bi-clock-fill pe-1"></i>倒數 2小時 20分鐘</p> --}}
                <div class="row">
                    <p>發言身分：</p>
                    <select class="form-select chat_name" name="chat_name">
                        @if (!empty($nickname))
                            <option value="{{ $nickname }}">{{ $nickname }}
                            </option>
                        @endif
                        <option value="匿名">匿名
                        </option>
                    </select>
                </div>
                <button type="button"
                    class="btn-xs btn-close btn-card-close position-absolute top-0 end-0 p-3"></button>
            </div>

            @if (!empty($nickname))
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; height: 400px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->

                </div>

                <div class="publisher bt-1 border-light">
                    <input class="publisher-input" type="text" placeholder="請輸入訊息" />
                    <span class="publisher-btn file-group">
                        <input type="file" />

                    </span>
                    <a class="publisher-btn text-info" role="button" onclick="user_send_msg('chat-room5')"><i
                            class="fa fa-paper-plane"></i></a>
                </div>
            @else
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; min-height: 399px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->
                    <div class="line">
                        <a href="{{ route('user_login') }}">請先登入！</a>
                    </div>
                </div>
            @endif
        </div>

        <div class="tab-pane fade" id="chat-room6" role="tabpanel" aria-labelledby="chat-room6">
            <div class="card-header">
                {{-- <div class="img-thumbnail-group">
                    <!-- 小編&用戶 頭像縮圖 -->
                    <img src="https://placehold.co/100/orange/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/dodgerblue/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                    <img src="https://placehold.co/100/hotpink/white" class="img-thumbnail rounded-circle"
                        alt="..." />
                </div> --}}
                <!-- 填入標題 -->
                <h4 class="card-title"><strong>保健咖啡廳</strong></h4>
                <!-- [標題]小產咖啡廳: 顯示該咖啡廳剩餘時間 -->
                {{-- <p class="card-subtitle"><i class="bi bi-clock-fill pe-1"></i>倒數 2小時 20分鐘</p> --}}
                <div class="row">
                    <p>發言身分：</p>
                    <select class="form-select chat_name" name="chat_name">
                        @if (!empty($nickname))
                            <option value="{{ $nickname }}">{{ $nickname }}
                            </option>
                        @endif
                        <option value="匿名">匿名
                        </option>
                    </select>
                </div>
                <button type="button"
                    class="btn-xs btn-close btn-card-close position-absolute top-0 end-0 p-3"></button>
            </div>

            @if (!empty($nickname))
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; height: 400px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->

                </div>

                <div class="publisher bt-1 border-light">
                    <input class="publisher-input" type="text" placeholder="請輸入訊息" />
                    <span class="publisher-btn file-group">
                        <input type="file" />

                    </span>
                    <a class="publisher-btn text-info" role="button" onclick="user_send_msg('chat-room6')"><i
                            class="fa fa-paper-plane"></i></a>
                </div>
            @else
                <div class="ps-container ps-theme-default ps-active-y" id="chat-content"
                    style="overflow-y: scroll !important; min-height: 399px !important">
                    <div class="alert alert-secondary m-2 p-2 align-items-center d-flex" role="alert">
                        <i class="bi bi-exclamation-circle float-start px-2"></i>
                        <!-- 如有置頂標語提醒 請顯示alert，並填入文字 -->
                        勿洩漏個資，留意聊天室中潛在的詐騙行為
                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px">
                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px"></div>
                    </div>
                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px">
                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px"></div>
                    </div>

                    <!-- 訊息框 -->
                    <div class="line">
                        <a href="{{ route('user_login') }}">請先登入！</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
