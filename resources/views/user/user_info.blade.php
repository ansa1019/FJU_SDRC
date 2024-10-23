<link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">



@extends('layouts.masterpage')

@section('content')
    @if (session('successful'))
        <script>
            function showAlert(success) {
                alert(success);
            }
            showAlert('{{ session('successful') }}');
        </script>
    @endif

    @if ($errors->has('error'))
        <script>
            function showAlert(error) {
                alert(error);
            }
            showAlert('{{ $errors->first('error') }}');
        </script>
    @endif
    <div class="container-xxl">
        <div class="row px-md-5">
            <form class="col-md col-lg-9 pe-md-4" form method="POST" action="{{ route('UserInfoEdit') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name='profile_id' value="{{ $profile_id }}" />
                <img style="display: none;" src="{{ asset('static/img/us-logo.png') }}" id='test' />
                <input type="hidden" name='bodyProfile_id' value="{{ $bodyProfile_id }}" />
                <div class="row pt-3">
                    <div class="col-12 my-2">
                        <nav class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                                <li class="breadcrumb-item active" aria-current="page">會員資料</li>
                            </ol>
                        </nav>
                        <div class="row d-flex align-items-center">
                            <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>會員資料</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12" style="font-size: var(--fs-18)">
                        <div class="row g-3 align-items-start">
                            <div class="col-3 col-lg-2">
                                <label for="user_name" class="col-form-label">大頭貼</label>
                            </div>
                            <div id="image_preview" class="col">
                                <img id="crop_image" src="{{ $user_image }}" alt="大頭貼"
                                    class="{{ isset($user_image) ? 'd-block' : 'd-none' }}"
                                    style="width: 200px; height: 200px; border-radius: 100%;">
                                <div class="my-3">
                                    <div class="preview {{ isset($user_image) ? 'd-none' : 'd-flex' }} align-items-center text-center justify-content-center "
                                        style="z-index: 1">
                                        <span class="d-none d-lg-block">上傳檔案</span><span><i
                                                class="fas fa-camera"></i></span>
                                    </div>
                                    <input type="file" id="user_image" name="user_image" accept=".jpg, .jpeg, .png" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 模態視窗部分，用來顯示裁切功能 -->
                    <div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cropModalLabel">裁切圖片</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="crop_area">
                                        <img id="image_to_crop" src="" alt="Image to crop" style="max-width: 100%;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                    <button type="button" id="crop_button" class="btn btn-primary">裁切並上傳</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6" style="font-size: var(--fs-18)">
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_name" class="col-form-label">姓名</label>
                            </div>
                            <div class="col">
                                <input type="text" id="user_name" name="user_name" class="form-control"
                                    value="{{ $user_name }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_nickname" class="col-form-label">暱稱</label>
                            </div>
                            <div class="col">
                                <input type="text" id="user_nickname" name='user_nickname' class="form-control"
                                    value="{{ $nickname }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_password" class="col-form-label">密碼</label>
                            </div>
                            <div class="col">
                                <label class="text-decoration-underline" data-bs-toggle="modal"
                                    data-bs-target="#pwdModal">設定新的密碼</label>
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_email" class="col-form-label">電子郵件</label>
                            </div>
                            <div class="col">
                                <input type="email" id="user_email" name='user_email' class="form-control"
                                    value="{{ $email }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_sex" class="col-form-label">生理性別</label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="gender" name="gender">
                                    <option value="male" @if ($gender == 'male') selected @endif>男性
                                    </option>
                                    <option value="female" @if ($gender == 'female') selected @endif>女性
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_birthday" class="col-form-label">生日</label>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input type="date" id="datepicker" name='datepicker' class="form-control"
                                        value="{{ $birthday }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_phone" class="col-form-label">手機號碼</label>
                                <!-- <span class="ct-sub-1 fs-16">(選填)</span> -->
                                <p class="ct-sub-1" style="line-height: var(--fs-14); font-size: var(--fs-16)">
                                    (選填)
                                </p>
                            </div>
                            <div class="col">
                                <input type="text" id="user_phone" name="user_phone" class="form-control"
                                    value="{{ $phone }}" />
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-3">
                                <label for="user_address" class="col-form-label">居住地址</label>
                                <p class="ct-sub-1" style="line-height: var(--fs-14); font-size: var(--fs-16)">
                                    (選填)
                                </p>
                            </div>
                            <div class="col">
                                <input type="text" id="user_address" name='user_address' class="form-control"
                                    value="{{ $address }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6" style="font-size: var(--fs-18)">
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_height" class="col-form-label">身高 / 體重</label>
                            </div>
                            <div class="col">
                                <input type="number" id="user_height" name='user_height' placeholder="身高(cm)"
                                    class="form-control" value="{{ $height }}">
                            </div>
                            <div class="col">
                                <input type="number" id="user_weight" name='user_weight' placeholder="體重(kg)"
                                    class="form-control" value="{{ $weight }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_birth_plan" class="col-form-label">生育計畫</label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="birth_plan" name='birth_plan'>
                                    <option value="有-正在嘗試自然受孕" {{ $family_planning == '有-正在嘗試自然受孕' ? 'selected' : '' }}>
                                        有-正在嘗試自然受孕</option>
                                    <option
                                        value="有-正在進行人工受孕療程"{{ $family_planning == '有-正在進行人工受孕療程' ? 'selected' : '' }}>
                                        有-正在進行人工受孕療程</option>
                                    <option value="無-未來有懷孕需求" {{ $family_planning == '無-未來有懷孕需求' ? 'selected' : '' }}>
                                        無-未來有懷孕需求</option>
                                    <option value="無-未來沒有懷孕需求" {{ $family_planning == '無-未來沒有懷孕需求' ? 'selected' : '' }}>
                                        無-未來沒有懷孕需求</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_pregnant" class="col-form-label">懷孕狀態</label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="pregnant_state" name='pregnant_state'>
                                    <option value="未懷孕/產後" {{ $expecting == '未懷孕/產後' ? 'selected' : '' }}>
                                        未懷孕/產後，已停止哺乳
                                    </option>
                                    <option value="小於六個月" {{ $expecting == '小於六個月' ? 'selected' : '' }}>小於六個月
                                    </option>
                                    <option value="大於六個月" {{ $expecting == '大於六個月' ? 'selected' : '' }}>大於六個月
                                    </option>
                                    <option value="正在哺乳中" {{ $expecting == '正在哺乳中' ? 'selected' : '' }}>正在哺乳中
                                    </option>
                                    <option value="正經歷流產" {{ $expecting == '正經歷流產' ? 'selected' : '' }}>正經歷流產
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_disease" class="col-form-label">病史</label>
                                <span class="ct-sub-1" style="font-size: var(--fs-16)">(多選)</span>
                            </div>
                            <div class="col">
                                <select class="form-select" id="disease_history" multiple="multiple"
                                    name="disease_history[]">
                                    @foreach ($diseases as $disease => $val)
                                        {{-- @if ($val == $medical)
                                                    <option value={{ $disease }} selected>{{ $disease }}</option>
                                                @break --}}
                                        <option value={{ $disease }} {{ $val == 1 ? 'selected' : '' }}>
                                            {{ $disease }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_disease_other" class="col-form-label">其他病史</label>
                            </div>
                            <div class="col">
                                <input type="text" id="disease_other" placeholder="上題選其他，請填寫病史" name='disease_other'
                                    class="form-control col-auto input_underline" value="{{ $other_medical_history }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_drug" class="col-form-label">用藥情況</label>
                            </div>
                            <div class="col-auto mx-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_drug" id="user_drug_1"
                                    value="有" {{ $user_drug ? 'checked' : '' }} />
                                <label class="form-check-label" for="user_drug_1">有</label>
                            </div>
                            <div class="col-auto mx-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_drug" id="user_drug_0"
                                    value="無" {{ !$user_drug ? 'checked' : '' }} />
                                <label class="form-check-label" for="user_drug_0">無</label>
                            </div>
                            <div class="col">
                                <input type="text" id="drug_other" placeholder="請敘述用藥情況" name='drug_other'
                                    class="form-control col-auto input_underline" value="{{ $medication }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_order" class="col-form-label">特別醫囑</label>
                            </div>
                            <div class="col-auto mx-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_order" id="user_order_1"
                                    value="有" {{ $user_order != null ? 'checked' : '' }}>
                                <label class="form-check-label" for="user_order_1">有</label>
                            </div>
                            <div class="col-auto mx-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_order" id="user_order_0"
                                    value="無" {{ $user_order == null ? 'checked' : '' }}>
                                <label class="form-check-label" for="user_order_0">無</label>
                            </div>
                            <div class="col">
                                <input type="text" id="order_other" placeholder="請敘述醫囑" name='order_other'
                                    class="form-control col-auto input_underline" value="{{ $doctor_advice }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_allergy" class="col-form-label">過敏來源</label>
                            </div>
                            <div class="col-auto mx-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_allergy" id="user_allergy_1"
                                    value="有" {{ $user_allergy != null ? 'checked' : '' }}>
                                <label class="form-check-label" for="user_allergy_1">有</label>
                            </div>
                            <div class="col-auto mx-1 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="user_allergy" id="user_allergy_0"
                                    value="無" {{ $user_allergy == null ? 'checked' : '' }}>
                                <label class="form-check-label" for="user_allergy_0">無</label>
                            </div>
                            <div class="col">
                                <input type="text" id="allergy_other" placeholder="請敘述過敏來源" name='allergy_other'
                                    class="form-control col-auto input_underline" value="{{ $allergy }}">
                            </div>
                        </div>
                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-4">
                                <label for="user_married" class="col-form-label">婚姻狀況</label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="married_state" name='married_state'>
                                    <option value="unmarried" {{ $marriage == false ? 'selected' : '' }}>未婚
                                    </option>
                                    <option value="married" {{ $marriage == true ? 'selected' : '' }}>已婚</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 mt-4" style="font-size: 18px">
                        <button type="submit" class="btn btn-outline-c2 rounded-pill mx-1">儲存變更</button>
                        {{-- onclick="info_setting()" --}}
                        <button class="btn mx-1">取消</button>
                    </div>
                </div>
        </form>
        @include('layouts.sidebar')
    </div>

    <!--重設密碼modal-->

    <!-- 重设密码 modal -->
    <div class="modal fade" id="pwdModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="bi bi-lock-fill ct-txt-1 me-2"></i>設定密碼
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: var(--fs-18)">

                </div>
                <div class="row d-flex justify-content-center py-3">
                    <div class="col-md col-lg-8">
                        <form id="passwordForm">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <!-- 隱藏的輸入框，用於存儲用戶電子郵件 -->
                            <input type="hidden" id="user_email_forpassword" name="user_email"
                                value="{{ $username }}">

                            <div id="step1">
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="old_password" class="col-form-label">舊密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="old_password" name="old_password"
                                            placeholder="請輸入舊密碼" class="form-control">
                                        <div class="error text-danger"></div>
                                    </div>
                                </div>
                                <div class="row g-3 my-4 align-items-center">
                                    <button type="button" class="btn btn-c2 rounded-pill px-4 mx-1 col-auto"
                                        onclick="validateOldPassword()">下一步</button>
                                </div>
                            </div>

                            <div id="step2" style="display: none;">
                                <div id="passwordup" data-update-password-route="{{ route('password.update') }}"></div>
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="new_password" class="col-form-label">新密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="new_password" name="new_password"
                                            placeholder="必須包含英文大小寫，至少8個字符" class="form-control">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="check_password" class="col-form-label">確認新密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="check_password" name="check_password"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row g-3 my-4 align-items-center">
                                    <button type="button" onclick="resetPassword()"
                                        class="btn btn-c2 rounded-pill px-4 mx-1 col-auto">完成</button>

                                    <button type="button" class="btn col-auto mx-1" data-bs-dismiss="modal">取消</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>









    {{-- <script>
        function validateOldPassword() {
            const oldPassword = document.getElementById('old_password').value;
            console.log(JSON.stringify({
                old_password: oldPassword,
                action: 'step1'
            }));
            fetch('{{ route('UserEditpassword') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        old_password: oldPassword,
                        action: 'step1'
                    })
                })

                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // 如果舊密碼正確，顯示新密碼步驟
                        document.getElementById('step1').style.display = 'none';
                        document.getElementById('step2').style.display = 'block';
                    } else {
                        // 如果舊密碼錯誤，顯示錯誤訊息
                        const errorSpan = document.createElement('span');
                        errorSpan.className = 'ct-txt-2 text-danger';
                        errorSpan.style.fontSize = 'var(--fs-16)';
                        errorSpan.innerText = '舊密碼不正確';
                        const oldPasswordContainer = document.querySelector('#old_password').parentElement;
                        // 清除之前的錯誤訊息（如果存在）
                        const existingError = oldPasswordContainer.querySelector('.ct-txt-2.text-danger');
                        if (existingError) {
                            existingError.remove();
                        }
                        oldPasswordContainer.appendChild(errorSpan);
                    }
                })
        }

        document.getElementById('passwordForm').addEventListener('submit', function(event) {
            const newPassword = document.getElementById('new_password').value;
            const checkPassword = document.getElementById('check_password').value;

            // 檢查新密碼和確認新密碼是否相同
            if (newPassword !== checkPassword) {
                event.preventDefault(); // 防止表單提交

                const errorSpan = document.createElement('span');
                errorSpan.className = 'ctxt-2 text-danger';
                errorSpan.style.fontSize = 'var(--fs-16)';
                errorSpan.innerText = '新密碼與確認新密碼不相符';
                const newPasswordContainer = document.querySelector('#new_password').parentElement;

                // 清除之前的錯誤訊息（如果存在）
                const existingError = newPasswordContainer.querySelector('.ctxt-2.text-danger');
                if (existingError) {
                    existingError.remove();
                }
                newPasswordContainer.appendChild(errorSpan);

                return; // 返回，不進行後續處理
            }
        });
    </script> --}}







    {{-- <div class="modal fade" id="pwdModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="bi bi-lock-fill ct-txt-1 me-2"></i>設定密碼
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: var(--fs-18)">
                    <div class="row d-flex justify-content-center py-3">
                        <div class="col-md col-lg-8">
                            <form method="POST" action="{{ route('UserEditpassword') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <!-- 顯示錯誤訊息 -->
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="old_password" class="col-form-label">舊密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="old_password" name="old_password"
                                            placeholder="請輸入舊密碼" class="form-control">
                                        @if ($errors->any())
                                            <span class="ct-txt-2 text-danger" style="font-size: var(--fs-16)">
                                                {{ $errors->first('old_password') ?? session('error') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="new_password" class="col-form-label">新密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="new_password" name="new_password"
                                            placeholder="須包含英文大小寫，至少8個字元" class="form-control" />
                                        <span class="ct-txt-2 d-none" id="new_pwd_alert"
                                            style="font-size: var(--fs-16)">＊新密碼須包含英文大小寫，至少8個字元</span>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="check_password" class="col-form-label">確認新密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="check_password" name="check_password"
                                            class="form-control" />
                                        <span class="ct-txt-2 d-none" id="check_pwd_alert"
                                            style="font-size: var(--fs-16)">＊請重新確認新密碼</span>
                                    </div>
                                </div>
                                <div class="row g-3 my-4 align-items-center">
                                    <button type="submit" class="btn btn-c2 rounded-pill px-4 mx-1 col-auto">完成</button>
                                    <button type="button" class="btn col-auto mx-1" data-bs-dismiss="modal">取消</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="modal fade" id="pwdModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-lock-fill ct-txt-1 me-2"></i>設定密碼
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: var(--fs-18)">
                    <div class="row d-flex justify-content-center py-3">
                        <div class="col-md col-lg-8">
                            <form method="POST" action="{{ route('UserEditpassword') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="old_password" class="col-form-label">舊密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="old_password" name="old_password"
                                            placeholder="請輸入舊密碼" class="form-control">
                                        <span class="ct-txt-2 d-none" id="old_pwd_alert"
                                            style="font-size: var(--fs-16)">＊舊密碼輸入錯誤</span>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="new_password" class="col-form-label">新密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="new_password" name="new_password"
                                            placeholder="須包含英文大小寫，至少8個字元" class="form-control" />
                                        <span class="ct-txt-2 d-none" id="new_pwd_alert"
                                            style="font-size: var(--fs-16)">＊新密碼須包含英文大小寫，至少8個字元</span>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="check_password" class="col-form-label">確認新密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="check_password" class="form-control" />
                                        <span class="ct-txt-2 d-none" id="check_pwd_alert"
                                            style="font-size: var(--fs-16)">＊請重新確認新密碼</span>
                                    </div>
                                </div>
                                <div class="row g-3 my-4 align-items-center">
                                    <button type="submit" class="btn btn-c2 rounded-pill px-4 mx-1 col-auto"
                                        onclick="">完成</button>
                                    <button type="button" class="btn col-auto mx-1" data-bs-dismiss="modal">取消</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
