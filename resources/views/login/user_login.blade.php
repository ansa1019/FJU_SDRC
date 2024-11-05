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

    @if ($errors->has('emailregistereerror'))
        <script>
            function showAlert(emailregistereerror) {
                alert(emailregistereerror);
            }
            showAlert('{{ $errors->first('emailregistereerror') }}');
        </script>
    @endif

    @if ($errors->has('registererror'))
        <script>
            function showAlert(registererror) {
                alert(registererror);
            }
            showAlert('{{ $errors->first('registererror') }}');
        </script>
    @endif

    @if ($errors->has('profileregistererror'))
        <script>
            function showAlert(profileregistererror) {
                alert(profileregistererror);
            }
            showAlert('{{ $errors->first('profileregistererror') }}');
        </script>
    @endif

    @if ($errors->has('bodyprofileregistererror'))
        <script>
            function showAlert(bodyprofileregistererror) {
                alert(bodyprofileregistererror);
            }
            showAlert('{{ $errors->first('bodyprofileregistererror') }}');
        </script>
    @endif

    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <div class="row mt-2 d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>會員登入</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-12 mt-4">
                <div class="form-signin w-100 m-auto">
                    <ul class="nav nav-tabs nav-fill" id="user_login_tabs">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#user_login">會員登入</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#user_register">加入會員</button>
                        </li>
                    </ul>

                    <div class="tab-content shadow p-3 border-bottom border-start border-end">
                        <div class="tab-pane fade show active text-center" id="user_login" tabindex="0">
                            <form method="POST" action="/authenticate">
                                @csrf
                                <div class="form-floating my-2">
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="name@example.com" />
                                    <label for="username">電子郵件帳號</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" />
                                    <label for="password">密碼</label>
                                </div>

                                <div class="col">
                                    <label class="text-decoration-underline" data-bs-toggle="modal"
                                        data-bs-target="#pwdModal">忘記密碼</label>
                                </div>
                                <button class="btn btn-outline-c2 w-75 py-2 my-3" type="submit">登入</button>
                                <p class="mt-5 mb-3 text-body-secondary"></p>
                            </form>
                            @if (session('warning'))
                                <div class="alert alert-warning">
                                    {{ session('warning') }}
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade text-center" id="user_register">
                            <form action="JumpUserRegister" method="POST">
                                @csrf
                                <div class="form-floating mt-3 mb-2">
                                    <input type="email" class="form-control" id="user_mail" name="user_mail"
                                        placeholder="name@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                                    <label for="floatingInput">電子郵件帳號</label>
                                </div>
                                <button class="btn btn-outline-c2 w-75 py-2 my-3" type="submit">註冊</button>
                                <p class="mt-5 mb-3 text-body-secondary"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                            <div class="row g-3 mb-3 align-items-start">
                                <div class="col-4">
                                    <label for="user_email" class="col-form-label">電子郵件帳號</label>
                                </div>
                                <div class="col">
                                    <input type="email" id="user_email" name="user_email" placeholder="電子郵件帳號"
                                        class="form-control">
                                    <span class="ct-txt-2 d-none" id="user_email_alert"
                                        style="font-size: var(--fs-16)">＊電子郵件帳號</span>
                                </div>
                            </div>
                            <div class="row g-3 mb-3 align-items-start">
                                <div class="col-4">
                                    <label for="chkmsg" class="col-form-label">驗證碼</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="chkmsg" name="checkmsg" placeholder="驗證碼"
                                        class="form-control" />
                                    <span class="ct-txt-2 d-none" id="new_chkmsg_alert"
                                        style="font-size: var(--fs-16)">＊驗證碼輸入錯誤</span>
                                </div>
                                <div class="col">
                                    <button type="button" id="chk_sub_btn" class="btn btn-primary">發送驗證碼</button>
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
                                    <input type="password" id="check_password" placeholder="需與新密碼相同"
                                        class="form-control" />
                                    <span class="ct-txt-2 d-none" id="check_pwd_alert"
                                        style="font-size: var(--fs-16)">＊需與新密碼相同</span>
                                </div>
                            </div>
                            <div class="row g-3 my-4 align-items-center">
                                <button type="submit" class="btn btn-c2 rounded-pill px-4 mx-1 col-auto"
                                    onclick="forget_password()">完成</button>
                                <button type="button" class="btn col-auto mx-1" data-bs-dismiss="modal">取消</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
