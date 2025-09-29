@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('point_task') }}">點數錢包</a></li>
                        <li class="breadcrumb-item active" aria-current="page">點數轉贈</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>點數轉贈</h2>
                </div>
            </div>
        </div>
        @if (session('successMsg'))
            <div class="alert alert-primary text-center">{{ session('successMsg') }}</div>
            <script>
                const apiIP = document
                    .getElementById("app")
                    .getAttribute("data-api-ip");
                var token = $("#jwt_token").text();
                var myHeaders = new Headers();
                myHeaders.append("Authorization", "Bearer " + token);
                var formdata2 = new FormData();
                formdata2.append("gift", {{ session('gift') }});
                // 後端會將 # 依序替換成 給予帳號、給予點數、剩餘點數
                formdata2.append(
                    "content",
                    "您給予 # 點數 # 點，剩餘點數為 # 點!"
                );
                formdata2.append(
                    "content2",
                    "# 給予您點數 # 點，剩餘點數為 # 點!"
                );
                var requestOptions2 = {
                    method: "POST",
                    headers: myHeaders,
                    body: formdata2,
                    redirect: "follow",
                };

                fetch(
                    apiIP + "api/notifications/notifications/",
                    requestOptions2
                );
            </script>
        @endif
        @if (session('errorMsg'))
            <div class="alert alert-danger text-center">{{ session('errorMsg') }}</div>
        @endif
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-1 pe-md-4">
                <div class="row mt-4 justify-content-between align-items-center" id="point_topbar">
                    <!-- span內 帶入用戶的當前點數-->
                    <div class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="total_points">聊心點 <span>{{ $point }}</span> 點</div>
                    <a href="{{ route('point_exchange') }}"
                        class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="point_exchange"> 點數兌換 </a>
                </div>
                <div class="row mt-2" style="font-size: var(--fs-18)">
                    <div class="col-md col-lg-7 my-3">
                        <form method="POST" action="{{ route('point_gift') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-auto">
                                    <label for="gift_points" class="col-form-label">
                                        贈送點數
                                        <i class="bi bi-info-circle-fill ct-sub-1 mx-1" data-bs-toggle="tooltip"
                                            data-bs-html="true" data-bs-title="半年內贈送同一帳號，</br>贈送聊心點上限為500點"></i>
                                    </label>
                                </div>
                                <div class="col">
                                    <input type="number" id="gift_points" name="gift_points"
                                        class="form-control input_underline" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 align-items-center">
                                <div class="col-auto">
                                    <label for="gift_account" class="col-form-label">贈送對象帳號</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="gift_account" name="gift_account"
                                        class="form-control input_underline" />
                                </div>
                            </div>
                            <div class="row g-3 mb-2 mt-4" style="font-size: var(--fs-18)">
                                <button type="submit" class="col-auto px-4 btn btn-outline-c2 rounded-pill">確認</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
