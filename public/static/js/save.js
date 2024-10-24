/// 文章收藏列表頁

function openBookmark(post_id) {
    var token = $("#jwt_token").text();
    if (token == "") {
        Swal.fire({
            title: "無法收藏",
            html: "請先登入!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
        });
    } else {
        $("#bookmark_collect").modal("toggle");
        $("#post_id").val(post_id);
        postStorageds.forEach((element) => {
            if (element.post.includes(post_id)) {
                $("#postStoraged_" + element.storage_name)
                    .find(".plus-btn i")
                    .removeClass("fa-plus");
                $("#postStoraged_" + element.storage_name)
                    .find(".plus-btn i")
                    .addClass("fa-check-circle");
            } else {
                $("#postStoraged_" + element.storage_name)
                    .find(".plus-btn i")
                    .removeClass("fa-check-circle");
                $("#postStoraged_" + element.storage_name)
                    .find(".plus-btn i")
                    .addClass("fa-plus");
            }
        });
        if (
            $("#article_id_" + post_id + " .openBookmark")
                .find("i")
                .hasClass("far")
        ) {
            article_saved(post_id, "不分類收藏");
        }
    }
}

//新增文章分類
$("#add_saved_btn").click(async function () {
    var modalNode = document.querySelector('.modal[tabindex="-1"]');
    modalNode.removeAttribute("tabindex");
    modalNode.classList.add("js-swal-fixed");
    const { value: storage_name } = await Swal.fire({
        title: "請輸入收藏分類",
        input: "text",
        inputLabel: "輸入收藏分類名稱",
        showCancelButton: true,
        confirmButtonText: "確定",
        cancelButtonText: "取消",
        confirmButtonColor: "#70c6e3",
        inputValidator: (value) => {
            if (!value) {
                return "請勿填空，務必確實填寫！";
            }
        },
    });
    var modalNode = document.querySelector(".modal.js-swal-fixed");
    modalNode.setAttribute("tabindex", "-1");
    modalNode.classList.remove("js-swal-fixed");
    if (storage_name) {
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);
        var formdata = new FormData();
        formdata.append("storage_name", storage_name);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
        };

        fetch(apiIP + "api/userdetail/postStoraged/", requestOptions)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                // console.log(data);

                // 检查是否存在 #postStorageds 元素
                var container = $("#postStorageds");
                if (postStorageds.length == 1) {
                    var container = $("#bookmark_collect .modal-body");
                    var Element = document.createElement("div");
                    Element.id = "postStorageds";
                    Element.className =
                        "row d-flex justify-content-center mt-3 border-top";
                    container.append(Element); // 添加标题元素
                    var container = $("#postStorageds");
                    // 第一次新增分组时刷新 modal-content 这个 div
                    // 创建标题元素
                    var titleElement = document.createElement("h1");
                    titleElement.className = "fs-5 text-center";
                    titleElement.textContent = "收藏分類";
                    container.append(titleElement);
                }

                var divElement = document.createElement("div");
                divElement.id = "postStoraged_" + storage_name;
                divElement.className = "col-auto text-center mb-3 postStoraged";

                var imgElement = document.createElement("img");
                imgElement.src = "https://placehold.co/180x130";
                imgElement.class = "rounded mx-auto d-block";
                imgElement.alt = storage_name;
                divElement.appendChild(imgElement);

                var rowElement = document.createElement("div");
                rowElement.className = "row";

                var pElement = document.createElement("p");
                pElement.className = "col-auto ms-1 saved-title ps-0";
                pElement.innerHTML = storage_name;
                rowElement.appendChild(pElement);

                if ($("#new_saved").length == 0) {
                    var plusaElement = document.createElement("button");
                    plusaElement.className =
                        "col-2 btn plus-btn float-end m-0 p-0";
                    plusaElement.onclick = function () {
                        article_saved(data, storage_name);
                    };
                    var plusiElement = document.createElement("i");
                    plusiElement.className = "fas fa-plus ct-txt-2 p-1";
                    plusaElement.appendChild(plusiElement);
                    rowElement.appendChild(plusaElement);
                }

                var tooltipElement = document.createElement("div");
                tooltipElement.className = "edit_storage dropdown d-inline";
                tooltipElement.setAttribute("data-bs-toggle", "tooltip");
                tooltipElement.setAttribute("data-bs-title", "編輯");
                tooltipElement.setAttribute("data-bs-placement", "top");

                var buttonElement = document.createElement("button");
                buttonElement.className = "btn btn-sm dropdown-toggle";
                buttonElement.setAttribute("data-bs-toggle", "dropdown");
                var buttoniElement = document.createElement("i");
                buttoniElement.className = "fas fa-pencil-alt ct-sub-1 me-1";
                buttonElement.appendChild(buttoniElement);
                tooltipElement.appendChild(buttonElement);

                var ulElement = document.createElement("ul");
                ulElement.className = "dropdown-menu";
                var liEditElement = document.createElement("li");
                var libuttonEditElement = document.createElement("button");
                libuttonEditElement.className = "dropdown-item rename_btn";
                libuttonEditElement.innerHTML = "修改分類";
                libuttonEditElement.onclick = function () {
                    storaged_rename(data, storage_name);
                };
                liEditElement.appendChild(libuttonEditElement);
                ulElement.appendChild(liEditElement);
                var liDelElement = document.createElement("li");
                var libuttonDelElement = document.createElement("button");
                libuttonDelElement.className = "dropdown-item del_btn";
                libuttonDelElement.innerHTML = "刪除分類";
                libuttonDelElement.onclick = function () {
                    storaged_delete(data, storage_name);
                };
                liDelElement.appendChild(libuttonDelElement);
                ulElement.appendChild(liDelElement);

                tooltipElement.appendChild(ulElement);
                rowElement.appendChild(tooltipElement);
                divElement.appendChild(rowElement);
                container.append(divElement);

                postStorageds.push({
                    id: data,
                    post: [],
                    storage_name: storage_name,
                });

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "新增成功!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            })
            .catch((error) => {
                // console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "新增失敗!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            });
    }
});

// 收藏文章
function article_saved(storage_id, storage_name) {
    // 取得被點擊的 收藏分類名稱
    var post_id = $("#post_id").val();
    var plus = $("#postStoraged_" + storage_name).find(".plus-btn i");
    var is_collect = plus.hasClass("fa-check-circle"); //取得目前狀態有無收藏
    action = is_collect ? "取消收藏" : "收藏文章";
    console.log("save:", storage_name, action);

    var token = $("#jwt_token").text();
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    try {
        var formdata = new FormData();
        formdata.append("storage_name", storage_name);
        formdata.append("post_id", post_id);
        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
        };

        fetch(
            apiIP + "api/userdetail/postStoraged/" + storage_id + "/",
            requestOptions
        );

        var formdata = new FormData();
        formdata.append("element", "bookmark");
        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
        };

        if (is_collect) {
            postStorageds.forEach((element, index) => {
                if (element.storage_name == storage_name) {
                    postStorageds[index].post.splice(
                        element.post.indexOf(post_id),
                        1
                    );
                    return;
                }
            });
            refreshBookmark();
            plus.toggleClass("fa-plus fa-check-circle");
        } else {
            postStorageds.forEach((element, index) => {
                if (element.storage_name == storage_name) {
                    postStorageds[index].post.push(post_id);
                    return;
                }
            });
            refreshBookmark();
            plus.toggleClass("fa-check-circle fa-plus");
        }
        Swal.fire({
            position: "center",
            icon: "success",
            title: action + "成功!",
            showConfirmButton: false,
            timer: 2500,
        });
        console.log(postStorageds);
    } catch (error) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: action + "失敗!",
            showConfirmButton: false,
            timer: 2500,
        });
    }
}

// 修改分類名稱
function storaged_rename(storage_id, storage_name) {
    Swal.fire({
        title: "請修改收藏分類",
        input: "text",
        inputPlaceholder: "輸入收藏分類",
        confirmButtonText: "確定",
        cancelButtonText: "取消",
        confirmButtonColor: "#70c6e3",
        inputValidator: (value) => {
            if (!value) {
                return "請勿填空，務必確實填寫！";
            }
        },
    }).then((result) => {
        if (result.isConfirmed) {
            console.log("edeit:", storage_name, "->", result.value);
            var token = $("#jwt_token").text();
            const apiIP = document
                .getElementById("app")
                .getAttribute("data-api-ip");
            var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + token);

            var formdata = new FormData();
            formdata.append("storage_name", storage_name);
            formdata.append("new_name", result.value);

            var requestOptions = {
                method: "PATCH",
                headers: myHeaders,
                body: formdata,
            };

            fetch(
                apiIP + "api/userdetail/postStoraged/" + storage_id + "/",
                requestOptions
            ).then((response) => {
                if (response.ok) {
                    $("#postStoraged_" + storage_name)
                        .find(".saved-title")
                        .text(result.value);
                    $("#postStoraged_" + storage_name)
                        .find(".rename_btn")
                        .attr(
                            "onclick",
                            "storaged_rename('" +
                                storage_id +
                                "','" +
                                result.value +
                                "')"
                        );
                    $("#postStoraged_" + storage_name)
                        .find(".del_btn")
                        .attr(
                            "onclick",
                            "storaged_delete('" +
                                storage_id +
                                "','" +
                                result.value +
                                "')"
                        );
                    $("#postStoraged_" + storage_name).attr(
                        "id",
                        "postStoraged_" + result.value
                    );
                    postStorageds.forEach((element, index) => {
                        if (element.storage_name == storage_name) {
                            postStorageds[index].storage_name = result.value;
                        }
                    });
                    refreshBookmark();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "修改成功!",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "修改失敗!",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
            });
        }
    });
}

// 刪除分類
function storaged_delete(storage_id, storage_name) {
    console.log("delete:", storage_id, storage_name);

    Swal.fire({
        title: "刪除收藏",
        text: `確認刪除「${storage_name}」收藏分類?`,
        showCancelButton: true,
        confirmButtonText: "刪除",
        cancelButtonText: "取消",
        confirmButtonColor: "#f24726",
    }).then((result) => {
        if (result.isConfirmed) {
            var token = $("#jwt_token").text();
            const apiIP = document
                .getElementById("app")
                .getAttribute("data-api-ip");
            var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + token);
            var requestOptions = {
                method: "DELETE",
                headers: myHeaders,
            };

            fetch(
                apiIP + "api/userdetail/postStoraged/" + storage_id + "/",
                requestOptions
            ).then((response) => {
                if (response.ok) {
                    $("#postStoraged_" + storage_name).remove();
                    refreshBookmark();
                    postStorageds.forEach((element, index) => {
                        if (element.storage_name == storage_name) {
                            postStorageds.splice(index, 1);
                        }
                    });
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "刪除成功!",
                        showConfirmButton: false,
                        timer: 2500,
                    }).then(() => {
                        if (
                            postStorageds.length >= 1 &&
                            postStorageds.length < 2
                        )
                            location.reload();
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "刪除失敗!",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
            });
        }
    });
}

// 刷新書籤圖示
function refreshBookmark() {
    $(".openBookmark").each(function () {
        if ($(this).find("i").hasClass("fas")) {
            $(this).find("i").removeClass("fas ct-txt-2 fa-bookmark me-1");
            $(this).find("i").addClass("far ct-sub-1 fa-bookmark me-1");
        }
    });
    postStorageds.forEach((element) => {
        element.post.forEach((post) => {
            console.log("#openBookmark_" +post);
            if (
                $("#openBookmark_" + post)
                    .find("i")
                    .hasClass("far")
            ) {
                $("#openBookmark_" + post)
                    .find("i")
                    .removeClass("far ct-sub-1 fa-bookmark me-1");
                $("#openBookmark_" + post)
                    .find("i")
                    .addClass("fas ct-txt-2 fa-bookmark me-1");
            }
        });
    });
}

//作者、話題追蹤頁
//通知按鈕
function notify_saved_btn(obj) {
    let notify_enable = $(obj)
        .parent()
        .find("i")
        .attr("class")
        .includes("slash");
    let title = $(obj).parents().eq(1).find(".topic_title").html(); //選中的作者/話題
    console.log(title);
    if (notify_enable) {
        $(obj).parent().find("i").removeClass("fa-bell-slash");
        $(obj).parent().find("i").addClass("fa-bell");
        //後端處理
    } else {
        $(obj).parent().find("i").removeClass("fa-bell");
        $(obj).parent().find("i").addClass("fa-bell-slash");
        //後端處理
    }
}

//作者追蹤按鈕
function follow_saved_btn(obj) {
    let follow_enable = $(obj).html().includes("追蹤中");
    let title = $(obj).parents().eq(1).find(".topic_title").html(); //要追蹤或取消的作者/話題
    // console.log(title);
    if (follow_enable) {
        // $(obj).html("取消追蹤");
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var formdata = new FormData();
        formdata.append("subscribe", title);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(apiIP + "api/userprofile/subscribe/", requestOptions).then(
            (response) => {
                if (response.ok) {
                    window.location.reload();
                }
            }
        );
        //後端處理
    } else {
        $(obj).html("追蹤中");
        //後端處理
    }
}

//話題追蹤按鈕
function follow_topic_saved_btn(obj) {
    let follow_enable = $(obj).html().includes("追蹤中");
    let title = $(obj).parents().eq(1).find(".topic_title").html(); //要追蹤或取消的作者/話題
    // console.log(title);
    if (follow_enable) {
        // $(obj).html("取消追蹤");
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var formdata = new FormData();
        formdata.append("category", title);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(apiIP + "api/userprofile/subTopic/", requestOptions).then(
            (response) => {
                if (response.ok) {
                    window.location.reload();
                }
            }
        );
        //後端處理
    } else {
        $(obj).html("追蹤中");
        //後端處理
    }
}
