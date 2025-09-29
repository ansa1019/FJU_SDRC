<script>
    var postStorageds = {!! json_encode($postStorageds) !!}
</script>
<!-- 建立書籤資料夾 Modal -->
@if ($jwt_token != '')
    <div class="modal fade" id="bookmark_collect" tabindex="-1" data-bs-focus="false" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <input type="hidden" id="return_content" name="content">
                <input type="hidden" id="return_html" name="html">
                <div class="modal-header border-bottom-0">
                    <h4 class="modal-title ct-txt-2 fw-bold"><i class="fa fa-folder fa-sm"></i> 文章收藏夾
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: var(--fs-18);">
                    <input type="hidden" id="post_id">
                    <div class="content p-3" id="article_collection_list">
                        <div class="row d-flex justify-content-center pb-2">
                            <div id="postStoraged_不分類收藏" class="col-auto text-center mb-3 postStoraged">
                                <!--分類圖片-->
                                <img src="{{ $postStorageds[0]['image'] ? $postStorageds[0]['image'] : asset('static/img/img_' . rand(1, 4) . '.png') }}"
                                    class="rounded mx-auto d-block" alt="不分類收藏" />
                                <!--分類名稱-->
                                <div class="row">
                                    <p class="col-auto ms-1 m-auto saved-title ps-0">不分類收藏</p>
                                    <button class="col-2 btn plus-btn float-end m-0 p-0"><i
                                            class="fas fa-plus ct-txt-2 p-1"
                                            onclick="article_saved('{{ $postStorageds[0]['id'] }}','不分類收藏')"></i></button>
                                </div>
                            </div>
                            <!--"新建分類" -->
                            <div class="col-auto text-center mb-3">
                                <!--點選"新建分類"可創建-->
                                <a id="add_saved_btn" style="cursor: pointer">
                                    <img src="https://placehold.jp/45/70c6e3/ffffff/180x130.png?text=%EF%BC%8B"
                                        class="rounded mx-auto d-block" alt="新增收藏分類" />
                                    <p class="saved-title text-start p-1 pt-2">新增收藏分類</p>
                                </a>
                            </div>
                        </div>

                        @if (count($postStorageds) > 1)
                            <div class="row d-flex justify-content-center mt-3 border-top" id="postStorageds">
                                <h1 class="fs-5 text-center">收藏分類</h1>
                                <!-- for loop 收藏分類-->
                                @foreach ($postStorageds as $postStoraged)
                                    @if ($postStoraged['storage_name'] != '不分類收藏')
                                        <div id="postStoraged_{{ $postStoraged['storage_name'] }}"
                                            class="col-auto text-center mb-3 postStoraged">
                                            <!--分類圖片-->
                                            {{-- <img src="{{ $postStorageds[0]['image'] ? $postStorageds[0]['image'] : asset('static/img/img_' . rand(1, 4) . '.png') }}"
                                                class="rounded mx-auto d-block" alt="不分類收藏" /> --}}
                                            <img src="{{ $postStoraged['image'] }}" class="rounded mx-auto d-block"
                                                alt="{{ $postStoraged['storage_name'] }}" />
                                            <!--分類名稱-->
                                            <div class="row">
                                                <p class="col-auto ms-1 saved-title ps-0">
                                                    {{ $postStoraged['storage_name'] }}
                                                </p>
                                                <button class="col-2 btn plus-btn float-end m-0 p-0"><i
                                                        class="fas fa-plus ct-txt-2 p-1"
                                                        onclick="article_saved('{{ $postStoraged['id'] }}','{{ $postStoraged['storage_name'] }}')"></i></button>
                                                <div class="edit_storage dropdown d-inline" data-bs-toggle="tooltip"
                                                    data-bs-title="編輯" data-bs-placement="top">
                                                    <button class="btn btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-pencil-alt ct-sub-1 me-1"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item rename_btn"
                                                                onclick="storaged_rename('{{ $postStoraged['id'] }}','{{ $postStoraged['storage_name'] }}')">修改分類</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item del_btn"
                                                                onclick="storaged_delete('{{ $postStoraged['id'] }}','{{ $postStoraged['storage_name'] }}')">刪除分類</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
