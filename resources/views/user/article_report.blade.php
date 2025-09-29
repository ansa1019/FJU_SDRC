@extends('layouts.masterpage')
@section('title', 'DNLab論壇 - DNLab 文章管理')
@section('content')
    <!-- 引用 ag-grid表格與複選套件 -->
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <script src="{{ asset('static/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}"></script>

    <script>
        $(document).ready(function() {
            // 宣告定義datepicker、multiselect套件
            $("#state_select").multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "狀態篩選 ... ",
                buttonClass: "form-select form-select-sm text-muted",
                allSelectedText: "全選",
                buttonWidth: "100%",
                onDropdownHide: function(event) {
                    set_state_filter();
                },
            });
        });

        // 表格欄位設定 field名稱再對應後端資料庫欄位修改
        @isset($articles)
            const rowData = @json($articles);
            const columnDefs = [{
                    flex: 4,
                    field: "title",
                    headerName: "標題",
                    filter: "agTextColumnFilter",
                    sortable: false,
                    cellRenderer: function(params) {
                        // 超連結文字，可放文章連結，但若太麻煩可以拿掉
                        var url = params.data.category[0]['name'].includes("聊療") ? 'TreatmentArticleGet' :
                            'knowledge_article'
                        return '<a href="/' + url + '/' + params.data.id + '" target="_blank">' + params.data
                            .title + "</a>";
                    },
                },
                {
                    flex: 2,
                    field: "author",
                    headerName: "作者",
                    filter: "agTextColumnFilter",
                    sortable: false,
                },
                {
                    flex: 1.5,
                    field: "state",
                    headerName: "狀態",
                    filter: "agTextColumnFilter",
                    sortable: false,
                    valueGetter: function(params) {
                        return params.data.is_temporary ? "草稿" : "已發布"
                    }
                },
                {
                    flex: 2,
                    headerName: "文章分類",
                    filter: "agTextColumnFilter",
                    sortable: false,
                    valueGetter: function(params) {
                        return params.data.category[0]['name']
                    }
                },
                {
                    flex: 3,
                    field: "created_at",
                    headerName: "發布/修改時間",
                    filter: "agTextColumnFilter",
                    sort: "desc"
                },
                {
                    flex: 1.5,
                    headerName: "瀏覽次數",
                    filter: "agTextColumnFilter",
                    valueGetter: function(params) {
                        return params.data.click['count']
                    }
                },
                {
                    flex: 1.5,
                    headerName: "互動次數",
                    filter: "agTextColumnFilter",
                    valueGetter: function(params) {
                        return params.data.like['count'] + params.data.comments.length + params.data.share[
                            'count'] + params.data.bookmark['count']
                    }
                },
                {
                    flex: 1.5,
                    headerName: "使用者數量",
                    filter: "agTextColumnFilter",
                    valueGetter: function(params) {
                        return params.data.users['count']
                    }
                },
                {
                    flex: 2,
                    headerName: "平均閱讀時間",
                    filter: "agTextColumnFilter",
                    valueGetter: function(params) {
                        return params.data.time
                    }
                },

            ];
        @endisset

        let gridApi;
        const gridOptions = {
            columnDefs: columnDefs,
            rowData: rowData, //後端撈取資料回傳
            domLayout: "autoHeight",
            defaultColDef: {
                sortable: true,
                filter: false,
                resizable: true,
                wrapHeaderText: true
            },
            pagination: true,
            paginationPageSize: 20,
            // paginationAutoPageSize: true,
            singleClickEdit: true,
            // onCellEditingStopped: function(event) {
            //     if (event.oldValue != event.newValue) {
            //         var token = $("#jwt_token").text();
            //         const apiIP = document.getElementById("app").getAttribute("data-api-ip");
            //         var myHeaders = new Headers();
            //         myHeaders.append("Authorization", "Bearer " + token);

            //         var formdata = new FormData();
            //         console.log(stat[event.data.status])
            //         formdata.append("status", stat[event.data.status]);
            //         var requestOptions = {
            //             method: "PATCH",
            //             headers: myHeaders,
            //             body: formdata,
            //         };
            //         fetch(
            //             apiIP + "api/blacklist/blacklist/" + event.data.id + "/",
            //             requestOptions
            //         ).then((response) => {
            //             if (response.ok) {
            //                 Swal.fire({
            //                     position: "center",
            //                     icon: "success",
            //                     title: "修改成功!",
            //                     showConfirmButton: false,
            //                     timer: 1500,
            //                 });
            //             } else {
            //                 Swal.fire({
            //                     position: "center",
            //                     icon: "error",
            //                     title: "修改失敗!",
            //                     showConfirmButton: false,
            //                     timer: 1500,
            //                 });
            //             }
            //         });
            //     }
            // }
        };

        document.addEventListener("DOMContentLoaded", () => {
            const gridDiv = document.querySelector("#myGrid");
            gridApi = agGrid.createGrid(gridDiv, gridOptions); //渲染table
        });

        //表格綜合查詢
        function onFilterTextBoxChanged() {
            gridApi.setGridOption("quickFilterText", document.getElementById("filter-text-box").value);
        }

        //狀態篩選，根據figma資料提供有三種狀態:[草稿, 已發布, 已排定發布]
        function set_state_filter() {
            var select_items = $("#state_select").val();
            var filters = select_items.map(function(item) {
                return {
                    type: "contain",
                    filter: item,
                };
            });
            //最多只能設兩個條件 等同於只能篩選兩個類別的值(套件限制)
            if (filters.length < 3) {
                gridApi
                    .setColumnFilterModel("state", {
                        conditions: filters,
                        operator: "OR",
                    })
                    .then(() => {
                        gridApi.onFilterChanged();
                    });
            } else gridApi.setFilterModel(null);
        }
    </script>
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <div class="row mt-2 d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>文章管理 -
                        {{ $category == 'knowledge' ? '知識圖書館' : '療心室' }}</h2>
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <!-- 整體洞察報告UI -->
            <div class="col-12 mt-4">
                <div class="row my-1">
                    <div class="col-auto d-flex align-items-center ps-0">
                        <span class="me-2"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control form-control-sm" id="filter-text-box"
                            placeholder="標題搜尋 ..." oninput="onFilterTextBoxChanged()" />
                    </div>
                    <div class="col-auto d-flex align-items-center ps-0">
                        <span class="me-1"><i class="fas fa-filter"></i></span>
                        <select class="form-select form-select-sm" id="state_select" multiple="multiple">
                            <option value="草稿">草稿</option>
                            <option value="已發布">已發布</option>
                        </select>
                    </div>
                </div>
                <div id="myGrid" style="width: 100%" class="ag-theme-alpine">
                </div>
                <p class="text-center mb-0 m-100">資料更新時間：{{ $update_time }}</p>
            </div>
        </div>
    </div>
@endsection
