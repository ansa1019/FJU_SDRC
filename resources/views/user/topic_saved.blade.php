@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user_info') }}">個人資料</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('article_saved_list') }}">收藏與追蹤</a></li>
                        <li class="breadcrumb-item active" aria-current="page">話題追蹤</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>話題追蹤</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-0 pe-md-4">
                <!--收藏項目-->
                @foreach ($subHashtag as $sub)
                    <div class="row mt-4">
                        <div class="col-12 ps-0" id="topic_collection_list">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-auto">
                                    <span class="rounded-circle ct-bg-1 me-1"><i
                                            class="fas fa-user p-1 text-white"></i></span>
                                    <!--收藏的發文者-->
                                    <a href="{{ Route('searchArticle') . '/' . substr($sub, 1, strlen($sub)) }}"
                                        class="topic_title" style="text-decoration: none; color: inherit;">
                                        {{ str_replace('#', '', $sub) }}
                                    </a>


                                    <!--該發文者的文章資訊-->
                                    <span class="topic_info">{{ $article_num[$sub] }}篇文章</span>
                                    {{-- <!--該發文者的近期發文資訊-->
                                    <span class="topic_news">有{{ $article_num[$sub . '_new_article'] }}篇新文章</span> --}}
                                </div>
                                <div class="col-auto">
                                    {{-- <button type="button" class="btn" onclick="notify_saved_btn(this)"><i
                                        class="fas fa-bell"></i></button> --}}
                                    <button type="button" class="btn btn-c2 rounded-pill follow-saved-btn"
                                        onclick="follow_topic_saved_btn(this)">追蹤中</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
