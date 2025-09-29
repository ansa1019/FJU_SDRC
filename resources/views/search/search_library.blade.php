@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        {{-- <p style="display: none" id='category'>{{ $subcategory }}</p>
        <p style="display: none" id='subcategory'>{{ $category }}</p> --}}
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">話題追蹤</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $searchText }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row pt-1 px-md-5">
            <div class="col-12 my-2">
                <div class="row d-flex align-items-center">
                    <h3 class="class-title col-auto ps-0" id='searchText'><i
                            class="fab fa-gratipay me-1 ct-txt-1"></i>{{ $searchText }}
                    </h3>
                    @if ($nickname != '' and $is_hashtag == true)
                        @if ($subTopic == 0)
                            <button type="button" class="btn btn-sm rounded-pill btn-outline-c2 col-auto mx-2 px-3"
                                onclick="topic_follow(this)">追蹤</button>
                        @else
                            <button type="button" class="btn btn-c2 rounded-pill follow-saved-btn col-auto mx-2 px-3"
                                onclick="topic_follow(this)">追蹤中</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-0 pe-md-4">
                <div class="row d-flex justify-content-between align-items-end">
                    <div class="col-md-12 col pe-0">
                        <div class="row g-3 align-items-center float-end">
                            <div class="col-auto pe-0">
                                <select class="form-select" id="articleSortSearch" style="font-size: var(--fs-16)">
                                    <option value='-click' {{ $sort == 'click' ? 'selected' : '' }}>熱門文章</option>
                                    <option value='-created_at' {{ $sort == '-created_at' ? 'selected' : '' }}>最新文章</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <!--文章列表-->
                    <div class="col-lg-12 px-0">
                        <!-- 文章1 -->
                        @foreach ($articles as $article)
                            <div class="row border-bottom">
                                <div id="article_id_{{ $article['id'] }}"
                                    class="col p-3 d-flex flex-column align-content-between justify-content-center position-static">
                                    <!--文章標題-->
                                    @if ($article['is_official'] == true)
                                        <h5 class="article-title" id="article_id_title"><a
                                                href="{{ route('knowledge_article', ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                                        </h5>
                                    @else
                                        <h5 class="article-title" id="article_id_title"><a
                                                href="{{ route('TreatmentArticleGet', ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                                        </h5>
                                    @endif
                                    <!--文章內文摘要-->
                                    <div class="mb-3 article-abs" id="article_id_abs"
                                        style="overflow: hidden; max-height: 4em; max-width: 430px;">
                                        {!! $article['plain'] !!}
                                    </div>
                                    <div class="ct-sub-1">
                                        <!--按鑽數 資料填入span-->
                                        <button class="btn btn-sm p-0" id='like' onclick="search_like(this)">
                                            <i
                                                class="fas fa-heart {{ $article['like']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i></button><span
                                            class="me-2 like_count" id='like_count'>{{ $article['like']['count'] }}</span>
                                        <i class="fas fa-comment me-1"></i><span
                                            class="me-2">{{ $article['comment_count'] }}</span>
                                        <button class="btn btn-sm p-0" id='share' onclick="search_share(this)"><i
                                                class="fas fa-share  {{ $article['share']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i></button><span
                                            class="me-2" id='share_count'>{{ $article['share']['count'] }}</span>
                                        <!--收藏文章 onclick()帶入文章id-->
                                        <button class="btn btn-sm p-0" id='collect' onclick="search_collect(this)"><i
                                                class="far fa-bookmark {{ $article['bookmark']['in_user'][0] == 1 ? 'fas ct-txt-2' : 'far ct-sub-1' }} me-1"></i></button>
                                    </div>
                                </div>
                                <div class="col-auto d-none d-lg-block px-0 py-1">
                                    <!--文章縮圖-->
                                    <img src={{ !empty($article['image']) ? $article['image'] : $article['index_image'] }}
                                        class="article-img"  />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>
    </div>

    <script>
        var searchArticleRoute = "{{ route('searchArticle') }}";
        var searchArticleUpdateRoute = "{{ route('searchArticleUpdate') }}";
    </script>
@endsection
