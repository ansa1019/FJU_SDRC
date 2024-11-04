const b64toBlob = (b64Data, contentType = "", sliceSize = 512) => {
    const byteCharacters = atob(b64Data);
    const byteArrays = [];

    for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        const slice = byteCharacters.slice(offset, offset + sliceSize);

        const byteNumbers = new Array(slice.length);
        for (let i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        const byteArray = new Uint8Array(byteNumbers);
        byteArrays.push(byteArray);
    }

    const blob = new Blob(byteArrays, { type: contentType });
    return blob;
};

$(document).ready(function () {
    $("#articleSortTreatment").on("change", function () {
        var selectedValue = $(this).val();
        var category = $("#category").text();
        window.location.href =
            ArticleRoute + "/" + category + "/" + selectedValue;
    });

    $("#articleSortKnowledge").on("change", function () {
        var selectedValue = $(this).val();
        var category = $("#category").text();
        window.location.href =
            ArticleRoute + "/" + category + "/" + selectedValue;
    });

    $("#articleSortSearch").on("change", function () {
        var selectedValue = $(this).val();
        var searchText = $("#searchText").text().trim();
        window.location.href =
            searchArticleRoute + "/" + searchText + "/" + selectedValue;
    });

    Element.prototype.documentOffsetTop = function () {
        return (
            this.offsetTop +
            (this.offsetParent ? this.offsetParent.documentOffsetTop() : 0)
        );
    };

    if (window.location.href.indexOf("#comment_") > -1) {
        var foc = document.getElementById(window.location.href.split("#")[1]);
        var top = foc.documentOffsetTop() - window.innerHeight / 2;
        window.scrollTo(0, top);
        foc.style.backgroundColor = "#ffd089";
    }
});

//是否讀過此文章
if ($("#is_click").text() == 0) {
    var token = $("#jwt_token").text();
    var article_id = $("#article_id").text();
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "click");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            console.log("is_click");
        }
    });
}

// const myModal = new bootstrap.Modal("#create_modal", {
//     focus: false,
// });

// 修改后的工具栏选项，移除字体、引用、置中、靠右
var toolbarOptions = [
    [
        {
            header: [1, 2, 3, false], // 标题选项
        },
    ],
    ["bold", "italic", "underline", "strike"], // 加粗、斜体、底线、删除线
    [
        {
            list: "ordered",
        },
        {
            list: "bullet",
        },
    ], // 顺序列表、无序列表
    [
        {
            color: [],
        },
        {
            background: [],
        },
    ], // 颜色选项
    ["link", "image"], // 超链接和图片功能
];

// 初始化新增用文字编辑器
var quill = new Quill("#editor-container", {
    modules: {
        toolbar: toolbarOptions,
    },
    theme: "snow",
    formats: { align: "left" }, // 设置默认格式，尽量保持文本靠左
});

// 初始化修改用文字编辑器
var patch_quill = new Quill("#patch-editor-container", {
    modules: {
        toolbar: toolbarOptions,
    },
    theme: "snow",
});

// 確保上述代碼在頁面完全加載後執行
document.addEventListener("DOMContentLoaded", function () {
    customizeTooltip(quill);
    customizeTooltip(patch_quill);
});

// 清除列表中的超链接
function removeLinksFromLists() {
    var editorHtml = quill.root.innerHTML; // 获取编辑器的 HTML
    var tempDiv = document.createElement("div"); // 创建一个临时 div 来处理 HTML
    tempDiv.innerHTML = editorHtml;

    // 只针对顺序列表和无序列表中的超链接进行操作
    tempDiv.querySelectorAll("ol li a, ul li a").forEach(function (a) {
        var parentLi = a.parentNode;
        if (parentLi.tagName === "LI") {
            // 确保超链接直接在列表项目下
            while (a.firstChild) parentLi.insertBefore(a.firstChild, a); // 将超链接的内容移动到列表项目
            parentLi.removeChild(a); // 移除超链接
        }
    });

    quill.root.innerHTML = tempDiv.innerHTML; // 更新编辑器的 HTML
}

// 使用 Day.js
// const now_today = dayjs().format("YYYY-MM-DD");
$("#article_date").html(now_today);

$("#content_tabs > li > a").click(function () {
    var target = $(this).attr("href");
    $("html, body").animate(
        {
            scrollTop: $(target).offset().top - 100,
        },
        300
    );
    return false;
});

if ($("#create_article_image")) {
    $("#create_article_image").on("change", function () {
        var url = URL.createObjectURL($("#create_article_image")[0].files[0]);
        $("#create_image_preview").attr("src", url);
    });
}

if ($("#update_article_image")) {
    $("#update_article_image").on("change", function () {
        var url = URL.createObjectURL($("#update_article_image")[0].files[0]);
        $("#update_image_preview").attr("src", url);
    });
}

// 使用者文章按讚
function treatment_like(obj) {
    var token = $("#jwt_token").text();
    if (token != "") {
        if ($(obj).parents().eq(1).attr("id") != null) {
            var article_id = $(obj)
                .parents()
                .eq(1)
                .attr("id")
                .replace("article_id_", "");
        } else {
            var article_id = $(obj)
                .parents()
                .find(".article_content")
                .attr("id")
                .replace("article_id_", "");
        }
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");

        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var formdata = new FormData();
        formdata.append("element", "like");

        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(
            apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
            requestOptions
        ).then((response) => {
            if (response.ok) {
                $.ajax({
                    url: treatmentArticleUpdateRoute + "/" + article_id + "/",
                    method: "GET",
                    dataType: "json",
                    success: function (article) {
                        console.log(article);
                        var content = $("#article_id_" + article["id"]);
                        var like = content.find("#like").empty();
                        var likeHtml = `<i class="fas fa-heart ${
                            article["like"]["in_user"][0] == 1
                                ? "ct-txt-2"
                                : "ct-sub-1"
                        } me-1"></i>`;
                        content
                            .find("#like_count")
                            .text(article["like"]["count"]);
                        like.append(likeHtml);

                        var formdata2 = new FormData();
                        formdata2.append("author", article_id);
                        // 後端會將 # 依序替換成 貼文標題、按讚數、留言數
                        formdata2.append(
                            "content",
                            "您發布的貼文 # 已有 # 人按讚、 # 人留言! 快去看看吧~"
                        );
                        var requestOptions2 = {
                            method: "POST",
                            headers: myHeaders,
                            body: formdata2,
                            redirect: "follow",
                        };

                        fetch(
                            apiIP + "api/notifications/notifications/",
                            requestOptions2
                        );
                    },
                    error: function (error) {
                        console.error("Ajax request failed:", error);
                    },
                });
            }
        });
    } else {
        Swal.fire({
            title: "無法留言",
            html: "請先登入!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
        });
    }
}

// 官方文章按讚
function knowledge_like(obj) {
    var token = $("#jwt_token").text();
    if (token != "") {
        if ($(obj).parents().eq(1).attr("id") != null) {
            var article_id = $(obj)
                .parents()
                .eq(1)
                .attr("id")
                .replace("article_id_", "");
        } else {
            var article_id = $(obj)
                .parents()
                .find(".article_content")
                .attr("id")
                .replace("article_id_", "");
        }
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");

        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var formdata = new FormData();
        formdata.append("element", "like");

        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(
            apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
            requestOptions
        ).then((response) => {
            if (response.ok) {
                $.ajax({
                    url: knowledgeArticleUpdateRoute + "/" + article_id + "/",
                    method: "GET",
                    dataType: "json",
                    success: function (article) {
                        console.log(article);
                        var content = $("#article_id_" + article["id"]);
                        var like = content.find("#like").empty();
                        var likeHtml = `<i class="fas fa-heart ${
                            article["like"]["in_user"][0] == 1
                                ? "ct-txt-2"
                                : "ct-sub-1"
                        } me-1"></i>`;
                        content
                            .find("#like_count")
                            .text(article["like"]["count"]);
                        like.append(likeHtml);

                        var formdata2 = new FormData();
                        formdata2.append("author", article_id);
                        // 後端會將 # 依序替換成 貼文標題、按讚數、留言數
                        formdata2.append(
                            "content",
                            "您發布的貼文 # 已有 # 人按讚、 # 人留言! 快去看看吧~"
                        );
                        var requestOptions2 = {
                            method: "POST",
                            headers: myHeaders,
                            body: formdata2,
                            redirect: "follow",
                        };

                        fetch(
                            apiIP + "api/notifications/notifications/",
                            requestOptions2
                        );
                    },
                    error: function (error) {
                        console.error("Ajax request failed:", error);
                    },
                });
            }
        });
    } else {
        Swal.fire({
            title: "無法留言",
            html: "請先登入!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
        });
    }
}

// 所有文章按讚
function search_like(obj) {
    var token = $("#jwt_token").text();
    if ($(obj).parents().eq(1).attr("id") != null) {
        var article_id = $(obj)
            .parents()
            .eq(1)
            .attr("id")
            .replace("article_id_", "");
    } else {
        var article_id = $(obj)
            .parents()
            .find(".article_content")
            .attr("id")
            .replace("article_id_", "");
    }
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "like");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            $.ajax({
                url: searchArticleUpdateRoute + "/" + article_id + "/",
                method: "GET",
                dataType: "json",
                success: function (article) {
                    console.log(article);
                    var content = $("#article_id_" + article["id"]);
                    var like = content.find("#like").empty();
                    var likeHtml = `<i class="fas fa-heart ${
                        article["like"]["in_user"][0] == 1
                            ? "ct-txt-2"
                            : "ct-sub-1"
                    } me-1"></i>`;
                    content.find("#like_count").text(article["like"]["count"]);
                    like.append(likeHtml);

                    var formdata2 = new FormData();
                    formdata2.append("author", article_id);
                    // 後端會將 # 依序替換成 貼文標題、按讚數、留言數
                    formdata2.append(
                        "content",
                        "您發布的貼文 # 已有 # 人按讚、 # 人留言! 快去看看吧~"
                    );
                    var requestOptions2 = {
                        method: "POST",
                        headers: myHeaders,
                        body: formdata2,
                        redirect: "follow",
                    };

                    fetch(
                        apiIP + "api/notifications/notifications/",
                        requestOptions2
                    );
                },
                error: function (error) {
                    console.error("Ajax request failed:", error);
                },
            });
        }
    });
}

// 使用者文章分享
function treatment_share(obj) {
    $("#input_link").val(location.href); //點擊分享 將當前網址填入shareModal內
    let fb_link = "https://www.facebook.com/sharer/sharer.php?u=";
    let line_link = "http://line.naver.jp/R/msg/text/?";
    $(".fb_share").attr("href", fb_link + location.href);
    $(".line_share").attr("href", line_link + location.href);

    var token = $("#jwt_token").text();
    if ($(obj).parents().eq(1).attr("id") != null) {
        var article_id = $(obj)
            .parents()
            .eq(1)
            .attr("id")
            .replace("article_id_", "");
    } else {
        var article_id = $(obj)
            .parents()
            .find(".article_content")
            .attr("id")
            .replace("article_id_", "");
    }
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "share");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            $.ajax({
                url: treatmentArticleUpdateRoute + "/" + article_id + "/",
                method: "GET",
                dataType: "json",
                success: function (article) {
                    console.log(article);
                    var content = $("#article_id_" + article["id"]);
                    var share = content.find("#share").empty();
                    var shareHtml = `<i class="fas fa-share ${
                        article["share"]["in_user"][0] == 1
                            ? "ct-txt-2"
                            : "ct-sub-1"
                    } me-1"></i>`;
                    content
                        .find("#share_count")
                        .text(article["share"]["count"]);
                    share.append(shareHtml);
                },
                error: function (error) {
                    console.error("Ajax request failed:", error);
                },
            });
        }
    });
}

// 官方文章分享
function knowledge_share(obj) {
    $("#input_link").val(location.href); //點擊分享 將當前網址填入shareModal內
    let fb_link = "https://www.facebook.com/sharer/sharer.php?u=";
    let line_link = "http://line.naver.jp/R/msg/text/?";
    $(".fb_share").attr("href", fb_link + location.href);
    $(".line_share").attr("href", line_link + location.href);

    var token = $("#jwt_token").text();
    if ($(obj).parents().eq(1).attr("id") != null) {
        var article_id = $(obj)
            .parents()
            .eq(1)
            .attr("id")
            .replace("article_id_", "");
    } else {
        var article_id = $(obj)
            .parents()
            .find(".article_content")
            .attr("id")
            .replace("article_id_", "");
    }
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "share");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            $.ajax({
                url: knowledgeArticleUpdateRoute + "/" + article_id + "/",
                method: "GET",
                dataType: "json",
                success: function (article) {
                    console.log(article);
                    var content = $("#article_id_" + article["id"]);
                    var share = content.find("#share").empty();
                    var shareHtml = `<i class="fas fa-share ${
                        article["share"]["in_user"][0] == 1
                            ? "ct-txt-2"
                            : "ct-sub-1"
                    } me-1"></i>`;
                    content
                        .find("#share_count")
                        .text(article["share"]["count"]);
                    share.append(shareHtml);
                },
                error: function (error) {
                    console.error("Ajax request failed:", error);
                },
            });
        }
    });
}

// 所有文章分享
function search_share(obj) {
    var token = $("#jwt_token").text();
    if ($(obj).parents().eq(1).attr("id") != null) {
        var article_id = $(obj)
            .parents()
            .eq(1)
            .attr("id")
            .replace("article_id_", "");
    } else {
        var article_id = $(obj)
            .parents()
            .find(".article_content")
            .attr("id")
            .replace("article_id_", "");
    }
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "share");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            $.ajax({
                url: searchArticleUpdateRoute + "/" + article_id + "/",
                method: "GET",
                dataType: "json",
                success: function (article) {
                    console.log(article);
                    var content = $("#article_id_" + article["id"]);
                    var share = content.find("#share").empty();
                    var shareHtml = `<i class="fas fa-share ${
                        article["share"]["in_user"][0] == 1
                            ? "ct-txt-2"
                            : "ct-sub-1"
                    } me-1"></i>`;
                    content
                        .find("#share_count")
                        .text(article["share"]["count"]);
                    share.append(shareHtml);
                },
                error: function (error) {
                    console.error("Ajax request failed:", error);
                },
            });
        }
    });
}

function copy_sharelink() {
    const select = (DOM) => document.querySelector(DOM);
    select("#input_link").select(); //選取連結文字
    document.execCommand("copy"); //複製文字
    //當複製時，顯示'已複製'文字
    $("#copylink_btn").html("Copied");
    setTimeout(() => {
        window.getSelection().removeAllRanges(); //remove selection from page
        $("#copylink_btn").html("複製連結");
    }, 3000);
    // navigator.clipboard.writeText(select("#input_link").value).then(() => {
    //     //當複製時，顯示'已複製'文字
    //     $("#copylink_btn").html("Copied");
    //     setTimeout(() => {
    //         window.getSelection().removeAllRanges(); //remove selection from page
    //         $("#copylink_btn").html("複製連結");
    //     }, 3000);
    // });
}

// 使用者文章收藏
function treatment_collect(obj) {
    var token = $("#jwt_token").text();
    if ($(obj).parents().eq(1).attr("id") != null) {
        var article_id = $(obj)
            .parents()
            .eq(1)
            .attr("id")
            .replace("article_id_", "");
    } else {
        var article_id = $(obj)
            .parents()
            .find(".article_content")
            .attr("id")
            .replace("article_id_", "");
    }
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "bookmark");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            $.ajax({
                url: treatmentArticleUpdateRoute + "/" + article_id + "/",
                method: "GET",
                dataType: "json",
                success: function (article) {
                    console.log(article);
                    var content = $("#article_id_" + article["id"]);
                    var collect = content.find("#collect").empty();
                    var collectHtml = `<i class="far fa-bookmark ${
                        article["bookmark"]["in_user"][0] == 1
                            ? "fas ct-txt-2"
                            : "far ct-sub-1"
                    } me-1"></i>`;
                    collect.append(collectHtml);
                },
                error: function (error) {
                    console.error("Ajax request failed:", error);
                },
            });
        }
    });
}

// 官方文章收藏
function knowledge_collect(obj) {
    var token = $("#jwt_token").text();
    if ($(obj).parents().eq(1).attr("id") != null) {
        var article_id = $(obj)
            .parents()
            .eq(1)
            .attr("id")
            .replace("article_id_", "");
    } else {
        var article_id = $(obj)
            .parents()
            .find(".article_content")
            .attr("id")
            .replace("article_id_", "");
    }
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "bookmark");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            $.ajax({
                url: knowledgeArticleUpdateRoute + "/" + article_id + "/",
                method: "GET",
                dataType: "json",
                success: function (article) {
                    console.log(article);
                    var content = $("#article_id_" + article["id"]);
                    var collect = content.find("#collect").empty();
                    var collectHtml = `<i class="far fa-bookmark ${
                        article["bookmark"]["in_user"][0] == 1
                            ? "fas ct-txt-2"
                            : "far ct-sub-1"
                    } me-1"></i>`;
                    collect.append(collectHtml);
                },
                error: function (error) {
                    console.error("Ajax request failed:", error);
                },
            });
        }
    });
}

// 所有文章收藏
function search_collect(obj) {
    var token = $("#jwt_token").text();
    if ($(obj).parents().eq(1).attr("id") != null) {
        var article_id = $(obj)
            .parents()
            .eq(1)
            .attr("id")
            .replace("article_id_", "");
    } else {
        var article_id = $(obj)
            .parents()
            .find(".article_content")
            .attr("id")
            .replace("article_id_", "");
    }
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("element", "bookmark");

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/PostMetadataHandler/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            $.ajax({
                url: searchArticleUpdateRoute + "/" + article_id + "/",
                method: "GET",
                dataType: "json",
                success: function (article) {
                    console.log(article);
                    var content = $("#article_id_" + article["id"]);
                    var collect = content.find("#collect").empty();
                    var collectHtml = `<i class="far fa-bookmark ${
                        article["bookmark"]["in_user"][0] == 1
                            ? "fas ct-txt-2"
                            : "far ct-sub-1"
                    } me-1"></i>`;
                    collect.append(collectHtml);
                },
                error: function (error) {
                    console.error("Ajax request failed:", error);
                },
            });
        }
    });
}

// 話題追蹤按鈕
function topic_follow(obj) {
    let follow_topic = (
        "#" + $(obj).parents().eq(0).find("#searchText").text()
    ).trim();
    console.log(follow_topic);

    var token = $("#jwt_token").text();
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("hashtag", follow_topic);

    var requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(apiIP + "api/userprofile/subscribeHashtag/", requestOptions).then(
        (response) => {
            if (response.ok) {
                window.location.reload();
            }
        }
    );
}

// 作者追蹤按鈕
function follow(obj, type) {
    if (type == "author") {
        //追蹤作者
        let follow_author = $("#article_author").html();
        console.log(follow_author);
        //後端處理
        var token = $("#jwt_token").text();
        const apiIP = document
            .getElementById("app")
            .getAttribute("data-api-ip");
        var myHeaders = new Headers();
        myHeaders.append("Authorization", "Bearer " + token);

        var formdata = new FormData();
        formdata.append("subscribe", follow_author);

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
    }
}

//編輯留言按鈕
// let edit_cmt_obj = "";
// function edit_comment(obj) {
//     edit_cmt_obj = $(obj).parents().eq(3).find(".comment_content").eq(0);
//     $(edit_cmt_obj).attr("contenteditable", "true"); //開啟可編輯
//     $(edit_cmt_obj).focus(); //亮起可編輯區域
// }

// //當編輯留言離開焦點時，儲存更新當前文字內容
// $(document).on("blur", ".comment_content", function () {
//     $(edit_cmt_obj).html($(this).html()); //更新留言內容
//     $(edit_cmt_obj).attr("contenteditable", "false"); //取消可編輯

//     //後端回傳資料 更新留言內容
//     let cmt_id = $(edit_cmt_obj).parent().attr("id"); //留言id
//     let cmt_content = $(this).html(); //留言內容
//     console.log(cmt_id, cmt_content); //該留言id & 內容
// });

//療心室-票選活動 投票
function vote(obj) {
    let select_item = $('input[name="vote_item"]:checked')
        .map(function () {
            return this.value;
        })
        .get()
        .join(",");
    console.log(select_item);
}

// //療心室-票選活動 倒數計時
// $(".countdown")._countTime("2023-08-03 12:30:00", {
//     isActive: true,
//     str: {
//         title: "活動截止：",
//         day: "日",
//     },
// });

function getValue(button, type) {
    if (type == "patch_list") {
        // 獲取文章 ID 和 DOM 元素
        var id = button.parentNode.parentNode.id.replace("article_id_", "");
        var title = document.getElementById("input_patch_title");
        var article_id = document.getElementById("article_id");
        var selectTreat = document.getElementById("patch_post_class");
        var hashtags = document.getElementById("patch_input_topic");
        var image = document.getElementById("update_image_preview");

        image.src = $(button).parents().eq(2).find(".article-img")[0].src;
        console.log("Subcategory ID:", subcategory_id); // 確認 subcategory_id 的值

        // 設置標題與文章ID
        title.value = $(button)
            .parents()
            .parents()
            .find("#article_id_title")
            .text()
            .trim();
        article_id.value = id;

        // 設置類別
        var subcategory_id = $(button)
            .parents()
            .eq(2)
            .find("#article_category")
            .text();
        console.log("Subcategory ID:", subcategory_id); // 確認 subcategory_id 的值

        // 將選擇的類別直接設置為 subcategory_id 的值
        selectTreat.value = subcategory_id; // 直接根據 value 設置選擇項目

        // 確認選擇的類別是否正確
        console.log("Selected category value:", selectTreat.value);

        // 設置話題欄位，移除空值與多餘的標點
        var hashtagsText = $(button)
            .parents()
            .eq(2)
            .find("#hashtags")
            .text()
            .trim();
        hashtags.value =
            hashtagsText === "null" || hashtagsText === ""
                ? ""
                : hashtagsText.replace(/,\s*$/, "").replace(/\s+/g, " ");

        // 使用 Quill 編輯器插入 HTML 內容
        patch_quill.clipboard.dangerouslyPasteHTML(
            $(button).parents().eq(1).find("#html").text().trim()
        );
    } else if (type == "patch_post") {
        // 獲取文章 ID 和 DOM 元素
        var id = $("#article_id").text();
        var title = document.getElementById("input_patch_title");
        var article_id = document.getElementById("article_id");
        var selectTreat = document.getElementById("patch_post_class");
        var hashtags = document.getElementById("patch_input_topic");
        var selectIdentity = document.getElementById("patch_id_type");
        var identity = $(button)
            .parents()
            .eq(2)
            .find("#identity")
            .text()
            .trim();

        // 設置標題與文章ID
        title.value = $("#article_title").text();
        article_id.value = id;

        // 設置類別
        var subcategory_id = $("#article_category").text();
        console.log("Subcategory ID:", subcategory_id); // 確認 subcategory_id 的值

        // 將選擇的類別直接設置為 subcategory_id 的值
        selectTreat.value = subcategory_id; // 直接根據 value 設置選擇項目

        // 確認選擇的類別是否正確
        console.log("Selected category value:", selectTreat.value);

        // 設置話題欄位，移除空值與多餘的標點
        var hashtagsa = $("#article_tabs a");
        if (hashtagsa.length == 0) {
            hashtagsText = "";
        } else {
            hashtagsText = "";
            for (var i = 0; i < hashtagsa.length; i++) {
                hashtagsText += "#" + hashtagsa[i].text;
            }
        }
        hashtags.value = hashtagsText;

        // 使用 Quill 編輯器插入 HTML 內容
        patch_quill.clipboard.dangerouslyPasteHTML($("#content").html().trim());
    } else if (type == "patch_mind") {
         // 獲取文章 ID 和 DOM 元素
         var id = button.parentNode.parentNode.id.replace("article_id_", "");
         var title = document.getElementById("input_patch_title");
         var article_id = document.getElementById("article_id");
         var selectTreat = document.getElementById("patch_post_class");
         var hashtags = document.getElementById("patch_input_topic");
         var image = document.getElementById("update_image_preview");
 
         image.src = $(button).parents().eq(2).find(".article-img")[0].src;
         console.log("Subcategory ID:", subcategory_id); // 確認 subcategory_id 的值
 
         // 設置標題與文章ID
         title.value = $(button)
             .parents()
             .parents()
             .find("#article_id_title")
             .text()
             .trim();
         article_id.value = id;
 
         // 設置類別
         var subcategory_id = $(button)
             .parents()
             .eq(2)
             .find("#article_category")
             .text();
         console.log("Subcategory ID:", subcategory_id); // 確認 subcategory_id 的值
 
         // 將選擇的類別直接設置為 subcategory_id 的值
         selectTreat.value = subcategory_id; // 直接根據 value 設置選擇項目
 
         // 確認選擇的類別是否正確
         console.log("Selected category value:", selectTreat.value);
 
         // 設置話題欄位，移除空值與多餘的標點
         var hashtagsText = $(button)
             .parents()
             .eq(2)
             .find("#hashtags")
             .text()
             .trim();
         hashtags.value =
             hashtagsText === "null" || hashtagsText === ""
                 ? ""
                 : hashtagsText.replace(/,\s*$/, "").replace(/\s+/g, " ");
 
         // 使用 Quill 編輯器插入 HTML 內容
         patch_quill.clipboard.dangerouslyPasteHTML(
             $(button).parents().eq(1).find("#html").text().trim()
         );
    } else {
        // 發佈時使用 Quill 編輯器插入 HTML
        quill.clipboard.dangerouslyPasteHTML(
            $(button).parents().eq(1).find("#html").text().trim()
        );
    }
}

//新增聊療
function postdata(obj, type) {
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var html = quill.root.innerHTML;
    var content = quill.getContents();
    var token = $("#jwt_token").text();
    var id_type = document.getElementById("id_type").value;
    var title = $("#input_new_title").val();
    var category = document.getElementById("post_class").value;
    var articleImageFile = document.getElementById("create_article_image")
        .files[0]; // 獲取上傳的封面圖片
    const randomInteger = Math.floor(Math.random() * 4) + 1;
    const Hashtags = $("#create_input_topic")
        .val()
        .match(/#[\u4e00-\u9fa5\w]+/g);

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("title", title);
    formdata.append("category", category);
    formdata.append("identity", id_type);
    formdata.append("is_official", 0);
    formdata.append("is_temporary", 0);
    formdata.append(
        "content",
        JSON.stringify({
            delta: content,
            html: html,
        })
    );
    if (Hashtags) {
        formdata.append("hashtag", Hashtags);
    }
    if (articleImageFile) {
        formdata.append("index_image", articleImageFile);
    } else if (content.ops[0]["insert"]["image"]) {
        var contentType = content.ops[0]["insert"]["image"]
            .split(",")[0]
            .split(":")[1]
            .split(";")[0];
        var b64Data = content.ops[0]["insert"]["image"].split(",")[1];
        var articleImageFile = b64toBlob(b64Data, contentType);
        formdata.append("index_image", articleImageFile, "image.png");
    } else {
        fetch("/get-image/img_" + randomInteger + ".png")
            .then((response) => {
                if (response.ok) {
                    return response.blob();
                }
                throw new Error("Network response was not ok.");
            })
            .then((blob) => {
                formdata.append("index_image", blob, "image.png");
            });
    }

    if (title == "") {
        alert("標題未填");
    } else if (type == "temporary") {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        var article_id = $(obj).parents().eq(1).find("#temporary_id").text();
        fetch(
            apiIP + "api/content/textEditorPost/" + article_id + "/",
            requestOptions
        )
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "新增失敗!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            })
            .then((data) => {
                var formdata2 = new FormData();
                formdata2.append("post", data["id"]);
                if (id_type != "匿名") {
                    formdata2.append(
                        "content_subscribe",
                        "您追蹤的作者 " +
                            id_type +
                            " 已發布一則新貼文! 快去看看吧~"
                    );
                }
                // 後端會將 # 替換成 #tag名稱
                formdata2.append(
                    "content_hashtag",
                    "您追蹤的hashtag # 已發布一則新貼文! 快去看看吧~"
                );
                var requestOptions2 = {
                    method: "POST",
                    headers: myHeaders,
                    body: formdata2,
                    redirect: "follow",
                };

                fetch(
                    apiIP + "api/notifications/notifications/",
                    requestOptions2
                );
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "新增成功!",
                    showConfirmButton: false,
                    timer: 2500,
                });
                window.location = "/TreatmentArticleGet/" + data["id"] + "/";
            });
    } else {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(apiIP + "api/content/textEditorPost/", requestOptions)
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "新增失敗!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            })
            .then((data) => {
                var formdata2 = new FormData();
                formdata2.append("post", data["id"]);
                if (id_type != "匿名") {
                    formdata2.append(
                        "content_subscribe",
                        "您追蹤的作者 " +
                            id_type +
                            " 已發布一則新貼文! 快去看看吧~"
                    );
                }
                // 後端會將 # 替換成 #tag名稱
                formdata2.append(
                    "content_hashtag",
                    "您追蹤的hashtag # 已發布一則新貼文! 快去看看吧~"
                );
                var requestOptions2 = {
                    method: "POST",
                    headers: myHeaders,
                    body: formdata2,
                    redirect: "follow",
                };

                fetch(
                    apiIP + "api/notifications/notifications/",
                    requestOptions2
                );
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "新增成功!",
                    showConfirmButton: false,
                    timer: 2500,
                });
                window.location = "/TreatmentArticleGet/" + data["id"] + "/";
            });
    }
}

//新增官方文章
function official_postdata(obj, type) {
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var html = quill.root.innerHTML;
    var content = quill.getContents();
    var token = $("#jwt_token").text();
    var id_type = document.getElementById("id_type").value;
    var title = $("#input_new_title").val();
    var category = document.getElementById("post_class").value;
    var articleImageFile = document.getElementById("create_article_image")
        .files[0]; // 獲取上傳的封面圖片
    const randomInteger = Math.floor(Math.random() * 4) + 1;
    const Hashtags = $("#create_input_topic")
        .val()
        .match(/#[\u4e00-\u9fa5\w]+/g);

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("title", title);
    formdata.append("category", category);
    formdata.append("identity", id_type);
    formdata.append("is_official", 1);
    formdata.append("is_temporary", 0);
    formdata.append(
        "content",
        JSON.stringify({
            delta: content,
            html: html,
        })
    );
    if (Hashtags) {
        formdata.append("hashtag", Hashtags);
    }
    if (articleImageFile) {
        formdata.append("index_image", articleImageFile);
    } else if (content.ops[0]["insert"]["image"]) {
        var contentType = content.ops[0]["insert"]["image"]
            .split(",")[0]
            .split(":")[1]
            .split(";")[0];
        var b64Data = content.ops[0]["insert"]["image"].split(",")[1];
        var articleImageFile = b64toBlob(b64Data, contentType);
        formdata.append("index_image", articleImageFile, "image.png");
    } else {
        fetch("/get-image/img_" + randomInteger + ".png")
            .then((response) => {
                if (response.ok) {
                    return response.blob();
                }
                throw new Error("Network response was not ok.");
            })
            .then((blob) => {
                formdata.append("index_image", blob, "image.png");
            });
    }

    if (title == "") {
        alert("標題未填");
    } else if (type == "temporary") {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        var article_id = $(obj).parents().eq(1).find("#temporary_id").text();
        fetch(
            apiIP + "api/content/textEditorPost/" + article_id + "/",
            requestOptions
        )
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "新增失敗!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            })
            .then((data) => {
                var formdata2 = new FormData();
                formdata2.append("post", data["id"]);
                if (id_type != "匿名") {
                    formdata2.append(
                        "content_subscribe",
                        "您追蹤的作者 " +
                            id_type +
                            " 已發布一則新貼文! 快去看看吧~"
                    );
                }
                // 後端會將 # 替換成 #tag名稱
                formdata2.append(
                    "content_hashtag",
                    "您追蹤的hashtag # 已發布一則新貼文! 快去看看吧~"
                );
                var requestOptions2 = {
                    method: "POST",
                    headers: myHeaders,
                    body: formdata2,
                    redirect: "follow",
                };

                fetch(
                    apiIP + "api/notifications/notifications/",
                    requestOptions2
                );
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "新增成功!",
                    showConfirmButton: false,
                    timer: 2500,
                });
                window.location = "/knowledge_article/" + data["id"] + "/";
            });
    } else {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(apiIP + "api/content/textEditorPost/", requestOptions)
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "新增失敗!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            })
            .then((data) => {
                var formdata2 = new FormData();
                formdata2.append("post", data["id"]);
                if (id_type != "匿名") {
                    formdata2.append(
                        "content_subscribe",
                        "您追蹤的作者 " +
                            id_type +
                            " 已發布一則新貼文! 快去看看吧~"
                    );
                }
                // 後端會將 # 替換成 #tag名稱
                formdata2.append(
                    "content_hashtag",
                    "您追蹤的hashtag # 已發布一則新貼文! 快去看看吧~"
                );
                var requestOptions2 = {
                    method: "POST",
                    headers: myHeaders,
                    body: formdata2,
                    redirect: "follow",
                };

                fetch(
                    apiIP + "api/notifications/notifications/",
                    requestOptions2
                );
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "新增成功!",
                    showConfirmButton: false,
                    timer: 2500,
                }).then(() => {
                    window.location =
                        "/TreatmentArticleGet/" + data["id"] + "/";
                });
            });
    }
}

//修改聊療
function patchData() {
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var article_id = document.getElementById("article_id").value;
    var content = patch_quill.getContents();
    var html = patch_quill.root.innerHTML;
    var token = $("#jwt_token").text();
    var title = $("#input_patch_title").val();
    var articleImageFile = document.getElementById("update_article_image")
        .files[0]; // 獲取上傳的封面圖片
    const Hashtags = $("#patch_input_topic")
        .val()
        .match(/#[\u4e00-\u9fa5\w]+/g);
    var category = document.getElementById("patch_post_class").value;
    var id_type = document.getElementById("patch_id_type").value;

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("id", article_id);
    formdata.append("title", title);
    formdata.append("category", category);
    formdata.append("identity", id_type);
    formdata.append("is_official", 0);
    formdata.append("is_temporary", 0);
    formdata.append(
        "content",
        JSON.stringify({
            delta: content,
            html: html,
        })
    );
    if (Hashtags) {
        formdata.append("hashtag", Hashtags);
    }
    if (articleImageFile) {
        formdata.append("index_image", articleImageFile);
    } else if (content.ops[0]["insert"]["image"]) {
        var contentType = content.ops[0]["insert"]["image"]
            .split(",")[0]
            .split(":")[1]
            .split(";")[0];
        var b64Data = content.ops[0]["insert"]["image"].split(",")[1];
        var articleImageFile = b64toBlob(b64Data, contentType);

        formdata.append("index_image", articleImageFile, "image.png");
    }

    // console.log(article_id);
    // console.log(title);
    // console.log(content);
    // console.log(html);
    // console.log(category);

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/textEditorPost/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "修改成功!",
                showConfirmButton: false,
                timer: 2500,
            }).then(() => {
                window.location = "/TreatmentArticleGet/" + article_id + "/";
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

//修改官方文章
function official_patchData() {
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var article_id = document.getElementById("article_id").value;
    var content = patch_quill.getContents();
    var html = patch_quill.root.innerHTML;
    var token = $("#jwt_token").text();
    var title = $("#input_patch_title").val();
    var articleImageFile = document.getElementById("update_article_image")
        .files[0]; // 獲取上傳的封面圖片
    const Hashtags = $("#patch_input_topic")
        .val()
        .match(/#[\u4e00-\u9fa5\w]+/g);
    var category = document.getElementById("patch_post_class").value;
    var id_type = document.getElementById("patch_id_type").value;

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("id", article_id);
    formdata.append("title", title);
    formdata.append("category", category);
    formdata.append("identity", id_type);
    formdata.append("is_official", 1);
    formdata.append("is_temporary", 0);
    formdata.append(
        "content",
        JSON.stringify({
            delta: content,
            html: html,
        })
    );
    if (Hashtags) {
        formdata.append("hashtag", Hashtags);
    }
    if (articleImageFile) {
        formdata.append("index_image", articleImageFile);
    } else if (content.ops[0]["insert"]["image"]) {
        var contentType = content.ops[0]["insert"]["image"]
            .split(",")[0]
            .split(":")[1]
            .split(";")[0];
        var b64Data = content.ops[0]["insert"]["image"].split(",")[1];
        var articleImageFile = b64toBlob(b64Data, contentType);

        formdata.append("index_image", articleImageFile, "image.png");
    }

    // console.log(article_id);
    // console.log(title);
    // console.log(content);
    // console.log(html);
    // console.log(category);

    var requestOptions = {
        method: "PATCH",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/textEditorPost/" + article_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "修改成功!",
                showConfirmButton: false,
                timer: 2500,
            }).then(() => {
                window.location = "/knowledge_article/" + article_id + "/";
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

//暫存聊療
function temporaryData(obj, type) {
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var html = quill.root.innerHTML;
    var content = quill.getContents();
    var token = $("#jwt_token").text();
    var id_type = document.getElementById("id_type").value;
    var title = $("#input_new_title").val();
    var category = document.getElementById("post_class").value;
    var articleImageFile = document.getElementById("create_article_image")
        .files[0];
    const randomInteger = Math.floor(Math.random() * 4) + 1;
    const Hashtags = $("#create_input_topic")
        .val()
        .match(/#[\u4e00-\u9fa5\w]+/g);

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("title", title);
    formdata.append("category", category);
    formdata.append("identity", id_type);
    formdata.append("is_official", 0);
    formdata.append("is_temporary", 1);
    formdata.append(
        "content",
        JSON.stringify({
            delta: content,
            html: html,
        })
    );
    if (Hashtags) {
        formdata.append("hashtag", Hashtags);
    }
    if (articleImageFile) {
        formdata.append("index_image", articleImageFile);
    } else if (content.ops[0]["insert"]["image"]) {
        var contentType = content.ops[0]["insert"]["image"]
            .split(",")[0]
            .split(":")[1]
            .split(";")[0];
        var b64Data = content.ops[0]["insert"]["image"].split(",")[1];
        var articleImageFile = b64toBlob(b64Data, contentType);
        formdata.append("index_image", articleImageFile, "image.png");
    } else {
        fetch("/get-image/img_" + randomInteger + ".png")
            .then((response) => {
                if (response.ok) {
                    return response.blob();
                }
                throw new Error("Network response was not ok.");
            })
            .then((blob) => {
                formdata.append("index_image", blob, "image.png");
            });
    }

    if (title == "") {
        alert("標題未填");
    } else if (type == "temporary") {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };
        var article_id = $(obj).parents().eq(1).find("#temporary_id").text();
        fetch(
            apiIP + "api/content/textEditorPost/" + article_id + "/",
            requestOptions
        ).then((response) => {
            if (response.ok) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "暫存成功!",
                    showConfirmButton: false,
                    timer: 2500,
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "暫存失敗!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            }
        });
    } else {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(apiIP + "api/content/textEditorPost/", requestOptions).then(
            (response) => {
                if (response.ok) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "暫存成功!",
                        showConfirmButton: false,
                        timer: 2500,
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "暫存失敗!",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
            }
        );
    }
}

//暫存官方文章
function official_temporaryData(obj, type) {
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var html = quill.root.innerHTML;
    var content = quill.getContents();
    var token = $("#jwt_token").text();
    var id_type = document.getElementById("id_type").value;
    var title = $("#input_new_title").val();
    var category = document.getElementById("post_class").value;
    var articleImageFile = document.getElementById("create_article_image")
        .files[0];
    const randomInteger = Math.floor(Math.random() * 4) + 1;
    const Hashtags = $("#create_input_topic")
        .val()
        .match(/#[\u4e00-\u9fa5\w]+/g);

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);

    var formdata = new FormData();
    formdata.append("title", title);
    formdata.append("category", category);
    formdata.append("identity", id_type);
    formdata.append("is_official", 1);
    formdata.append("is_temporary", 1);
    formdata.append(
        "content",
        JSON.stringify({
            delta: content,
            html: html,
        })
    );
    if (Hashtags) {
        formdata.append("hashtag", Hashtags);
    }
    if (articleImageFile) {
        formdata.append("index_image", articleImageFile);
    } else if (content.ops[0]["insert"]["image"]) {
        var contentType = content.ops[0]["insert"]["image"]
            .split(",")[0]
            .split(":")[1]
            .split(";")[0];
        var b64Data = content.ops[0]["insert"]["image"].split(",")[1];
        var articleImageFile = b64toBlob(b64Data, contentType);
        formdata.append("index_image", articleImageFile, "image.png");
    } else {
        fetch("/get-image/img_" + randomInteger + ".png")
            .then((response) => {
                if (response.ok) {
                    return response.blob();
                }
                throw new Error("Network response was not ok.");
            })
            .then((blob) => {
                formdata.append("index_image", blob, "image.png");
            });
    }

    if (title == "") {
        alert("標題未填");
    } else if (type == "temporary") {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        var article_id = $(obj).parents().eq(1).find("#temporary_id").text();
        fetch(
            apiIP + "api/content/textEditorPost/" + article_id + "/",
            requestOptions
        ).then((response) => {
            if (response.ok) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "暫存成功!",
                    showConfirmButton: false,
                    timer: 2500,
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "暫存失敗!",
                    showConfirmButton: false,
                    timer: 2500,
                });
            }
        });
    } else {
        // console.log(article_id);
        // console.log(apiIP);
        // console.log(token);
        // console.log(category);
        // console.log(id_type);
        // console.log(content);
        // console.log(html);
        // console.log(Hashtags);

        var requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(apiIP + "api/content/textEditorPost/", requestOptions).then(
            (response) => {
                if (response.ok) {
                    console.log(response.json());
                    $(obj)
                        .parents()
                        .eq(1)
                        .find("#temporary_id")
                        .text(response.json()["id"]);
                    $(obj).attr(
                        "onclick",
                        "official_temporaryData(this, 'temporary')"
                    );
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "暫存成功!",
                        showConfirmButton: false,
                        timer: 2500,
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "暫存失敗!",
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
            }
        );
    }
}

//刪除文章
function delArticle(button) {
    var id =
        button.parentNode.parentNode.parentNode.parentNode.parentNode.id.replace(
            "article_id_",
            ""
        );
    var token = $("#jwt_token").text();
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var myHeaders = new Headers();

    myHeaders.append("Authorization", "Bearer " + token);

    var requestOptions = {
        method: "DELETE",
        headers: myHeaders,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/textEditorPost/" + id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            var category = $("#category").text();
            window.location.href = ArticleRoute + "/" + category;
        }
    });
}

function generateHashtag(obj) {
    // 獲取輸入框中的值
    let input = obj.value;
    const output = input.match(/#[\u4e00-\u9fa5\w]+/g);
    Hashtags = output;
    console.log(Hashtags); //輸出["#ABC", "#qwe"]
}

//使用者文章留言=
function createArticleComment(button) {
    var token = $("#jwt_token").text();
    if (token != "") {
        if (banlist["comment"] == true) {
            var comment = document.getElementById("comment").value;
            var article_id = $("#article_id").text();
            var nickname = $("#nickname").text();
            var updated_at = $("updated_at").text();
            const apiIP = document
                .getElementById("app")
                .getAttribute("data-api-ip");
            var formdata = new FormData();
            formdata.append("post", article_id);
            formdata.append("body", comment);
            if ($("#anony_enable").prop("checked")) {
                formdata.append("identity", "匿名");
            } else {
                formdata.append("identity", nickname);
            }
            console.log(article_id);
            console.log(comment);

            var myHeaders = new Headers();
            myHeaders.append("Authorization", "Bearer " + token);

            var requestOptions = {
                method: "POST",
                headers: myHeaders,
                body: formdata,
                redirect: "follow",
            };

            fetch(
                apiIP + "api/content/textEditorPostComment/",
                requestOptions
            ).then((response) => {
                if (response.ok) {
                    var taskFormdata = new FormData();
                    taskFormdata.append("task_title", "每日回覆");

                    var taskRequestOptions = {
                        method: "POST",
                        headers: myHeaders,
                        body: taskFormdata,
                        redirect: "follow",
                    };

                    fetch(apiIP + "api/task/taskRecord/", taskRequestOptions);

                    var formdata2 = new FormData();
                    formdata2.append("author", article_id);
                    // 後端會將 # 依序替換成 貼文標題、按讚數、留言數
                    formdata2.append(
                        "content",
                        "您發布的貼文 # 已有 # 人按讚、 # 則留言! 快去看看吧~"
                    );
                    var requestOptions2 = {
                        method: "POST",
                        headers: myHeaders,
                        body: formdata2,
                        redirect: "follow",
                    };

                    fetch(
                        apiIP + "api/notifications/notifications/",
                        requestOptions2
                    );

                    window.location.reload();
                }
            });
        } else if (banlist["comment"][0] == "禁言24小時") {
            Swal.fire({
                title: "你已被禁言！",
                html:
                    "因您於短時間內收到多次檢舉，<br>故系統於 " +
                    dayjs(banlist["comment"][1]).format("YYYY-MM-DD HH:mm:ss") +
                    " 起自動禁言24小時<br>我們將同步進行人工審核，若造成不便請見諒，謝謝",
                icon: "error",
                allowOutsideClick: false, // 禁止點擊外部關閉
                allowEscapeKey: false, // 禁止按 ESC 鍵關閉
                confirmButtonText: "確定", // 確認按鈕文字
                confirmButtonColor: "#d33",
            });
        } else {
            banerror(banlist["comment"]);
        }
    } else {
        Swal.fire({
            title: "無法留言",
            html: "請先登入!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
        });
    }
}

//使用者文章留言修改
function patchArticleComment(obj) {
    comment_id = $(obj).parents().eq(2).attr("id").replace("comment_", "");
    var token = $("#jwt_token").text();
    var article_id = $("#article_id").text();
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var formdata = new FormData();
    formdata.append("post", article_id);

    var myHeaders = new Headers();
    myHeaders.append("Authorization", "Bearer " + token);
    console.log($(obj).parents().eq(2).find(".comment_content").eq(0));
    edit_cmt_obj = $(obj).parents().eq(2).find(".comment_content").eq(0);
    $(edit_cmt_obj).attr("contenteditable", "true"); //開啟可編輯
    $(edit_cmt_obj).focus();
    $(".edit_check_btn").show(); //顯示編輯完成提交按鈕，是個假按鈕、不會觸發動作，單純讓使用者有作提交動作
    $(edit_cmt_obj).on("blur", function () {
        $(".edit_check_btn").hide(); //隱藏編輯完成提交按鈕
        var editedContent = $(this).text(); // 取得編輯後的內容
        formdata.append("body", editedContent);

        var requestOptions = {
            method: "PATCH",
            headers: myHeaders,
            body: formdata,
            redirect: "follow",
        };

        fetch(
            apiIP + "api/content/textEditorPostComment/" + comment_id + "/",
            requestOptions
        ).then((response) => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });
}

//使用者文章留言刪除
function delArticleComment(obj) {
    // console.log($(obj).parents())
    var comment_id = $(obj).parents().eq(5).attr("id").replace("comment_", "");
    var token = $("#jwt_token").text();
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    var myHeaders = new Headers();

    myHeaders.append("Authorization", "Bearer " + token);

    var requestOptions = {
        method: "DELETE",
        headers: myHeaders,
        redirect: "follow",
    };

    fetch(
        apiIP + "api/content/textEditorPostComment/" + comment_id + "/",
        requestOptions
    ).then((response) => {
        if (response.ok) {
            window.location.reload();
        }
    });
}

//搜尋文章
function searchArticle(event) {
    if (event.key === "Enter") {
        var searchText = event.target.value;
        window.location.href = searchArticleRoute + "/" + searchText;
    }
}

// //點擊分享 將當前網址填入shareModal內
// $("#shareModal").on("show.bs.modal", function (e) {
//     $("#input_link").val(location.href);
// });

// //分享文章 複製連結
// select("#copylink_btn").addEventListener("click", () => {
//     const select = (DOM) => document.querySelector(DOM);
//     select("#input_link").select(); //選取連結文字
//     navigator.clipboard.writeText(select("#input_link").value).then(() => {
//         //當複製時，顯示'已複製'文字
//         $("#copylink_btn").html("Copied");
//         setTimeout(() => {
//             window.getSelection().removeAllRanges(); //remove selection from page
//             $("#copylink_btn").html("複製連結");
//         }, 3000);
//     });
// });
