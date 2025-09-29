@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <input type="hidden" name='profile_id' value={{ $id }} />
        <input type="hidden" id='user_point' name='user_point' value={{ $point }} />
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('point_task') }}">點數錢包</a></li>
                        <li class="breadcrumb-item active" aria-current="page">點數兌換</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>點數兌換</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-1 pe-md-4">
                <div class="row mt-4 justify-content-between align-items-center" id="point_topbar">
                    <!-- span內 帶入用戶的當前點數-->
                    <div class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="total_points">聊心點 <span id="user_total_points">{{ $point }}</span> 點</div>
                    <a href="{{ route('point_exchange') }}"
                        class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="point_exchange" name="point_exchange"> 點數兌換 </a>
                </div>
                <!--兌換商品列表-->
                <div class="row px-1 mt-5 justify-content-center justify-content-md-start" id="point_exchange_list">
                    <!--兌換商品1-->
                    @foreach ($responseProduct as $Product)
                        <div class="col-auto text-center px-2 mb-2 pd-item">
                            <img src={{ $Product['product_image'] }} class="rounded mx-auto d-block" width="100%"
                                alt="商品1" />
                            <!--商品名稱 根據消費者過去最常購買的商品會顯示皇冠icon-->
                            <p class="title p-1 my-1">{{ $Product['product_title'] }}<i class="fas fa-crown ms-1"></i></p>
                            <!--商品兌換點數(填入span)-->
                            <p class="text">聊心點 <span class="pd_point">{{ $Product['product_point'] }}</span>點</p>
                            <div class="col-auto my-1">
                                <div class="border d-inline-block rounded-pill">
                                    <button class="border" onclick="add_product(this,'dash')"><i
                                            class="bi bi-dash"></i></button>
                                    <!--要兌換數量-->
                                    <span class="pd_num px-2">0</span>
                                    <button class="border" onclick="add_product(this,'plus')"><i
                                            class="bi bi-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforEach
                </div>
                <!-- 商品介紹瀏覽 -->
                <div class="row px-1 my-2"></div>
                <div class="row mt-5 d-flex justify-content-center align-items-center" style="font-size: var(--fs-18)">
                    <div class="col-auto" style="font-weight: 500">已選擇兌換商品 共<span class="fw-bold mx-1" id="total_exg_point"
                            name="total_exg_point">0</span>點</div>
                    <div class="col-auto px-0">
                        <button type="submit" class="btn btn-outline-c2 rounded-pill m-2"
                            onclick="updateRemainingPoint()">我要兌換</button>
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
