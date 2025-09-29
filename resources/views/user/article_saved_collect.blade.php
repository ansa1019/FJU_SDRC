@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">收藏夾</a></li>
                        <li class="breadcrumb-item"><a href="#">收藏文章列表</a></li>

                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0">
                        <i class="fab fa-gratipay me-1 ct-txt-1"> </i>{{ $storage_name }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-0 pe-md-4">
                <div class="row mt-4">
                    <!--文章列表-->
                    <div class="col-lg-12 px-0" id='articleContainer'>
                        <!-- 文章 -->
                        @foreach ($articles as $article)
                            <div class="row border-bottom">
                                <div id="article_id_{{ $article['id'] }}"
                                    class="col p-3 d-flex flex-column align-content-between justify-content-center position-static">
                                    <p style="display:none" id='article_category'>{{ $article['category'][0]['name'] }}
                                    <p style="display:none" id='identity'>{{ $article['identity'] }}
                                    <p style="display:none" id='hashtags'>{{ $article['hashtag'] }}
                                    </p>
                                    {{-- <h5 class="article-title" id="article_id_title">
                                        <a href="{{ 
                                            in_array($article['category'][0]['name'], ['備孕調理', '婦科保健', '小產調理', '懷孕知識', '日常保健']) 
                                                ? route('knowledge_article', ['id' => $article['id']]) 
                                                : route('TreatmentArticleGet', ['id' => $article['id']]) 
                                        }}">
                                            {{ $article['title'] }}
                                        </a>
                                    </h5> --}}
                                    
                                    <h5 class="article-title" id="article_id_title">
                                        <a href="{{ 
                                            in_array($article['maincate'], ['備孕調理', '婦科保健', '小產調理', '懷孕知識', '日常保健']) 
                                                ? route('knowledge_article', ['id' => $article['id']]) 
                                                : route('TreatmentArticleGet', ['id' => $article['id']]) 
                                        }}" 
                                        onclick="console.log('{{ $article['maincate'] }}')">
                                            {{ $article['title'] }}
                                        </a>
                                    </h5>
                                    {{-- <h5 class="article-title" id="article_id_title">
                                        <a
                                            href="{{ route('TreatmentArticleGet', ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                                    </h5> --}}
                                    
                                    
                                    
                                    
                                    
                                    <p style="display: none" id='html'>{{ $article['html'] }}</p>
                                    <div class="mb-3 article-abs" id="article_id_abs"
                                        style="overflow: hidden; max-height: 4em; max-width: 430px;">
                                        {!! $article['plain'] !!}
                                    </div>
                                    <div class="ct-sub-1">
                                        <i
                                            class="fas fa-heart {{ $article['like']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i>
                                        <span class="me-2 like_count" id='like_count'>{{ $article['like']['count'] }}</span>
                                        <i class="fas fa-comment me-1"></i>
                                        <span class="me-2" id='comment_count'>{{ $article['comment_count'] }}</span>
                                        <i
                                            class="fas fa-share  {{ $article['share']['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i>
                                        <span class="me-2" id='share_count'>{{ $article['share']['count'] }}</span>
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
