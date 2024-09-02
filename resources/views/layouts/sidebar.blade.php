@if ($sidebar == 'knowledge')
    <!--右邊欄選單-->
    <div class="col-md-4 col-lg d-flex align-items-start">
        <div class="row position-sticky" id="right-sidebar">
            <div class="mb-3 px-0 col-12 my-auto">
                <input type="text" class="form-control rounded-pill search-input" placeholder="搜尋文章"
                    style="font-family: YourFont', sans-serif" onkeydown="searchArticle(event)" />
            </div>
            <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                <p class="ct-title-1 my-auto" style="font-weight: 500">文章類別</p>
            </div>
            <div class="col-12 px-0">
                <ul class="nav flex-column" id="article_class_list">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-1">小產調理<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse {{ $category == '小產調理' ? 'show' : '' }}" id="sub-class-1">
                            <a class="dropdown-item {{ $subcategory == '小產知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '小產調理', 'subcategory' => '小產知識']) }}">小產知識</a>
                            <a class="dropdown-item {{ $subcategory == '小產調理知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '小產調理', 'subcategory' => '小產調理知識']) }}">小產調理知識</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-2">婦科保健<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse {{ $category == '婦科保健' ? 'show' : '' }}" id="sub-class-2">
                            <a class="dropdown-item {{ $subcategory == '婦科保健知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '婦科保健', 'subcategory' => '婦科保健知識']) }}">婦科保健知識</a>
                            <a class="dropdown-item {{ $subcategory == '婦科保健調理知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '婦科保健', 'subcategory' => '婦科保健調理知識']) }}">婦科保健調理知識</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-3">備孕調理<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse {{ $category == '備孕調理' ? 'show' : '' }}" id="sub-class-3">
                            <a class="dropdown-item {{ $subcategory == '備孕知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '備孕調理', 'subcategory' => '備孕知識']) }}">備孕知識</a>
                            <a class="dropdown-item {{ $subcategory == '備孕調理知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '備孕調理', 'subcategory' => '備孕調理知識']) }}">備孕調理知識</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-4">懷孕知識<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse {{ $category == '懷孕知識' ? 'show' : '' }}" id="sub-class-4">
                            <a class="dropdown-item {{ $subcategory == '懷孕知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '懷孕知識', 'subcategory' => '懷孕知識']) }}">懷孕知識</a>
                            <a class="dropdown-item {{ $subcategory == '懷孕調理知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '懷孕知識', 'subcategory' => '懷孕調理知識']) }}">懷孕調理知識</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-5">日常保健<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse {{ $category == '日常保健' ? 'show' : '' }}" id="sub-class-5">
                            <a class="dropdown-item {{ $subcategory == '日常保健知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '日常保健', 'subcategory' => '日常保健知識']) }}">日常保健知識</a>
                            <a class="dropdown-item {{ $subcategory == '日常保健調理知識' ? 'active' : '' }}"
                                href="{{ route('knowledge_library', ['category' => '日常保健', 'subcategory' => '日常保健調理知識']) }}">日常保健調理知識</a>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if ($sidebar == 'treatment')
    <!--右邊欄選單-->
    <div class="col-md-4 col-lg d-flex align-items-start">
        <div class="row position-sticky" id="right-sidebar">
            <div class="mb-3 px-0 col-12 my-auto">
                <input type="text" class="form-control rounded-pill search-input" placeholder="搜尋文章"
                    style="font-family: YourFont', sans-serif" onkeydown="searchArticle(event)" />
            </div>
            <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                <p class="ct-title-1 my-auto" style="font-weight: 500">聊療類別</p>
            </div>
            <div class="col-12 px-0">
                <ul class="nav flex-column" id="treat_class_list">
                    <li class="nav-item">
                        <a class="nav-link {{ $category == '聊療小產' ? 'active' : '' }}"
                            href="{{ route('treatment_qa', ['article' => '聊療小產']) }}">聊療小產</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $category == '聊療婦科保健' ? 'active' : '' }}"
                            href="{{ route('treatment_qa', ['article' => '聊療婦科保健']) }}">聊療婦科保健</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $category == '聊療備孕' ? 'active' : '' }}"
                            href="{{ route('treatment_qa', ['article' => '聊療備孕']) }}">聊療備孕</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $category == '聊療懷孕' ? 'active' : '' }}"
                            href="{{ route('treatment_qa', ['article' => '聊療懷孕']) }}">聊療懷孕</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $category == '聊療日常保健' ? 'active' : '' }}"
                            href="{{ route('treatment_qa', ['article' => '聊療日常保健']) }}">聊療日常保健</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if ($sidebar == 'user')
    <!--右邊欄選單-->
    <div class="col-md-4 col-lg d-flex align-items-start">
        <div class="row position-sticky" id="right-sidebar">
            <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                <p class="ct-title-1 my-auto" style="font-weight: 500">個人資料</p>
            </div>
            <div class="col-12 px-0">
                <ul class="nav flex-column" id="info_class_list">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-1">會員資料<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse show" id="sub-class-1">
                            <a class="dropdown-item {{ $title == 'user' ? 'active' : '' }}"
                                href="{{ route('user_info') }}">會員資料</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $title == 'calendar' ? 'active' : '' }}"
                            href="{{ route('CalendarIndex') }}">專屬月曆</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-2">點數錢包<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse {{ $title == 'point' ? 'show' : '' }}" id="sub-class-2">
                            <a class="dropdown-item {{ $web_name == 'point_task' ? 'active' : '' }}"
                                href="{{ route('point_task') }}">任務專區</a>
                            <a class="dropdown-item {{ $web_name == 'point_exchange' ? 'active' : '' }}"
                                href="{{ route('point_exchange') }}">點數兌換</a>
                            <a class="dropdown-item {{ $web_name == 'point_gift1' ? 'active' : '' }}"
                                href="{{ route('point_gift1') }}">點數轉贈</a>
                            <a class="dropdown-item {{ $web_name == 'point_get_record' ? 'active' : '' }}"
                                href="{{ route('point_get_record') }}">點數獲得紀錄</a>
                            <a class="dropdown-item {{ $web_name == 'point_use_record' ? 'active' : '' }}"
                                href="{{ route('point_use_record') }}">點數使用紀錄</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $title == 'my_mind' ? 'active' : '' }}"
                            href="{{ route('my_mind') }}">我的心事</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sub-class-3">收藏與追蹤<i
                                class="fas fa-angle-down ms-2"></i></a>
                        <ul class="collapse {{ $title == 'article' ? 'show' : '' }}" id="sub-class-3">
                            <a class="dropdown-item {{ $web_name == 'article_saved_list' ? 'active' : '' }}"
                                href="{{ route('article_saved_list') }}">文章收藏</a>
                            <a class="dropdown-item {{ $web_name == 'author_saved' ? 'active' : '' }}"
                                href="{{ route('author_saved') }}">作者收藏</a>
                            <a class="dropdown-item {{ $web_name == 'topic_saved' ? 'active' : '' }}"
                                href="{{ route('topic_saved') }}">話題收藏</a>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if ($sidebar[0] == 'article')
    <!--右邊文章選單-->
    <div class="col-md-4 col-lg d-flex align-items-start">
        <div class="row position-sticky" id="right-sidebar">
            <div class="mb-3 px-0 col-12 my-auto">
                <input type="text" class="form-control rounded-pill search-input" placeholder="&#xF52A; 搜尋文章"
                    style="font-family: 'bootstrap-icons'" />
            </div>
            <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                <p class="ct-title-1 my-auto" style="font-weight: 500">熱門文章</p>
            </div>
            <div class="col-12">
                <ul class="nav flex-column forum-list">
                    @foreach ($popular_articles as $article)
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route($sidebar[1], ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                <p class="ct-title-1 my-auto" style="font-weight: 500">最新文章</p>
            </div>
            <div class="col-12">
                <ul class="nav flex-column forum-list">
                    @foreach ($latest_articles as $article)
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route($sidebar[1], ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-12 ct-bg-3 ps-2 p-1 rounded">
                <p class="ct-title-1 my-auto" style="font-weight: 500">延伸文章</p>
            </div>
            <div class="col-12">
                <ul class="nav flex-column forum-list">
                    @foreach ($extend_articles as $article)
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('knowledge_article', ['id' => $article['id']]) }}">{{ $article['title'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
