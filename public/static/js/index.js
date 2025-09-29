$(document).ready(function () {
    $('.datepicker').datepicker('setDates',current);
    $("#card-date").text(dayjs().format("D"));
    $("#card-yearmon").text(dayjs().format("YYYY.M"));
    $("#card-day").text(dayjs().locale('zh-tw').format("dddd"));
});

$(".datepicker").datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayHighlight: true,
    language: "zh-TW",
});

const goTop = document.getElementById("goTopButton");
const article_class = document.getElementById("article_class");
// goTop.style.display = "none";
window.onscroll = function () {
    let nowheight = document.documentElement.scrollTop || document.body.scrollTop;
    //滾動條位置
    if (nowheight >= 300) {
        $(goTop).fadeIn(); //顯示按钮
        $(article_class).scrollTop(nowheight * 1.2);
    } else {
        $(goTop).fadeOut(); //隐藏按钮
    }
};

// goTop.onclick = function () {
//     $("html, body").animate({ scrollTop: 0 }, "fast");
// };
