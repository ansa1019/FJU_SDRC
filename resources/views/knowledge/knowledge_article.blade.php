@extends('layouts.masterpage')

@section('content')

    <head>
        <style>
            h1::before,
            h2::before,
            h3::before {
                content: "";
                display: block;
                height: 70px;
                /* 调整滚动位置的高度 */
                margin-top: -70px;
                /* 负值等于上面设置的高度，以抵消滚动位置 */
                visibility: hidden;
            }
        </style>
    </head>

    <div class="container-xxl">
        <p style="display: none" id='article_id'>{{ $id }}</p>
        <p style="display: none" id='category'>{{ $maincate . '/' . $category['0']['name'] }}</p>
        <p style="display: none" id='nickname'>{{ $nickname }}</p>
        <p style="display: none" id='is_click'>{{ $is_click }}</p>
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('knowledge_library',$maincate . '/' . $category['0']['name']) }}" class="ct-title-1 text-decoration-none mx-2"
                            id='article_category'>知識圖書館</a></li> --}}
                            
                        <li class="breadcrumb-item active">知識圖書館&nbsp;/&nbsp;<a href="{{ route('knowledge_library',$maincate . '/' . $category['0']['name']) }}" class="breadcrumb-item active"
                            id='article_category'>{{ $category['0']['name'] }}</a></li>
                        {{-- <!-- <li class="breadcrumb-item active" aria-current="page">{{ $article_title }}</li> --> --}}
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <!-- 顯示文章標題 -->
                    <h3 class="col-auto px-0" id="article_title">{{ $article_title }}</h3>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-0 pe-md-4">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-12">
                        <ul class="nav" id="article_class_tabs">
                            <!-- 文章類別標籤 -->
                            <a class="nav-link rounded-pill active" aria-current="page" href="#"><i
                                    class="fas fa-tag me-1"></i>{{ $category[0]['name'] }}</a>
                            {{-- <a class="nav-link rounded-pill active" aria-current="page" href="#"><i
                                    class="fas fa-tag me-1"></i>{{ $category[0]['article_title'] }}</a> --}}
                        </ul>
                    </div>
                    <br />
                    <br />
                    <div class="col-12 mt-2 d-flex align-items-center">
                        <!-- 顯示文章日期 -->
                        <span class="ct-sub-1 mx-2">{{ date('Y-m-d', strtotime($date)) }}</span>
                        <!-- 顯示小編名稱/作者 *帶個人頁面超連結?-->
                        <a href="{{ route('author_article_list', $identity) }}" class="ct-title-1 text-decoration-none mx-2"
                            id="article_author">{{ $identity }}</a>
                        @if ($nickname != '')
                            @if ($subscribe == 0)
                                <button type="button" class="btn btn-sm rounded-pill btn-outline-c2 col-auto mx-2 px-3"
                                    onclick="follow(this,'author')">追蹤</button>
                            @else
                                <button type="button" class="btn btn-c2 rounded-pill follow-saved-btn col-auto mx-2 px-3"
                                    onclick="follow(this,'author')">追蹤中</button>
                            @endif
                        @endif
                        @if ($is_rd)
                            <button type="button"
                                class="btn btn-c2 rounded-pill follow-saved-btn col-auto mx-2 px-3 ms-auto"
                                data-bs-toggle="modal" data-bs-target="#dataModal">查看洞察報告</button>
                            <div class="modal fade" id="dataModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">洞察報告</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body row row-cols-2 d-flex justify-content-center">
                                            <div class="card col-5 py-3 m-1" style="background: #ececec">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title fs-18 fw-normal">文章瀏覽次數
                                                        <i class="fas fa-question-circle "
                                                            title="使用者進入文章的次數，同一使用者重複瀏覽文章也會列入文章"></i>
                                                    </h5>
                                                    <p class="fs-24 my-0 fw-bold">{{ $record['click'] }}</p>
                                                </div>
                                            </div>
                                            <div class="card col-5 py-3 m-1" style="background: #ececec">
                                                <div class="card-body text-center m-auto">
                                                    <h5 class="card-title fs-18 fw-normal">文章互動次數
                                                        <i class="fas fa-question-circle"
                                                            title="與本文章互動過的次數，包含愛心數、留言數、收藏數、分享次數"></i>
                                                    </h5>
                                                    <p class="fs-24 my-0 fw-bold">
                                                        {{ $like['count'] + $comment_count + $share['count'] + $bookmark['count'] }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="card col-5 py-3 m-1" style="background: #ececec">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title fs-18 fw-normal">使用者數量
                                                        <i class="fas fa-question-circle" title="使用者總數"></i>
                                                    </h5>
                                                    <p class="fs-24 my-0 fw-bold">{{ $users['count'] }}</p>
                                                </div>
                                            </div>
                                            <div class="card col-5 py-3 m-1" style="background: #ececec">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title fs-18 fw-normal">平均閱讀時間
                                                        <i class="fas fa-question-circle" title="使用者閱讀本文章的平均閱讀時間"></i>
                                                    </h5>
                                                    <p class="fs-24 my-0 fw-bold">{{ $record['time'] }}</p>
                                                </div>
                                            </div>
                                            <p class="mb-0 w-auto">資料更新時間：{{ $update_time }}</p>
                                            <a href="{{ url('article_report/knowledge') }}"
                                                class="btn btn-c2 rounded-pill my-2 fs-6">查看整體洞察報告</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="row mt-3 px-1 ps-md-0 pe-md-3">
                    <div class="article_content" id="article_id_{{ $id }}">
                        <!-- 顯示文章內容 -->
                        <div class="article_content" id="content">
                            {!! $html !!}
                        </div>
                        @if ($hashtag != [])
                            <div class="col-12 my-3">
                                <ul class="nav" id="article_tabs">
                                    <!-- for loop 顯示用戶自定義標籤 data:標籤名稱+連結 -->
                                    @foreach ($hashtag as $tag)
                                        @if ($tag != 'null')
                                            <a class="nav-link rounded-pill"
                                                href="{{ route('searchArticle', ['searchText' => $tag]) }}"><i
                                                    class="fas fa-hashtag me-1"></i>{{ $tag }}</a>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- 按讚/留言/分享數 顯示於span中 -->
                        <div class="col-12 d-flex mt-4 mb-2 ct-sub-1">
                            <div class="me-3">
                                <button class="btn btn-sm p-0" id='like' onclick="knowledge_like(this)">
                                    <!--需判斷是否按讚過此文章-->
                                    <!-- 無按讚 顯示-->
                                    <i class="fas fa-heart {{ $like['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }}"></i>
                                    <!-- 有按讚 顯示-->
                                    <!-- <i class="fas fa-heart ct-txt-2"></i> -->
                                </button>
                                <span class="me-2 like_count" id='like_count'>{{ $like['count'] }}</span>
                            </div>
                            <div class="me-3"><i class="fas fa-comment me-1"></i><span
                                    class="me-2 comment_count">{{ $comment_count }}</span>
                            </div>
                            <div class="me-3">
                                <button class="btn btn-sm p-0" id='share' data-bs-toggle="modal"
                                    data-bs-target="#shareModal" onclick="knowledge_share(this)">
                                    <i
                                        class="fas fa-share {{ $share['in_user'][0] == 1 ? 'ct-txt-2' : 'ct-sub-1' }} me-1"></i></button><span
                                    class="me-2 share_count" id='share_count'>{{ $share['count'] }}</span>
                            </div>
                            <div class="dropdown d-inline me-3" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                data-bs-placement="top">
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <!--判斷是否是自己帳號留的言 有則顯示編輯功能-->
                                    @if ($user_mail == $author)
                                        <li>
                                            <button type="button" onclick="delArticle(this)"
                                                class="dropdown-item">刪除文章</button>
                                        </li>
                                    @else
                                        <li>
                                            <button type="button"
                                                onclick="open_denounce(this,'post', {{ $id }})"
                                                class="dropdown-item">檢舉文章</button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="me-3">
                                <button class="btn btn-sm p-0 openBookmark" id="openBookmark_{{ $id }}"
                                    onclick="openBookmark('{{ $id }}')"><i
                                        class="{{ $bookmark['in_user'][0] == 1 ? 'fas ct-txt-2' : 'far ct-sub-1' }} fa-bookmark me-1"></i></button>
                                <!-- <button class="btn btn-sm p-0" id='collect' onclick="knowledge_collect(this)"> -->
                                <!--需判斷是否收藏過此文章-->
                                <!--沒收藏 顯示此按紐-->
                                <!-- <i class="far fa-bookmark {{ $bookmark['in_user'][0] == 1 ? 'fas ct-txt-2' : 'far ct-sub-1' }} me-1"></i> -->
                                <!--有收藏 顯示此按紐-->
                                <!-- <i class="fas fa-bookmark ct-txt-2 me-1"></i> -->
                                <!-- </button> -->
                            </div>
                        </div>
                        <!--留言區-->
                        <div class="col-12 my-2">
                            <div class="position-relative">
                                <textarea class="form-control d-block ps-3 py-3" rows="4" placeholder="留下你的想法！" id="comment"></textarea>
                                <div class="form-check position-absolute" style="top: 0.6rem; right: 0.7rem">
                                    <input class="form-check-input" type="checkbox" value="" id="anony_enable" />
                                    <label class="form-check-label" for="anony_enable">匿名留言</label>
                                </div>
                                <button type="submit" class="btn btn-c2 rounded-pill py-1 position-absolute"
                                    style="bottom: 0.6rem; right: 0.4rem" onclick="createArticleComment(this)">留言</button>
                            </div>
                        </div>
                        <!--留言回應區-->
                        <div class="mt-4" id="comments_list">
                            <!-- 留言 1F -->
                            @foreach ($comments as $comment)
                            @php
                                $blacklist = session('blacklist', []);
                                $blacklistedCommentIds = $blacklist['comment'] ?? [];
                            @endphp
                                @if (!in_array($comment['id'], $blacklistedCommentIds))
                                    <div class="col-12 my-1 border-bottom" id="comment_{{ $comment['id'] }}">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-end">
                                                @if ($comment['identity'] == '匿名')
                                                    <img class="comment-uesr-img me-2"
                                                        src={{ asset('static/img/female.png') }}
                                                        style="width: var(--fs-30);" />
                                                @else
                                                    <img class="comment-uesr-img me-2"
                                                        src={{ env('API_IP') . $comment['userdata']['image'] }}
                                                        style="width: var(--fs-30);" />
                                                @endif
                                                <span
                                                    class="cmt_author">{{ $comment['identity'] ? $comment['identity'] : $comment['userdata']['nickname'] }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-sm p-0" onclick="like(this)">
                                                    <!--需判斷是否按讚過此文章-->
                                                    <!-- 無按讚 顯示-->
                                                    {{-- <i class="fas fa-heart ct-sub-1 me-1"></i> --}}
                                                    <!-- 有按讚 顯示-->
                                                    <!-- <i class="fas fa-heart ct-txt-2 me-1"></i> -->
                                                </button>
                                                {{-- <span class="me-2 like_count">112</span> --}}
                                                @if ($user_mail == $comment['author'])
                                                    <button class="btn btn-sm p-0" onclick="patchArticleComment(this)">
                                                        <i class="fas fa-edit ct-sub-1 me-1"></i>
                                                    </button>
                                                    <!--當使用者正在編輯留言時 顯示提交按鈕-->
                                                    <!-- <button class="btn btn-sm p-0 edit_check_btn" data-bs-toggle="tooltip" data-bs-title="提交">
                                                                                                                                                        <i class="fas fa-check ct-sub-1 me-1"></i>
                                                                                                                                                    </button> -->
                                                    <button class="btn btn-primary btn-sm edit_check_btn mx-1">提交</button>
                                                @endif
                                                <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                                    data-bs-placement="top">
                                                    <button class="btn btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <!--判斷是否是自己帳號留的言 有則顯示編輯功能-->
                                                        @if ($user_mail == $comment['author'])
                                                            <li>
                                                                <button type="button" onclick="delArticleComment(this)"
                                                                    class="dropdown-item">刪除留言</button>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <button type="button"
                                                                    onclick="open_denounce(this,'comment', {{ $comment['id'] }})"
                                                                    class="dropdown-item">檢舉留言</button>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 my-3 pe-4 ct-title-1 comment_content" contenteditable="false"
                                            id="commentid_content1" style="text-align: justify">
                                            {{ $comment['body'] }}
                                        </div>
                                        <!--當使用者正在編輯留言時 顯示提交按鈕 -->
                                        <!-- <button class="btn btn-primary btn-sm edit_check_btn">提交</button> -->
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>

        <!--分享貼文 modal-->
        <div class="popup modal fade" id="shareModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">分享文章</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size: var(--fs-18)">
                        <div class="row d-flex justify-content-center py-3 ">
                            <p>分享至社群平台</p>
                            <ul class="icons">
                                <a target="_blank" href="#" class="fb_share"><i class="fab fa-facebook-f"></i></a>
                                <a target="_blank" href="#" class="line_share"><i class="bi bi-line"></i></a>
                            </ul>
                            <p>或 複製連結</p>
                            <div class="field">
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                    <input type="text" class="form-control" id="input_link" readonly
                                        value="https://codepen.io/" />
                                    <button class="btn btn-outline-c3" type="button" id="copylink_btn"
                                        onclick="copy_sharelink()">複製連結</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @include('layouts.bookmark')

        <script>
            var token = $("#jwt_token").text();
            var socketIP = document
                .getElementById("app")
                .getAttribute("data-api-ip")
                .split("//")[1];
            var socket = new WebSocket("ws://" + socketIP + "ws/record/{{ $id }}/?token=" + token);
            socket.onopen = function() {
                if (sessionStorage.getItem('previousPageUrl') != window.location.href) {
                    console.log("connect")
                    socket.send(
                        JSON.stringify({
                            action: "connect",

                        }));
                } else {
                    console.log("reconnect")
                    socket.send(
                        JSON.stringify({
                            action: "reconnect",
                        }));
                }
            }
            var ArticleRoute = "{{ route('knowledge_library') }}";
            var knowledgeArticleUpdateRoute = "{{ route('KnowledgeArticleUpdate') }}";
        </script>
    @endsection
