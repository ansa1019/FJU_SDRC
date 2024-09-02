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
                        <li class="breadcrumb-item active" aria-current="page">我的心事</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>我的心事</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-0 pe-md-4">
                <!--文章列表-->
                <div class="row mt-4">
                    <div class="col-lg-12 px-0">
                        <!-- 文章1 -->
                        @foreach ($articles as $article)
                            <div class="row border-bottom">
                                <div id="article_id_{{ $article['id'] }}"
                                    class="col p-3 d-flex flex-column align-content-between justify-content-center position-static">
                                    </p>
                                    <h5 class="article-title" id="article_id_title">
                                        <a
                                            href="{{ route('knowledge_article', ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                                    </h5>
                                    <p style="display: none" id='html'>{{ $article['html'] }}</p>
                                    <div class="mb-3 article-abs" id="article_id_abs"
                                        style="overflow: hidden; max-height: 4em; max-width: 430px;">
                                        {!! $article['plain'] !!}
                                    </div>
                                    <div class="ct-sub-1">
                                        @if ($user_mail == $article['author'])
                                            <!--判斷是否是自己帳號留的言 有則顯示編輯功能-->
                                            <button class="btn btn-sm p-0" data-bs-toggle="modal"
                                                data-bs-target="#patch_modal" onclick="getValue(this)">
                                                <i class="fas fa-edit ct-sub-1 me-1"></i>
                                            </button>

                                            <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="刪除"
                                                data-bs-placement="top">
                                                <button class="btn btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" onclick="delData(this)"
                                                            class="dropdown-item">刪除文章</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                        <button class="btn btn-sm p-0" onclick="like(this)">
                                            <i
                                                class="fas fa-heart {{ $article['like']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i></button><span
                                            class="me-2 like_count">{{ $article['like']['count'] }}</span> <i
                                            class="fas fa-comment me-1"></i><span
                                            class="me-2">{{ $article['comment_count'] }}</span>
                                        <button class="btn btn-sm p-0" onclick="share(this)"><i
                                                class="fas fa-share  {{ $article['share']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i></button><span
                                            class="me-2">{{ $article['share']['count'] }}</span>
                                        <!--收藏文章 onclick()帶入文章id-->
                                        <button class="btn btn-sm p-0 openBookmark" id="openBookmark_{{ $article['id'] }}"
                                            onclick="openBookmark('{{ $article['id'] }}')"><i
                                                class="{{ $article['bookmark']['in_user'][0] == 1 ? 'fas ct-txt-2' : 'far ct-sub-1' }} fa-bookmark me-1"></i></button>
                                        <!---->
                                    </div>
                                </div>
                                <div class="col-auto d-none d-lg-block px-0 py-1">
                                    <img src={{ !empty($article['image']) ? $article['image'] : $article['index_image'] }}
                                        class="article-img" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>

    @include('layouts.bookmark')
@endsection
