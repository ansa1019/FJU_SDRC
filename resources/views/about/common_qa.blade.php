@extends('layouts.masterpage')

@section('content')
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">常見問題</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>常見問題</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 px-1 ps-md-1 pe-md-4">
                <div class="row mt-4 tab-content" id="qa_list">
                    <!--根據問答類別 填入類別標題名稱(ex:知識圖書館、療心事/暢聊咖啡廳)-->
                    <div class="col-12 tab-pane fade show active" id="class_1">
                        <h4 class="fw-bold">知識圖書館、療心事</h4>
                        <!-- 問題1 -->
                        <div class="py-1">
                            <p class="my-2">
                                <!-- 帶入問題 以及 根據問題ID 修改a href的id -->
                                <a href="#qa_class1_id1" class="text-dark text-decoration-none" data-bs-toggle="collapse"> <i class="fas fa-caret-down me-2 ct-txt-2"></i>如何發文？ </a>
                            </p>
                            <!-- 帶入問題1答案(文字&圖片) & 問題ID -->
                            <div class="collapse" id="qa_class1_id1">
                                Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                <img src="https://placehold.co/500x200" />
                            </div>
                        </div>
                        <!-- 問題2 以下以此類推-->
                        <div class="border-top py-1">
                            <p class="my-2">
                                <a href="#qa_class1_id2" class="text-dark text-decoration-none" data-bs-toggle="collapse"> <i class="fas fa-caret-down me-2 ct-txt-2"></i>如何匿名？ </a>
                            </p>
                            <div class="collapse" id="qa_class1_id2">我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案</div>
                        </div>
                    </div>
                    <!--問題類別種類2 內容資料同上概念-->
                    <div class="col-12 tab-pane fade" id="class_2">
                        <h4 class="fw-bold">暢聊咖啡廳</h4>
                        <div class="py-1">
                            <p class="my-2">
                                <a class="text-dark text-decoration-none" data-bs-toggle="collapse" href="#qa_class2_id1">
                                    <i class="fas fa-caret-down me-2 ct-txt-2"></i>什麼時候可以使用暢聊咖啡廳?
                                </a>
                            </p>
                            <div class="collapse" id="qa_class2_id1">
                                Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                <img src="https://placehold.co/500x200" />
                            </div>
                        </div>
                        <div class="border-top py-1">
                            <p class="my-2">
                                <a class="text-dark text-decoration-none" data-bs-toggle="collapse" href="#qa_class2_id2">
                                    <i class="fas fa-caret-down me-2 ct-txt-2"></i>為什麼暢聊咖啡廳要限時?</a
                                >
                            </p>
                            <div class="collapse" id="qa_class2_id2">我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案我是答案</div>
                        </div>
                    </div>
                    <div class="col-12 tab-pane fade" id="class_3">
                        <h4 class="fw-bold">營養師諮詢</h4>
                    </div>
                    <div class="col-12 tab-pane fade" id="class_4">
                        <h4 class="fw-bold">會員資料</h4>
                    </div>
                    <div class="col-12 tab-pane fade" id="class_5">
                        <h4 class="fw-bold">點數錢包</h4>
                    </div>
                    <div class="col-12 tab-pane fade" id="class_6">
                        <h4 class="fw-bold">其他</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection