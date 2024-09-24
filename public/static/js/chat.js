var token = $("#jwt_token").text();
let current_chat_tab = "";
let previous_chat_tab = "";
var socketIP = document
    .getElementById("app")
    .getAttribute("data-api-ip")
    .split("//")[1];
var socket2 = new WebSocket(
    "ws://" + socketIP + "ws/chat/room2/?token=" + token
);
var socket3 = new WebSocket(
    "ws://" + socketIP + "ws/chat/room3/?token=" + token
);
var socket4 = new WebSocket(
    "ws://" + socketIP + "ws/chat/room4/?token=" + token
);
var socket5 = new WebSocket(
    "ws://" + socketIP + "ws/chat/room5/?token=" + token
);
var socket6 = new WebSocket(
    "ws://" + socketIP + "ws/chat/room6/?token=" + token
);
var previous_chat2 = null;
var previous_chat3 = null;
var previous_chat4 = null;
var previous_chat5 = null;
var previous_chat6 = null;

$(document).ready(function () {
    if (previous_chat2 == null) {
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var requestOptions = {
            method: "GET",
            headers: myHeaders,
        };

        previous_chat2 = [getPreviousChat("chat-room2")];
        Promise.all(previous_chat2).then((data) => {
            data[0].forEach((chat) => {
                if (chat["is_user"]) {
                    show_msg(
                        "user",
                        "chat-room2",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                } else {
                    show_msg(
                        "other",
                        "chat-room2",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                }
            });
        });
    }
    if (previous_chat3 == null) {
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var requestOptions = {
            method: "GET",
            headers: myHeaders,
        };

        previous_chat3 = [getPreviousChat("chat-room3")];
        Promise.all(previous_chat3).then((data) => {
            data[0].forEach((chat) => {
                if (chat["is_user"]) {
                    show_msg(
                        "user",
                        "chat-room3",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                } else {
                    show_msg(
                        "other",
                        "chat-room3",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                }
            });
        });
    }
    if (previous_chat4 == null) {
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var requestOptions = {
            method: "GET",
            headers: myHeaders,
        };

        previous_chat4 = [getPreviousChat("chat-room4")];
        Promise.all(previous_chat4).then((data) => {
            data[0].forEach((chat) => {
                if (chat["is_user"]) {
                    show_msg(
                        "user",
                        "chat-room4",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                } else {
                    show_msg(
                        "other",
                        "chat-room4",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                }
            });
        });
    }

    if (previous_chat5 == null) {
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var requestOptions = {
            method: "GET",
            headers: myHeaders,
        };

        previous_chat5 = [getPreviousChat("chat-room5")];
        Promise.all(previous_chat5).then((data) => {
            data[0].forEach((chat) => {
                if (chat["is_user"]) {
                    show_msg(
                        "user",
                        "chat-room5",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                } else {
                    show_msg(
                        "other",
                        "chat-room5",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                }
            });
        });
    }
    if (previous_chat6 == null) {
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var requestOptions = {
            method: "GET",
            headers: myHeaders,
        };

        previous_chat6 = [getPreviousChat("chat-room6")];
        Promise.all(previous_chat6).then((data) => {
            data[0].forEach((chat) => {
                if (chat["is_user"]) {
                    show_msg(
                        "user",
                        "chat-room6",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                } else {
                    show_msg(
                        "other",
                        "chat-room6",
                        chat["id"],
                        chat["identity"],
                        chat["message"],
                        chat["user_image"],
                        dayjs(chat["created_at"])
                    );
                }
            });
        });
    }

    // 取得使用者目前點選的聊天室分類
    $(".chats-nav-tab a").on("shown.bs.tab", function (e) {
        current_chat_tab = e.target;
        previous_chat_tab = e.relatedTarget;
    });

    $(".chat_name").on("change", function () {
        var name = $(this).val();
        $(".chat_name").val(name);
    });

    // 監聽 socket
    socket2.onmessage = function (e) {
        var data = JSON.parse(e.data);
        var id = data["id"];
        var identity = data["identity"];
        var msg = data["message"];
        var user_image = data["user_image"];
        if (user != data["user"] && !blacklist["chat"].includes(data["user"])) {
            show_msg("other", "chat-room2", id, identity, msg, user_image); //接收訊息
        }
    };
    socket3.onmessage = function (e) {
        var data = JSON.parse(e.data);
        var id = data["id"];
        var identity = data["identity"];
        var msg = data["message"];
        var user_image = data["user_image"];
        if (user != data["user"] && !blacklist["chat"].includes(data["user"])) {
            show_msg("other", "chat-room3", id, identity, msg, user_image); //接收訊息
        }
    };
    socket4.onmessage = function (e) {
        var data = JSON.parse(e.data);
        var id = data["id"];
        var identity = data["identity"];
        var msg = data["message"];
        var user_image = data["user_image"];
        if (user != data["user"] && !blacklist["chat"].includes(data["user"])) {
            show_msg("other", "chat-room4", id, identity, msg, user_image); //接收訊息
        }
    };
    socket5.onmessage = function (e) {
        var data = JSON.parse(e.data);
        var id = data["id"];
        var identity = data["identity"];
        var msg = data["message"];
        var user_image = data["user_image"];
        if (user != data["user"] && !blacklist["chat"].includes(data["user"])) {
            show_msg("other", "chat-room5", id, identity, msg, user_image); //接收訊息
        }
    };
    socket6.onmessage = function (e) {
        var data = JSON.parse(e.data);
        var id = data["id"];
        var identity = data["identity"];
        var msg = data["message"];
        var user_image = data["user_image"];
        if (user != data["user"] && !blacklist["chat"].includes(data["user"])) {
            show_msg("other", "chat-room6", id, identity, msg, user_image); //接收訊息
        }
    };

    // 監聽聊天室輸入框的 keydown 事件
    $(".publisher-input").keydown(function (e) {
        // 如果按下的是 Enter 鍵 (key code 13)
        if (e.keyCode == 13) {
            let chat_room = "";
            // 判斷當前的聊天室分類
            if (current_chat_tab != "") {
                chat_room = $(current_chat_tab).attr("href").replace("#", "");
            } else {
                chat_room = "chat-room1";
            }

            user_send_msg(chat_room); //發送訊息
        }
    });
});

async function getPreviousChat(room) {
    var token = $("#jwt_token").text();
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var requestOptions = {
        method: "GET",
        headers: myHeaders,
    };

    return fetch(apiIP + "api/chat/getPrevious/?room=" + room, requestOptions)
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log(data);
            return data;
        });
}

// 顯示頭像與訊息文字
function show_msg(
    action,
    chat_room,
    id = null,
    name = null,
    msg = null,
    user_image = null,
    datetime = dayjs()
) {
    if (nickname != "") {
        if (action === "user") {
            // 前端對話框模板
            var chatMedia = document.createElement("div");
            chatMedia.id = "chat_" + id;
            chatMedia.className = "media media-chat media-chat-reverse";

            var mediaBody = document.createElement("div");
            mediaBody.className = "media-body";

            // Message
            if (msg === null) {
                var msg = $(`#${chat_room} .publisher-input`).val();
            }
            var paragraphElement = document.createElement("p");
            paragraphElement.innerHTML = msg;
            mediaBody.appendChild(paragraphElement);

            // Time
            var timeElement = document.createElement("p");
            timeElement.className = "meta";
            var time = document.createElement("time");
            var date = datetime;
            time.dateTime = date;
            time.innerHTML = date.format("MM/DD HH:mm");
            time.style.fontSize = "var(--fs-15)"; // 字体大小
            time.style.color = "#696969";
            timeElement.appendChild(time);
            mediaBody.appendChild(timeElement);
        } else {
            const apiIP = document
                .getElementById("app")
                .getAttribute("data-api-ip");

            // 前端對話框模板
            var chatMedia = document.createElement("div");
            chatMedia.id = "chat_" + id;
            chatMedia.className = "media media-chat";

            var avatarImg = document.createElement("img");
            avatarImg.className = "avatar";
            avatarImg.src = apiIP + user_image;
            avatarImg.alt = "...";

            var mediaBody = document.createElement("div");
            mediaBody.className = "media-body";
            // 若聊天有跨日(比如:隔夜凌晨) 顯示時間 (有空做)
            // var dayElement = document.createElement("div");
            // dayElement.className = "media media-meta-day";
            // <div class="media media-meta-day">Today</div>
            // Nickname
            var nameElement = document.createElement("p");
            nameElement.className = "meta";
            nameElement.innerHTML = name;
            mediaBody.appendChild(nameElement);

            // Message
            var paragraphElement = document.createElement("div");
            paragraphElement.className = "row";
            var msgElement = document.createElement("p");
            msgElement.className = "msg";
            msgElement.innerHTML = msg;
            paragraphElement.appendChild(msgElement);
            var buttonElement = document.createElement("button");
            buttonElement.onclick = function () {
                open_denounce(this, "chat", id);
            };
            buttonElement.className = "btn btn-sm p-0";
            var iElement = document.createElement("i");
            iElement.className = "fa fa-exclamation-circle fa-sm";
            buttonElement.appendChild(iElement);
            paragraphElement.appendChild(buttonElement);
            mediaBody.appendChild(paragraphElement);

            //Time
            var timeElement = document.createElement("p");
            timeElement.className = "meta";
            var time = document.createElement("time");
            var date = datetime;
            time.dateTime = date;
            time.innerHTML = date.format("MM/DD HH:mm");
            time.style.fontSize = "var(--fs-15)"; // 字体大小
            time.style.color = "#696969";
            timeElement.appendChild(time);
            mediaBody.appendChild(timeElement);

            chatMedia.appendChild(avatarImg);
        }
        chatMedia.appendChild(mediaBody);
        // 將 chatMedia 元素添加到 .chat_content 的 div 內
        // 目前預設為營養師諮詢(chat-room1)，如果是其他聊天室 將chat-room1 改成 2 or 3
        var container = $(`#${chat_room} .ps-container`).eq(0);
        container.append(chatMedia);
        container.scrollTop(container.prop("scrollHeight"));
    }
}

// 用戶方(media-chat-reverse) 顯示發送訊息文字
function user_send_msg(chat_room) {
    if (banlist["chat"] == true) {
        show_msg("user", chat_room);

        // 廣播訊息至聊天室
        var identity = $(".chat_name").val();
        var msg = $(`#${chat_room} .publisher-input`).val();
        // console.log(chat_room, user, identity, msg);
        if (chat_room == "chat-room2") {
            socket2.send(
                JSON.stringify({
                    action: "chat",
                    room: chat_room,
                    identity: identity,
                    message: msg,
                    user_image: user_image,
                })
            );
        } else if (chat_room == "chat-room3") {
            socket3.send(
                JSON.stringify({
                    action: "chat",
                    room: chat_room,
                    user: user,
                    identity: identity,
                    message: msg,
                    user_image: user_image,
                })
            );
        } else if (chat_room == "chat-room4") {
            socket4.send(
                JSON.stringify({
                    action: "chat",
                    room: chat_room,
                    user: user,
                    identity: identity,
                    message: msg,
                    user_image: user_image,
                })
            );
        } else if (chat_room == "chat-room5") {
            socket5.send(
                JSON.stringify({
                    action: "chat",
                    room: chat_room,
                    user: user,
                    identity: identity,
                    message: msg,
                    user_image: user_image,
                })
            );
        } else if (chat_room == "chat-room6") {
            socket6.send(
                JSON.stringify({
                    action: "chat",
                    room: chat_room,
                    identity: identity,
                    message: msg,
                    user_image: user_image,
                })
            );
        }

        //輸入框文字清空
        $(`#${chat_room} .publisher-input`).val("");
    } else if (banlist["chat"] != true) {
        banerror(banlist["chat"]);
    } else {
        Swal.fire({
            title: "你已被禁言！",
            html:
                "因您於短時間內收到多次檢舉，故系統於 " +
                dayjs(banlist["chat"][1]).format("YYYY-MM-DD HH:mm:ss") +
                " 起 自動禁言24小時我們將同步進行人工審核，若造成不便請見諒，謝謝",
            icon: "error",
            showConfirmButton: true, // 顯示確認按鈕
            allowOutsideClick: false, // 禁止點擊外部關閉
            allowEscapeKey: false, // 禁止按 ESC 鍵關閉
            confirmButtonText: "確定", // 確認按鈕文字
        });
    }
}
