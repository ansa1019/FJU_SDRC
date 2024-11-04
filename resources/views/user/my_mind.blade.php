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
                                        <a href="{{ in_array($article['maincate'], ['備孕調理', '婦科保健', '小產調理', '懷孕知識', '日常保健'])
                                            ? route('knowledge_article', ['id' => $article['id']])
                                            : route('TreatmentArticleGet', ['id' => $article['id']]) }}"
                                            onclick="console.log('{{ $article['maincate'] }}')">
                                            {{ $article['title'] }}
                                        </a>
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
                                                data-bs-target="#patch_modal" onclick="getValue(this, 'patch_list')">
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
                                                        <button type="button" onclick="delArticle(this);location.reload();"
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
        <div class="modal fade" id="patch_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <input type="hidden" id="return_content" name="content">
                    <input type="hidden" id="return_html" name="html">
                    <input type="hidden" id="return_id">
                    <div class="modal-header pb-0 border-bottom-0">
                        <h1 class="modal-title fs-5 ct-txt-2 fw-bold">修改聊療，一起聊聊吧🙂</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-1 g-2 align-items-center">
                            <div class="col-auto">
                                <img class="me-1" src="{{ asset('static/img/user.png') }}" width="25" />
                            </div>
                            <div class="col-auto">
                                <select class="form-select" id="patch_id_type">
                                    <option value={{ $nickname }} selected>{{ $nickname }}</option>
                                    <option value="匿名">匿名</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-1 g-2 align-items-center justify-content-between">
                            <div class="col-8">
                                <input class="form-control" type="text" id="input_patch_title" name="title"
                                    placeholder="標題：請用簡短的話說明你的提問/分享" />
                            </div>
                            <div class="col">
                                <select class="form-select" id="patch_treat_class" name="treat">
                                    <option value="聊療小產">聊療小產</option>
                                    <option value="聊療婦科保健">聊療婦科保健</option>
                                    <option value="聊療備孕">聊療備孕</option>
                                    <option value="聊療懷孕">聊療懷孕</option>
                                    <option value="聊療日常保健">聊療日常保健</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-1 g-2 justify-content-center">
                            <!--文字編輯器套件 editor-->
                            <div class="col-12" id="patch-editor-container" style="height: 300px; font-size: 30px;">
                                <textarea class="form-control h-100" rows="7" id="patch_editor" name="patch_editor"></textarea>
                            </div>
                            <div class="col-12">
                                <input class="form-control" type="text" id="patch_input_topic"
                                    placeholder="#話題：可以根據你的文章內容，輸入半形的#，可以新增多個話題喔！" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-c2 rounded-pill px-3 py-1" onclick="patchData()"><i
                                class="fas fa-bullhorn me-1"></i>發文</button>
                        {{-- <button type="button" class="btn btn-outline-c2 ct-sub-1 rounded-pill px-3 py-1"
                        onclick="draft()"><i class="bi bi-inbox-fill me-1"></i>暫存</button> --}}
                        {{-- <button onclick="data()">發文</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.bookmark')
@endsection
