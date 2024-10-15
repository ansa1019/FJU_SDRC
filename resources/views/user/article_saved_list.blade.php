@extends('layouts.masterpage')

@section('content')
    <script>
        var postStorageds = {!! json_encode($postStorageds) !!}
    </script>
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('article_saved_list') }}">收藏與追蹤</a></li>
                        <li class="breadcrumb-item active" aria-current="page">文章收藏</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>文章收藏</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-0 pe-md-4">
                <input type="hidden" id="post_id">
                <input type="hidden" id="post_title">
                <div class="content p-3" id="article_collection_list">
                    <div id="postStorageds" class="row d-flex justify-content-center mt-3">
                        <!--"不分類收藏" -->
                        <div id="postStoraged_不分類收藏" class="col-auto text-center mb-3 postStoraged">
                            <!--分類圖片-->
                            <a href="{{ route('article_saved_collect') . '/不分類收藏' }}">
                                <img src="{{ asset('static/img/img_' . rand(1, 4) . '.png') }}"
                                    class="rounded mx-auto d-block" alt="所有收藏" />
                            </a>
                            <!--分類名稱-->
                            <div class="row">
                                <p class="col-auto ms-1 m-auto saved-title ps-0">所有收藏</p>
                            </div>
                        </div>

                        <!-- for loop 收藏分類-->
                        @foreach ($postStorageds as $postStoraged)
                            @if ($postStoraged['storage_name'] != '不分類收藏')
                                <div id="postStoraged_{{ $postStoraged['storage_name'] }}"
                                    class="col-auto text-center mb-3 postStoraged">

                                    <!--分類圖片-->
                                    <a href="{{ route('article_saved_collect') . '/' . $postStoraged['storage_name'] }}">
                                        <img src="{{ !empty($postStoraged['latest_article_image']) ? $postStoraged['latest_article_image'] : asset('static/img/img_' . rand(1, 4) . '.png') }}"
                                            class="rounded mx-auto d-block" alt="{{ $postStoraged['storage_name'] }}" />
                                    </a>
                                    <!--分類名稱-->
                                    <div class="row">
                                        <p class="col-auto ms-1 saved-title ps-0">
                                            {{ $postStoraged['storage_name'] }}
                                        </p>
                                        <div class="edit_storage dropdown d-inline" data-bs-toggle="tooltip"
                                            data-bs-title="編輯" data-bs-placement="top">
                                            <button class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="fas fa-pencil-alt ct-sub-1 me-1"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button class="dropdown-item rename_btn"
                                                        onclick="storaged_rename('{{ $postStoraged['id'] }}','{{ $postStoraged['storage_name'] }}')">修改分類</button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item del_btn"
                                                        onclick="storaged_delete('{{ $postStoraged['id'] }}','{{ $postStoraged['storage_name'] }}')">刪除分類</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div id="new_saved" class="col-auto text-center mx-0"> <!--"新建分類" -->
                            <!--點選"新建分類"可創建-->
                            <a id="add_saved_btn" style="cursor: pointer">
                                <img src="https://placehold.jp/45/70c6e3/ffffff/180x130.png?text=%EF%BC%8B"
                                    class="rounded mx-auto d-block" alt="新增收藏分類" />
                                <p class="saved-title text-start p-1 pt-2">新增收藏分類</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
    @include('layouts.bookmark')
@endsection
