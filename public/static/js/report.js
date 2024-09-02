$(document).ready(function () {
    // 宣告定義datepicker、multiselect套件
    $("#state_select").multiselect({
        includeSelectAllOption: true,
        nonSelectedText: "狀態篩選 ... ",
        buttonClass: "form-select form-select-sm text-muted",
        allSelectedText: "全選",
        buttonWidth: "100%",
        onDropdownHide: function (event) {
            set_state_filter();
        },
    });
});

let random_data = [];
let gridApi;

for (var i = 0; i < 150; i++) {
    var title = "標題" + (i + 1);
    var state = Math.random() < 0.33 ? "草稿" : Math.random() < 0.5 ? "已排定發布" : "已發布";
    var classValue = "分類" + Math.floor(Math.random() * 10);
    var time = "2023/11/13 09:15:53"; // 假設所有時間都相同
    var viewCount = Math.floor(Math.random() * 1000);
    var clickCount = Math.floor(Math.random() * 1000);
    var usersCount = Math.floor(Math.random() * 1000);
    var viewAvgTimeMinutes = Math.floor(Math.random() * 10);
    var viewAvgTimeSeconds = Math.floor(Math.random() * 60);
    var viewAvgTime = viewAvgTimeMinutes + "分" + viewAvgTimeSeconds + "秒";

    random_data.push({
        title: title,
        state: state,
        class: classValue,
        time: time,
        view_count: viewCount,
        click_count: clickCount,
        users_count: usersCount,
        view_avg_time: viewAvgTime,
    });
}

// 表格欄位設定 field名稱再對應後端資料庫欄位修改
const columnDefs = [
    {
        flex: 4,
        field: "title",
        headerName: "文章標題",
        filter: "agTextColumnFilter",
        sortable: false,
        cellRenderer: function (params) {
            // 超連結文字，可放文章連結，但若太麻煩可以拿掉
            return '<a href="https://www.google.com" target="_blank">' + params.value + "</a>";
        },
    },
    {
        flex: 2,
        field: "state",
        headerName: "狀態",
        filter: "agTextColumnFilter",
        sortable: false,
    },
    { flex: 2, field: "class", headerName: "文章分類", filter: "agTextColumnFilter", sortable: false },
    { flex: 3, field: "time", headerName: "發布/修改時間" },
    { flex: 2, field: "view_count", headerName: "文章瀏覽次數" },
    { flex: 2, field: "click_count", headerName: "文章互動次數" },
    { flex: 2, field: "users_count", headerName: "使用者數量" },
    { flex: 2, field: "view_avg_time", headerName: "平均閱讀時間" },
];

// 資料sample
const rowData = [
    {
        title: "<a href='https://www.google.com' target='_blank'>1婦產保健知識:你知道sample................</a>",
        state: "草稿",
        class: "聊療婦女保健",
        time: "2023/11/13 14:23:40",
        view_count: 256,
        click_count: 256,
        users_count: 341,
        view_avg_time: "3分01秒",
    },
    {
        title: "2小產保健知識:你知道...",
        state: "已發布",
        class: "聊療婦女保健",
        time: "2023/11/21 14:23:40",
        view_count: 134,
        click_count: 33,
        users_count: 76,
        view_avg_time: "6分10秒",
    },
    {
        title: "3生理期保健知識:你知道...",
        state: "已發布",
        class: "聊療婦女保健",
        time: "2023/11/13 09:15:53",
        view_count: 256,
        click_count: 256,
        users_count: 341,
        view_avg_time: "7分11秒",
    },
    {
        title: "自由爆新聞》怕了? 藍擋無赦封殺傅崐萁條款網酸他直奔祖國為這件事(中國團客/地震- 自由電子報影音頻道",
        state: "已發布",
        class: "聊療婦女保健",
        time: "2023/11/13 09:15:53",
        view_count: 256,
        click_count: 256,
        users_count: 341,
        view_avg_time: "7分20秒",
    },
    {
        title: "加強對外宣傳 中馬媒體簽訂新聞合作協議",
        state: "已發布",
        class: "聊療婦女保健",
        time: "2023/11/13 09:15:53",
        view_count: 256,
        click_count: 256,
        users_count: 341,
        view_avg_time: "7分10秒",
    },
    {
        title: "4生理期保健知識:你知道...",
        state: "已排定發布",
        class: "聊療婦女保健",
        time: "2023/11/13 09:15:53",
        view_count: 256,
        click_count: 256,
        users_count: 341,
        view_avg_time: "4分10秒",
    },
    {
        title: "花蓮6.3地震「只是剛開始」 氣象署：規模4以上餘震恐持續1年",
        state: "已發布",
        class: "聊療婦女保健",
        time: "2023/11/13 09:15:53",
        view_count: 256,
        click_count: 256,
        users_count: 341,
        view_avg_time: "5分30秒",
    },
];

const gridOptions = {
    columnDefs: columnDefs,
    rowData: random_data, //後端撈取資料回傳
    domLayout: "autoHeight",
    onGridReady: function () {
        gridOptions.api.sizeColumnsToFit(); //調整表格大小自適應
    },
    defaultColDef: {
        sortable: true,
        filter: false,
        resizable: true,
    },
    pagination: true,
    paginationPageSize: 10,
    // paginationAutoPageSize: true,
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
    var filters = select_items.map(function (item) {
        return {
            type: "contain",
            filter: item,
        };
    });
    //最多只能設兩個條件 等同於只能篩選兩個類別的值(套件限制)
    if (filters.length !== 3) {
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
