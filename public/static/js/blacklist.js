var cate;
var den_id;
var obj;
var reason;
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function open_denounce(o, c, i) {
    if (nickname != "") {
        obj = o;
        cate = c;
        den_id = i;
        $("#denounce").modal("show");
    } else {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "請先登入!",
            showConfirmButton: false,
            timer: 2500,
        });
    }
}

$("input[name='reason']").on("change", function () {
    reason = $(this).val();
    if (reason == "其他") {
        $("#reason_other").show();
    } else {
        $("#reason_other").hide();
    }
});

$("#reason_other").on("change", function () {
    reason = $(this).val();
});

function denounce() {
    console.log(cate, den_id, reason);
    if (reason != null) {
        $("#denounce").modal("hide");
        $(obj).closest(".media-chat").remove();

        //傳後端
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var formdata = new FormData();
        formdata.append(cate, den_id);
        formdata.append("reason", reason);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
        };

        fetch(apiIP + "api/blacklist/blacklist/", requestOptions).then(
            (response) => {
                if (response.ok) {
                    if (cate == "comment") {
                        // 即時刪除留言
                        const commentElement = document.getElementById(
                            `comment_${den_id}`
                        );
                        if (commentElement) {
                            commentElement.remove();
                        }
                    } else if (cate == "chat") {
                        // 即時刪除聊天室訊息
                        const chatMessageElement = document.getElementById(
                            `chat_${den_id}`
                        );
                        if (chatMessageElement) {
                            chatMessageElement.remove();
                        }
                    } else if (cate == "post") {
                        // 檢舉文章後即時跳回文章列表
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "檢舉成功，返回文章列表",
                            showConfirmButton: false,
                            timer: 2000,
                        }).then(() => {
                            window.history.back();
                        });
                    }
                    // 非文章顯示
                    if (cate !== "post") {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "檢舉成功!",
                            showConfirmButton: false,
                            timer: 2500,
                        });
                    }
                    // 重置變量
                    cate = null;
                    den_id = null;
                    reason = null;
                    obj = null;
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "檢舉失敗!",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
            }
        );
    } else {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "請填寫檢舉原因!",
            showConfirmButton: false,
            timer: 2500,
        });
    }
}

function banerror(ban) {
    Swal.fire({
        title: "你已被禁言！",
        html:
            "經人工審核，因您之前的檢舉違反社群規範，故系統於 " +
            dayjs(ban[1]).format("YYYY-MM-DD HH:mm:ss") +
            " 起 " +
            ban[0] +
            "。若有任何問題，請來信客服信箱，謝謝。",
        icon: "error",
        allowOutsideClick: false, // 禁止點擊外部關閉
        allowEscapeKey: false, // 禁止按 ESC 鍵關閉
        confirmButtonText: "確定", // 確認按鈕文字
        confirmButtonColor: "#d33",
        didOpen: function () {
            Swal.getConfirmButton().blur();
        },
    });
}
