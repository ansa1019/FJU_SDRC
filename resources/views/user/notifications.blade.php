@extends('layouts.masterpage')
@section('title', '優德莎莉')
@section('content')
    <!-- 引用 ag-grid表格與複選套件 -->
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
    <script src="{{ asset('static/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}"></script>

    <script>
        $(document).ready(function() {
            // 宣告定義datepicker、multiselect套件
            $("#status_select").multiselect({
                includeSelectAllOption: true,
                nonSelectedText: "狀態篩選 ... ",
                buttonClass: "form-select form-select-sm text-muted",
                allSelectedText: "全選",
                buttonWidth: "100%",
                onDropdownHide: function(event) {
                    set_status_filter();
                },
            });
        });

        // 表格欄位設定 field名稱再對應後端資料庫欄位修改
        @isset($notifications)
            const rowData = @json($notifications);
            console.log(rowData);
            const columnDefs = [{
                flex: 1,
                field: "id",
                headerName: "#",
                sortable: false,
            }, {
                flex: 5,
                field: "content",
                headerName: "通知內容",
                filter: "agTextColumnFilter",
                cellRenderer: function(params) {
                    // 超連結文字，可放文章連結，但若太麻煩可以拿掉
                    if (!params.data.url) {
                        return '<p>' + params.data.content +
                            "</p>";
                    } else {
                        return '<a href="' + params.data.url + '" target="_blank">' + params.data.content +
                            "</a>";
                    }
                },
            }, {
                flex: 2.5,
                field: "read",
                headerName: "讀取狀態",
                filter: "agSetColumnFilter",
                cellDataType: "text",
                sort: "asc",
                valueFormatter: params => params.value ?
                    '已讀' : '未讀',
            }, {
                flex: 4,
                field: "created_at",
                sort: "desc",
                headerName: "通知時間"
            }];
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
        };

        document.addEventListener("DOMContentLoaded", () => {
            const gridDiv = document.querySelector("#myGrid");
            gridApi = agGrid.createGrid(gridDiv, gridOptions); //渲染table
        });

        //表格綜合查詢
        function onFilterTextBoxChanged() {
            gridApi.setGridOption("quickFilterText", document.getElementById("filter-text-box").value);
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
                    .setColumnFilterModel("read", {
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
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>通知列表</h2>
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
                            placeholder="通知搜尋 ..." oninput="onFilterTextBoxChanged()" />
                    </div>
                    <div class="col-auto d-flex align-items-center ps-0">
                        <span class="me-1"><i class="fas fa-filter"></i></span>
                        <select class="form-select form-select-sm" id="status_select" multiple="multiple">
                            <option value="false">未讀</option>
                            <option value="true">已讀</option>
                        </select>
                    </div>
                </div>
                <div id="myGrid" style="width: 100%" class="ag-theme-alpine">
                </div>
                <p class="text-center mb-0 m-100">通知更新時間：{{ $update_time }}</p>
            </div>
        </div>
    </div>
@endsection
