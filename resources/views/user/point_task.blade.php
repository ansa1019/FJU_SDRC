@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('point_task') }}">點數錢包</a></li>
                        <li class="breadcrumb-item active" aria-current="page">任務專區</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>任務專區</h2>
                </div>
            </div>
        </div>
        <div class="row px-1 px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-1 pe-md-4">
                <div class="row mt-4 justify-content-between align-items-center" id="point_topbar">
                    <!-- span內 帶入用戶的當前點數-->
                    <div class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="total_points">聊心點 <span id="point" name="point">{{ $point }}</span> 點</div>
                    <a href="{{ route('point_exchange') }}"
                        class="col-sm-11 col-md mx-2 mx-lg-3 mb-2 justify-content-center d-flex align-items-center"
                        id="point_exchange"> 點數兌換 </a>
                </div>
                <div class="row mt-2">
                    <div class="col-12 my-3">
                        <ul class="nav" id="task_class_tabs">
                            <!-- 任務類型篩選器 -->
                            <a class="nav-link rounded-pill" onclick="task_class_filter('beginner')"><i
                                    class="fas fa-hashtag me-1"></i>新手任務</a>
                            <a class="nav-link rounded-pill" onclick="task_class_filter('activity')"><i
                                    class="fas fa-hashtag me-1"></i>活動任務</a>
                            <a class="nav-link rounded-pill" onclick="task_class_filter('normal')"><i
                                    class="fas fa-hashtag me-1"></i>常態任務</a>
                            <a class="nav-link rounded-pill" onclick="task_class_filter('all')"><i
                                    class="fas fa-hashtag me-1"></i>全部任務</a>
                        </ul>
                    </div>
                </div>
                <!-- 任務列表 -->
                <div class="row mt-2 mt-md-4" id="task_list">
                    <!--如果該任務已全部完成(進度100%) 下方class內要加 order-last，讓任務強制跑到最下方顯示-->
                    <!--反之，該任務若未完成，class中則不要有order-last -->
                    <!-- 判斷第一項任務 class沒有border-top 沒有分隔線 -->
                    @foreach ($responseTaskRecord as $record)
                        @if ($record['is_done'])
                            <div class="row py-3 order-last">
                            @else
                                <div class="row py-3 border-top">
                        @endif
                        <div class="col task_title">{{ $record['task'] }}</div>
                        <div class="col-auto">
                            <button class="btn" data-bs-toggle="collapse" href="#task_no2">
                                <i class="fas fa-caret-down" data-bs-toggle="tooltip" data-bs-title="展開更多"></i>
                            </button>
                        </div>
                        <div class="col-12 mb-2">
                            @if ($record['task_type'] == 'BEGGINER')
                                <p class="my-2"><span class="task_class">新手任務</span></p>
                            @elseif ($record['task_type'] == 'DAILY')
                                <p class="my-2"><span class="task_class">常態任務</span></p>
                            @elseif ($record['task_type'] == 'EVENT')
                                <p class="my-2"><span class="task_class">活動任務</span></p>
                            @endif
                            @if (is_null($record['task_deadline']))
                                <p class="my-2">活動期限：<span class="task_deadline">無期限</span></p>
                            @else
                                <p class="my-2">活動期限：<span class="task_deadline">{{ $record['task_deadline'] }}</span></p>
                            @endif
                            <p class="my-2">獲得點數：<span class="task_get_point">{{ $record['task_point'] }}</span>點</p>
                            <div class="row d-flex align-items-center">
                                <div class="col px-0 progress rounded-pill" role="progressbar" aria-valuemin="0"
                                    aria-valuemax="100">
                                    <div class="progress-bar rounded-pill"
                                        style="width:{{ ($record['progress'] / $record['task_progress']) * 100 }}%"></div>
                                </div>
                                <div class="col-auto mx-2 progres_value">
                                    {{ $record['progress'] }}/{{ $record['task_progress'] }}</div>
                            </div>
                        </div>
                        <div class="col-12 my-2 pe-5 collapse" id="task_no2">
                            @if ($record['task'] == '個人資料')
                                @foreach ($personalProgress['profile']['is_null'] as $key => $value)
                                    @if ($value)
                                        <p class="my-2">
                                            未完成：@if ($key == 'phone')
                                                手機
                                            @elseif($key == 'address')
                                                地址
                                            @elseif($key == 'user_image')
                                                個人照
                                            @endif
                                            <a href="#"><span class="badge">去完成</span></a>
                                        </p>
                                    @else
                                        
                                        <p class="my-2">
                                            已完成：@if ($key == 'phone')
                                                手機
                                            @elseif($key == 'address')
                                                地址
                                            @elseif($key == 'user_image')
                                                個人照
                                            @endif
                                            <a href="#">
                                                <span class="badge finish_badge">已完成</span></a>
                                        </p>
                                    @endif
                                @endforeach
                            @endif
                            <p class="mt-3 mb-1">任務規則：</p>
                            <div class="task_detail">
                                <!-- 任務規則內容 如是html tag資料可直接找task_detail帶入資料-->
                                <p class="my-2">
                                    {{ $record['requirement'] }}
                                </p>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
        @include('layouts.sidebar')
    </div>
@endsection
