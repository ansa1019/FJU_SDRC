var token = $("#jwt_token").text();
var socketIP = document
    .getElementById("app")
    .getAttribute("data-api-ip")
    .split("//")[1];
var usersocket = new WebSocket("ws://" + socketIP + "ws/user/?token=" + token);
usersocket.onmessage = function (e) {
    var data = JSON.parse(e.data);
    if (data["notifications"]) {
        $.ajax({
            type: "POST",
            url: "/setNotifications",
            dataType: "json",
            data: {
                notifications: data["notifications"],
            },
        });
        if (data["notifications"].length > 0) {
            var reddot = document.getElementById("reddot");
            if (!reddot) {
                document.querySelectorAll(".notify_bell").forEach((x) => {
                    var reddot = document.createElement("span");
                    reddot.id = "reddot";
                    reddot.className =
                        "position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle";
                    container.appendChild(reddot);
                });
            }

            var reddot = document.getElementById("reddotNumber");
            if (reddot) {
                reddot.innerHTML = data["notifications"].length;
            } else {
                var container = document.querySelector(
                    "#notifications_box div a"
                );
                var reddot = document.createElement("span");
                reddot.id = "reddotNumber";
                reddot.className = "badge bg-danger rounded-circle";
                reddot.innerHTML = data["notifications"].length;
                container.append(reddot);
            }

            document
                .querySelectorAll(".notifications-item")
                .forEach((el) => el.remove());
            var container = document.getElementById("notifications_box");
            data["notifications"].forEach((element) => {
                var notify = document.createElement("a");
                notify.href = element["url"];
                notify.id = "notify_" + element["id"];
                notify.className =
                    "notifications-item btn btn-link text-decoration-none text-start";
                var span = document.createElement("span");
                span.className =
                    "p-1 bg-danger border border-light rounded-circle";
                span.style = "height: 1px;width: 1px;margin: auto 8px auto 0;";
                notify.append(span);
                var div = document.createElement("div");
                div.className = "text";
                var h4 = document.createElement("h4");
                h4.className = "d-flex align-items-center";
                h4.innerHTML = element["action"];
                div.append(h4);
                var p = document.createElement("p");
                p.innerHTML = element["content"];
                div.append(p);
                notify.append(div);
                container.append(notify);
            });
        }
    } else if (data["blacklist"]) {
        blacklist = data["blacklist"];
        console.log(blacklist);
        $.ajax({
            type: "POST",
            url: "/setBlacklist",
            dataType: "json",
            data: {
                blacklist: JSON.stringify(data["blacklist"]),
            },
        });
    } else if (data["banlist"]) {
        banlist = data["banlist"];
        console.log(banlist);
        $.ajax({
            type: "POST",
            url: "/setBanlist",
            dataType: "json",
            data: {
                banlist: JSON.stringify(data["banlist"]),
            },
        });
    }
};

function all_read() {
    usersocket.send(
        JSON.stringify({
            action: "all_read",
        })
    );
    $("#notifications_box .rounded-circle").remove();
    $(".notify_bell span").remove();
    $.ajax({
        type: "POST",
        url: "/setNotifications",
    });
}

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).ready(function () {
    // 宣告定義datepicker、multiselect套件
    $("#disease_history").multiselect({
        includeSelectAllOption: true,
        maxHeight: 250,
        allSelectedText: "全選",
        buttonWidth: "100%",
        numberDisplayed: 4,
    });

    $("#datepicker").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        language: "zh-TW",
    });
});
/* 會員資料 上傳圖片 */
if ($("#user_image")) {
    let cropper;

    // 當選擇圖片後
    $("#user_image").on("change", (event) => {
        var input = document.getElementById("user_image");

        if (input.files.length > 0) {
            const file = input.files[0];
            const validImageTypes = ["image/jpeg", "image/png", "image/gif"];

            // 檢查檔案類型是否有效
            if (!validImageTypes.includes(file.type)) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "請上傳有效的圖片檔案！",
                    showConfirmButton: false,
                    timer: 2500,
                });
                // 重置文件輸入框
                input.value = "";
                return;
            }

            // 檢查檔案大小是否超過 3MB
            const maxSize = 3 * 1024 * 1024;
            if (file.size > maxSize) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "圖片大小不得超過 3MB！",
                    showConfirmButton: false,
                    timer: 2500,
                });
                // 重置文件輸入框
                input.value = "";
                return;
            }

            // 顯示模態視窗並初始化 Cropper.js
            const reader = new FileReader();
            reader.onload = (e) => {
                $("#image_to_crop").attr("src", e.target.result);

                // 顯示模態視窗
                $("#cropModal").modal("show");

                // 初始化 Cropper.js
                const imageElement = document.getElementById("image_to_crop");
                cropper = new Cropper(imageElement, {
                    aspectRatio: 1, // 圓形裁切
                    viewMode: 1,
                    minContainerWidth: 300,
                    minContainerHeight: 300,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // 當使用者點擊裁切並上傳按鈕
    $("#crop_button").on("click", () => {
        if (cropper) {
            const croppedCanvas = cropper.getCroppedCanvas({
                width: 200, // 設定裁切後的寬度
                height: 200, // 設定裁切後的高度
            });

            // 將裁切後的圖片轉為 Blob 格式
            croppedCanvas.toBlob((blob) => {
                const formdata = new FormData();
                formdata.append("user_image", blob, "image.png");

                const apiIP = document
                    .getElementById("app")
                    .getAttribute("data-api-ip");
                var authorizationId =
                    document.getElementsByName("profile_id")[0].value;
                var myHeaders = new Headers();
                myHeaders.append("Authorization", "Bearer " + token);

                var requestOptions = {
                    method: "PATCH",
                    headers: myHeaders,
                    body: formdata,
                    redirect: "follow",
                };

                // 發送圖片至後端
                fetch(
                    apiIP + "api/userprofile/profile/" + authorizationId + "/",
                    requestOptions
                )
                    .then((response) => response.json())
                    .then((data) => {
                        let userImage =
                            data[0] && data[0]["user_image"]
                                ? data[0]["user_image"]
                                : null;
                        if (userImage) {
                            // 更新圖片預覽
                            $("#crop_image").attr("src", userImage);
                            $("#topbar-nav-tabs img").attr("src", userImage);

                            $.ajax({
                                type: "POST",
                                url: "/setUserimage",
                                data: { user_image: userImage },
                                success: function (result) {
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "修改頭像成功!",
                                        showConfirmButton: false,
                                        timer: 2500,
                                    });

                                    // 隱藏模態視窗並重整頁面
                                    $("#cropModal").modal("hide");
                                    setTimeout(() => {
                                        window.location.reload(); // 重整網頁
                                    }, 1500);
                                },
                                error: function (result) {
                                    console.log(result);
                                },
                            });
                        }
                    })
                    .catch((error) => {
                        console.log("Fetch error: ", error);
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "修改頭像失敗!",
                            showConfirmButton: false,
                            timer: 2500,
                        });
                    });
            });
        }
    });

    // 當模態視窗關閉時，重置 cropper 並清空圖片
    $("#cropModal").on("hidden.bs.modal", function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        $("#image_to_crop").attr("src", ""); // 清空裁切區域的圖片
        $("#user_image").val(""); // 重置文件輸入框
    });
}

// 當模態視窗取消按鈕被點擊時，手動觸發關閉
$(".btn-secondary").on("click", function () {
    $("#cropModal").modal("hide");
});

// 手動處理右上角叉叉按鈕的關閉
$(".close").on("click", function () {
    $("#cropModal").modal("hide");
});

// 模態視窗關閉時，重置 Cropper
$("#cropModal").on("hidden.bs.modal", function () {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    $("#image_to_crop").attr("src", ""); // 清空圖片
    $("#user_image").val(""); // 重置輸入框
});

// if ($("#user_image")) {
//     let cropper;

//     $("#user_image").on("change", (event) => {
//         var input = document.getElementById("user_image");

//         if (input.files.length > 0) {
//             const file = input.files[0];
//             const validImageTypes = ["image/jpeg", "image/png", "image/gif"];

//             if (!validImageTypes.includes(file.type)) {
//                 Swal.fire({
//                     position: "center",
//                     icon: "error",
//                     title: "請上傳有效的圖片檔案！",
//                     showConfirmButton: false,
//                     timer: 2500,
//                 });
//                 return;
//             }

//             const maxSize = 5 * 1024 * 1024; // 5MB
//             if (file.size > maxSize) {
//                 Swal.fire({
//                     position: "center",
//                     icon: "error",
//                     title: "圖片大小不得超過 5MB！",
//                     showConfirmButton: false,
//                     timer: 2500,
//                 });
//                 return;
//             }

//             // 顯示圖片裁切區域
//             const reader = new FileReader();
//             reader.onload = (e) => {
//                 $("#image_to_crop").attr("src", e.target.result);
//                 $("#crop_area").show(); // 顯示裁切區域
//                 $("#crop_button").show(); // 顯示裁切按鈕

//                 // 初始化 Cropper.js
//                 const imageElement = document.getElementById("image_to_crop");
//                 cropper = new Cropper(imageElement, {
//                     aspectRatio: 1, // 圓形裁切 (1:1)
//                     viewMode: 1,
//                     minContainerWidth: 300,
//                     minContainerHeight: 300,
//                 });
//             };
//             reader.readAsDataURL(file);
//         }
//     });

//     // 當使用者裁切完成後，點擊 "裁切並上傳" 按鈕
//     $("#crop_button").on("click", () => {
//         if (cropper) {
//             const croppedCanvas = cropper.getCroppedCanvas({
//                 width: 200, // 圖片寬度
//                 height: 200, // 圖片高度
//             });

//             // 將裁切後的圖片轉為 blob 格式
//             croppedCanvas.toBlob((blob) => {
//                 const formdata = new FormData();
//                 formdata.append("user_image", blob, "cropped_image.png");

//                 const apiIP = document.getElementById("app").getAttribute("data-api-ip");
//                 var authorizationId = document.getElementsByName("profile_id")[0].value;
//                 var myHeaders = new Headers();
//                 myHeaders.append("Authorization", "Bearer " + token);

//                 var requestOptions = {
//                     method: "PATCH",
//                     headers: myHeaders,
//                     body: formdata,
//                     redirect: "follow",
//                 };

//                 fetch(apiIP + "api/userprofile/profile/" + authorizationId + "/", requestOptions)
//                     .then((response) => response.json())
//                     .then((data) => {
//                         let userImage = data[0] && data[0]["user_image"] ? data[0]["user_image"] : null;
//                         if (userImage) {
//                             // 更新圖片預覽
//                             $("#image_preview img").attr("src", userImage);
//                             $("#topbar-nav-tabs img").attr("src", userImage);

//                             Swal.fire({
//                                 position: "center",
//                                 icon: "success",
//                                 title: "修改頭像成功!",
//                                 showConfirmButton: false,
//                                 timer: 2500,
//                             });
//                         }
//                     })
//                     .catch((error) => {
//                         console.log("Fetch error: ", error);
//                         Swal.fire({
//                             position: "center",
//                             icon: "error",
//                             title: "修改頭像失敗!",
//                             showConfirmButton: false,
//                             timer: 2500,
//                         });
//                     });
//             });
//         }
//     });
// }

let datepick_pos_top = null;

// 會員資料前端 有無按鈕 */
$(".button-radio > button").click(function () {
    $(this).css("background", "var(--ct-color-2)");
    $(this).css("color", "white");
    $(this).addClass("active");
    $(this).parent().find("button").not(this).css("background", "none");
    $(this).parent().find("button").not(this).css("color", "black");
});

/* 修改會員資料 */
function info_setting() {
    let diease = ""; //使用者的疾病病史
    let drug = ""; //使用者的用藥狀況
    let order = ""; //使用者的醫師醫囑
    let allergy = ""; //使用者的過敏狀況

    //疾病病史
    if ($("input#disease_other").val() != "") {
        //有填其他
        diease =
            $("#disease_history").val() + "," + $("input#disease_other").val();
    } else {
        diease = $("#disease_history").val();
    }
    //用藥狀況
    if ($("input#drug_other").val() != "") {
        //有填其他
        drug =
            $("#user_drug").children("button.active").html() +
            "," +
            $("input#drug_other").val();
    } else {
        drug = $("#user_drug").children("button.active").html();
    }
    //醫生醫囑
    if ($("input#order_other").val() != "") {
        //有填其他
        order =
            $("#user_order").children("button.active").html() +
            "," +
            $("input#order_other").val();
    } else {
        order = $("#user_order").children("button.active").html();
    }
    //過敏狀況
    if ($("input#allergy_other").val() != "") {
        //有填其他
        allergy =
            $("#user_allergy").children("button.active").html() +
            "," +
            $("input#allergy_other").val();
    } else {
        allergy = $("#user_allergy").children("button.active").html();
    }
    let user_info = {
        user_password: $("input#user_password").val(),
        user_name: $("input#user_name").val(), //用戶姓名
        user_nickname: $("input#user_nickname").val(), //用戶暱稱
        user_email: $("input#user_email").val(), //電子信箱
        user_sex: $("#user_sex").val(), //性別
        user_birthday: $("input#datepicker").val(), //生日
        user_phone: $("input#user_phone").val(), //電話
        user_address: $("input#user_address").val(), //住址
        user_height: $("input#user_height").val(), //身高
        user_weight: $("input#user_weight").val(), //體重
        user_birth_plan: $("#birth_plan").val(), //生育計畫
        user_pregnant: $("#pregnant_state").val(), //懷孕狀態
        user_disease: diease, //疾病病史
        user_drug: drug, //用藥狀況
        user_drug_all: $("#input#user_drug_state").val(), //用藥顯示
        user_order: order, //醫生醫囑
        user_allergy: allergy, //過敏狀況
        user_married: $("#married_state").val(), //婚姻狀態
    };
    // $.ajax({
    //     type: 'POST',
    //     url: '/get_user_info', // 這是伺服器端處理請求的路由 URL，請根據您的 Laravel 路由進行更改
    //     data: userInfo, // 發送使用者資訊的資料
    //     success: function (response) {
    //         // 在這裡處理伺服器回應
    //         console.log(response); // 可以在控制台查看伺服器的回應資料
    //         // 將回應資料傳遞給 Blade 範本
    //         updateUserProfile(response);
    //     },
    //     error: function (error) {
    //         console.error(error); // 處理錯誤情況
    //     }
    // });
}

//////
document.addEventListener("DOMContentLoaded", function () {
    function getUserEmail() {
        // 嘗試從不同可能的元素中獲取用戶電子郵件
        const emailElement = document.getElementById("user_email_forpassword");
        if (emailElement && emailElement.value) {
            return emailElement.value;
        }

        console.error("User email is not available.");
        return null;
    }

    function getApiIp() {
        // 嘗試從頁面中的元素中獲取 API IP 位址
        const appElement = document.getElementById("app");
        if (appElement && appElement.dataset.apiIp) {
            return appElement.dataset.apiIp;
        }

        throw new Error("API_IP not set in page");
    }

    function getUpdatePasswordRoute() {
        const appElement = document.getElementById("passwordup");
        if (appElement && appElement.dataset.updatePasswordRoute) {
            return appElement.dataset.updatePasswordRoute;
        }
        throw new Error("Update password route is not set in the page");
    }
    // 檢查新密碼與確認新密碼是否一致並重置密碼
    // Update new password without changing other parts
    async function updatePassword() {
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        let email = document.getElementById("user_email").value;
        let oldPassword = document.getElementById("old_password").value;
        let password = document.getElementById("old_password").value;
        let new_password = document.getElementById("new_password").value;
        let confirm_password = document.getElementById("check_password").value;
        let pwd_rule = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/; // 密碼規則
        let has_error = false;

        try {
            // 發送 POST 請求到認證 API
            var formdata = new FormData();
            formdata.append("username", email);
            formdata.append("password", oldPassword);
            var requestOptions = {
                method: "POST",
                headers: new Headers(),
                body: formdata,
            };
            fetch(apiIP + "api/auth/token/", requestOptions).then(
                (response) => {
                    if (!response.ok) {
                        document
                            .getElementById("old_pwd_alert")
                            .classList.remove("d-none");
                        has_error = true;
                    } else {
                        document
                            .getElementById("old_pwd_alert")
                            .classList.add("d-none");
                        has_error = false;
                    }
                }
            );
        } catch (error) {
            // 處理請求失敗的情況
            document.getElementById("old_pwd_alert").classList.remove("d-none");
            has_error = true;
        }

        // 檢查新密碼是否符合規則
        if (!new_password.match(pwd_rule)) {
            document.getElementById("new_pwd_alert").classList.remove("d-none");
            has_error = true;
        } else {
            document.getElementById("new_pwd_alert").classList.add("d-none");
        }

        // 檢查新密碼與確認密碼是否一致
        if (new_password !== confirm_password) {
            document
                .getElementById("check_pwd_alert")
                .classList.remove("d-none");
            has_error = true;
        } else {
            document.getElementById("check_pwd_alert").classList.add("d-none");
        }

        // 如果有錯誤，停止提交
        if (has_error) {
            return;
        } else {
            const apiIP = document
                .getElementById("app")
                .getAttribute("data-api-ip");
            var formdata = new FormData();
            formdata.append("password", password);
            formdata.append("new_password", new_password);
            var requestOptions = {
                method: "POST",
                headers: new Headers(),
                body: formdata,
            };
            fetch(
                apiIP + "api/auth/update_password/" + email + "/",
                requestOptions
            )
                .then((response) => {
                    console.log(response);
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data["result"] == "success") {
                        Swal.fire({
                            title: "密碼修改成功！",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        window.location.reload();
                    } else {
                        if (data["error"] == "verification code") {
                            Swal.fire({
                                icon: "error",
                                title: "驗證碼輸入錯誤",
                                showConfirmButton: false,
                                timer: 2500,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "密碼修改失敗",
                                text: data.message || "請稍後再試。",
                                showConfirmButton: false,
                                timer: 2500,
                            });
                        }
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "伺服器錯誤！",
                        text: "請稍後再試。",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                });
        }
    }

    window.updatePassword = function () {
        updatePassword();
    };
});
/*註冊步驟按鈕*/
const step_confirm_btn = document.querySelectorAll(".step-confirm");
const register_info = {}; // 儲存註冊資料 json格式
let img_path = "static/img/register/vc/"; //註冊頁插圖目錄路徑
let bg_path = "static/img/register/bg/"; //註冊頁背景目錄路徑

// 當 ds_item_1 被點選時
$(`input[id='ds_item_1']`).change(function () {
    if ($(this).is(":checked")) {
        // 如果選擇了全選選項，禁用其他選項
        $(`input[name*="user_disease_state"]:not("#ds_item_1")`).prop(
            "disabled",
            true
        );
        // 取消其他選項的選中狀態
        $(`input[name*="user_disease_state"]:not("#ds_item_1")`).prop(
            "checked",
            false
        );
        // 清空 ds_item_other 輸入框
        $(`input[id='ds_item_other']`).val("");
    } else {
        // 取消選擇時，啟用其他選項
        $(`input[name*="user_disease_state"]:not("#ds_item_1")`).prop(
            "disabled",
            false
        );
    }
});

// 當 ds_item_16 被點選時
$(`input[id='ds_item_16']`).change(function () {
    if ($(this).is(":checked")) {
        // 啟用 ds_item_other 的輸入框
        $(`input[id='ds_item_other']`).prop("disabled", false);
    } else {
        // 取消選中時，禁用並清空 ds_item_other 的輸入框
        $(`input[id='ds_item_other']`).prop("disabled", true).val("");
    }
});

// 當其他選項被選擇時（除 ds_item_1 和 ds_item_16）
$(`input[name*="user_disease_state"]:not("#ds_item_1, #ds_item_16")`).change(
    function () {
        // 當選擇其他選項時，禁用並清空 ds_item_other 的輸入框
        if (!$("#ds_item_16").is(":checked")) {
            $(`input[id='ds_item_other']`).prop("disabled", true).val("");
        }
    }
);

// 當 a_item_1 被點選時
$(`input[id='a_item_1']`).click(function () {
    // 檢查是否已經選中 a_item_1
    if ($(this).is(":checked")) {
        // 取消選中 a_item_2 並清空 a_item_other 的輸入框，但不禁用 a_item_other
        $(`input[id='a_item_2']`).prop("checked", false);
        $(`input[id='a_item_other']`).val("");
        // 禁用 a_item_other 輸入框，因為 a_item_2 沒有被選中
        $(`input[id='a_item_other']`).attr("disabled", true);
    }
});

// 當 a_item_2 被點選時
$(`input[id='a_item_2']`).click(function () {
    // 檢查是否已經選中 a_item_2
    if ($(this).is(":checked")) {
        // 啟用 a_item_other 輸入框
        $(`input[id='a_item_other']`).attr("disabled", false);
    } else {
        // 如果取消選中 a_item_2，禁用並清空 a_item_other
        $(`input[id='a_item_other']`).attr("disabled", true).val("");
    }
});

// 當 d_item_1 被點選時
$(`input[id='d_item_1']`).click(function () {
    // 檢查是否已經選中 d_item_1
    if ($(this).is(":checked")) {
        // 取消選中 d_item_2 並清空 d_item_other 的輸入框，但不禁用 d_item_other
        $(`input[id='d_item_2']`).prop("checked", false);
        $(`input[id='d_item_other']`).val("");
        // 禁用 d_item_other 輸入框，因為 d_item_2 沒有被選中
        $(`input[id='d_item_other']`).attr("disabled", true);
    }
});

// 當 d_item_2 被點選時
$(`input[id='d_item_2']`).click(function () {
    // 檢查是否已經選中 d_item_2
    if ($(this).is(":checked")) {
        // 啟用 d_item_other 輸入框
        $(`input[id='d_item_other']`).attr("disabled", false);
    } else {
        // 如果取消選中 d_item_2，禁用並清空 d_item_other
        $(`input[id='d_item_other']`).attr("disabled", true).val("");
    }
});
// 當 or_item_1 被點選時
$(`input[id='or_item_1']`).click(function () {
    // 檢查是否已經選中 or_item_1
    if ($(this).is(":checked")) {
        // 取消選中 or_item_2 並清空 or_item_other 的輸入框，但不禁用 or_item_other
        $(`input[id='or_item_2']`).prop("checked", false);
        $(`input[id='or_item_other']`).val("");
        // 禁用 or_item_other 輸入框，因為 or_item_2 沒有被選中
        $(`input[id='or_item_other']`).attr("disabled", true);
    }
});

// 當 or_item_2 被點選時
$(`input[id='or_item_2']`).click(function () {
    // 檢查是否已經選中 or_item_2
    if ($(this).is(":checked")) {
        // 啟用 or_item_other 輸入框
        $(`input[id='or_item_other']`).attr("disabled", false);
    } else {
        // 如果取消選中 or_item_2，禁用並清空 or_item_other
        $(`input[id='or_item_other']`).attr("disabled", true).val("");
    }
});

/* 註冊頁 每按下確認按紐 即檢視輸入資料並做防呆提醒等處理，沒問題即存於 register_info 變數中 */
step_confirm_btn.forEach((item, step_index) => {
    item.addEventListener("click", function () {
        let is_write = false; //是否有確實填寫 (防呆
        let input_obj_arr = $(this).parent().parent().find("input"); //取得當前input元素
        let step_id = 0;
        let pwd_rule = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/;

        console.log("Now step index:" + step_index); //目前點擊確認的是第幾步驟
        // 獲取 CSRF 權杖值
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        console.log("csrfToken=", csrfToken);
        $(document).ready(function () {
            // 當文檔載入完成後執行這段代碼
            $("#checkNicknameButton").click(function () {
                console.log("Check nickname button clicked."); // 確認按鈕被點擊
                // 獲取用戶輸入的暱稱
                var nickname = $("#nicknameInput").val();
                console.log("nickname=", nickname);
                // 發送Ajax請求
                $.ajax({
                    url: "/checknickname", // 此處應該是您的後端路由
                    method: "POST", // 使用POST方法
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    data: { nickname: nickname }, // 傳遞nickname到後端
                    success: function (response) {
                        console.log("Ajax request succeeded.", response); // 確認Ajax請求成功並列印回應

                        // 在獲得回應後處理結果
                        if (response.exists) {
                            // 如果暱稱已經被註冊，顯示警告
                            console.log("Nickname exists."); // 確認暱稱已存在
                            Swal.fire({
                                title: "此暱稱已經被使用！",
                                confirmButtonColor: "#70c6e3",
                                icon: "warning",
                            });
                            register_step(null, 2); // 保持在暱稱填寫頁面
                            $("#step_3_btn").prop("disabled", true);
                        } else {
                            console.log("Nickname is available."); // 確認暱稱可以使用
                            $("#step_3_btn").prop("disabled", false);
                            register_step(null, 3); // 跳到下一頁選擇性別
                        }
                    },
                    error: function (error) {
                        console.error("Ajax請求出錯：", error);
                    },
                });
            });
        });
        if (step_index == 3) {
            //有一題僅是介紹描述 無須填寫記錄資料，直接啟用按鈕並下一步並變更背景圖片
            $(this).next().find(".step-next-btn").attr("disabled", false);
            $(this).next().find(".step-next-btn").click();
            step_id = $(this)
                .next()
                .find(".step-next-btn")
                .data("bs-target")
                .substring(6);
            $("body").css(
                "background-image",
                `url('${bg_path + step_id}.png')`
            );
        }
        if (input_obj_arr.length > 0) {
            let obj_key = $(input_obj_arr).eq(0).get(0).name;
            //取得input值 並以「，」組合成字串格式
            let obj_value = $(input_obj_arr)
                .map(function () {
                    if (this.value != "") return this.value;
                })
                .get()
                .join(",");

            if ([0, 1, 4, 5].includes(step_index) == true) {
                //以上 step_index題型皆屬於input填值，另分出來取值
                if (step_index == 0 || step_index == 5) {
                    //步驟1:設定密碼題 & 步驟5:身高體重題
                    //有兩個input 把string切分成arr，以便後續儲存
                    obj_values = obj_value.split(",");
                }
                if (
                    obj_value == "" ||
                    (step_index == 5 && obj_values.length < 2)
                ) {
                    //當遇到空值or身高體重題 兩個input其中之一未填，返回提示
                    Swal.fire({
                        title: `請勿填空`,
                        text: "請再檢查必要欄位是否確實有填寫！",
                        confirmButtonColor: "#70c6e3",
                    });
                } else if (step_index == 0) {
                    //步驟1:設定密碼題
                    if (
                        !obj_values[0].match(pwd_rule) &&
                        !obj_values[1].match(pwd_rule)
                    ) {
                        // 若未符合密碼規則，返回提示
                        Swal.fire({
                            title: `密碼須符合規則`,
                            text: "請再檢查必要欄位是否確實有填寫！",
                            confirmButtonColor: "#70c6e3",
                            icon: "warning",
                        });
                    } else if (obj_values[0] != obj_values[1]) {
                        // 若密碼與確認密碼輸入不相同，返回提示
                        Swal.fire({
                            title: `請重新確認密碼`,
                            text: "密碼不相同，請再檢查並重新輸入！",
                            confirmButtonColor: "#70c6e3",
                            icon: "warning",
                        });
                    } else is_write = true;
                } else is_write = true;
            } else if (
                [2, 6, 7, 8, 9, 10, 11, 12, 13].includes(step_index) == true
            ) {
                // let input_val_arr = obj_value.split(",");

                if (step_index == 13) {
                    //步驟13:個人姓名、電話、ˋ地址題
                    if ($(`input[name='user_name']`).val() == "") {
                        //步驟13完成 檢查姓名有無填寫
                        Swal.fire({
                            title: `請勿填空`,
                            text: "請再檢查必要欄位是否確實有填寫！",
                            confirmButtonColor: "#70c6e3",
                        });
                    } else is_write = true;
                } else {
                    //step_index = 2, 6, 7, 8, 9, 10, 11, 12 皆屬選項題型(含單複選)
                    //取得選取(checked)值 並以「，」組合成字串格式
                    obj_value = $(`input[name='${obj_key}']:checked`)
                        .map(function () {
                            if (this.value != "") return this.value;
                        })
                        .get()
                        .join(",");

                    if (obj_value == "") {
                        //如果未選取、空值，則返回提示
                        Swal.fire({
                            title: `請勿填空`,
                            text: "請再檢查必要欄位是否確實有填寫！",
                            confirmButtonColor: "#70c6e3",
                        });
                    } else {
                        if (obj_value.includes("1")) {
                            // 第9-12題 答"有"的話，需要檢查有無填寫備註
                            other_text = $(
                                `input[name='${obj_key}'][id$='other']`
                            ).val();
                            console.log("other_text:", other_text);

                            if (other_text == "") {
                                Swal.fire({
                                    title: `請勿填空`,
                                    text: "選「有」的話，請記得填寫描述！",
                                    confirmButtonColor: "#70c6e3",
                                });
                            } else {
                                if (step_index == 11) {
                                    // 步驟11: 病史題 將其他填寫選項接寫在病史字串後
                                    obj_value = obj_value.replace(
                                        /1(,|$)/,
                                        `${other_text}$1`
                                    );
                                    // 如果 obj_value 原本是以 "1" 結尾，則用 "other_text" 替代
                                    if (obj_value.endsWith(",1")) {
                                        obj_value =
                                            obj_value.slice(0, -2) +
                                            `, ${other_text}`;
                                    }
                                } else {
                                    obj_value += `, ${other_text}`;
                                }
                                is_write = true;
                            }
                        } else {
                            is_write = true;
                        }
                    }
                }
            }

            if (is_write == true) {
                //確認有填寫資料後
                $(this).next().find(".step-next-btn").attr("disabled", false); //啟用上下步按紐
                sessionStorage.setItem(obj_key, obj_value); //儲存至session
                console.log(sessionStorage.getItem(obj_key));
                register_info[obj_key] = obj_value; //儲存成json
                console.log(register_info[obj_key]);

                if (step_index == 5) {
                    //身高體重題
                    obj_value = obj_value.split(",");
                    register_info["user_height"] = obj_value[0];
                    register_info["user_weight"] = obj_value[1];
                }
                if (step_index == 11) {
                    //其他病史
                    register_info["other_disease"] = $(
                        `input[name='user_other_disease_state']`
                    ).val();
                }
                if (step_index == 13) {
                    //姓名電話地址題
                    register_info["user_password"] = $(
                        `input[name='user_password']`
                    ).val();
                    register_info["user_name"] = $(
                        `input[name='user_name']`
                    ).val();
                    register_info["user_phone"] = $(
                        `input[name='user_phone']`
                    ).val();
                    register_info["user_address"] = $(
                        `input[name='user_address']`
                    ).val();
                }
                if (obj_key == "user_nickname") {
                    //已填寫會員暱稱，返回前端顯示
                    $("#nickname").html(obj_value);
                }
                if (obj_key == "user_birthday") {
                    //已填寫會員生日，(年紀)返回前端顯示
                    let age = now_year - parseInt(obj_value.substring(0, 4)); //計算年紀
                    $("#age").html(age);
                    sessionStorage.setItem("user_age", age);
                    register_info["user_age"] = age;
                }

                if (step_index == 6) {
                    //步驟6完成 檢查性別跳過問題
                    if (register_info.user_sex == "male") {
                        //如果性別選男性 上下步驟按鈕修改步驟index，可以使男性略過不需回答的問題
                        $(".step-btn").each(function (i, btn) {
                            let step_id = parseInt(
                                $(btn).data("bs-target").substring(6)
                            );
                            if (step_id == 7) {
                                $(btn).attr("data-bs-target", "#step_9");
                            }
                            if (i == 18) {
                                $(btn).attr("data-bs-target", "#step_6");
                            }
                            if (step_id == 9) {
                                $(btn).attr("disabled", false);
                                $(btn).click();
                            }
                        });
                    } else {
                        //如果性別選女性 上下步驟按鈕也需重新修改步驟index 以及更新背景圖片
                        $(".step-btn").each(function (i, btn) {
                            let step_id = parseInt(
                                $(btn).data("bs-target").substring(6)
                            );
                            if (i == 13) {
                                $(btn).attr("data-bs-target", "#step_7");
                            }
                            if (i == 18) {
                                $(btn).attr("data-bs-target", "#step_8");
                            }
                        });
                        step_id = $(this)
                            .next()
                            .find(".step-next-btn")
                            .data("bs-target")
                            .substring(6);
                        $("body").css(
                            "background-image",
                            `url('${bg_path + step_id}.png')`
                        );

                        $(this).next().find(".step-next-btn").click();
                    }
                } else if (step_index == 13) {
                    //已填寫所有資料，最後統整成步驟14的信件內容
                    //將這些資料返回顯示於前端頁面中
                    $("#password").html(register_info.user_password); //密碼
                    $("#gender").html(register_info.user_sex); //性別
                    $("#phone").html(register_info.user_phone); //手機
                    $("#name").html(register_info.user_name); //用戶真實姓名
                    $("#address").html(register_info.user_address); //地址
                    $("#today").html(now_today); //信件當天日期
                    $("#nickname2").html(register_info.user_nickname); //收件人暱稱
                    $("#age2").html(register_info.user_age); //年紀
                    $("#birthday").html(register_info.user_birthday); //生日
                    $("#height").html(register_info.user_height); //身高
                    $("#weight").html(register_info.user_weight); //體重
                    $("#drug").html(register_info.user_drug); //藥物
                    // $("#drug_all").html(register_info.user_drug_all); //藥物

                    if (register_info.user_sex == "male") {
                        //如果為男性 直接隱藏女性問題的區塊
                        $(".onyly-show-famele").hide();
                    }
                    //婚姻狀態 如未選0(無) 需於註冊信中顯示已填寫資料，下列皆相同作法
                    if (register_info.user_married_state != "0")
                        $("#married_state").html(
                            register_info.user_married_state
                        );
                    //懷孕狀態
                    if (register_info.user_pregnant_state != "0")
                        $("#pregnant_state").html(
                            register_info.user_pregnant_state
                        );
                    //生育計畫
                    if (register_info.user_birth_plan != "0")
                        $("#birth_plan").html(register_info.user_birth_plan);
                    //疾病病史
                    $("#disease").html("");
                    if (register_info.user_disease_state != "0")
                        $("#disease").html(
                            "有" + register_info.user_disease_state
                        );
                    //過敏狀況
                    $("#allergy_state").html("");
                    if (register_info.user_allergy_state != "0")
                        $("#allergy_state").html(
                            "，對" +
                                register_info.user_allergy_state.replace(
                                    "1,",
                                    ""
                                ) +
                                "過敏"
                        );
                    //醫生醫囑
                    $("#order").html("");
                    if (register_info.user_order_state != "0")
                        $("#order").html(
                            "，醫生有特別說" +
                                register_info.user_order_state.replace("1,", "")
                        );
                    //用藥狀況
                    $("#drug").html("");
                    if (register_info.user_drug_state != "0")
                        $("#drug").html(
                            "，需要吃" +
                                register_info.user_drug_state.replace("1,", "")
                        );
                    //其他病史
                    if (
                        register_info.other_disease != "" &&
                        typeof register_info.other_disease != "undefined"
                    )
                        $("#other_disease").html(
                            "," + register_info.other_disease
                        );

                    $("#username").html(register_info.user_name); //註冊者姓名
                    step_id = $(this)
                        .next()
                        .find(".step-next-btn")
                        .data("bs-target")
                        .substring(6);
                    $("body").css(
                        "background-image",
                        `url('${bg_path + step_id}.png')`
                    ); //更換成對應的背景
                    $(this).next().find(".step-next-btn").click();
                } else {
                    //如果並非註冊填寫資料的最後一步(步驟13)，更換成對應背景&跳下一個步驟頁
                    step_id = $(this)
                        .next()
                        .find(".step-next-btn")
                        .data("bs-target")
                        .substring(6); //取得當前下一步按紐，並取得bs-target屬性資料前往下個步驟id
                    $("body").css(
                        "background-image",
                        `url('${bg_path + step_id}.png')`
                    );
                    $(this).next().find(".step-next-btn").click();
                    //每到下一題 讓網頁位置回到頂端置頂
                    document.body.scrollTop = 0; // For Safari
                    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                }
            }
        }
        console.log("Now step id:" + step_id);
    });
});

//上下按鈕 onclick 跳到對應的步驟頁
function register_step(obj, step_num) {
    let step_id = 0;
    if (step_num != null) {
        $(".step-btn").each(function (i, btn) {
            step_id = parseInt($(btn).attr("data-bs-target").substring(6));
            $("body").css(
                "background-image",
                `url('${bg_path + step_id}.png')`
            );
            if (step_id == step_num) {
                $(btn).click();
            }
        });
    }
    if ($(obj).attr("data-bs-target")) {
        step_id = parseInt($(obj).attr("data-bs-target").substring(6));
        $("body").css("background-image", `url('${bg_path + step_id}.png')`);
    }

    setTimeout(() => {
        $(obj).eq(0).removeClass("active");
    }, "1000");
}

/* 會員登入頁 */
function facebook_login() {
    //api串接
}
function line_login() {
    //api串接
}

var verification_code;

function resetButton() {
    $("#chk_sub_btn")
        .removeAttr("disabled")
        .text("發送驗證碼")
        .css("cursor", "pointer");
}

function resetButtonWithDelay() {
    var sec = 60;
    const timer = setInterval(function () {
        if (sec > 0) {
            $("#chk_sub_btn").text("剩" + sec + "秒");
            sec--;
        } else {
            clearInterval(timer);
            resetButton();
        }
    }, 1000);
}

$("#chk_sub_btn").on("click", function () {
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var email = $("#user_email").val();
    var email_rule = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // 檢查電子郵件格式是否正確
    if (!email.match(email_rule)) {
        $("#user_email_alert").removeClass("d-none").text("電子信箱格式錯誤");
        return;
    } else {
        $("#user_email_alert").addClass("d-none"); // 隱藏提示
    }

    // 禁用按鈕防止重複請求
    $("#chk_sub_btn")
        .attr("disabled", "disabled")
        .text("傳送中")
        .css("cursor", "default");

    // 使用 fetch 發送郵件驗證請求
    verification_code = String(Math.floor(Math.random() * 1000000)).padStart(
        6,
        "0"
    );
    var formdata = new FormData();
    formdata.append("verification_code", verification_code); // 新增驗證碼
    var requestOptions = {
        method: "POST",
        headers: new Headers(),
        body: formdata,
    };
    fetch(apiIP + "api/auth/forget_password/" + email + "/", requestOptions)
        .then((response) => response.json())
        .then((data) => {
            if (data["result"] == "success") {
                // 使用 fetch 發送驗證碼到後端
                // 在 POST 請求中添加 CSRF token
                fetch("/chkmail", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        user_name: email,
                        verification_code: verification_code,
                    }),
                })
                    .then((response) => {
                        if (response.ok) {
                            // 顯示成功提示
                            Swal.fire({
                                title: "已發送驗證碼到您的信箱",
                                icon: "success",
                                confirmButtonColor: "#70c6e3",
                                showConfirmButton: false,
                                timer: 2500,
                            });
                            resetButtonWithDelay(); // 延遲重置按鈕
                        } else {
                            throw new Error("發送驗證碼失敗");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        Swal.fire({
                            icon: "error",
                            title: "發送失敗，請檢查您的信箱",
                            confirmButtonColor: "#70c6e3",
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        resetButton();
                    });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "無法發送驗證碼",
                    text: "請檢查您的郵件地址或稍後再試",
                    showConfirmButton: false,
                    timer: 2500,
                });
                resetButton();
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "伺服器錯誤！",
                text: "請稍後再試。",
                showConfirmButton: false,
                timer: 2500,
            });
            resetButton();
        });
});

function forget_password() {
    let email = document.getElementById("user_email").value;
    let entered_verification_code = document.getElementById("chkmsg").value; // 用戶輸入的驗證碼
    let new_password = document.getElementById("new_password").value;
    let confirm_password = document.getElementById("check_password").value;

    let pwd_rule = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/; // 密碼規則
    let has_error = false;

    // 檢查電子郵件格式
    let email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.match(email_regex)) {
        document.getElementById("user_email_alert").classList.remove("d-none");
        has_error = true;
    } else {
        document.getElementById("user_email_alert").classList.add("d-none");
    }

    // 驗證碼是否一致
    if (entered_verification_code !== verification_code) {
        document.getElementById("new_chkmsg_alert").classList.remove("d-none");
        document.getElementById("new_chkmsg_alert").textContent =
            "驗證碼輸入錯誤";
        has_error = true;
    } else {
        document.getElementById("new_chkmsg_alert").classList.add("d-none");
    }

    // 檢查新密碼是否符合規則
    if (!new_password.match(pwd_rule)) {
        document.getElementById("new_pwd_alert").classList.remove("d-none");
        has_error = true;
    } else {
        document.getElementById("new_pwd_alert").classList.add("d-none");
    }

    // 檢查新密碼與確認密碼是否一致
    if (new_password !== confirm_password) {
        document.getElementById("check_pwd_alert").classList.remove("d-none");
        has_error = true;
    } else {
        document.getElementById("check_pwd_alert").classList.add("d-none");
    }

    // 如果有錯誤，停止提交
    if (has_error) {
        return;
    }

    // 提交表單，這裡你可以用 Ajax 發送新密碼到後端
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var formdata = new FormData();
    formdata.append("password", new_password);
    formdata.append("verification_code", verification_code); // 新增驗證碼

    var requestOptions = {
        method: "POST",
        headers: new Headers(),
        body: formdata,
    };
    fetch(apiIP + "api/auth/update_password/" + email + "/", requestOptions)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            if (data["result"] == "success") {
                Swal.fire({
                    title: "密碼修改成功！",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2500,
                });
                window.location.reload();
            } else {
                if (data["error"] == "verification code") {
                    Swal.fire({
                        icon: "error",
                        title: "驗證碼輸入錯誤",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "密碼修改失敗",
                        text: data.message || "請稍後再試。",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "伺服器錯誤！",
                text: "請稍後再試。",
                showConfirmButton: false,
                timer: 2500,
            });
        });
}

//會員資料
function user_data() {
    document
        .getElementById("register_form")
        .addEventListener("submit", function (event) {
            var checkBox = document.getElementById("mail_confirm_check");
            // if (checkBox) {
            //     // checkBox 存在，執行相應的操作
            //     console.log("成功獲取到checkBox元素");
            //     event.preventDefault(); // 阻止表單提交
            // } else {
            //     // checkBox 不存在，執行相應的操作
            //     console.log("未找到checkBox元素");
            //     event.preventDefault(); // 阻止表單提交
            // }
            if (checkBox.checked == false) {
                alert("請同意服務條款及隱私權政策");
                event.preventDefault(); // 阻止表單提交
            } else {
                var username = $("#name").text();
                document.getElementById("return_user_name").value = username; //真實姓名
                var nickname2 = $("#nickname2").text();
                document.getElementById("return_nickname2").value = nickname2; //用戶暱稱
                var password = $("#password").text();
                document.getElementById("return_user_password").value =
                    password; //密碼

                var birthday = $("#birthday")
                    .text()
                    .replace("/", "-")
                    .replace("/", "-");
                document.getElementById("return_birthday").value = birthday; //生日
                var age = $("#age2").text();
                document.getElementById("return_user_age").value = age; //年齡
                var gender = $("#gender").text();
                if (gender === "男性") {
                    $("#gender").text("name");
                } else if (gender === "女性") {
                    $("#gender").text("feman");
                }
                // 設置性別值到 return_user_gender 元素
                document.getElementById("return_user_gender").value = gender; //性別
                var height = $("#height").text();
                document.getElementById("return_height").value = height; //身高
                var weight = $("#weight").text();
                document.getElementById("return_weight").value = weight; //體重
                var married_state = $("#married_state").text();
                document.getElementById("return_married_state").value =
                    married_state; //婚姻狀況
                var pregnant_state = $("#pregnant_state").text();
                document.getElementById("return_pregnant_state").value =
                    pregnant_state; //懷孕狀況
                var birth_plan = $("#birth_plan").text();
                document.getElementById("return_birth_plan").value = birth_plan; //生育計畫
                var disease = $("#disease").text().replace("有", "");
                document.getElementById("return_disease").value = disease; //病史
                var disease = $("#other_disease").text().replace(",", "");
                document.getElementById("return_other_disease").value = disease; //其他病史
                var allergy_state = $("#allergy_state")
                    .text()
                    .replace("，對", "")
                    .replace("過敏", ""); //過敏
                document.getElementById("return_allergy_state").value =
                    allergy_state;
                var order = $("#order").text().replace("，醫生有特別說", ""); //醫囑
                document.getElementById("return_order").value = order;
                var drug = $("#drug").text().replace("，需要吃", "");
                document.getElementById("return_drug").value = drug; //用藥
                var phone = $("#phone").text();
                document.getElementById("return_phone").value = phone; //電話
                var address = $("#address").text();
                document.getElementById("return_address").value = address; //地址
                var today = $("#today").text();
                document.getElementById("return_today").value = today; //註冊日期
            }
        });
}
