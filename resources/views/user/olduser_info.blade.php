@extends('layouts.table')
<script src="{{ asset('static/js/user.js') }}"></script>
@section('mainmeau')
    @parent

    <div class="container-xxl">
        <form method="POST" action="{{ route('UserInfoEdit') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row pt-3 px-md-5">
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
            <div class="row px-md-5">
                <div class="col-md col-lg-9 px-1 ps-md-1 pe-md-4">
                    <div class="row mt-4">
                        <div class="col-md-12 col-lg-6" style="font-size: var(--fs-18)">
                            <div class="row g-3 align-items-start">
                                <div class="col-3">
                                    <label for="user_name" class="col-form-label">大頭貼</label>
                                </div>
                                <div class="col-auto">
                                    {{-- 大頭貼修改表單 --}}
                                    <form method="post" action="UserInfoStickerEdit" enctype="multipart/form-data">
                                        @csrf
                                        <div>
                                            <input type="file" id="image_uploads" name="image_uploads"
                                                accept=".jpg, .jpeg, .png" style="position: absolute; height: 10vw" />
                                        </div>
                                        <div class="preview d-flex align-items-center text-center justify-content-center"
                                            style="z-index: 1">
                                            <p class="my-0">
                                                <span class="d-none d-lg-block">上傳檔案 </span><span><i
                                                        class="fas fa-camera"></i></span>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6"></div>
                        <div class="col-md-12 col-lg-6" style="font-size: var(--fs-18)">
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="user_name" class="col-form-label">姓名</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="user_name" name="user_name" class="form-control" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="user_nickname" class="col-form-label">暱稱</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="user_nickname" name='user_nickname' class="form-control" />
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
                                    <input type="email" id="user_email" name='user_email' class="form-control" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="user_sex" class="col-form-label">生理性別</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="user_sex" name='user_sex'>
                                        <option value="male" selected>男性</option>
                                        <option value="female">女性</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="user_birthday" class="col-form-label">生日</label>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <input type="date" id="datepicker" name='datepicker' class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="user_phone" class="col-form-label">手機號碼</label>
                                    <!-- <span class="ct-sub-1 fs-16">(選填)</span> -->
                                    <p class="ct-sub-1" style="line-height: var(--fs-14); font-size: var(--fs-16)">(選填)
                                    </p>
                                </div>
                                <div class="col">
                                    <input type="text" id="user_phone" name="user_phone" class="form-control" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="user_address" class="col-form-label">居住地址</label>
                                    <p class="ct-sub-1" style="line-height: var(--fs-14); font-size: var(--fs-16)">(選填)
                                    </p>
                                </div>
                                <div class="col">
                                    <input type="text" id="user_address" name='user_address' class="form-control" />
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
                                        class="form-control" />
                                </div>
                                <div class="col">
                                    <input type="number" id="user_weight" name='user_weight' placeholder="體重(kg)"
                                        class="form-control" />
                                </div>
                            </div>
                            <!-- <div class="row g-3 mb-2 align-items-center">
                                            <div class="col-4">
                                                <label for="user_weight" class="col-form-label">體重(kg)</label>
                                            </div>
                                            <div class="col">
                                                <input type="number" id="user_weight" class="form-control" />
                                            </div>
                                        </div> -->
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-4">
                                    <label for="user_birth_plan" class="col-form-label">生育計畫</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="birth_plan" name='birth_plan'>
                                        <option value="有-正在嘗試自然受孕" selected>有-正在嘗試自然受孕</option>
                                        <option value="有-正在進行人工受孕療程">有-正在進行人工受孕療程</option>
                                        <option value="無-未來有懷孕需求">無-未來有懷孕需求</option>
                                        <option value="無-未來沒有懷孕需求">無-未來沒有懷孕需求</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-4">
                                    <label for="user_pregnant" class="col-form-label">懷孕狀態</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="pregnant_state" name='pregnant_state'>
                                        <option value="未懷孕/產後" selected>未懷孕/產後，已停止哺乳</option>
                                        <option value="小於六個月">小於六個月</option>
                                        <option value="大於六個月">大於六個月</option>
                                        <option value="正在哺乳中">正在哺乳中</option>
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
                                        name='disease_history'>
                                        <option value="高血壓" selected>高血壓</option>
                                        <option value="糖尿病">糖尿病</option>
                                        <option value="腎臟病">腎臟病</option>
                                        <option value="癌症">癌症</option>
                                        <option value="外食道逆流">外食道逆流</option>
                                        <option value="便秘">便秘</option>
                                        <option value="甲狀腺亢進/低下">甲狀腺亢進/低下</option>
                                        <option value="子宮肌瘤">子宮肌瘤</option>
                                        <option value="多囊性卵巢">多囊性卵巢</option>
                                        <option value="子宮肌腺症">子宮肌腺症</option>
                                        <option value="巧克力囊腫">巧克力囊腫</option>
                                        <option value="子宮外孕">子宮外孕</option>
                                        <option value="骨盆腔發炎">骨盆腔發炎</option>
                                        <option value="流產">流產</option>
                                        <option value="其他">其他</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-4">
                                    <label for="user_disease_other" class="col-form-label">其他病史</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="disease_other" placeholder="上題選其他，請填寫病史"
                                        name='disease_other' class="form-control col-auto input_underline" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-4">
                                    <label for="user_drug" class="col-form-label">用藥情況</label>
                                </div>
                                <div class="col-auto button-radio" id="user_drug">
                                    <button class="btn border">無</button>
                                    <button class="btn border">有</button>
                                </div>
                                <div class="col">
                                    <input type="text" id="drug_other" placeholder="請敘述用藥情況" name='drug_other'
                                        class="form-control col-auto input_underline" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-4">
                                    <label for="user_order" class="col-form-label">特別醫囑</label>
                                </div>
                                <div class="col-auto button-radio" id="user_order">
                                    <button class="btn border">無</button>
                                    <button class="btn border">有</button>
                                </div>
                                <div class="col">
                                    <input type="text" id="order_other" placeholder="請敘述醫囑" name='order_other'
                                        class="form-control col-auto input_underline" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-4">
                                    <label for="user_allergy" class="col-form-label">過敏來源</label>
                                </div>
                                <div class="col-auto button-radio" id="user_allergy">
                                    <button class="btn border">無</button>
                                    <button class="btn border">有</button>
                                </div>
                                <div class="col">
                                    <input type="text" id="allergy_other" placeholder="請敘述過敏來源" name='allergy_other'
                                        class="form-control col-auto input_underline" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-4">
                                    <label for="user_married" class="col-form-label">婚姻狀況</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="married_state" name='married_state'>
                                        <option value="unmarried" selected>未婚</option>
                                        <option value="married">已婚</option>
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
                </div>
            </div>
        </form>
    @endsection

    @section('user_sidebar')
        @parent
    @endsection

    @section('about')
        @parent

    </div>

    <!--重設密碼modal-->
    <div class="modal fade" id="pwdModal" tabindex="-1">
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
                            <form action="#">
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="old_password" class="col-form-label">舊密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="old_password" placeholder="請輸入舊密碼"
                                            class="form-control" />
                                        <span class="ct-txt-2 d-none" id="old_pwd_alert"
                                            style="font-size: var(--fs-16)">＊舊密碼輸入錯誤</span>
                                    </div>
                                </div>
                                <div class="row g-3 mb-3 align-items-start">
                                    <div class="col-4">
                                        <label for="new_password" class="col-form-label">新密碼</label>
                                    </div>
                                    <div class="col">
                                        <input type="password" id="new_password" placeholder="須包含英文大小寫，至少8個字元"
                                            class="form-control" />
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
                                    <button type="button" class="btn btn-c2 rounded-pill px-4 mx-1 col-auto"
                                        onclick="reset_password()">完成</button>
                                    <button type="button" class="btn col-auto mx-1" data-bs-dismiss="modal">取消</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
