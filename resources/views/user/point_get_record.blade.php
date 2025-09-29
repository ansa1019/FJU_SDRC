@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('point_task') }}">點數錢包</a></li>
                        <li class="breadcrumb-item active" aria-current="page">點數獲取記錄</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>點數獲取記錄</h2>
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
                        @isset($record['task'])
                            <div class="row py-3 mb-2 d-flex align-items-center border-bottom">
                                <div class="col">
                                    <!--記錄標題-->
                                    <p class="record_title mb-1">完成任務｜ {{ $record['task'] }}</p> <!--記錄時間-->
                                    <span class="task_time">{{ $record['created_at'] }}</span>
                                </div>
                                <!--該記錄所獲得點數-->
                                <div class="col-auto col-lg-2 text-end task_point get">{{ $record['point'] }}</div>
                            </div>
                        @endisset
                        @isset($record['receiver'])
                            @if ($user == $record['receiver'])
                                <div class="row py-3 mb-2 d-flex align-items-center border-bottom">
                                    <div class="col">
                                        <!--記錄標題-->
                                        <p class="record_title mb-1">禮物｜來自 {{ $record['giver'] }}</p> <!--記錄時間-->
                                        <span class="task_time">{{ $record['created_at'] }}</span>
                                    </div>
                                    <!--該記錄所獲得點數-->
                                    <div class="col-auto col-lg-2 text-end task_point get">{{ $record['point'] }}</div>
                                </div>
                            @endif
                        @endisset
                    @endforeach
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
