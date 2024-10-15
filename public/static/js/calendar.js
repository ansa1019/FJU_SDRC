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
    menstrualCycle: "生理期週期",
    lastMenstrual: "上次生理期開始日",
    menstruationLast: "月經天數",
    weeksPregnancy: "懷孕週數",
    dueDate: "預產日期",
    miscarriageDay: "小產日期",
    productionPeriod: "生產日期",
    menstrualPeriodOther: "填寫其他症狀",
    miscarriagePeriodOther: "填寫其他症狀",
    pregnancyOther: "填寫其他症狀",
    postpartumPeriodOther: "填寫其他症狀",
    menopauseOther: "填寫其他症狀",
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

     // 監聽單選按鈕的變更事件來禁用或啟用相關欄位
     $("input[name='has_mc_type'], input[name='has_loc_type'], input[name='has_blood_type'], input[name='has_loc_type1']").on("change", function () {
        var isChecked = $(this).prop("checked") && $(this).val() === "沒有";
        // 判斷是否要禁用或啟用輸入欄位
        $( "input[name='mc_amount'], input[name='pain_level'], input[name='loc_amount'], input[name='loc_color'], input[name='blood_amount'], input[name='blood_color'], input[name='loc_amount4'], input[name='loc_color4']").prop("disabled", isChecked);
    }); 
    $('#first_daily_form').submit(function(event) {
        first_daily_set(event); 
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
                if (data.dict.hasOwnProperty("pain_no")) {
                    menstruationDescription += "經痛程度：不痛" + "<br/>";
                } else if (data.dict.hasOwnProperty("pain_less")) {
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
    $("#daily_modal").modal("hide"); 
    $("#first_daily_modal").modal("show"); 
}

function close_modal() {
    $(".modal").modal("hide");
    $(".modal-backdrop").remove();
    $("#first_daily_modal input").val("");
    $('#daily_modal input[type="checkbox"]').prop("checked", false);
    $('#daily_modal input[type="radio"]').prop("checked", false);
}
//初次使用月曆記錄(先留著)
// function first_daily_set() {
//     let selected_item = $("#health_type").find(":selected").val();
//     setting_json = {
//         type: selected_item,
//     };
//     switch (selected_item) {
//         case "menstruation": {
//             setting_json["cycle"] = $("#type1_q1").val();
//             setting_json["date"] = $("#type1_q2").val();
//             setting_json["cycle_days"] = $("#type1_q3").val();
//             break;
//         }
//         case "miscarriage period": {
//             setting_json["date"] = $("#type2_q1").val();
//             break;
//         }
//         case "pregnancy": {
//             setting_json["cycle"] = $("#type3_q1").val();
//             setting_json["date"] = $("#type3_q2").val();
//             break;
//         }
//         case "postpartum_period": {
//             setting_json["date"] = $("#type4_q1").val();
//             break;
//         }
//         default: {
//             break;
//         }
//     }
//     toggle_modal();
//     open_modal(selected_item);
//     //後端處理 儲存setting_json資料
// }
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

function first_daily_set(event) {
    event.preventDefault(); // 防止表單提交
    if (firstDailyModalValidate()) {
        // 如果驗證通過，則轉到 daily_modal
        $('#daily_modal').modal('show');
    }
}
//資料防呆檢查(first_daily_modal)
function firstDailyModalValidate() {
    let modal_id = "#first_daily_modal"; // 取得 first_daily_modal 的 ID
    let emptyFields = [];
    let healthType = $(modal_id + " #health_type").val();

    // 根據健康類型檢查對應的 number 輸入框
    if (healthType === "menstruation") {
        // 檢查生理期相關的 number 輸入框
        let fieldsToCheck = ["menstrualCycle", "menstruationLast"];
        fieldsToCheck.forEach(function (field) {
            let value = $(`${modal_id} input[name='${field}']`).val();
            if (value === "") {
                emptyFields.push(chineseLabels[field] || field);
            }
        });
    } else if (healthType === "pregnancy") {
        // 檢查懷孕相關的 number 輸入框
        let fieldsToCheck = ["weeksPregnancy"]; // 可以在這裡添加其他懷孕相關的輸入框名稱
        fieldsToCheck.forEach(function (field) {
            let value = $(`${modal_id} input[name='${field}']`).val();
            if (value === "") {
                emptyFields.push(chineseLabels[field] || field);
            }
        });
    }

    // 生成警示信息
    if (emptyFields.length > 0) {
        let errorMessage = "存在未填寫的項目，請進行填寫:\n";
        errorMessage += "- " + emptyFields.join("\n- ") + "\n";
        alert(errorMessage);
        return false; // 阻止進入下一步
    }

    return true; // 通過驗證，允許進入下一步
}
//資料防呆檢查(daily_modal)
function calendarValidate() {
    // 檢查是否需要跳過 first_daily_modal 的驗證
    let hasFilledFirstDaily = true; // 假設這是判斷是否已填過的變數
    if (!hasFilledFirstDaily && !firstDailyModalValidate()) {
        return false; // 如果 first_daily_modal 沒有通過驗證，停止操作
    }

    let daily_id = $(".daily_type").not(".d-none").attr("id"); // 取得是哪個時期的 div id
    let daily_index = daily_id.replace("daily_type_", "");
    let emptyFields = [];
    let uncheckedFields = [];

    // 檢查文本輸入框
    $(`#${daily_id} input[type='text']`).each(function (index, element) {
        if (!$(element).prop("disabled") && !$(element).attr("name").includes("symptom")) {
            let fieldName = $(element).attr("name");
            if (chineseLabels.hasOwnProperty(fieldName)) {
                var checkbox = $(`#${daily_id} input[type="checkbox"][value="其他"]`);
                if ($(element).val() !== "" && !checkbox.prop("checked")) {
                    checkbox.prop("checked", true);
                }
                if (checkbox.prop("checked") && $(element).val() === "") {
                    emptyFields.push(chineseLabels[fieldName] || fieldName);
                }
            } else {
                if ($(element).val() === "") {
                    emptyFields.push(chineseLabels[fieldName] || fieldName);
                }
            }
        }
    });

    // 檢查單選按鈕
    let radioGroups = {};
    $(`#${daily_id} input[type='radio']`).each(function (index, element) {
        if (!$(element).prop("disabled") && !$(element).attr("name").includes("symptom")) {
            let groupName = $(element).attr("name");
            if (!radioGroups[groupName]) {
                radioGroups[groupName] = false; // 初始化群組為未選中狀態
            }
            if ($(element).prop("checked")) {
                radioGroups[groupName] = true; // 如果有選擇則標記為 true
            }
        }
    });

    // 檢查未選擇的單選按鈕群組
    for (let group in radioGroups) {
        if (!radioGroups[group]) {
            uncheckedFields.push(chineseLabels[group] || group);
        }
    }

    // 生成警示信息
    if (emptyFields.length > 0 || uncheckedFields.length > 0) {
        let errorMessage = "存在未填寫或未選擇的項目，請進行填寫或選擇:\n";
        if (emptyFields.length > 0) {
            errorMessage += "- " + emptyFields.join("\n- ") + "\n";
        }
        if (uncheckedFields.length > 0) {
            errorMessage += "- " + uncheckedFields.join("\n- ") + "\n";
        }
        alert(errorMessage);
        return false;
    } else {
        // 將單選按鈕的 name 設置為其 id
        $(`#${daily_id} input[type=radio]`).each(function () {
            $(this).attr("name", $(this).attr("id"));
        });
        return true;
    }
}

