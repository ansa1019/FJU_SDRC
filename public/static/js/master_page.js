const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

// 使用 Day.js
const now_year = dayjs().year();
const now_month = dayjs().format("MM");
const now_date = dayjs().date();
const now_day = dayjs().day();
const now_today = dayjs().format("YYYY-MM-DD");

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

document.addEventListener("click", function (e) {
    let checkNotifyShow = $(e.target).parents(".notify_bell,.notifications");
    if (checkNotifyShow.length == 0) {
        $("#notifications_box").removeClass("show");
        notify_dropdown = false;
    }
});

//點選通知 打開選單
let notify_dropdown = false;
$(".notify_bell").click(function (e) {
    if (notify_dropdown) {
        $("#notifications_box").removeClass("show");
        notify_dropdown = false;
    } else {
        $("#notifications_box").addClass("show");
        notify_dropdown = true;
    }
});

$(document).ready(function () {
    sessionStorage.setItem("previousPageUrl", window.location.href);

    //頂端欄 滑動顯示下拉選單
    $("#topbar-nav-tabs > li:not(.dropstart)").mouseover(function () {
        $(this).find(".dropdown-menu").addClass("show");
    });
    $("#topbar-nav-tabs > li:not(.dropstart)").mouseout(function () {
        $(this).find(".dropdown-menu").removeClass("show");
    });

    $(".dropdown-submenu a").on("mouseover", function (e) {
        $(this).next("ul").toggleClass("show");
        e.stopPropagation();
        e.preventDefault();
    });

    $(".dropdown-submenu").on("mouseleave", function (e) {
        var submenu = $(this).find(".dropdown-menu");
        if (submenu.length > 0) {
            submenu.removeClass("show");
        }
    });

    $(".dropdown-submenu a").on("touchstart", function (e) {
        $(this).next("ul").toggleClass("show");
        e.stopPropagation();
        e.preventDefault();
    });

    if (
        $(".notify_bell:visible").position().left +
            $(".notify_bell:visible").width() / 2 +
            $("#notifications_box").width() / 2 >
        $(window).width() - 20
    ) {
        let right =
            $(window).width() -
            $(".notify_bell:visible").position().left -
            $(".notify_bell:visible").width() * 2;
        $("#notifications_box").css("right", right + "px");
    } else {
        let left =
            $(".notify_bell:visible").position().left +
            $(".notify_bell:visible").width() / 2 -
            $("#notifications_box").width() / 2;
        $("#notifications_box").css("left", left + "px");
    }
});

$(window).resize(function () {
    if (
        $(".notify_bell:visible").position().left +
            $(".notify_bell:visible").width() / 2 +
            $("#notifications_box").width() / 2 >
        $(window).width() - 20
    ) {
        let right =
            $(window).width() -
            $(".notify_bell:visible").position().left -
            $(".notify_bell:visible").width() * 2;
        $("#notifications_box").css("left", "auto");
        $("#notifications_box").css("right", right + "px");
    } else {
        let left =
            $(".notify_bell:visible").position().left +
            $(".notify_bell:visible").width() / 2 -
            $("#notifications_box").width() / 2;
        $("#notifications_box").css("left", left + "px");
        $("#notifications_box").css("right", "auto");
    }
});

//即時聊天室 close按鈕
$(".btn-card-close").on("click", function () {
    $(this).closest(".tab-vertical").fadeOut("fast");
});
/* 開啟即時聊天室 */
$("#floatButton , #chats-button").on("click", function () {
    $(".tab-vertical").show();
});
//頂端欄 暢聊咖啡廳-按鈕
$("#chats-button").on("click", function () {
    $(".tab-vertical").show();
    $("#room2-vertical-tab").tab("show");
});
//頂端欄 營養師諮詢-按鈕
$("#consult-button").on("click", function () {
    $(".tab-vertical").show();
    $("#room1-vertical-tab").tab("show");
});
