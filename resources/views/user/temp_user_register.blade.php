@extends('layouts.table')

@section('mainmeau')
    @parent

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
    <div class="container-xl">
        <div class="row px-3 pt-3 pt-md-5 form-register">
            <div class="col-md col-lg-10 px-3">
                <div class="tab-content">
                    <div class="tab-pane position-relative fade show active" id="step_1" tabindex="0">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/1.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">1.</span>
                            莎莉聊療吧是一個可以讓所有人暢所欲言的地方，
                            <br />
                            為了保障你的個人資料及隱私安全，請先設定一組你自己的密碼吧！
                            <span class="i-imp">*</span>
                        </p>
                        <span class="text-muted">小提示：密碼須至少8個字元，包含大小寫英文及數字</span>
                        <p class="mt-4">
                            <input type="password" name="user_password" class="form-control input_underline w-50"
                                placeholder="請輸入密碼" />
                        </p>
                        <button class="btn btn-c2 mt-2 rounded-pill step-confirm">確定</button>

                        <div class="step-div">
                            <ul class="nav nav-pills align-items-center">
                                <li class="nav-item">
                                    <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                        data-bs-target="#step_1" onclick="register_step(this)">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="step-btn step-next-btn nav-link me-1" disabled disabled
                                        data-bs-toggle="pill" data-bs-target="#step_2" onclick="register_step(this)">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </li>
                                註冊進度：1/3
                            </ul>
                        </div>
                    </div>
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
                            這是之後你在莎莉聊療吧裡面的暱稱喔！
                            <br />
                            放心，若是之後想修改，你隨時都可以在會員資料裡面修改，
                            <br />
                            同時為了保障所有使用者，請不要使用不雅、不當言詞作為你的暱稱
                        </span>
                        <p class="mt-4">
                            <input type="text" name="user_nickname" class="form-control input_underline w-50"
                                placeholder="請輸入暱稱" />
                        </p>
                        <button class="btn btn-c2 mt-2 rounded-pill step-confirm">確定</button>

                        <div class="step-div">
                            <ul class="nav nav-pills align-items-center">
                                <li class="nav-item">
                                    <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                        data-bs-target="#step_1" onclick="register_step(this)">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="step-btn step-next-btn nav-link me-1" disabled disabled
                                        data-bs-toggle="pill" data-bs-target="#step_3" onclick="register_step(this)">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </li>
                                註冊進度：2/3
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane position-relative" id="step_3">
                        <div class="position-absolute full-img p-2">
                            <img src="static/img/register/vc/13.png" width="100%" />
                        </div>
                        <p class="title">
                            <span class="ol">3.</span>
                            最後，寫下我的收件資料
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
                        <button class="btn btn-c2 mt-4 rounded-pill step-confirm">寫下</button>

                        <div class="step-div">
                            <ul class="nav nav-pills align-items-center">
                                <li class="nav-item">
                                    <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                        data-bs-target="#step_2" onclick="register_step(this)">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="step-btn step-next-btn nav-link me-1" disabled
                                        data-bs-toggle="pill" data-bs-target="#step_4" onclick="register_step(this)">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </li>
                                註冊進度：3/4
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane position-relative" id="step_4">
                        <p class="title">
                            <span class="ol">4.</span>
                            這是根據剛剛回想的內容，所寫出來的信件喔，請確認，沒問題的話就可以寄出囉<span class="i-imp">*</span>
                        </p>
                        <p class="text-muted">藍字為你所填答內容，請確認是否正確，若需修改，請直接點選欲修改之藍字即可</p>


                        <form method="POST" class="form_mail" action="UserRegister" enctype="multipart/form-data">
                            @csrf


                            <input type="hidden" name="userpassword" id='return_data1' />
                            <input type="hidden" name="userpassword2" id='return_data2' />
                            <input type="hidden" name="userpassname" id='return_data3' />

                            <fieldset>
                                <p>
                                    親愛的
                                    <span class="step-tabs" onclick="register_step(this,2)" id="admin_name"
                                        name="admin_name"></span>
                                    ：
                                </p>
                                <p>
                                    不知道現在的你過得好嗎？我相信這段時間你經歷了各種大大小小的事情，
                                    <br />
                                    有歡笑、有淚水，你很勇敢且努力的到了現在，我覺得你真的很棒！
                                </p>
                                <p>
                                    寫信的當下我
                                    <span class="step-tabs" id="age2" name="age"
                                        onclick="register_step(this,4)">XX</span>
                                    歲(生日為
                                    <span class="step-tabs" onclick="register_step(this,4)" id="birthday"
                                        name="birthday"></span>
                                    )， 身高
                                    <span class="step-tabs" onclick="register_step(this,5)" id="height"
                                        name="height"> </span>
                                    公分、體重
                                    <span class="step-tabs" onclick="register_step(this,5)" id="weight"
                                        name="weight"></span>
                                    公斤， 我很喜歡現在我的樣子，你也一樣喜歡現在的自己嗎？我現在
                                    <span onclick="register_step(this,6)" class="step-tabs" id="married_state"
                                        name="marriage"></span>
                                    <span class="onyly-show-famele">
                                        ， 而且
                                        <span class="step-tabs" onclick="register_step(this,8)" id="pregnant_state"
                                            name="expecting"></span>
                                        ，不過我
                                        <span class="step-tabs" onclick="register_step(this,7)" id="birth_plan"
                                            name="family_planning"></span>
                                    </span>
                                    ，不知道未來看到信的你是否還是這樣呢？
                                    <span class="onyly-show-famele">還是你已經邁入人生下一段旅程了呢？</span>
                                </p>
                                <p>
                                    現在的我
                                    <span class="step-tabs" onclick="register_step(this,11)" id="disease"
                                        name="medical_history">高血壓、子宮肌瘤</span>
                                    <span class="step-tabs" onclick="register_step(this,10)" id="allergy_state"
                                        name="allergy"></span>
                                    <span class="step-tabs" onclick="register_step(this,12)" id="order"
                                        neme="doctor_advice"></span>
                                    <span class="step-tabs" onclick="register_step(this,9)" id="drug"
                                        name="medication"></span>
                                    ，不過整體都還可以，希望你也一切都好～
                                </p>
                                <p>
                                    最後，不要忘記那個充滿熱情和夢想的自己，或許時間會帶來許多變化，但是我希望你能一直保持那份初心和熱情，同時，我相信你現在也一定成為一個更好的人，希望未來的日子裡，你能找到屬於自己的步調，繼續成為一個更好的自己。
                                </p>
                                <p class="mt-3">
                                    <span class="step-tabs" id="username" nema="user_name"></span>
                                    敬上
                                </p>
                                <span class="float-end" id="today" name="">註冊日期</span>

                                <div class="row g-2 mt-2" style="visibility:visible;">
                                    <div class="col-12 my-1 justify-content-center d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="mail_confirm_check" />
                                            <label class="form-check-label" for="mail_confirm_check"> 已閱讀並同意<a
                                                    href="#">服務條款</a>及<a href="#">隱私權政策</a></label>
                                        </div>
                                    </div>
                                    <div class="col-12 my-1 text-center">
                                        <button type="submit" onclick="data() class="btn btn-c2 rounded-pill
                                            step-confirm">確認寄信</button>
                                    </div>
                                </div>
                        </form>

                        <div class="step-div" style="display: none">
                            <ul class="nav nav-pills align-items-center">
                                <li class="nav-item">
                                    <button type="button" class="step-btn nav-link me-1" data-bs-toggle="pill"
                                        data-bs-target="#step_3" onclick="register_step(this)">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                </li>
                                註冊進度：4/4
                            </ul>
                        </div>
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
            var val = $('#admin_name').text();
            document.getElementById('return_data1').value = val;


        }
        // JavaScript 来将 <span> 的值更新到隐藏的输入字段中
        // var spanValue = document.getElementById('mySpan').textContent;
    </script>
@endsection
@endsection
