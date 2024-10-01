@extends('layouts.masterpage')
@section('title', '莎莉聊療吧 - 優德莎莉 檢舉管理')
@section('content')
    <!-- 引用 ag-grid表格與複選套件 -->
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <script src="{{ asset('static/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}"></script>

    <script>
        var stat = @json($status);
        $(document).ready(function() {
            // 宣告定義datepicker、multiselect套件
            $("#category_select").multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "類別篩選 ... ",
                buttonClass: "form-select form-select-sm text-muted",
                allSelectedText: "全選",
                buttonWidth: "100%",
                onDropdownHide: function(event) {
                    set_category_filter();
                },
            });
            $("#status_select").multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "處理方式篩選 ... ",
                buttonClass: "form-select form-select-sm text-muted",
                allSelectedText: "全選",
                buttonWidth: "100%",
                onDropdownHide: function(event) {
                    set_status_filter();
                },
            });
        });

        // 表格欄位設定 field名稱再對應後端資料庫欄位修改
        @isset($blacklists)
            const rowData = @json($blacklists);
            const columnDefs = [{
                    flex: 1,
                    field: "id",
                    headerName: "#",
                    sortable: false,
                }, {
                    flex: 2,
                    field: "category",
                    headerName: "類別",
                    filter: "agSetColumnFilter",
                    cellEditor: 'agSelectCellEditor',
                    cellEditorParams: {
                        values: ["文章", "留言", "聊天室"],
                    },
                }, {
                    flex: 5,
                    field: "content",
                    headerName: "檢舉內容",
                    filter: "agTextColumnFilter",
                    sortable: false,
                    cellRenderer: function(params) {
                        // 超連結文字，可放文章連結，但若太麻煩可以拿掉
                        if (params.data.category != "聊天室") {
                            return '<a href="/' + params.data.url + '" target="_blank">' + params.data.content +
                                "</a>";
                            // 聊天室要open modal...先掰
                        } else {
                            return params.value
                            //     return '<a href="' + window.location.href + params.data.url + '" target="_blank">' +
                            //         params.data.content + "</a>";
                        }
                    },
                },
                {
                    flex: 3,
                    field: "user",
                    headerName: "檢舉帳號",
                    filter: "agTextColumnFilter",
                    sortable: false,
                },
                {
                    flex: 3,
                    field: "blacklist",
                    headerName: "被檢舉帳號",
                    filter: "agTextColumnFilter",
                    sortable: false
                },
                {
                    flex: 5,
                    field: "reason",
                    headerName: "檢舉原因",
                    filter: "agTextColumnFilter",
                    sortable: false
                },
                {
                    flex: 4,
                    field: "created_at",
                    headerName: "檢舉時間"
                },
                {
                    flex: 2.5,
                    field: "status",
                    headerName: "處理方式",
                    editable: true,
                    filter: "agSetColumnFilter",
                    cellEditor: 'agSelectCellEditor',
                    cellEditorParams: {
                        values: Object.keys(stat),
                    },
                }
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
            onCellEditingStopped: function(event) {
                if (event.oldValue != event.newValue) {
                    var token = $("#jwt_token").text();
                    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
                    var myHeaders = new Headers();
                    myHeaders.append("Authorization", "Bearer " + token);

                    var formdata = new FormData();
                    console.log(stat[event.data.status])
                    formdata.append("status", stat[event.data.status]);
                    var requestOptions = {
                        method: "PATCH",
                        headers: myHeaders,
                        body: formdata,
                    };
                    fetch(
                        apiIP + "api/blacklist/blacklist/" + event.data.id + "/",
                        requestOptions
                    ).then((response) => {
                        if (response.ok) {
                            var status_notify = ["禁言15天", "永久禁言", "停用帳號"]
                            if (status_notify.includes(event.data.status)) {
                                var category = (event.data.category == "聊天室") ? "訊息" : event.data.category
                                var formdata2 = new FormData();
                                formdata2.append("blacklist", event.data.id);
                                formdata2.append(
                                    "content",
                                    "因您於 " + event.data.created_at + " 發布的" + category + "『" + event
                                    .data
                                    .content + "』被人檢舉 " + event.data.reason +
                                    "! 此帳號將進行『" + event.data
                                    .status + "』的處置。如有疑慮，請洽客服。"
                                );
                                var requestOptions2 = {
                                    method: "POST",
                                    headers: myHeaders,
                                    body: formdata2,
                                    redirect: "follow",
                                };

                                fetch(
                                    apiIP + "api/notifications/notifications/",
                                    requestOptions2
                                );
                            }
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "修改成功!",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        } else {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "修改失敗!",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        }
                    });
                }
            }
        };

        document.addEventListener("DOMContentLoaded", () => {
            const gridDiv = document.querySelector("#myGrid");
            gridApi = agGrid.createGrid(gridDiv, gridOptions); //渲染table
        });

        //表格綜合查詢
        function onFilterTextBoxChanged() {
            gridApi.setGridOption("quickFilterText", document.getElementById("filter-text-box").value);
        }

        function set_category_filter() {
            var select_items = $("#category_select").val();
            console.log(select_items)
            var filters = select_items.map(function(item) {
                return {
                    type: "contain",
                    filter: item,
                };
            });
            //最多只能設兩個條件 等同於只能篩選兩個類別的值(套件限制)
            if (filters.length < 3) {
                gridApi
                    .setColumnFilterModel("category", {
                        conditions: filters,
                        operator: "OR",
                    })
                    .then(() => {
                        gridApi.onFilterChanged();
                    });
            } else gridApi.setFilterModel(null);
        }

        function set_status_filter() {
            var select_items = $("#status_select").val();
            var filters = select_items.map(function(item) {
                return {
                    type: "contain",
                    filter: item,
                };
            });
            //最多只能設兩個條件 等同於只能篩選兩個類別的值(套件限制)
            if (filters.length < 3) {
                gridApi
                    .setColumnFilterModel("status", {
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
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>檢舉管理</h2>
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
                            placeholder="{{ isset($chats) ? '聊天室' : '文章' }}搜尋 ..." oninput="onFilterTextBoxChanged()" />
                    </div>
                    <div class="col-auto d-flex align-items-center ps-0">
                        <span class="me-1"><i class="fas fa-filter"></i></span>
                        <select class="form-select form-select-sm" id="category_select" multiple="multiple">
                            <option value="文章">文章</option>
                            <option value="留言">留言</option>
                            <option value="聊天室">聊天室</option>
                        </select>
                    </div>
                    <div class="col-auto d-flex align-items-center ps-0">
                        <span class="me-1"><i class="fas fa-filter"></i></span>
                        <select class="form-select form-select-sm" id="status_select" multiple="multiple">
                            @foreach ($status as $key => $value)
                                <option value="{{ $key }}">{{ $key }}</option>
                            @endforeach
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
