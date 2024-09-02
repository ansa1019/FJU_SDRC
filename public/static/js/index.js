$(document).ready(function () {
    $('.datepicker').datepicker('setDates',current);
    $("#card-date").text(dayjs().format("D"));
    $("#card-yearmon").text(dayjs().format("YYYY.M"));
    $("#card-day").text(dayjs().locale('zh-tw').format("dddd"));
    // 監聽所有具有相關屬性的單選按鈕的變更事件
    $(
        "input[name='has_mc_type'], input[name='has_loc_type'], input[name='has_blood_type'], input[name='has_loc_type1']"
    ).on("change", function () {
        console.log("change");
        var isChecked = $(this).prop("checked") && $(this).val() === "沒有";
        // 判斷是否要禁用或啟用輸入欄位
        $(
            "input[name='mc_amount'], input[name='pain_level'], input[name='loc_amount'], input[name='loc_color'], input[name='blood_amount'], input[name='blood_color'], input[name='loc_amount4'], input[name='loc_color4']"
        ).prop("disabled", isChecked);
    });
    $('#daily_form').submit(calendarValidate);
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
