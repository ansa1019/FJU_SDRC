@extends('layouts.masterpage')

<head>
    <style>
        div.vote_div input,
        div.vote_div .form-select {
            background: #f5f5f5;
        }
    </style>
</head>
@section('content')
    <div class="container-xxl">
        <p style="display: none" id='category'>{{ $category . '/' . $subcategory }}</p>
        <div class="row pt-1 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <!-- 麵包屑 網頁導覽列-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">知識圖書館</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ url('/knowledge_library/' . $category . '/' . $subcategory) }}">{{ $category }}</a>

                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subcategory }}</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h3 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>{{ $category }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-0 pe-md-4">
                <div class="row d-flex justify-content-between align-items-end">
                    <div class="col-auto mb-1">
                        <ul class="nav" id="article_class_tabs">
                            <!-- 文章類別標籤 -->
                            @if ($subcategory == '小產知識' || $subcategory == '小產調理知識')
                                <a class="nav-link rounded-pill {{ $subcategory == '小產知識' ? 'active' : '' }}"
                                    aria-current="page"
                                    href="{{ route('knowledge_library', ['category' => '小產調理', 'subcategory' => '小產知識']) }}"><i
                                        class="fas fa-tag me-1"></i>小產知識</a>
                                <a class="nav-link rounded-pill {{ $subcategory == '小產調理知識' ? 'active' : '' }}"
                                    href="{{ route('knowledge_library', ['category' => '小產調理', 'subcategory' => '小產調理知識']) }}
                                    "><i
                                        class="fas fa-tag me-1"></i>小產調理知識</a>
                            @elseif ($subcategory == '婦科保健知識' || $subcategory == '婦科保健調理知識')
                                <a class="nav-link rounded-pill {{ $subcategory == '婦科保健知識' ? 'active' : '' }}"
                                    aria-current="page"
                                    href="{{ route('knowledge_library', ['category' => '婦科保健', 'subcategory' => '婦科保健知識']) }}"><i
                                        class="fas fa-tag me-1"></i>婦科保健知識</a>
                                <a class="nav-link rounded-pill {{ $subcategory == '婦科保健調理知識' ? 'active' : '' }}"
                                    href="{{ route('knowledge_library', ['category' => '婦科保健', 'subcategory' => '婦科保健調理知識']) }}
                                            "><i
                                        class="fas fa-tag me-1"></i>婦科保健調理知識</a>
                            @elseif ($subcategory == '備孕知識' || $subcategory == '備孕調理知識')
                                <a class="nav-link rounded-pill {{ $subcategory == '備孕知識' ? 'active' : '' }}"
                                    aria-current="page"
                                    href="{{ route('knowledge_library', ['category' => '備孕調理', 'subcategory' => '備孕知識']) }}"><i
                                        class="fas fa-tag me-1"></i>備孕知識</a>
                                <a class="nav-link rounded-pill {{ $subcategory == '備孕調理知識' ? 'active' : '' }}"
                                    href="{{ route('knowledge_library', ['category' => '備孕調理', 'subcategory' => '備孕調理知識']) }}
                                                    "><i
                                        class="fas fa-tag me-1"></i>備孕調理知識</a>
                            @elseif ($subcategory == '懷孕知識' || $subcategory == '懷孕調理知識')
                                <a class="nav-link rounded-pill {{ $subcategory == '懷孕知識' ? 'active' : '' }}"
                                    aria-current="page"
                                    href="{{ route('knowledge_library', ['category' => '懷孕知識', 'subcategory' => '懷孕知識']) }}"><i
                                        class="fas fa-tag me-1"></i>懷孕知識</a>
                                <a class="nav-link rounded-pill {{ $subcategory == '懷孕調理知識' ? 'active' : '' }}"
                                    href="{{ route('knowledge_library', ['category' => '懷孕知識', 'subcategory' => '懷孕調理知識']) }}
                                                            "><i
                                        class="fas fa-tag me-1"></i>懷孕調理知識</a>
                            @elseif ($subcategory == '日常保健知識' || $subcategory == '日常保健調理知識')
                                <a class="nav-link rounded-pill {{ $subcategory == '日常保健知識' ? 'active' : '' }}"
                                    aria-current="page"
                                    href="{{ route('knowledge_library', ['category' => '日常保健', 'subcategory' => '日常保健知識']) }}"><i
                                        class="fas fa-tag me-1"></i>日常保健知識</a>
                                <a class="nav-link rounded-pill {{ $subcategory == '日常保健調理知識' ? 'active' : '' }}"
                                    href="{{ route('knowledge_library', ['category' => '日常保健', 'subcategory' => '日常保健調理知識']) }}
                                                            "><i
                                        class="fas fa-tag me-1"></i>日常保健調理知識</a>
                            @endif
                        </ul>
                        @if ($is_rd)
                            @if ($temporary_article == [])
                                <button class="btn btn-c2 rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#create_modal"><i class="fas fa-pen me-1"></i>建立營養師文章</button>
                            @else
                            <p style="display: none" id='article_title'>{{ $temporary_article[0]['title'] }}</p>
                            <p style="display:none" id='article_category'>{{ $temporary_article[0]['category'][0]['name'] }}</p>
                            <p style="display: none" id='html'>{{ $temporary_article[0]['html'] }}</p>
                                <button class="btn btn-c2 rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#create_modal" onclick="getValue(this, 'post')"><i
                                        class="fas fa-pen me-1"></i>建立營養師文章</button>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-12 col pe-0">
                        <div class="row g-3 align-items-center float-end">
                            <div class="col-auto pe-0">
                                <select class="form-select" id="articleSortKnowledge" style="font-size: var(--fs-16)">
                                    <option value='-created_at' {{ $sort == '-created_at' ? 'selected' : '' }}>最新文章
                                    </option>
                                    <option value='-click' {{ $sort == '-click' ? 'selected' : '' }}>熱門文章</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <!--文章列表-->
                    <div class="col-lg-12 px-0">
                        <!-- 文章1 -->
                        @if ($articles != [])
                            @foreach ($articles as $article)
                                @php
                                    $blacklist = session('blacklist', []);
                                    $blacklistedArticleIds = $blacklist['article'] ?? [];
                                @endphp
                                @if (!in_array($article['id'], $blacklistedArticleIds))
                                    @if ($article['category'][0]['name'] == $subcategory)
                                        <div class="row border-bottom">
                                            <div id="article_id_{{ $article['id'] }}"
                                                class="col p-3 d-flex flex-column align-content-between justify-content-center position-static">
                                                <p style="display:none" id='article_category'>
                                                    {{ $article['category'][0]['name'] }}
                                                <p style="display:none" id='identity'>{{ $article['identity'] }}
                                                <p style="display:none" id='hashtags'>{{ $article['hashtag'] }}
                                                    <!--文章標題-->
                                                <h5 class="article-title" id="article_id_title">
                                                    <a
                                                        href="{{ route('knowledge_article', ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                                                </h5>
                                                <p style="display: none" id='html'>{{ $article['html'] }}</p>
                                                <!--文章內文摘要-->
                                                <div class="mb-3 article-abs" id="article_id_abs"
                                                    style="overflow: hidden; max-height: 4em; max-width: 430px;">
                                                    {!! $article['plain'] !!}
                                                </div>
                                                <div class="ct-sub-1">
                                                    @if ($user_mail == $article['author'])
                                                        <!--判斷是否是自己帳號留的言 有則顯示編輯功能-->
                                                        <button class="btn btn-sm p-0" data-bs-toggle="modal"
                                                            data-bs-target="#patch_modal" onclick="getValue(this, 'patch')">
                                                            <i class="fas fa-edit ct-sub-1 me-1"></i>
                                                        </button>

                                                        <div class="dropdown d-inline" data-bs-toggle="tooltip"
                                                            data-bs-title="刪除" data-bs-placement="top">
                                                            <button class="btn btn-sm dropdown-toggle" type="button"
                                                                data-bs-toggle="dropdown">
                                                                <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <button type="button" onclick="delArticle(this)"
                                                                        class="dropdown-item">刪除文章</button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <!--按鑽數 資料填入span-->
                                                    <i
                                                        class="fas fa-heart {{ $article['like']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i>
                                                    <span class="me-2 like_count"
                                                        id='like_count'>{{ $article['like']['count'] }}</span>
                                                    <i class="fas fa-comment me-1"></i>
                                                    <span class="me-2">{{ $article['comment_count'] }}</span>
                                                    <i
                                                        class="fas fa-share {{ $article['share']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i>
                                                    <span class="me-2"
                                                        id='share_count'>{{ $article['share']['count'] }}</span>
                                                    <!--收藏文章 onclick()帶入文章id-->
                                                    <button class="btn btn-sm p-0 openBookmark"
                                                        id="openBookmark_{{ $article['id'] }}"
                                                        onclick="openBookmark('{{ $article['id'] }}')"><i
                                                            class="{{ $article['bookmark']['in_user'][0] == 1 ? 'fas ct-txt-2' : 'far ct-sub-1' }} fa-bookmark me-1"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-auto d-none d-lg-block px-0 py-1">
                                                <!--文章縮圖-->
                                                <img src={{ $article['index_image'] }}
                                                    class="article-img" />
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>

    <!-- 建立營養師文章 Modal -->
    <div class="modal fade" id="create_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                @if ($temporary_article == [])
                    <input type="hidden" id="return_content" name="content">
                    <input type="hidden" id="return_html" name="html">
                    <div class="modal-header pb-0 border-bottom-0">
                        <h1 class="modal-title fs-5 ct-txt-2 fw-bold">建立營養師文章🙂</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-1 g-2 align-items-center">
                            <div class="col-auto">
                                <img class="me-1" src="{{ asset('static/img/user.png') }}" width="25" />
                            </div>
                            <div class="col-auto">
                                <select class="form-select" id="id_type">
                                    <option value={{ $nickname }} selected>{{ $nickname }}</option>
                                    {{-- <option value="匿名">匿名</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="row my-1 g-2 align-items-center justify-content-between">
                            <div class="col-8">
                                <input class="form-control" type="text" id="input_new_title" name="title"
                                    placeholder="標題：請用簡短的話說明你的提問/分享" />
                            </div>
                            <div class="col">
                                <select class="form-select" id="treat_class" name="treat">
                                    <option value="小產知識" {{ $subcategory == '小產知識' ? 'selected' : '' }}>小產知識</option>
                                    <option value="小產調理知識" {{ $subcategory == '小產調理知識' ? 'selected' : '' }}>小產調理知識
                                    </option>
                                    <option value="婦科保健知識" {{ $subcategory == '婦科保健知識' ? 'selected' : '' }}>婦科保健知識
                                    </option>
                                    <option value="婦科保健調理知識" {{ $subcategory == '婦科保健調理知識' ? 'selected' : '' }}>婦科保健調理知識
                                    </option>
                                    <option value="備孕知識" {{ $subcategory == '備孕知識' ? 'selected' : '' }}>備孕知識</option>
                                    <option value="備孕調理知識" {{ $subcategory == '備孕調理知識' ? 'selected' : '' }}>備孕調理知識
                                    </option>
                                    <option value="懷孕知識" {{ $subcategory == '懷孕知識' ? 'selected' : '' }}>懷孕知識</option>
                                    <option value="懷孕調理知識" {{ $subcategory == '懷孕調理知識' ? 'selected' : '' }}>懷孕調理知識
                                    </option>
                                    <option value="日常保健知識" {{ $subcategory == '日常保健知識' ? 'selected' : '' }}>日常保健知識
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-1 g-2 justify-content-center">
                            <!--文字編輯器套件 editor-->
                            <div class="col-12" id="editor-container" style="height: 300px; font-size: 30px;">
                                <textarea class="form-control" rows="7" id="editor"></textarea>
                            </div>
                            
                            <div class="col-12">
                                <input class="form-control" type="text" id="create_input_topic"
                                    placeholder="#話題：可以根據你的文章內容，輸入半形的#，可以新增多個話題喔！" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-c2 rounded-pill px-3 py-1"
                            onclick="official_postdata(this, '')"><i class="fas fa-bullhorn me-1"></i>發文</button>
                        <button type="button" class="btn btn-outline-c2 ct-sub-1 rounded-pill px-3 py-1"
                            onclick="official_temporaryData(this, '')"><i class="bi bi-inbox-fill me-1"></i>暫存</button>
                        {{-- <button onclick="data()">發文</button> --}}
                    </div>
                @else
                    <input type="hidden" id="return_content" name="content">
                    <input type="hidden" id="return_html" name="html">
                    <p style="display: none" id='temporary_id'>{{ $temporary_article[0]['id'] }}</p>
                    <div class="modal-header pb-0 border-bottom-0">
                        <h1 class="modal-title fs-5 ct-txt-2 fw-bold">建立聊療，一起聊聊吧🙂</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-1 g-2 align-items-center">
                            <div class="col-auto">
                                <img class="me-1" src="{{ asset('static/img/user.png') }}" width="25" />
                            </div>
                            <div class="col-auto">
                                <select class="form-select" id="id_type">
                                    <option value={{ $nickname }}
                                        {{ $temporary_article[0]['identity'] == $nickname ? 'selected' : '' }}>
                                        {{ $nickname }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-1 g-2 align-items-center justify-content-between">
                            <div class="col-8">
                                <input class="form-control" type="text" id="input_new_title" name="title"
                                    placeholder="標題：請用簡短的話說明你的提問/分享" value={{ $temporary_article[0]['title'] }} />
                            </div>
                            <div class="col">
                                <select class="form-select" id="treat_class" name="treat">
                                    <option value="小產知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '小產知識' ? 'selected' : '' }}>小產知識
                                    </option>
                                    <option value="小產調理知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '小產調理知識' ? 'selected' : '' }}>
                                        小產調理知識</option>
                                    <option value="婦科保健知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '婦科保健知識' ? 'selected' : '' }}>
                                        婦科保健知識
                                    </option>
                                    <option value="婦科保健調理知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '婦科保健調理知識' ? 'selected' : '' }}>
                                        婦科保健調理知識
                                    </option>
                                    <option value="備孕知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '備孕知識' ? 'selected' : '' }}>
                                        備孕知識</option>
                                    <option value="備孕調理知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '備孕調理知識' ? 'selected' : '' }}>
                                        備孕調理知識</option>
                                    <option value="懷孕知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '懷孕知識' ? 'selected' : '' }}>
                                        懷孕知識</option>
                                    <option value="懷孕調理知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '懷孕調理知識' ? 'selected' : '' }}>
                                        懷孕調理知識</option>
                                    <option value="日常保健知識"
                                        {{ $temporary_article[0]['category'][0]['name'] == '日常保健知識' ? 'selected' : '' }}>
                                        日常保健知識</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-1 g-2 justify-content-center">
                            <!--文字編輯器套件 editor-->
                            <div class="col-12" id="editor-container" style="height: 300px; font-size: 30px;">
                                <textarea class="form-control" rows="7" id="editor"></textarea>
                            </div>

                            <div class="col-12 mb-2">
                                <input class="form-control" type="text" id="create_input_topic"
                                    placeholder='#話題：可以根據你的文章內容，輸入半形的#，可以新增多個話題喔！'
                                    value={{ $temporary_article[0]['hashtag'] != 'null' ? $temporary_article[0]['hashtag'] : '' }}>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-c2 rounded-pill px-3 py-1"
                            onclick="official_postdata(this, 'temporary')"><i class="fas fa-bullhorn me-1"></i>發文</button>
                        <button type="button" class="btn btn-outline-c2 ct-sub-1 rounded-pill px-3 py-1"
                            onclick="official_temporaryData(this, 'temporary')"><i
                                class="bi bi-inbox-fill me-1"></i>暫存</button>
                        {{-- <button onclick="data()">發文</button> --}}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 建立修改營養師文章 Modal -->
    <div class="modal fade" id="patch_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <input type="hidden" id="return_content" name="content">
                <input type="hidden" id="return_html" name="html">
                <input type="hidden" id="article_id">
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
                                <option selected>選擇聊療的類別</option>
                                <option value="小產知識">小產知識</option>
                                <option value="小產調理知識">小產調理知識</option>
                                <option value="婦科保健知識">婦科保健知識</option>
                                <option value="婦科保健調理知識">婦科保健調理知識</option>
                                <option value="備孕知識">備孕知識</option>
                                <option value="備孕調理知識">備孕調理知識</option>
                                <option value="懷孕知識">懷孕知識</option>
                                <option value="懷孕調理知識">懷孕調理知識</option>
                                <option value="日常保健知識">日常保健知識</option>
                            </select>
                        </div>
                    </div>
                    <div class="row my-1 g-2 justify-content-center">
                        <!--文字編輯器套件 editor-->
                        <div class="col-12" id="patch-editor-container" style="height: 300px; font-size: 30px;">
                            <textarea class="form-control" rows="7" id="patch_editor" name="patch_editor"></textarea>
                        </div>
                        <div class="col-12">
                            <input class="form-control" type="text" id="patch_input_topic"
                                placeholder="#話題：可以根據你的文章內容，輸入半形的#，可以新增多個話題喔！" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-c2 rounded-pill px-3 py-1" onclick="official_patchData()"><i
                            class="fas fa-bullhorn me-1"></i>發文</button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.bookmark')

    <script>
        var ArticleRoute = "{{ route('knowledge_library') }}";
        var knowledgeArticleUpdateRoute = "{{ route('KnowledgeArticleUpdate') }}";
        var searchArticleRoute = "{{ route('searchArticle') }}";
    </script>
@endsection
