var menstruationSymptoms = [
    "menstrualPeriodHeadache",
    "backache",
    "hecticFever",
    "breastTenderness",
    "OvulationPain",
    "menstrualPeriodConstipate",
    "diarrhea",
    "increasedSecretions",
    "spottingHemorrhage",
    "menstrualPeriodOther",
];
var miscarriagePeriodSymptoms = [
    "miscarriagePeriodContractions",
    "miscarriagePeriodBackache",
    "largeBloodClots",
    "fever",
    "nausea",
    "vomit",
    "dizziness",
    "chestPain",
    "miscarriagePeriodOther",
];
var pregnancySymptoms = [
    "vaginalBleeding",
    "backPain",
    "pregnancyChestPain",
    "lowerAbdominalPain",
    "pregnancyNausea",
    "pregnancyVomit",
    "pregnancyDizziness",
    "pregnancyConstipate",
    "pregnancyFrequentUrination",
    "upsetStomach",
    "pregnancyIndigestion",
    "pregnancyOther",
];
var postpartumSymptoms = [
    "postpartumPeriodContractions",
    "postpartumPeriodBackache",
    "postpartumPeriodLargeBloodClots",
    "lossOfAppetite",
    "postpartumPeriodIndigestion",
    "postpartumPeriodConstipate",
    "itching",
    "postpartumPeriodChestPain",
    "postpartumPeriodOther",
];
var menopauseSymptoms = [
    "menopause",
    "hotFlashes",
    "nightSweats",
    "coldHandsAndFeet",
    "difficultyFallingAsleep",
    "vaginalDryness",
    "vaginalItching",
    "menopauseFrequentUrination",
    "menopauseHeadache",
    "menopauseOther",
];
var event_dot_colors = {
    生理期: "yellow",
    小產期: "red",
    懷孕期: "pink",
    產後期: "blue",
    更年期: "gray",
    // 生理期: "#ffc64c",
    // 小產期: "#53d2dc",
    // 懷孕期: "#a07be5",
    // 產後期: "#fe72a9",
    // 更年期: "#808080",
}; //明黃色,湖水藍,紫色,粉色,灰色
// 定義英文代碼與中文的對應關係
const chineseLabels = {
    has_mc_type: "是否有月經",
    mc_amount: "月經量",
    pain_level: "經痛程度",
    roommate_type: "同房",
    has_loc_type: "惡露",
    loc_amount: "惡露量",
    loc_color: "惡露顏色",
    has_blood_type: "出血",
    blood_amount: "出血量",
    blood_color: "出血顏色",
    has_loc_type1: "惡露",
    loc_amount4: "惡露量",
    loc_color4: "惡露顏色",
    loc_color4: "惡露顏色",
};

dayjs.locale("zh-tw");
var current = dayjs().format("YYYY-MM-DD");
var date_format = "DD/MM/YYYY";
var calendarEvents = {};

// Get elements
var elements = {
    // Input element
    events: document.getElementById("events"),
    subtitle: document.getElementsByClassName("subtitle"),
    list: document.getElementById("event-content"),
};

//月曆初始化
var calendar = jsCalendar.new("#calendar", "now", {
    monthFormat: "YYYY年 ##月",
    language: "zh",
});

$(".datepicker").datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayHighlight: true,
    language: "zh-TW",
});

$(document).ready(function () {
    getCalendarEvents();
    $(".datepicker").datepicker("setDate", current);

    // 當點擊日期 即觸發顯示該日期事件
    calendar.onDateClick(function (event, date) {
        // Update calendar date
        calendar.set(date);
        // Show events
        showEvents(date);
        $(".datepicker").datepicker(
            "setDate",
            dayjs(date).format("YYYY-MM-DD")
        );
    });

    // 當點擊上or下一月按鈕都須refresh events data
    $(".jsCalendar-nav-right").click(function () {
        // Go to the perious month
        refreshEvents(calendarEvents);
    });
    $(".jsCalendar-nav-left").click(function () {
        // Go to the next month
        refreshEvents(calendarEvents);
    });

    //今日按鈕 月曆快速點到當天日期
    $("#today_btn").click(function () {
        calendar.set(dayjs(current).format(date_format));
        showEvents(current);
    });

    //當未點擊月曆區塊、選擇日期 即顯示提醒事項而非日期事件
    $("#calendar").focusout(function () {
        $("#event-reminder").show();
    });

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

//載入月曆資料
function getCalendarEvents() {
    var content = {};
    subPersonalCalendar.forEach((data) => {
        if (data.calendar.type == "menstruation") {
            var menstruationDescription = "";
            content["id"] =
                String(data.calendar.type) + String(data.calendar.id);
            content["name"] = "生理期";
            content["date"] = data.dict.menstrualPeriod;
            if (data.dict.hasOwnProperty("has_mc")) {
                menstruationDescription += "是否來月經：是<br/>";
                if (data.dict.hasOwnProperty("mc_less")) {
                    menstruationDescription += "月經量：少量" + "<br/>";
                } else if (data.dict.hasOwnProperty("mc_normal")) {
                    menstruationDescription += "月經量：適中" + "<br/>";
                } else if (data.dict.hasOwnProperty("mc_more")) {
                    menstruationDescription += "月經量：量多" + "<br/>";
                }

                if (data.dict.hasOwnProperty("pain_less")) {
                    menstruationDescription += "經痛程度：輕微" + "<br/>";
                } else if (data.dict.hasOwnProperty("pain_normal")) {
                    menstruationDescription += "經痛程度：適中" + "<br/>";
                } else if (data.dict.hasOwnProperty("pain_more")) {
                    menstruationDescription += "經痛程度：嚴重" + "<br/>";
                }
            } else {
                menstruationDescription += "是否來月經：否<br/>";
            }

            var menstruationSymptom = "症狀：";

            for (var j = 0; j < menstruationSymptoms.length; j++) {
                var symptom = menstruationSymptoms[j];
                if (data.dict.hasOwnProperty(symptom)) {
                    menstruationSymptom += data.dict[symptom] + "、";
                }
            }

            if (menstruationSymptom !== "症狀：") {
                menstruationSymptom = menstruationSymptom.slice(0, -1);
                menstruationDescription += menstruationSymptom + "<br/>";
            }

            if (data.dict.hasOwnProperty("noRoommate")) {
                menstruationDescription += "是否同房：否<br/>";
            } else if (data.dict.hasOwnProperty("roommateContraception")) {
                menstruationDescription += "是否同房：是，且有避孕<br/>";
            } else if (data.dict.hasOwnProperty("roommateNoContraception")) {
                menstruationDescription += "是否同房：是，且未避孕<br/>";
            }
            content["description"] =
                "狀態：" + content["name"] + "<br/>" + menstruationDescription;
            content["type"] = content["name"];
            content["color"] = event_dot_colors["生理期"];
        } else if (data.calendar.type == "miscarriage period") {
            var menstruationDescription = "";
            content["id"] =
                String(data.calendar.type) + String(data.calendar.id);
            content["name"] = "小產期";
            content["date"] = data.dict.miscarriagePeriod;
            if (data.dict.hasOwnProperty("miscarriagePeriodHas_loc")) {
                menstruationDescription += "是否惡露：是<br/>";
                if (data.dict.hasOwnProperty("miscarriagePeriodLoc_less")) {
                    menstruationDescription += "惡露量：少量" + "<br/>";
                } else if (
                    data.dict.hasOwnProperty("miscarriagePeriodLoc_normal")
                ) {
                    menstruationDescription += "惡露量：適中" + "<br/>";
                } else if (
                    data.dict.hasOwnProperty("miscarriagePeriodLoc_more")
                ) {
                    menstruationDescription += "惡露量：量多" + "<br/>";
                }

                if (data.dict.hasOwnProperty("miscarriagePeriodLoc_red")) {
                    menstruationDescription += "惡露顏色：鮮紅色" + "<br/>";
                } else if (
                    data.dict.hasOwnProperty("miscarriagePeriodLoc_darkred")
                ) {
                    menstruationDescription += "惡露顏色：暗紅色" + "<br/>";
                }
            } else {
                menstruationDescription += "是否惡露：否<br/>";
            }

            var miscarriagePeriodSymptomDescription = "症狀：";

            for (var j = 0; j < miscarriagePeriodSymptoms.length; j++) {
                var symptom = miscarriagePeriodSymptoms[j];
                if (data.dict.hasOwnProperty(symptom)) {
                    miscarriagePeriodSymptomDescription +=
                        data.dict[symptom] + "、";
                }
            }

            if (miscarriagePeriodSymptomDescription !== "症狀：") {
                miscarriagePeriodSymptomDescription =
                    miscarriagePeriodSymptomDescription.slice(0, -1);
                menstruationDescription +=
                    miscarriagePeriodSymptomDescription + "<br/>";
            }
            content["description"] =
                "狀態：" + content["name"] + "<br/>" + menstruationDescription;
            content["type"] = content["name"];
            content["color"] = event_dot_colors["小產期"];
        } else if (data.calendar.type == "pregnancy") {
            var menstruationDescription = "";
            content["id"] =
                String(data.calendar.type) + String(data.calendar.id);
            content["name"] = "懷孕期";
            content["date"] = data.dict.pregnancyPeriod;

            if (data.dict.hasOwnProperty("has_blood")) {
                menstruationDescription += "是否出血：是<br/>";
                if (data.dict.hasOwnProperty("blood_less")) {
                    menstruationDescription += "出血量：少量" + "<br/>";
                } else if (data.dict.hasOwnProperty("blood_normal")) {
                    menstruationDescription += "出血量：適中" + "<br/>";
                } else if (data.dict.hasOwnProperty("blood_more")) {
                    menstruationDescription += "出血量：量多" + "<br/>";
                }

                if (data.dict.hasOwnProperty("blood_pink")) {
                    menstruationDescription += "出血顏色：粉紅色" + "<br/>";
                } else if (data.dict.hasOwnProperty("blood_red")) {
                    menstruationDescription += "出血顏色：鮮紅色" + "<br/>";
                } else if (data.dict.hasOwnProperty("blood_darkred")) {
                    menstruationDescription += "出血顏色：暗紅色" + "<br/>";
                }
            } else {
                menstruationDescription += "是否出血：否<br/>";
            }

            var pregnancySymptomDescription = "症狀：";

            for (var j = 0; j < pregnancySymptoms.length; j++) {
                var symptom = pregnancySymptoms[j];
                if (data.dict.hasOwnProperty(symptom)) {
                    pregnancySymptomDescription += data.dict[symptom] + "、";
                }
            }

            if (pregnancySymptomDescription !== "症狀：") {
                pregnancySymptomDescription = pregnancySymptomDescription.slice(
                    0,
                    -1
                );
                menstruationDescription +=
                    pregnancySymptomDescription + "<br/>";
            }

            content["description"] =
                "狀態：" + content["name"] + "<br/>" + menstruationDescription;
            content["type"] = content["name"];
            content["color"] = event_dot_colors["懷孕期"];
        } else if (data.calendar.type == "postpartum_period") {
            var menstruationDescription = "";
            content["id"] =
                String(data.calendar.type) + String(data.calendar.id);
            content["name"] = "產後期";
            content["date"] = data.dict.postpartumPeriod;

            if (data.dict.hasOwnProperty("postpartumPeriodHas_loc1")) {
                menstruationDescription += "是否惡露：是<br/>";
                if (data.dict.hasOwnProperty("postpartumPeriodLoc_less")) {
                    menstruationDescription += "惡露量：少量" + "<br/>";
                } else if (
                    data.dict.hasOwnProperty("postpartumPeriodLoc_normal")
                ) {
                    menstruationDescription += "惡露量：適中" + "<br/>";
                } else if (
                    data.dict.hasOwnProperty("postpartumPeriodLoc_more")
                ) {
                    menstruationDescription += "惡露量：量多" + "<br/>";
                }

                if (data.dict.hasOwnProperty("postpartumPeriodLoc_red")) {
                    menstruationDescription += "惡露顏色：鮮紅色" + "<br/>";
                } else if (
                    data.dict.hasOwnProperty("postpartumPeriodLoc_darkred")
                ) {
                    menstruationDescription += "惡露顏色：暗紅色" + "<br/>";
                }
            } else {
                menstruationDescription += "是否惡露：否<br/>";
            }

            var postpartumPeriodSymptom = "症狀：";

            for (var j = 0; j < postpartumSymptoms.length; j++) {
                var symptom = postpartumSymptoms[j];
                if (data.dict.hasOwnProperty(symptom)) {
                    postpartumPeriodSymptom += data.dict[symptom] + "、";
                }
            }

            if (postpartumPeriodSymptom !== "症狀：") {
                postpartumPeriodSymptom = postpartumPeriodSymptom.slice(0, -1);
                menstruationDescription += postpartumPeriodSymptom + "<br/>";
            }

            content["description"] =
                "狀態：" + content["name"] + "<br/>" + menstruationDescription;
            content["type"] = content["name"];
            content["color"] = event_dot_colors["產後期"];
        } else if (data.calendar.type == "menopause") {
            var menstruationDescription = "";
            content["id"] =
                String(data.calendar.type) + String(data.calendar.id);
            content["name"] = "更年期";
            content["date"] = data.dict.menopausePeriod;

            var menopauseSymptomDescription = "症狀：";
            for (var j = 0; j < menopauseSymptoms.length; j++) {
                var symptom = menopauseSymptoms[j];
                if (data.dict.hasOwnProperty(symptom)) {
                    menopauseSymptomDescription += data.dict[symptom] + "、";
                }
            }

            if (menopauseSymptomDescription !== "症狀：") {
                menopauseSymptomDescription = menopauseSymptomDescription.slice(
                    0,
                    -1
                );
                menstruationDescription +=
                    menopauseSymptomDescription + "<br/>";
            }

            content["description"] =
                "狀態：" + content["name"] + "<br/>" + menstruationDescription;
            content["type"] = content["name"];
            content["color"] = event_dot_colors["更年期"];
        }
        calendarEvents[content["date"]] = {
            name: content["description"],
            type: content["name"],
        };
    });
    refreshEvents(calendarEvents);
}

//更新載入月曆事件
function refreshEvents(events_data) {
    jQuery.each(events_data, function (date, val) {
        // Date string
        calendar.select(
            dayjs(date).format(date_format),
            event_dot_colors[val.type]
        );
    });
    showEvents(current);
}

// 前端顯示日期事件
function showEvents(eventDate) {
    var date = dayjs(eventDate).format("YYYY-MM-DD");
    // Date string 日期格式轉換處理
    var title = dayjs(eventDate).format("YYYY年MM月DD日 dddd");
    // Set title 前端返回日期標題
    $("#event-title").html(title);
    // Clear old events 清除舊有事件
    elements.list.innerHTML = "";
    $("#event-content").html("");
    $("#event-reminder").hide();
    // Add events on list
    // if (events.hasOwnProperty(id) && events[id].length) {
    if (calendarEvents.hasOwnProperty(date)) {
        $(".subtitle").html("1 event"); // 前端badge標籤 顯示事件數量
        $("#event-content").html(calendarEvents[date].name); // 前端事件內文 顯示內容

        /* 原先事件為list格式 已改成單事件(先保留原始code) */
        // Number of events
        // elements.subtitle.textContent = events[id].length + " " + (events[id].length > 1 ? "events" : "event");

        // var div;
        // var close;
        // For each event
        // for (var i = 0; i < events[id].length; i++) {
        // div = document.createElement("div");
        // div.className = "event-item";
        // div.textContent = i + 1 + ". " + events[id][i].name;
        // elements.list.appendChild(div);
        // close = document.createElement("div");
        // close.className = "close";
        // close.textContent = "×";
        // div.appendChild(close);
        // close.addEventListener(
        //     "click",
        //     (function (date, index) {
        //         return function () {
        //             removeEvent(date, index);
        //         };
        //     })(date, i),
        //     false
        // );
        // }
    } else {
        // elements.subtitle.textContent = "No events";
        $(".subtitle").html("No events"); // 若無日期事件資料，則前端badge標籤 顯示事件數量
    }
}

function modal_type(type) {
    //記錄會員的身體狀態，預設是"生理期" (ex:生理期=daily_type_1;小產期=daily_type_2...)
    var daily_id = $(".daily_type").not(".d-none").attr("id");
    switch (type) {
        case "menstruation": {
            //生理期
            $("#health_type_1").removeClass("d-none");
            $("#daily_type_1").removeClass("d-none");
            daily_id = "daily_type_1";
            break;
        }
        case "miscarriage period": {
            //小產期
            $("#health_type_2").removeClass("d-none");
            $("#daily_type_2").removeClass("d-none");
            daily_id = "daily_type_2";
            break;
        }
        case "pregnancy": {
            //懷孕期
            $("#health_type_3").removeClass("d-none");
            $("#daily_type_3").removeClass("d-none");
            daily_id = "daily_type_3";
            break;
        }
        case "postpartum_period": {
            //產後期
            $("#health_type_4").removeClass("d-none");
            $("#daily_type_4").removeClass("d-none");
            daily_id = "daily_type_4";
            break;
        }
        case "menopause": {
            //更年期
            $("#health_type_5").removeClass("d-none");
            $("#daily_type_5").removeClass("d-none");
            daily_id = "daily_type_5";
            break;
        }
        default: {
            break;
        }
    }
}
function open_modal(type) {
    if (type != "undefined") {
        // 有的話 開啟平時日誌記錄modal
        $("#health_type_1").addClass("d-none");
        $("#daily_type_1").addClass("d-none");
        $("#health_type").val(type);
        modal_type(type);
    }
}
function toggle_modal() {
    $("#first_daily_modal").modal("toggle");
    $("#daily_modal").modal("toggle");
}
function close_modal() {
    $(".modal").modal("hide");
    $(".modal-backdrop").remove();
    $("#first_daily_modal input").val("");
    $('#daily_modal input[type="checkbox"]').prop("checked", false);
    $('#daily_modal input[type="radio"]').prop("checked", false);
}

//初次使用月曆記錄
function first_daily_set() {
    let selected_item = $("#health_type").find(":selected").val();
    setting_json = {
        type: selected_item,
    };
    switch (selected_item) {
        case "menstruation": {
            setting_json["cycle"] = $("#type1_q1").val();
            setting_json["date"] = $("#type1_q2").val();
            setting_json["cycle_days"] = $("#type1_q3").val();
            break;
        }
        case "miscarriage period": {
            setting_json["date"] = $("#type2_q1").val();
            break;
        }
        case "pregnancy": {
            setting_json["cycle"] = $("#type3_q1").val();
            setting_json["date"] = $("#type3_q2").val();
            break;
        }
        case "postpartum_period": {
            setting_json["date"] = $("#type4_q1").val();
            break;
        }
        default: {
            break;
        }
    }
    toggle_modal();
    open_modal(selected_item);
    //後端處理 儲存setting_json資料
}

//初次紀錄modal 生理狀態select change 前端切換成相對應表單
// select後 會將會員初次設置的生理狀態 記錄在 daily_id 變數
function daily_select_type() {
    $(".health_type").addClass("d-none");
    $(".daily_type").addClass("d-none");
    modal_type($("#health_type").val());
    // 清空daily_modal 填寫/選取內容
    $('#daily_modal input[type="checkbox"]').prop("checked", false);
    $('#daily_modal input[type="radio"]').prop("checked", false);
}

// 資料防呆檢查
function calendarValidate() {
    let daily_id = $(".daily_type").not(".d-none").attr("id"); // 取得是哪個時期的 div id
    let daily_index = daily_id.replace("daily_type_", "");
    let emptyFields = [];
    let uncheckedFields = [];
    let checked_list = [];

    // 檢查所有文本輸入框是否為空且沒有被禁用
    $(`#${daily_id} input[type='text']`).each(function (index, element) {
        if (!$(element).prop("disabled") && $(element).val() === "") {
            // 如果值為空且輸入欄位沒有被禁用
            if ($(element).attr("id") == `type${daily_index}_q3_other`) {
                var checkbox = $(`#${daily_id} input[type="checkbox"][value="其他"]`);
                if (checkbox.prop("checked")) {
                    emptyFields.push(chineseLabels[$(element).attr("name")] || $(element).attr("name"));
                }
            } else {
                emptyFields.push(chineseLabels[$(element).attr("name")] || $(element).attr("name"));
            }
        }
    });

    // 檢查所有單選按鈕是否有選擇且沒有被禁用
    $(`#${daily_id} input[type='radio']`).each(function (index, element) {
        if (!$(element).prop("disabled")) {
            if (index === 0) {
                firstInputName = $(element).attr("name");
                checked_list.push($(element).prop("checked"));
            } else if (index === $(`#${daily_id} input[type='radio']`).length - 1) {
                checked_list.push($(element).prop("checked"));
                if (!checked_list.includes(true)) {
                    uncheckedFields.push(chineseLabels[firstInputName] || firstInputName);
                }
            } else {
                if (firstInputName == $(element).attr("name")) {
                    checked_list.push($(element).prop("checked"));
                } else {
                    if (!checked_list.includes(true)) {
                        uncheckedFields.push(chineseLabels[firstInputName] || firstInputName);
                    }
                    firstInputName = $(element).attr("name");
                    checked_list = [];
                    checked_list.push($(element).prop("checked"));
                }
            }
        }
    });

    // 生成警示信息
    if (emptyFields.length > 0 || uncheckedFields.length > 0) {
        let errorMessage = "存在未填寫或未選擇的項目，請進行填寫或選擇:\n";
        if (emptyFields.length > 0) {
            errorMessage += "- " + emptyFields.join("\n- ") + "\n";
        }
        if (uncheckedFields.length > 0) {
            errorMessage += "- " + uncheckedFields.filter(item => item !== '經痛程度').join("\n- ");
        }
        alert(errorMessage);
        return false;
    } else {
        // 將單選按鈕的 name 屬性設置為其 id 屬性值
        $(this)
            .find("input[type=radio]")
            .each(function () {
                $(this).attr("name", $(this).attr("id"));
            });
        return true;
    }
};

// // 新增日期事件 addCalendarEvent
// $("#add_daily_btn").click(function () {
//     let daily_json = {};

//     //根據不同身體狀態TYPE，取得 #daily_modal內的 input value 並存於 daily_json變數
//     switch (daily_id) {
//         //生理期
//         case "daily_type_1": {
//             daily_json["type"] = "生理期";
//             daily_json["date"] = $("#d_type1_q1").val();
//             daily_json["月經"] = $("input[name='has_mc_type']:checked").val();
//             daily_json["月經量"] = $("input[name='mc_amount']:checked").val();
//             daily_json["經痛程度"] = $("input[name='mc_pain']:checked").val();
//             daily_json["症狀"] = $(`input[name='d_type1_q3']:checked`)
//                 .map(function () {
//                     return this.value;
//                 })
//                 .get()
//                 .join("、");
//             if ($(`input#type1_q3_other`).val()) {
//                 daily_json["症狀"] =
//                     daily_json["症狀"].replace("其他", "其他 - ") +
//                     `${$(`input#type1_q3_other`).val()}`;
//             }
//             daily_json["同房"] = $("input[name='d_type1_q4']:checked").val();
//             break;
//         }
//         //小產期
//         case "daily_type_2": {
//             daily_json["type"] = "小產期";
//             daily_json["date"] = $("#d_type2_q1").val();
//             daily_json["惡露"] = $("input[name='has_loc_type']:checked").val();
//             daily_json["惡露量"] = $("input[name='loc_amount']:checked").val();
//             daily_json["惡露顏色"] = $("input[name='loc_color']:checked").val();
//             daily_json["症狀"] = $(`input[name='d_type2_q3']:checked`)
//                 .map(function () {
//                     return this.value;
//                 })
//                 .get()
//                 .join("、");
//             if ($(`input#type2_q3_other`).val()) {
//                 daily_json["症狀"] =
//                     daily_json["症狀"].replace("其他", "其他 - ") +
//                     `${$(`input#type2_q3_other`).val()}`;
//             }

//             break;
//         }
//         case "daily_type_3": {
//             daily_json["type"] = "懷孕期";
//             daily_json["date"] = $("#d_type3_q1").val();
//             daily_json["出血"] = $(
//                 "input[name='has_blood_type']:checked"
//             ).val();
//             daily_json["出血量"] = $(
//                 "input[name='blood_amount']:checked"
//             ).val();
//             daily_json["出血顏色"] = $(
//                 "input[name='blood_color']:checked"
//             ).val();
//             daily_json["症狀"] = $(`input[name='d_type3_q3']:checked`)
//                 .map(function () {
//                     return this.value;
//                 })
//                 .get()
//                 .join("、");
//             if ($(`input#type3_q3_other`).val()) {
//                 daily_json["症狀"] =
//                     daily_json["症狀"].replace("其他", "其他 - ") +
//                     `${$(`input#type3_q3_other`).val()}`;
//             }

//             break;
//         }
//         case "daily_type_4": {
//             daily_json["type"] = "產後期";
//             daily_json["date"] = $("#d_type4_q1").val();
//             daily_json["惡露"] = $("input[name='has_loc_type1']:checked").val();
//             daily_json["惡露量"] = $("input[name='loc_amount4']:checked").val();
//             daily_json["惡露顏色"] = $(
//                 "input[name='loc_color4']:checked"
//             ).val();
//             daily_json["症狀"] = $(`input[name='d_type4_q3']:checked`)
//                 .map(function () {
//                     return this.value;
//                 })
//                 .get()
//                 .join("、");
//             if ($(`input#type4_q3_other`).val()) {
//                 daily_json["症狀"] =
//                     daily_json["症狀"].replace("其他", "其他 - ") +
//                     `${$(`input#type4_q3_other`).val()}`;
//             }

//             break;
//         }
//         case "daily_type_5": {
//             daily_json["type"] = "更年期";
//             daily_json["date"] = $("#d_type5_q1").val();
//             daily_json["症狀"] = $(`input[name='d_type5_q3']:checked`)
//                 .map(function () {
//                     return this.value;
//                 })
//                 .get()
//                 .join("、");
//             if ($(`input#type5_q3_other`).val()) {
//                 daily_json["症狀"] =
//                     daily_json["症狀"].replace("其他", "其他 - ") +
//                     `${$(`input#type5_q3_other`).val()}`;
//             }

//             break;
//         }
//         default: {
//             break;
//         }
//     }

//     //取得選取日期
//     let cal_id = (Math.random() + dayjs().getTime())
//         .toString(32)
//         .slice(0, 8);
//     //將剛剛前端使用者填的json資料存至cal_json 變數，並不要date資料
//     let cal_json = JSON.parse(JSON.stringify(daily_json));
//     delete cal_json.date;
//     //將json轉成str，這是要拿來放置前端#event-content的顯示內容
//     let cal_description = JSON.stringify(cal_json)
//         .slice(2, -2)
//         .replaceAll(`:`, "：")
//         .replaceAll(`"`, "")
//         .replaceAll(",", "<br/>");
//     cal_description = cal_description.replace("type", "身體狀態");
//     console.log("daily_json:");
//     console.log(daily_json);
//     console.log(daily_json.date);
//     console.log(daily_json.type);
//     console.log("cal_description:");
//     console.log(cal_description);

//     // $.ajax({
//     //     type: 'POST',
//     //     url: apiUrl + '/api/userprofile/personalCalendar/',
//     //     data: {
//     //         type:daily_json.type,
//     //         cycle:0,
//     //         date:daily_json.date,
//     //         cycle_days:
//     //     },
//     //     success: function(response) {
//     //         console.log(response.message);  // 在控制台中印出後端回傳的訊息
//     //     },
//     //     error: function(error) {
//     //         console.error('Error:', error);
//     //     }
//     // });

//     var current = dayjs(daily_json.date);
//     // Date string
//     var id = jsCalendar.tools.dateToString(current, "DD/MM/YYYY", "zh");

//     // If no calendarEvents, create list
//     if (!calendarEvents.hasOwnProperty(id)) {
//         // Create list
//         calendarEvents[id] = [];
//     }

//     // If where were no calendarEvents
//     // if (calendarEvents[id].length === 0) {
//     //     // Select date
//     // }

//     // 月曆套件 Add event
//     calendar.unselect(current); //先清除舊有日期事件
//     calendar.select(current, event_dot_colors[daily_json.type]); //建立事件

//     // events[id].push({ name: cal_description });
//     events[id] = { name: cal_description, json_data: cal_json }; //日期事件json資料
//     /* 後端處理 儲存events資料 */

//     // Refresh events
//     showEvents(current);
//     $("#daily_modal").modal("hide");
//     // modal 恢復初始表單內容設置&清除已填資料
//     $("#first_daily_form").trigger("reset");
//     $("#daily_form").trigger("reset");
// });

// var removeEvent = function (date, index) {
//     // Date string
//     var id = jsCalendar.tools.dateToString(date, date_format, "en");

//     // If no events return
//     if (!events.hasOwnProperty(id)) {
//         return;
//     }
//     // If not found
//     if (events[id].length <= index) {
//         return;
//     }

//     // Remove event
//     events[id].splice(index, 1);

//     // Refresh events
//     showEvents(current);

//     // If no events uncheck date
//     if (events[id].length === 0) {
//         calendar.unselect(date);
//     }
// };

/* 日期事件json格式如下： */
/* key為日期且date格式必須為 DD/MM/YYYY (*月曆套件才能建立事件) */
/* 以下資料皆可先由前端完成記錄儲存得到該資料內容後 返回儲存至後端中 */
// let calendarEvents;
// function saveEvents(events) {
//     calendarEvents = events;
//     refreshEvents(calendarEvents);
// };

// let calendarEvents = {
//     "07/09/2023": {
//         name: "type：懷孕期<br/>出血：有<br/>出血量：量少<br/>出血顏色：粉紅色<br/>症狀：腰痠背痛",
//         json_data: {
//             type: "懷孕期",
//             出血: "有",
//             出血量: "量少",
//             出血顏色: "粉紅色",
//             症狀: "腰痠背痛",
//         },
//     },
//     "30/09/2023": {
//         name: "type：產後期<br/>惡露：有<br/>惡露量：量適中<br/>惡露顏色：鮮紅色<br/>症狀：消化不良",
//         json_data: {
//             type: "產後期",
//             惡露: "有",
//             惡露量: "量適中",
//             惡露顏色: "鮮紅色",
//             症狀: "消化不良",
//         },
//     },
// };
//單選 連點兩下可取消選取
// $("input:radio").click(function () {
//     var $radio = $(this);
//     if ($radio.data("checked")) {
//         $radio.prop("checked", false);
//         $radio.data("checked", false);
//     } else {
//         $radio.prop("checked", true);
//         $radio.data("checked", true);
//     }
// });
