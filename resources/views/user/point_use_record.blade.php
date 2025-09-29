@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('point_task') }}">點數錢包</a></li>
                        <li class="breadcrumb-item active" aria-current="page">點數使用記錄</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>點數使用記錄</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 pe-md-4">
                <div class="row mt-4 justify-content-between align-items-center" id="point_topbar">
                    <!-- span內 帶入用戶的當前點數-->
                    <div class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="total_points">聊心點 <span>{{ $point }}</span> 點</div>
                    <a href="{{ route('point_exchange') }}"
                        class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="point_exchange"> 點數兌換 </a>
                </div>

                <div class="row mt-4">
                    @foreach ($responseAllRecord->sortByDesc('created_at') as $record)
                        @isset($record['exchage_token'])
                            <div class="row py-3 mb-2 d-flex align-items-center border-bottom">
                                <div class="col">
                                    <!--記錄標題-->
                                    <p class="record_title mb-1">
                                        兌換｜<?php $text = '';
                                        foreach ($record['products'] as $item) {
                                            $text .= $item['product'] . '、';
                                        }
                                        echo mb_substr($text, 0, -1, 'utf-8'); ?>
                                    </p>
                                    <!--記錄時間-->
                                    <p class="exchage_token m-0">兌換碼：<span>{{ $record['exchage_token'] }}</span></p>
                                    <span class="task_time">{{ $record['created_at'] }}</span>
                                </div>
                                <!--該記錄所獲得點數-->
                                <div class="col-auto col-lg-2 text-end task_point use">{{ $record['point'] }}</div>
                            </div>
                        @endisset
                        @isset($record['giver'])
                            @if ($record['giver'] == $user)
                                <div class="row py-3 mb-2 d-flex align-items-center border-bottom">
                                    <div class="col">
                                        <!--記錄標題-->
                                        <p class="record_title mb-1">點數贈送｜送給 {{ $record['receiver'] }}</p>
                                        <!--記錄時間-->
                                        <span class="task_time">{{ $record['created_at'] }}</span>
                                    </div>
                                    <!--該記錄所獲得點數-->
                                    <div class="col-auto col-lg-2 text-end task_point use">{{ $record['point'] }}</div>
                                </div>
                            @endif
                        @endisset
                    @endforeach
                    {{-- @foreach ($responseexchangeProfile as $record)
                        <div class="row py-3 mb-2 d-flex align-items-center border-bottom">
                            <div class="col">
                                <p class="record_title mb-1">兌換｜{{ $record['product_title'] }}</p>
                                <span class="task_time">{{ $record['created_at'] }}</span>
                            </div>
                            <div class="col-auto col-lg-2 text-end task_point use">{{ $record['point'] }}</div>
                        </div>
                    @endforeach --}}
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
