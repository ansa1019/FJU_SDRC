@extends('layouts.table')

@section('mainmeau')
    @if ($errors->has('error'))
        <script>
            function showAlert(error) {
                alert(error);
            }
            showAlert('{{ $errors->first('error') }}');
        </script>
    @endif

    <head>
        <style>
            body {
                background-image: url("static/img/register/bg/1.png");
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
                background-position: center;
            }

            footer i,
            footer a {
                color: var(--ct-title-1) !important;
                text-shadow: #fff 1px 0 0, #fff 0 1px 0, #fff -1px 0 0, #fff 0 -1px 0;
            }
        </style>
    </head>
    <div class="container-xl" style="padding-bottom: 15%">
        <div class="row px-3 pt-3 pt-md-5 form-register">
            <div class="col-md col-lg-10 px-3">
                <div class="tab-content">

                    <!-- 密碼 -->
                    <div class="tab-pane position-relative fade show active" id="step_1" tabindex="0">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/1.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">1.</span>
                            DNLab論壇是一個可以讓所有人暢所欲言的地方，
                            <br />
                            為了保障你的個人資料及隱私安全，請先設定一組你自己的密碼吧！
                            <span class="i-imp">*</span>
                        </p>
                        <span class="text-muted">小提示：密碼須至少8個字元，包含大小寫英文及數字</span>
                        <p class="mt-2">
                            <input type="password" name="user_password" class="form-control input_underline w-50"
                                placeholder="請輸入密碼" />
                        </p>
                        <p class="mt-2">
                            <input type="password" name="user_check_password" class="form-control input_underline w-50"
                                placeholder="再次輸入確認密碼" />
                        </p>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 mt-2 rounded-pill step-confirm">確定</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_1" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            disabled data-bs-toggle="pill" data-bs-target="#step_2"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：1/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 暱稱 -->
                    <div class="tab-pane position-relative" id="step_2">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/2.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">2.</span>
                            請問你喜歡我們怎麼稱呼你呢？
                            <span class="i-imp">*</span>
                        </p>
                        <span class="text-muted">
                            這是之後你在DNLab論壇裡面的暱稱喔！
                            <br />
                            放心，若是之後想修改，你隨時都可以在會員資料裡面修改，
                            <br />
                            同時為了保障所有使用者，請不要使用不雅、不當言詞作為你的暱稱
                        </span>
                        <p class="mt-4">
                            <input type="text" name="user_nickname" class="form-control input_underline w-50"
                                placeholder="請輸入暱稱" />
                        </p>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 mt-2 rounded-pill step-confirm">確定</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_1" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            disabled data-bs-toggle="pill" data-bs-target="#step_3"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：2/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 性別 -->
                    <div class="tab-pane position-relative" id="step_3">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/3.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">3.</span>
                            <span id="nickname"></span>
                            你好，歡迎你加入DNLab論壇！
                            <br />
                            在開始之前，我們想先認識你，請告訴我你的生理性別？
                            <span class="i-imp">*</span>
                        </p>
                        <div class="mb-3">
                            <input type="radio" class="btn-check m-1" name="user_sex" id="user_male" value="male"
                                autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="user_male">男性</label>
                            <p></p>
                            <input type="radio" class="btn-check m-1" name="user_sex" id="user_female" value="female"
                                autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="user_female">女性</label>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 mt-2 rounded-pill step-confirm">確定</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_2" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            disabled data-bs-toggle="pill" data-bs-target="#step_3_fin"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：3/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 敘述 過頁 -->
                    <div class="tab-pane position-relative" id="step_3_fin">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/3_fin.png" width="100%" />
                        </div>
                        <p class="title" style="text-indent: 0">現在的你，對於未來或許有很多的期待和擔心，<br />因此你想寫一封信給未來的自己，在寫之前，你開始回想...
                        </p>

                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 mt-2 rounded-pill step-confirm">確定</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_3" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            disabled data-bs-toggle="pill" data-bs-target="#step_4"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：3/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 生日 -->
                    <div class="tab-pane position-relative" id="step_4">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/4.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">4.</span>
                            我是在哪天來到這個世界的呢？
                            <span class="i-imp">*</span>
                        </p>
                        <div class="input-group w-50 my-4">
                            <input type="datetime" id="datepicker" name="user_birthday" class="form-control" />
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 mt-2 rounded-pill step-confirm">確定</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_3" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            disabled data-bs-toggle="pill" data-bs-target="#step_5"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：4/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 身高體重 -->
                    <div class="tab-pane position-relative" id="step_5">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/5.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">5.</span>
                            抬頭看看身邊的鏡子，我的身高是 ___，體重是 ___，
                            <br />
                            或許不是我最滿意的樣子，可是我喜歡現在的我自己！
                            <span class="i-imp">*</span>
                        </p>
                        <div class="input-group w-50 mt-4 mb-1 align-items-end">
                            <input type="number" name="user_height" class="form-control input_underline"
                                placeholder="請輸入身高" />
                            <span class="ms-2">公分</span>
                        </div>
                        <div class="input-group w-50 mt-4 mb-1 align-items-end">
                            <input type="number" name="user_height" class="form-control input_underline"
                                placeholder="請輸入體重" />
                            <span class="ms-2">公斤</span>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_4" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            disabled data-bs-toggle="pill" data-bs-target="#step_6"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：5/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 婚姻狀況 -->
                    <div class="tab-pane position-relative" id="step_6">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/6.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">6.</span>
                            單身有單身的自由，結婚也有結婚的踏實，我現在...
                            <span class="i-imp">*</span>
                        </p>
                        <span class="text-muted">婚姻狀況說明</span>
                        <div class="my-3">
                            <input type="radio" class="btn-check" name="user_married_state" id="user_unmarried"
                                value="未婚" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="user_unmarried">非常自由自在 (單身)</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_married_state" id="user_married"
                                value="已婚" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="user_married">有另一伴 (已婚)</label>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_5" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_7" onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：6/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 生育計畫 -->
                    <div class="tab-pane position-relative" id="step_7">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/7.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">7.</span>
                            我今年
                            <span id="age">XX</span>
                            歲，我現在對生育的計畫是？
                            <span class="i-imp">*</span>
                        </p>
                        <div class="my-3">
                            <input type="radio" class="btn-check" name="user_birth_plan" id="item_1"
                                value="正在嘗試自然受孕" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="item_1">自然隨緣（正在嘗試自然受孕）</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_birth_plan" id="item_2"
                                value="正在進行人工受孕療程" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="item_2">擁抱醫療科技（正在進行人工受孕療程）</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_birth_plan" id="item_3"
                                value="未來有計畫想生小孩" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="item_3">再等等，時候未到（未來有懷孕需求）</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_birth_plan" id="item_4"
                                value="未來沒有計畫要生育" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="item_4">我沒有考慮耶（未來沒有懷孕需求）</label>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_6" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_8" onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：7/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 懷孕壯況 -->
                    <div class="tab-pane position-relative" id="step_8">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/8.png" width="100%" />
                        </div>
                        <p class="title" style="color: white">
                            <span class="ol" style="color: white">8.</span>
                            我最近看了一部電影，在講身為女人，一生可能經歷過的種種事情，
                            <br />
                            其中的片段很符合我現在的情況
                            <span class="i-imp">*</span>
                        </p>
                        <p class="text-muted">現在的懷孕狀態是什麼呢？</p>
                        <div class="my-3">
                            <input type="radio" class="btn-check" name="user_pregnant_state" id="p_item_1"
                                value="沒有懷孕" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="p_item_1">未懷孕</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_pregnant_state" id="p_item_2"
                                value="懷孕不到6個月" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="p_item_2">懷孕小於六個月，肚子還沒到最大的時候</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_pregnant_state" id="p_item_3"
                                value="懷孕大於6個月" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3"
                                for="p_item_3">懷孕大於六個月，對於寶寶出生期待又緊張</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_pregnant_state" id="p_item_4"
                                value="停止哺乳" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="p_item_4">已經生完小孩，而且停止哺乳</label>
                            <p class="mb-2"></p>
                            <input type="radio" class="btn-check" name="user_pregnant_state" id="p_item_5"
                                value="正在哺乳中" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="p_item_5">生完小孩，還繼續哺乳中</label>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm">寫下</button>
                            <div class="step-div ms-3" style="color: #fff">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_7" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_9" onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：8/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 用藥狀況 -->
                    <div class="tab-pane position-relative" id="step_9">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/9.png" width="85%" />
                        </div>
                        <p class="title">
                            <span class="ol">9.</span>
                            「滴滴滴滴——」，鬧鐘響起，原來是吃藥的提醒
                            <span class="i-imp">*</span>
                        </p>
                        <p class="text-muted">用藥情況說明</p>
                        <div class="my-3">
                            <input type="radio" class="btn-check" name="user_drug_state" id="d_item_1"
                                value="0" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="d_item_1">不用吃藥，只要養成好的生活習慣就可以</label>
                            <p class="mb-2"></p>
                            <div class="input-group w-50">
                                <input type="radio" class="btn-check" name="user_drug_state" id="d_item_2"
                                    value="1" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="d_item_2">我需要吃：</label>
                                <input type="text" class="form-control input_underline ms-2" name="user_drug_state"
                                    id="d_item_other" placeholder="請填入常用藥物" />
                            </div>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_8" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_10"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：9/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 過敏狀況 -->
                    <div class="tab-pane position-relative" id="step_10">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/10.png" width="85%" />
                        </div>
                        <p class="title">
                            <span class="ol">10.</span>
                            關掉鬧鐘，滑了滑手機，看到朋友分享一個美食貼文，
                            <br />
                            但我眉頭一皺，因為我發現有我不能吃的
                            <span class="i-imp">*</span>
                        </p>
                        <p class="text-muted">過敏來源說明</p>
                        <div class="my-3">
                            <input type="radio" class="btn-check" name="user_allergy_state" id="a_item_1"
                                value="0" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="a_item_1">沒有過敏的來源，我只是有點小挑食～</label>
                            <p class="mb-2"></p>
                            <div class="input-group w-50">
                                <input type="radio" class="btn-check" name="user_allergy_state" id="a_item_2"
                                    value="1" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="a_item_2">我對某些東西過敏：</label>
                                <input type="text" class="form-control input_underline ms-2" name="user_allergy_state"
                                    id="a_item_other" placeholder="請填入過敏原" />
                            </div>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_9" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_11"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：10/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 疾病病史 -->
                    <div class="tab-pane position-relative" id="step_11">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/11.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">11.</span>
                            突然聽到電視傳來健康節目中，醫生講話的聲音，
                            <br />
                            他分享了許多疾病的注意事項，我特別調大音量聽醫生講
                            <span class="i-imp">*</span>
                        </p>
                        <p class="text-muted">病史說明，可複選</p>
                        <div class="row my-3 align-items-end">
                            <div class="col-auto">
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_1"
                                    value="沒有病史" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_1">我沒有病史，只是想了解新知</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_2"
                                    value="高血壓" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_2">高血壓</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_3"
                                    value="糖尿病" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_3">糖尿病</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_4"
                                    value="腎臟病" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_4">腎臟病</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_5"
                                    value="癌症" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_5">癌症</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_6"
                                    value="胃食道逆流" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_6">胃食道逆流</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_7"
                                    value="便秘" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_7">便秘</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_8"
                                    value="甲狀腺亢進/低下" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_8">甲狀腺亢進/低下</label>
                                <p class="mb-2"></p>
                            </div>
                            <div class="col-auto">
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_9"
                                    value="子宮肌瘤" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_9">子宮肌瘤</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_10"
                                    value="多囊性卵巢" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_10">多囊性卵巢</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_11"
                                    value="巧克力囊腫" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_11">巧克力囊腫</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_12"
                                    value="子宮外孕" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_12">子宮外孕</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_13"
                                    value="骨盆腔發炎" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_13">骨盆腔發炎</label>
                                <p class="mb-2"></p>
                                <input type="checkbox" class="btn-check" name="user_disease_state" id="ds_item_14"
                                    value="流產" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_14">流產</label>
                                <p class="mb-2"></p>
                                <div class="input-group">
                                    <input type="radio" class="btn-check" name="user_disease_state" id="ds_item_15"
                                        value="1" autocomplete="off" />
                                    <label class="btn btn-outline-gy1 rounded-pill px-3" for="ds_item_15">其他：</label>
                                    <input type="text" class="form-control input_underline ms-2"
                                        name="user_disease_state" id="ds_item_other" placeholder="請填入病症" />
                                </div>
                            </div>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm mx-1">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_10" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_12"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：11/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 醫師醫囑 -->
                    <div class="tab-pane position-relative" id="step_12">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/12.png" width="85%" />
                        </div>
                        <p class="title">
                            <span class="ol">12.</span>
                            聽醫生說了各種疾病需要注意的事項，
                            <br />
                            我仔細回想了一下，過去看病時，醫生有沒有特別叮嚀我什麼
                            <span class="i-imp">*</span>
                        </p>
                        <p class="text-muted">特殊醫囑說明</p>
                        <div class="my-3">
                            <input type="radio" class="btn-check" name="user_order_state" id="or_item_1"
                                value="0" autocomplete="off" />
                            <label class="btn btn-outline-gy1 rounded-pill px-3" for="or_item_1">認真回想後，我好像沒有特殊醫囑</label>
                            <p class="mb-2"></p>
                            <div class="input-group w-50">
                                <input type="radio" class="btn-check" name="user_order_state" id="or_item_2"
                                    value="1" autocomplete="off" />
                                <label class="btn btn-outline-gy1 rounded-pill px-3" for="or_item_2">醫生有特別說：</label>
                                <input type="text" class="form-control input_underline ms-2" name="user_order_state"
                                    id="or_item_other" placeholder="請填入醫囑" />
                            </div>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm mx-1">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_11" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_13"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：12/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 個人資料(姓名/電話/住址) -->
                    <div class="tab-pane position-relative" id="step_13">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/13.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">13.</span>
                            一直被其他事情打斷，我終於寫完信了，最後，寫下我的收件資料
                        </p>

                        <div class="row g-md-3 my-2 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">
                                    姓名：
                                    <span class="i-imp">*</span>
                                </label>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <input type="text" name="user_name" class="form-control input_underline"
                                    placeholder="請輸入真實姓名" />
                            </div>
                        </div>
                        <div class="row g-md-3 mb-2 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">
                                    手機：
                                    <span>&nbsp;</span>
                                </label>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <input type="text" name="user_phone" class="form-control input_underline"
                                    placeholder="請輸入手機號碼" />
                            </div>
                        </div>
                        <div class="row g-md-3 mb-2 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">
                                    地址：
                                    <span>&nbsp;</span>
                                </label>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <input type="text" name="user_address" class="form-control input_underline"
                                    placeholder="請輸入居住地址" />
                            </div>
                        </div>
                        <div class="d-inline-flex align-items-baseline my-3">
                            <button class="btn btn-c2 rounded-pill step-confirm mx-1">寫下</button>
                            <div class="step-div ms-3">
                                <ul class="nav nav-pills align-items-center">
                                    <li class="nav-item">
                                        <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                            data-bs-target="#step_12" onclick="register_step(this)">
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                            data-bs-toggle="pill" data-bs-target="#step_14"
                                            onclick="register_step(this)">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </li>
                                    註冊進度：13/14
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- 註冊信 -->
                    <div class="tab-pane position-relative" id="step_14">
                        <p class="title">
                            <span class="ol">14.</span>
                            這是根據剛剛回想的內容，所寫出來的信件喔，請確認，沒問題的話就可以寄出囉<span class="i-imp">*</span>
                        </p>
                        <p class="text-muted">藍字為你所填答內容，請確認是否正確，若需修改，請直接點選欲修改之藍字即可</p>
                        <form class="form_mail" action="UserRegister" method="POST">
                            @csrf

                            <input type="hidden" name="usermail" value={{ session('usermail') }}>
                            <input type="hidden" name="gender" id='return_user_gender' />{{-- 性別 --}}
                            <input type="hidden" name="age2" id='return_user_age' />{{-- 年齡 --}}
                            <input type="hidden" name="password" id='return_user_password' />
                            <input type="hidden" name="nickname2" id='return_nickname2' />
                            <input type="hidden" name="birthday" id='return_birthday' />
                            <input type="hidden" name="height" id='return_height' />
                            <input type="hidden" name="weight" id='return_weight' />
                            <input type="hidden" name="married_state" id='return_married_state' />
                            <input type="hidden" name="pregnant_state" id='return_pregnant_state' />
                            <input type="hidden" name="birth_plan" id='return_birth_plan' />
                            <input type="hidden" name="disease" id='return_disease' />
                            <input type="hidden" name="allergy_state" id='return_allergy_state' />
                            <input type="hidden" name="order" id='return_order' />
                            <input type="hidden" name="drug" id='return_drug' />
                            <input type="hidden" name="username" id='return_user_username' />
                            <input type="hidden" name="phone" id='return_phone' />
                            <input type="hidden" name="address" id='return_address' />
                            <input type="hidden" name="today" id='return_today' />
                        @section('email_content')
                            <fieldset>
                                <span style="visibility:hidden;" onclick="register_step(this,1)"
                                    id="password"></span>{{-- 密碼 --}}
                                <span style="visibility:hidden;" onclick="register_step(this,3)"
                                    id="gender"></span>{{-- 性別 --}}
                                <span style="visibility:hidden;" onclick="register_step(this,13)" id="phone"></span>
                                <span style="visibility:hidden;" onclick="register_step(this,13)" id="address"></span>
                                <p>
                                    親愛的
                                    <span class="step-tabs" onclick="register_step(this,2)" id="nickname2"></span>
                                    ：
                                </p>
                                <p>
                                    不知道現在的你過得好嗎？我相信這段時間你經歷了各種大大小小的事情，
                                    <br />
                                    有歡笑、有淚水，你很勇敢且努力的到了現在，我覺得你真的很棒！
                                </p>
                                <p>
                                    寫信的當下我
                                    <span class="step-tabs" id="age2"
                                        onclick="register_step(this,4)">XX</span>{{-- 年齡 --}}
                                    歲(生日為
                                    <span class="step-tabs" onclick="register_step(this,4)" id="birthday"></span>
                                    )， 身高
                                    <span class="step-tabs" onclick="register_step(this,5)" id="height"></span>
                                    公分、體重
                                    <span class="step-tabs" onclick="register_step(this,5)" id="weight"></span>
                                    公斤， 我很喜歡現在我的樣子，你也一樣喜歡現在的自己嗎？我現在
                                    <span onclick="register_step(this,6)" class="step-tabs" id="married_state"></span>
                                    <span class="onyly-show-famele">
                                        ， 而且
                                        <span class="step-tabs" onclick="register_step(this,8)"
                                            id="pregnant_state"></span>
                                        ，不過我
                                        <span class="step-tabs" onclick="register_step(this,7)" id="birth_plan"></span>
                                    </span>
                                    ，不知道未來看到信的你是否還是這樣呢？
                                    <span class="onyly-show-famele">還是你已經邁入人生下一段旅程了呢？</span>
                                </p>
                                <p>
                                    現在的我
                                    <span class="step-tabs" onclick="register_step(this,11)"
                                        id="disease">高血壓、子宮肌瘤</span>
                                    <span class="step-tabs" onclick="register_step(this,10)" id="allergy_state"></span>
                                    <span class="step-tabs" onclick="register_step(this,12)" id="order"></span>
                                    <span class="step-tabs" onclick="register_step(this,9)" id="drug"></span>
                                    ，不過整體都還可以，希望你也一切都好～
                                </p>
                                <p>
                                    最後，不要忘記那個充滿熱情和夢想的自己，或許時間會帶來許多變化，但是我希望你能一直保持那份初心和熱情，同時，我相信你現在也一定成為一個更好的人，希望未來的日子裡，你能找到屬於自己的步調，繼續成為一個更好的自己。
                                </p>
                                <p class="mt-3">
                                    <span class="step-tabs" id="username"></span>
                                    敬上
                                </p>
                                <span class="float-end" id="today">註冊日期</span>
                                <div class="row g-2 mt-2"
                                    style="position: fixed; bottom: 0;left: 50%; transform: translateX(-50%); text-align: center; ">
                                    <div class="col-12 my-1 justify-content-center d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="mail_confirm_check" />
                                            <label class="form-check-label" for="mail_confirm_check"> 已閱讀並同意<a
                                                    href="#">服務條款</a>及<a href="#">隱私權政策</a></label>
                                        </div>
                                    </div>
                                    <div class="col-12 my-1 text-center">
                                        <button type="submit" onclick="data()"
                                            class="btn btn-c2 rounded-pill step-confirm">確認註冊</button>
                                    </div>
                                </div>

                                <div class="step-div" style="display: none">
                                    <ul class="nav nav-pills align-items-center">
                                        <li class="nav-item">
                                            <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                                data-bs-target="#step_13" onclick="register_step(this)">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                        </li>
                                        註冊進度：14/14
                                    </ul>
                            </fieldset>
                        @show
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('about')
    @parent

    </div>

    <script>
        function data() {
            var username = $('#username').text();

            document.getElementById('return_user_username').value = username; //真實姓名

            var nickname2 = $('#nickname2').text();

            document.getElementById('return_nickname2').value = nickname2; //用戶暱稱

            var password = $('#password').text();

            document.getElementById('return_user_password').value = password; //密碼

            var birthday = $('#birthday').text();

            document.getElementById('return_birthday').value = birthday; //生日

            var age = $('#age2').text();

            document.getElementById('return_user_age').value = age; //年齡

            var gender = $('#gender').text();

            document.getElementById('return_user_gender').value = gender; //性別

            var height = $('#height').text();

            document.getElementById('return_height').value = height; //身高

            var weight = $('#weight').text();

            document.getElementById('return_weight').value = weight; //體重

            var married_state = $('#married_state').text();

            document.getElementById('return_married_state').value = married_state; //婚姻狀況

            var pregnant_state = $('#pregnant_state').text();

            document.getElementById('return_pregnant_state').value = pregnant_state; //懷孕狀況

            var birth_plan = $('#birth_plan').text();

            document.getElementById('return_birth_plan').value = birth_plan; //生育計畫

            var disease = $('#disease').text().replace("有", "");

            document.getElementById('return_disease').value = disease; //病史

            var allergy_state = $('#allergy_state').text().replace("，對", "").replace("過敏", ""); //過敏

            document.getElementById('return_allergy_state').value = allergy_state;

            var order = $('#order').text().replace("，醫生有特別說", ""); //醫囑

            document.getElementById('return_order').value = order;

            var drug = $('#drug').text().replace("，需要吃", "");

            document.getElementById('return_drug').value = drug; //用藥

            var phone = $('#phone').text();

            document.getElementById('return_phone').value = phone; //電話

            var address = $('#address').text();

            document.getElementById('return_address').value = address; //地址

            var today = $('#today').text();

            document.getElementById('return_today').value = today; //註冊日期
        }
        // JavaScript 来将 <span> 的值更新到隐藏的输入字段中
        // var spanValue = document.getElementById('mySpan').textContent;
    </script>

@endsection
@endsection
