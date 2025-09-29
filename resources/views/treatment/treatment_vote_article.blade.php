@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">療心室</a></li>
                        <li class="breadcrumb-item active" aria-current="page">聊療婦科保健</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="col-auto px-0" id="article_title">票選活動 活動標題</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-0 pe-md-4">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-12 mt-3 d-flex align-items-end">
                        <span class="ct-sub-1 mx-2" id="article_date"></span>
                        <a href="#" class="ct-title-1 text-decoration-none mx-2" id="article_author">月經順順來</a>
                        <button type="button" class="btn btn-sm rounded-pill btn-outline-c2 col-auto mx-2 px-3"
                            onclick="follow(this,'author')">追蹤</button>
                    </div>
                </div>
                <div class="row mt-4 px-1 ps-md-0 pe-md-3">
                    <div class="article_content" id="article_content_id">
                        <div class="col-12 my-3 countdown"></div>
                        <img src="https://placehold.co/500x200" alt="文章圖片" />
                        <p id="article_abs">
                            我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文 我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文
                            我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文 我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文
                            我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文 我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文
                            我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文 我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文
                            我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文 我是內文我是內文我是內文我是內文我是內文我是內文我是內文我是內文
                        </p>
                        <img src="https://placehold.co/200x100" />
                        <div class="col-12 my-3" id="article_vote">
                            <!--票選選項 type分有單選radio / 複選checkbox -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="vote_item" value="vote_item1" />
                                <label class="form-check-label" for="vote_item1"> 選項一 </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="vote_item" value="vote_item2"
                                    checked />
                                <label class="form-check-label" for="vote_item2"> 選項二 </label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-c2 col-12 my-1" onclick="vote(this)"
                            style="font-size: var(--fs-18)">投票</button>
                    </div>

                    <div class="col-12 my-3">
                        <ul class="nav" id="article_tabs">
                            <!-- for loop 顯示用戶自定義標籤 data:標籤名稱+連結 -->
                            <a class="nav-link rounded-pill" href="#"><i class="fas fa-hashtag me-1"></i>多囊性卵巢</a>
                            <a class="nav-link rounded-pill" href="#"><i class="fas fa-hashtag me-1"></i>調經藥</a>
                        </ul>
                    </div>
                    <!-- 按讚/留言/分享數 顯示於span中 -->
                    <div class="col-12 d-flex mt-4 mb-2 ct-sub-1">
                        <div class="me-3">
                            <button class="btn btn-sm p-0" onclick="like(this)">
                                <!--需判斷是否按讚過此文章-->
                                <!-- 無按讚 顯示-->
                                <i class="fas fa-heart ct-sub-1"></i>
                                <!-- 有按讚 顯示-->
                                <!-- <i class="fas fa-heart ct-txt-2"></i> -->
                            </button>
                            <span class="me-2 like_count">112</span>
                        </div>
                        <div class="me-3"><i class="fas fa-comment me-1"></i><span class="me-2 comment_count">26</span>
                        </div>
                        <div class="me-3"><i class="fas fa-share me-1"></i><span class="me-2 share_count">3</span></div>
                        <div class="me-3">
                            <button class="btn btn-sm p-0" onclick="collect(this)">
                                <!--需判斷是否收藏過此文章-->
                                <!--沒收藏 顯示此按紐-->
                                <i class="far fa-bookmark ct-sub-1 me-1"></i>
                                <!--有收藏 顯示此按紐-->
                                <!-- <i class="fas fa-bookmark ct-txt-2 me-1"></i> -->
                            </button>
                        </div>
                    </div>
                    <!--留言區-->
                    <div class="col-12 my-2">
                        <form action="#" method="post">
                            <div class="position-relative">
                                <textarea class="form-control d-block ps-3 py-3" rows="4" placeholder="留下你的想法！" id="comment"></textarea>
                                <div class="form-check position-absolute" style="top: 0.6rem; right: 0.7rem">
                                    <input class="form-check-input" type="checkbox" value="" id="anony_enable" />
                                    <label class="form-check-label" for="anony_enable">匿名留言</label>
                                </div>
                                <button type="submit" class="btn btn-c2 rounded-pill py-1 position-absolute"
                                    style="bottom: 0.6rem; right: 0.4rem">留言</button>
                            </div>
                        </form>
                    </div>
                    <!--留言回應區-->
                    <div class="mt-4" id="comments_list">
                        <!-- 留言 1F -->
                        <div class="col-12 my-1 border-bottom" id="comment_1F">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-end"><img class="comment-uesr-img me-2"
                                        src="static/img/user.png" /><span class="cmt_author">作者</span></div>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm p-0" onclick="like(this)">
                                        <!--需判斷是否按讚過此文章-->
                                        <!-- 無按讚 顯示-->
                                        <i class="fas fa-heart ct-sub-1 me-1"></i>
                                        <!-- 有按讚 顯示-->
                                        <!-- <i class="fas fa-heart ct-txt-2 me-1"></i> -->
                                    </button>
                                    <span class="me-2 like_count">112</span>

                                    <!--判斷是否是自己帳號留的言 有則顯示編輯功能-->
                                    <button class="btn btn-sm p-0" onclick="edit_comment(this)">
                                        <i class="fas fa-edit ct-sub-1 me-1"></i>
                                    </button>
                                    <!--當使用者正在編輯留言時 顯示提交按鈕-->
                                    <button class="btn btn-sm p-0 edit_check_btn" data-bs-toggle="tooltip" data-bs-title="提交">
                                        <i class="fas fa-check ct-sub-1 me-1"></i>
                                    </button>
                                    <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                        data-bs-placement="top">
                                        <button class="btn btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button type="button" onclick="del_comment(this)"
                                                    class="dropdown-item">刪除留言</button>
                                            </li>
                                            <li>
                                                <button type="button" onclick="report_comment(this)"
                                                    class="dropdown-item">檢舉留言</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 my-3 pe-4 ct-title-1 comment_content" contenteditable="false"
                                id="commentid_content1" style="text-align: justify">
                                我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容
                            </div>
                            <div class="col-12 my-2">
                                <a class="ct-sub-1 text-decoration-none" data-bs-toggle="collapse"
                                    href="#commentid_reply_list">
                                    顯示回覆
                                    <span id="comment_id_reply_count">
                                        2
                                        <!-- 顯示回覆留言數 -->
                                    </span>
                                </a>
                            </div>
                            <!--留言回覆 摺疊區 -->
                            <div class="col-12 ps-4 mt-3 collapse" id="commentid_reply_list">
                                <!--留言回覆 第一則顯示-->
                                <div class="my-1" id="comment1F_reply_1F">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-end"><img class="comment-uesr-img me-2"
                                                src="static/img/user.png" /><span class="cmt_author">作者</span></div>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-sm p-0" onclick="like(this)">
                                                <i class="fas fa-heart ct-sub-1 me-1"></i>
                                            </button>
                                            <span class="me-2 like_count">112</span>
                                            <!--判斷是否是自己帳號留的言 有則顯示編輯功能-->
                                            <button class="btn btn-sm p-0" onclick="edit_comment(this)">
                                                <i class="fas fa-edit ct-sub-1 me-1"></i>
                                            </button>
                                            <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                                data-bs-placement="top">
                                                <button class="btn btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" onclick="del_comment(this)"
                                                            class="dropdown-item">刪除留言</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" onclick="report_comment(this)"
                                                            class="dropdown-item">檢舉留言</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3 pe-4 ct-title-1 comment_content" contenteditable="false"
                                        id="replyid_content1" style="text-align: justify">
                                        我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容
                                    </div>
                                </div>
                                <!--留言回覆 其他顯示 (有分隔線border-top差別)-->
                                <div class="border-top my-1 pt-3" id="comment1F_reply_2F ">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-end"><img class="comment-uesr-img me-2"
                                                src="static/img/user.png" /><span class="cmt_author">作者</span></div>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-sm p-0" onclick="like(this)">
                                                <i class="fas fa-heart ct-sub-1 me-1"></i>
                                            </button>
                                            <span class="me-2 like_count">112</span>
                                            <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                                data-bs-placement="top">
                                                <button class="btn btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" onclick="del_comment(this)"
                                                            class="dropdown-item">刪除留言</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" onclick="report_comment(this)"
                                                            class="dropdown-item">檢舉留言</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3 pe-4 ct-title-1 comment_content" contenteditable="false"
                                        id="replyid_content2" style="text-align: justify">
                                        我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 留言 2F -->
                        <div class="col-12 my-1 pt-3 border-top" id="comment_2F">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-end"><img class="comment-uesr-img me-2"
                                        src="static/img/user.png" /><span class="cmt_author">作者</span></div>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm p-0" onclick="like(this)">
                                        <i class="fas fa-heart ct-sub-1 me-1"></i>
                                    </button>
                                    <span class="me-2 like_count">89</span>
                                    <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                        data-bs-placement="top">
                                        <button class="btn btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button type="button" onclick="del_comment(this)"
                                                    class="dropdown-item">刪除留言</button>
                                            </li>
                                            <li>
                                                <button type="button" onclick="report_comment(this)"
                                                    class="dropdown-item">檢舉留言</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 my-3 pe-4 ct-title-1 comment_content" contenteditable="false"
                                id="commentid_content1" style="text-align: justify">
                                我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容
                            </div>
                            <div class="col-12 my-2">
                                <a class="ct-sub-1 text-decoration-none" data-bs-toggle="collapse"
                                    href="#commentid2_reply_list"> 顯示回覆 <span id="comment_id_reply_count">2</span> </a>
                            </div>
                            <!--留言回覆 摺疊區 -->
                            <div class="col-12 ps-4 mt-3 collapse" id="commentid2_reply_list">
                                <!--留言回覆第一則顯示-->
                                <div class="my-1" id="comment2F_reply_1F">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-end"><img class="comment-uesr-img me-2"
                                                src="static/img/user.png" /><span class="cmt_author">作者</span></div>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-sm p-0" onclick="like(this)">
                                                <i class="fas fa-heart ct-sub-1 me-1"></i>
                                            </button>
                                            <span class="me-2 like_count">19</span>
                                            <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                                data-bs-placement="top">
                                                <button class="btn btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" onclick="del_comment(this)"
                                                            class="dropdown-item">刪除留言</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" onclick="report_comment(this)"
                                                            class="dropdown-item">檢舉留言</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3 pe-4 ct-title-1 comment_content" contenteditable="false"
                                        id="replyid_content1" style="text-align: justify">
                                        我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容
                                    </div>
                                </div>
                                <!--留言回覆 其他顯示 (有分隔線差別)-->
                                <div class="border-top my-1 pt-3" id="comment2F_reply_2F">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-end"><img class="comment-uesr-img me-2"
                                                src="static/img/user.png" /><span class="cmt_author">作者</span></div>
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-sm p-0" onclick="like(this)">
                                                <i class="fas fa-heart ct-sub-1 me-1"></i>
                                            </button>
                                            <span class="me-2 like_count">5</span>
                                            <div class="dropdown d-inline" data-bs-toggle="tooltip" data-bs-title="檢舉/刪除"
                                                data-bs-placement="top">
                                                <button class="btn btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-exclamation-circle ct-sub-1 me-1"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" onclick="del_comment(this)"
                                                            class="dropdown-item">刪除留言</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" onclick="report_comment(this)"
                                                            class="dropdown-item">檢舉留言</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3 pe-4 ct-title-1 comment_content" contenteditable="false"
                                        id="replyid_content2" style="text-align: justify">
                                        我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容我是留言內容
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--右邊文章選單-->
            <div class="col-md-4 col-lg d-flex align-items-start">
                <div class="row position-sticky" id="right-sidebar">
                    <div class="mb-3 px-0 col-12 my-auto">
                        <input type="text" class="form-control search-input rounded-pill" placeholder="&#xF52A; 搜尋文章"
                            style="font-family: 'bootstrap-icons'" />
                    </div>
                    <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                        <p class="ct-title-1 my-auto" style="font-weight: 500">熱門文章</p>
                    </div>
                    <div class="col-12">
                        <ul class="nav flex-column forum-list">
                            <li class="nav-item">
                                <a class="nav-link" href="#"> 小產了怎麼辦？調理方式與常見Q&A總整理 ，解決各類小產的疑惑 </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> 小產/流產關鍵問題－需要吃小產餐或月子餐嗎？ </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                        <p class="ct-title-1 my-auto" style="font-weight: 500">最新文章</p>
                    </div>
                    <div class="col-12">
                        <ul class="nav flex-column forum-list">
                            <li class="nav-item">
                                <a class="nav-link" href="#"> 小產了怎麼辦？調理方式與常見Q&A總整理 ，解決各類小產的疑惑 </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> 小產/流產關鍵問題－需要吃小產餐或月子餐嗎？ </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                        <p class="ct-title-1 my-auto" style="font-weight: 500">延伸文章</p>
                    </div>
                    <div class="col-12">
                        <ul class="nav flex-column forum-list">
                            <li class="nav-item">
                                <a class="nav-link" href="#"> 小產了怎麼辦？調理方式與常見Q&A總整理 ，解決各類小產的疑惑 </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> 小產/流產關鍵問題－需要吃小產餐或月子餐嗎？ </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @section('about')
        @parent

    </div>
@endsection
@endsection
