// let event_dot_colors = {
//     生理期: "#ffc64c",
//     小產期: "#53d2dc",
//     懷孕期: "#a07be5",
//     產後期: "#fe72a9",
//     更年期: "#808080",
// }; //明黃色,湖水藍,紫色,粉色,灰色

let event_type = {
    生理期: "mc",
    小產期: "pl",
    懷孕期: "pg",
    產後期: "pm",
    更年期: "mp",
};

// try {
//     var authorization = $("#jwt_token").text();
//     const apiIP = document.getElementById('app').getAttribute('data-api-ip');
//     var calendarEventsContent = [];
//     var menstruationSymptoms = [
//         "menstrualPeriodHeadache",
//         "backache",
//         "hecticFever",
//         "breastTenderness",
//         "OvulationPain",
//         "menstrualPeriodConstipate",
//         "diarrhea",
//         "increasedSecretions",
//         "spottingHemorrhage",
//         "menstrualPeriodOther"
//     ];
//     var miscarriagePeriodSymptoms = [
//         "miscarriagePeriodContractions",
//         "miscarriagePeriodBackache",
//         "largeBloodClots",
//         "fever",
//         "nausea",
//         "vomit",
//         "dizziness",
//         "chestPain",
//         "miscarriagePeriodOther"
//     ];
//     var pregnancySymptoms = [
//         "vaginalBleeding",
//         "backPain",
//         "pregnancyChestPain",
//         "lowerAbdominalPain",
//         "pregnancyNausea",
//         "pregnancyVomit",
//         "pregnancyDizziness",
//         "pregnancyConstipate",
//         "pregnancyFrequentUrination",
//         "upsetStomach",
//         "pregnancyIndigestion",
//         "pregnancyOther"
//     ];
//     var postpartumSymptoms = [
//         "postpartumPeriodContractions",
//         "postpartumPeriodBackache",
//         "postpartumPeriodLargeBloodClots",
//         "lossOfAppetite",
//         "postpartumPeriodIndigestion",
//         "postpartumPeriodConstipate",
//         "itching",
//         "postpartumPeriodChestPain",
//         "postpartumPeriodOther"
//     ];
//     var menopauseSymptoms = [
//         "menopause",
//         "hotFlashes",
//         "nightSweats",
//         "coldHandsAndFeet",
//         "difficultyFallingAsleep",
//         "vaginalDryness",
//         "vaginalItching",
//         "menopauseFrequentUrination",
//         "menopauseHeadache",
//         "menopauseOther"
//     ];

//     var myHeaders = new Headers();
//     myHeaders.append("Authorization", 'Bearer ' + authorization);

//     var requestOptions = {
//         method: 'GET', // method
//         headers: myHeaders,
//     };

//     fetch(apiIP + "api/userprofile/subPersonalCalendar/", requestOptions)
//         .then(response => response.json())
//         .then(result => {
//             resultData = result;
//             for (var i = 0; i < result.length; i++) {
//                 var content = {};
//                 console.log(result[i].dict);
//                 if (result[i].calendar.type == 'menstruation') {
//                     var menstruationDescription = '';
//                     content['id'] = String(result[i].calendar.type) + String(result[i].calendar.id);
//                     content['name'] = "生理期";
//                     content['date'] = result[i].dict.menstrualPeriod;
//                     if (result[i].dict.hasOwnProperty('has_mc')){
//                         menstruationDescription += "是否來月經：是<br/>";
//                         if (result[i].dict.hasOwnProperty('mc_less')){
//                             menstruationDescription += "月經量：少量" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('mc_normal')){
//                             menstruationDescription += "月經量：適中" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('mc_more')){
//                             menstruationDescription += "月經量：量多" + "<br/>";
//                         }

//                         if (result[i].dict.hasOwnProperty('pain_less')){
//                             menstruationDescription += "經痛程度：輕微" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('pain_normal')){
//                             menstruationDescription += "經痛程度：適中" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('pain_more')){
//                             menstruationDescription += "經痛程度：嚴重" + "<br/>";
//                         }                        
//                     } else {
//                         menstruationDescription += "是否來月經：否<br/>";
//                     }
                    
//                     var menstruationSymptom = "症狀：";

//                     for (var j = 0; j < menstruationSymptoms.length; j++) {
//                         var symptom = menstruationSymptoms[j];
//                         if (result[i].dict.hasOwnProperty(symptom)) {
//                             menstruationSymptom += result[i].dict[symptom] + "、";
//                         }
//                     }

//                     if (menstruationSymptom !== "症狀：") {
//                         menstruationSymptom = menstruationSymptom.slice(0, -1);
//                         menstruationDescription += menstruationSymptom + "<br/>";
//                     }

//                     if (result[i].dict.hasOwnProperty('noRoommate')){
//                         menstruationDescription += "是否同房：否<br/>";
//                     } else if (result[i].dict.hasOwnProperty('roommateContraception')){
//                         menstruationDescription += "是否同房：是，且有避孕<br/>";
//                     } else if (result[i].dict.hasOwnProperty('roommateNoContraception')){
//                         menstruationDescription += "是否同房：是，且未避孕<br/>";
//                     }
//                     content['description'] = menstruationDescription
//                     content['type'] = event_type[content['name']];
//                     content['color'] = event_dot_colors["生理期"];
//                 }else if (result[i].calendar.type == 'miscarriage period'){
//                     var menstruationDescription = '';
//                     content['id']=String(result[i].calendar.type) + String(result[i].calendar.id);
//                     content['name']="小產期";
//                     content['date'] = result[i].dict.miscarriagePeriod;
//                     if (result[i].dict.hasOwnProperty('miscarriagePeriodHas_loc')){
//                         menstruationDescription += "是否惡露：是<br/>";
//                         if (result[i].dict.hasOwnProperty('miscarriagePeriodLoc_less')){
//                             menstruationDescription += "惡露量：少量" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('miscarriagePeriodLoc_normal')){
//                             menstruationDescription += "惡露量：適中" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('miscarriagePeriodLoc_more')){
//                             menstruationDescription += "惡露量：量多" + "<br/>";
//                         }

//                         if (result[i].dict.hasOwnProperty('miscarriagePeriodLoc_red')){
//                             menstruationDescription += "惡露顏色：鮮紅色" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('miscarriagePeriodLoc_darkred')){
//                             menstruationDescription += "惡露顏色：暗紅色" + "<br/>";
//                         }
//                     } else {
//                         menstruationDescription += "是否惡露：否<br/>";
//                     }

//                     var miscarriagePeriodSymptomDescription = "症狀：";

//                     for (var j = 0; j < miscarriagePeriodSymptoms.length; j++) {
//                         var symptom = miscarriagePeriodSymptoms[j];
//                         if (result[i].dict.hasOwnProperty(symptom)) {
//                             miscarriagePeriodSymptomDescription += result[i].dict[symptom] + "、";
//                         }
//                     }

//                     if (miscarriagePeriodSymptomDescription !== "症狀：") {
//                         miscarriagePeriodSymptomDescription = miscarriagePeriodSymptomDescription.slice(0, -1);
//                         menstruationDescription += miscarriagePeriodSymptomDescription + "<br/>";
//                     }
//                     content['description'] = menstruationDescription
//                     content['type'] = event_type[content['name']];
//                     content['color'] = event_dot_colors["小產期"];
//                 }else if (result[i].calendar.type == 'pregnancy'){
//                     var menstruationDescription = '';
//                     content['id']=String(result[i].calendar.type) + String(result[i].calendar.id);
//                     content['name']="懷孕期";
//                     content['date'] = result[i].dict.pregnancy;

//                     if (result[i].dict.hasOwnProperty('has_blood')){
//                         menstruationDescription += "是否出血：是<br/>";
//                         if (result[i].dict.hasOwnProperty('blood_less')){
//                             menstruationDescription += "出血量：少量" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('blood_normal')){
//                             menstruationDescription += "出血量：適中" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('blood_more')){
//                             menstruationDescription += "出血量：量多" + "<br/>";
//                         }

//                         if (result[i].dict.hasOwnProperty('blood_pink')){
//                             menstruationDescription += "出血顏色：粉紅色" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('blood_red')){
//                             menstruationDescription += "出血顏色：鮮紅色" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('blood_darkred')){
//                             menstruationDescription += "出血顏色：暗紅色" + "<br/>";
//                         }                        
//                     } else {
//                         menstruationDescription += "是否出血：否<br/>";
//                     }

//                     var pregnancySymptomDescription = "症狀：";

//                     for (var j = 0; j < pregnancySymptoms.length; j++) {
//                         var symptom = pregnancySymptoms[j];
//                         if (result[i].dict.hasOwnProperty(symptom)) {
//                             pregnancySymptomDescription += result[i].dict[symptom] + "、";
//                         }
//                     }

//                     if (pregnancySymptomDescription !== "症狀：") {
//                         pregnancySymptomDescription = pregnancySymptomDescription.slice(0, -1);
//                         menstruationDescription += pregnancySymptomDescription + "<br/>";
//                     }

//                     content['description'] = menstruationDescription
//                     content['type'] = event_type[content['name']];
//                     content['color'] = event_dot_colors["懷孕期"];
//                 }else if(result[i].calendar.type == 'postpartum_period'){
//                     var menstruationDescription = '';
//                     content['id']=String(result[i].calendar.type) + String(result[i].calendar.id);
//                     content['name']="產後期";
//                     content['date'] = result[i].dict.postpartumPeriod;

//                     if (result[i].dict.hasOwnProperty('postpartumPeriodHas_loc1')){
//                         menstruationDescription += "是否惡露：是<br/>";
//                         if (result[i].dict.hasOwnProperty('postpartumPeriodLoc_less')){
//                             menstruationDescription += "惡露量：少量" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('postpartumPeriodLoc_normal')){
//                             menstruationDescription += "惡露量：適中" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('postpartumPeriodLoc_more')){
//                             menstruationDescription += "惡露量：量多" + "<br/>";
//                         }

//                         if (result[i].dict.hasOwnProperty('postpartumPeriodLoc_red')){
//                             menstruationDescription += "惡露顏色：鮮紅色" + "<br/>";
//                         }else if(result[i].dict.hasOwnProperty('postpartumPeriodLoc_darkred')){
//                             menstruationDescription += "惡露顏色：暗紅色" + "<br/>";
//                         }
//                     } else {
//                         menstruationDescription += "是否惡露：否<br/>";
//                     }

//                     var postpartumPeriodSymptom = "症狀：";

//                     for (var j = 0; j < postpartumSymptoms.length; j++) {
//                         var symptom = postpartumSymptoms[j];
//                         if (result[i].dict.hasOwnProperty(symptom)) {
//                             postpartumPeriodSymptom += result[i].dict[symptom] + "、";
//                         }
//                     }

//                     if (postpartumPeriodSymptom !== "症狀：") {
//                         postpartumPeriodSymptom = postpartumPeriodSymptom.slice(0, -1);
//                         menstruationDescription += postpartumPeriodSymptom + "<br/>";
//                     }

//                     content['description'] = menstruationDescription
//                     content['type'] = event_type[content['name']];
//                     content['color'] = event_dot_colors["產後期"];
//                 }else if(result[i].calendar.type == 'menopause'){
//                     var menstruationDescription = '';
//                     content['id']=String(result[i].calendar.type) + String(result[i].calendar.id);
//                     content['name']="更年期";
//                     content['date'] = result[i].dict.menopause

//                     var menopauseSymptomDescription  = "症狀：";

//                     for (var j = 0; j < menopauseSymptoms.length; j++) {
//                         var symptom = menopauseSymptoms[j];
//                         if (result[i].dict.hasOwnProperty(symptom)) {
//                             menopauseSymptomDescription += result[i].dict[symptom] + "、";
//                         }
//                     }

//                     if (menopauseSymptomDescription !== "症狀：") {
//                         menopauseSymptomDescription = menopauseSymptomDescription.slice(0, -1);
//                         menstruationDescription += menopauseSymptomDescription + "<br/>";
//                     }

//                     content['description'] = menstruationDescription
//                     content['type'] = event_type[content['name']];
//                     content['color'] = event_dot_colors["更年期"];
//                 }
//                 calendarEventsContent.push(content);
//             }
//             console.log(calendarEventsContent);
//             calendarEvents = calendarEventsContent;
//             // initializeCalendar();
//         })
//         .catch(error => console.log('error', error));
// } catch (error) {}

function initializeCalendar() {
    $("#calendar").evoCalendar({
        theme: "Orange Coral",
        titleFormat: "yyyy年 mm月",
        todayHighlight: true,
        sidebarDisplayDefault: false,
        calendarEvents: calendarEvents,
    });
}


$(".datepicker").datepicker({
    format: "yyyy/mm/dd",
    autoclose: true,
    todayHighlight: true,
    language: "zh-TW",
});

// let datepick_pos_top = null;
// $(".datepicker").focus(function () {
//     var datepk_display = $(".datepicker-dropdown").css("display");
//     if (datepk_display == "block") {
//         let top = parseFloat($(".datepicker-dropdown").css("top")) + 70;
//         if (datepick_pos_top == null || datepick_pos_top != top) {
//             datepick_pos_top = top;
//         }
//         $(".datepicker-dropdown").css("top", `${datepick_pos_top}px`);
//     }
// });

$("#today_btn").click(function () {
    $("#calendar").evoCalendar("selectDate", now_today);
});

// addCalendarEvent
$("#add_daily_btn").click(function () {
    let daily_id = $(".daily_type").not(".d-none").attr("id");
    let daily_json = {};
    switch (daily_id) {
        case "daily_type_1": {
            daily_json["type"] = "生理期";
            daily_json["date"] = $("#d_type1_q1").val();
            daily_json["月經"] = $("input[name='has_mc_type']:checked").val();
            daily_json["月經量"] = $("input[name='mc_amount']:checked").val();
            daily_json["經痛程度"] = $("input[name='mc_pain']:checked").val();
            daily_json["症狀"] = $(`input[name='d_type1_q3']:checked`)
                .map(function () {
                    return this.value;
                })
                .get()
                .join("、");
            if ($(`input#type1_q3_other`).val()) {
                daily_json["症狀"] = daily_json["症狀"].replace("其他", "其他 - ") + `${$(`input#type1_q3_other`).val()}`;
            }
            daily_json["同房"] = $("input[name='d_type1_q4']:checked").val();
            break;
        }
        case "daily_type_2": {
            daily_json["type"] = "小產期";
            daily_json["date"] = $("#d_type2_q1").val();
            daily_json["惡露"] = $("input[name='has_loc_type']:checked").val();
            daily_json["惡露量"] = $("input[name='loc_amount']:checked").val();
            daily_json["惡露顏色"] = $("input[name='loc_color']:checked").val();
            daily_json["症狀"] = $(`input[name='d_type2_q3']:checked`)
                .map(function () {
                    return this.value;
                })
                .get()
                .join("、");
            if ($(`input#type2_q3_other`).val()) {
                daily_json["症狀"] = daily_json["症狀"].replace("其他", "其他 - ") + `${$(`input#type2_q3_other`).val()}`;
            }

            break;
        }
        case "daily_type_3": {
            daily_json["type"] = "懷孕期";
            daily_json["date"] = $("#d_type3_q1").val();
            daily_json["出血"] = $("input[name='has_blood_type']:checked").val();
            daily_json["出血量"] = $("input[name='blood_amount']:checked").val();
            daily_json["出血顏色"] = $("input[name='blood_color']:checked").val();
            daily_json["症狀"] = $(`input[name='d_type3_q3']:checked`)
                .map(function () {
                    return this.value;
                })
                .get()
                .join("、");
            if ($(`input#type3_q3_other`).val()) {
                daily_json["症狀"] = daily_json["症狀"].replace("其他", "其他 - ") + `${$(`input#type3_q3_other`).val()}`;
            }

            break;
        }
        case "daily_type_4": {
            daily_json["type"] = "產後期";
            daily_json["date"] = $("#d_type4_q1").val();
            daily_json["惡露"] = $("input[name='has_loc_type1']:checked").val();
            daily_json["惡露量"] = $("input[name='loc_amount4']:checked").val();
            daily_json["惡露顏色"] = $("input[name='loc_color4']:checked").val();
            daily_json["症狀"] = $(`input[name='d_type4_q3']:checked`)
                .map(function () {
                    return this.value;
                })
                .get()
                .join("、");
            if ($(`input#type4_q3_other`).val()) {
                daily_json["症狀"] = daily_json["症狀"].replace("其他", "其他 - ") + `${$(`input#type4_q3_other`).val()}`;
            }

            break;
        }
        case "daily_type_5": {
            daily_json["type"] = "更年期";
            daily_json["date"] = $("#d_type4_q1").val();
            daily_json["症狀"] = $(`input[name='d_type5_q3']:checked`)
                .map(function () {
                    return this.value;
                })
                .get()
                .join("、");
            if ($(`input#type5_q3_other`).val()) {
                daily_json["症狀"] = daily_json["症狀"].replace("其他", "其他 - ") + `${$(`input#type5_q3_other`).val()}`;
            }

            break;
        }
        default: {
            break;
        }
    }
    console.log(daily_json);
    let cal_id = (Math.random() + new Date().getTime()).toString(32).slice(0, 8);
    let cal_json = JSON.parse(JSON.stringify(daily_json));
    delete cal_json.type;
    delete cal_json.date;
    let cal_description = JSON.stringify(cal_json).slice(2, -2).replaceAll(`:`, "：").replaceAll(`"`, "").replaceAll(",", "<br/>");

    $("#calendar").evoCalendar("addCalendarEvent", [
        {
            id: cal_id,
            name: daily_json.type,
            description: cal_description,
            date: daily_json.date,
            type: event_type[daily_json.type],
        },
        // {
        //     id: "asDf87L",
        //     name: "Graduation Day!",
        //     description: "我是內文, 我是內文, 我是內文, 我是內文, 我是內文, 我是內文, 我是內文, ",
        //     date: "2023/07/30",
        //     type: "event",
        // },
        // {
        //     id: "dddwee2",
        //     name: "Happy Day!",
        //     description: "我是內文, 我是內文, 我是內文, 我是內文, 我是內文, 我是內文, 我是內文, ",
        //     date: "2023/07/30",
        //     type: "holiday",
        //     color: event_dot_colors[0],
        // },
    ]);
    $("#daily_modal").modal("hide");
});

//初次紀錄 生理狀態選擇
function daily_select_type(selectOS) {
    let selected_item = $(selectOS).find(":selected").val();
    $(".health_type").addClass("d-none");
    $(".daily_type").addClass("d-none");
    switch (selected_item) {
        case "生理期": {
            $("#health_type_1").removeClass("d-none");
            $("#daily_type_1").removeClass("d-none");
            break;
        }
        case "小產期": {
            $("#health_type_2").removeClass("d-none");
            $("#daily_type_2").removeClass("d-none");
            break;
        }
        case "懷孕期": {
            $("#health_type_3").removeClass("d-none");
            $("#daily_type_3").removeClass("d-none");
            break;
        }
        case "產後期": {
            $("#health_type_4").removeClass("d-none");
            $("#daily_type_4").removeClass("d-none");
            break;
        }
        case "更年期": {
            $("#health_type_5").removeClass("d-none");
            $("#daily_type_5").removeClass("d-none");
            break;
        }
        default: {
            break;
        }
    }
}
