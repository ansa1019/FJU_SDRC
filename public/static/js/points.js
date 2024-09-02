//任務專區 任務類型篩選
function task_class_filter(cls) {
    let cls_len = $("#task_list").find(".task_class").length;
    let cls_arr = $("#task_list").find(".task_class");
    if (cls == "all") {
        $("#task_list")
            .find(".row")
            .each(function (i, obj) {
                $(obj).css("display", "");
            });
    } else {
        cls_arr.each(function (i, obj) {
            let now_cls = $(obj).html();
            switch (now_cls) {
                case "新手任務": {
                    now_cls = "beginner";
                    break;
                }
                case "活動任務": {
                    now_cls = "activity";
                    break;
                }
                case "常態任務": {
                    now_cls = "normal";
                    break;
                }
                default: {
                    break;
                }
            }

            if (cls != now_cls) {
                $(obj).parents(".row").eq(0).css("display", "none");
            } else {
                $(obj).parents(".row").eq(0).css("display", "");
            }
        });
    }
}

//點數轉贈 送出確認彈出視窗
function points_gift() {
    let gift_points = $("#gift_points").val(); //要贈送的點數
    let gift_account = $("#gift_account").val(); //要贈送的對象
    if (gift_points == "" || gift_account == "") {
        Swal.fire({
            title: `填寫有誤`,
            text: "請再檢查欄位是否確實有填寫！",
            confirmButtonColor: "#70c6e3",
        });
    } else {
        Swal.fire({
            title: `贈送${gift_account} ${gift_points}點？`,
            showCancelButton: true,
            confirmButtonText: "贈送",
            cancelButtonText: `取消`,
            confirmButtonColor: "#70c6e3",
            cancelButtonColor: "#808080",
        }).then((result) => {
            if (result.isConfirmed) {
                //後端處理
                // 跳轉 point_gift2 頁面
            }
        });
    }
}

// 點數兌換頁
const exg_list = {};

//兌換數量調整加減
function add_product(obj, sum_type) {
    let pd_num = parseInt($(obj).parent().find(".pd_num").html());
    if (sum_type == "dash") {
        if (pd_num != 0) {
            $(obj)
                .parent()
                .find(".pd_num")
                .html(pd_num - 1);
        }
    }
    if (sum_type == "plus") {
        $(obj)
            .parent()
            .find(".pd_num")
            .html(pd_num + 1);
    }

    //計算當前點數
    let pd_arr = $("#point_exchange_list").find(".pd-item");
    let total_point = 0;
    $(pd_arr).each(function (i, pd) {
        let pd_title = $(pd).find(".title").html();
        let pd_point = parseInt($(pd).find(".pd_point").html());
        let pd_num = parseInt($(pd).find(".pd_num").html());
        total_point += pd_point * pd_num;
    });
    $("#total_exg_point").html(total_point);
}

//確定要兌換
function exchange() {
    //商品項目list
    let product_list = $("#point_exchange_list .title")
        .map(function () {
            return this.innerHTML;
        })
        .get();

    //商品項目兌換點數list
    let product_point_list = $("#point_exchange_list .pd_point")
        .map(function () {
            return this.innerHTML;
        })
        .get();

    //商品項目要兌換數量list
    let product_num_list = $("#point_exchange_list .pd_num")
        .map(function () {
            return this.innerHTML;
        })
        .get();

    console.log(product_list);
    console.log(product_point_list);
    console.log(product_num_list);
}

//兌換商品
function updateRemainingPoint() {
    // 获取点数和已选兑换点数的元素
    // const pointElementText = document.getElementById('user_point');
    // const point = pointElementText.value;
    const apiIP = document.getElementById("app").getAttribute("data-api-ip");
    // console.log('point = ', point);

    // const usepoint = document.getElementById('total_exg_point').textContent;
    // console.log('usepoint = ', usepoint);

    // // 计算剩余点数
    // const remainingPoint = point - usepoint;
    // console.log('remainingPoint = ', remainingPoint);
    // // 获取授权信息和用户ID
    const authorization = $("#jwt_token").text();
    // console.log('authorization = ', authorization);
    // const authorizationId = document.getElementsByName('profile_id')[0].value;
    // console.log('authorizationId = ', authorizationId);
    // // 创建要发送的数据对象
    // const data = {
    //     point: remainingPoint
    // };

    // // 创建请求头
    // const myHeaders = new Headers();
    // myHeaders.append("Authorization", 'Bearer ' + authorization);
    // myHeaders.append("Content-Type", "application/json");

    // // 创建请求选项
    // const requestOptions = {
    //     method: 'PATCH',
    //     headers: myHeaders,
    //     body: JSON.stringify(data), // 将数据转换为 JSON 字符串
    //     redirect: 'follow'
    // };
    // console.log('data=', JSON.stringify(data));
    // // 发送请求
    // fetch(apiIP + "api/point/userPoint/" + authorizationId + "/", requestOptions)
    //     .then(response => response.json()) // 使用 .json() 解析响应数据
    //     .then(result => {
    //         console.log(result);
    //         // 检查兑换是否成功，根据情况更新页面上的点数显示

    //         // 更新页面上的点数显示
    //         const pointElement = document.getElementById('user_total_points');
    //         const newPoint = result.point; // 从响应数据中获取新的点数值
    //         console.log('newPoint = ', newPoint);
    //         pointElement.textContent = newPoint;

    //         // 兑换成功后，显示提示框
    //         alert('兌換成功！');
    //     })
    //     .catch(error => {
    //         console.log('error', error);
    //         // 这里可以处理错误情况
    //     });

    const productItems = document.querySelectorAll(".pd-item");

    productItems.forEach((productItem, index) => {
        const pdNumElement = productItem.querySelector(".pd_num");
        const productNameElement = productItem.querySelector(".title");
        const productName = productNameElement.textContent.trim();
        const productQuantity = parseInt(pdNumElement.textContent, 10);
        if (productQuantity >= 1) {
            // console.log(`商品名稱: ${productName}, 數量: ${productQuantity}`);
            var myHeaders2 = new Headers();

            myHeaders2.append("Authorization", "Bearer " + authorization);

            var formdata = new FormData();
            formdata.append("product", productName);
            formdata.append("amount", productQuantity);

            var exchangeRequestOptions = {
                method: "POST",
                headers: myHeaders2,
                body: formdata,
                redirect: "follow",
            };

            fetch(apiIP + "api/point/exchange/", exchangeRequestOptions)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok.");
                    }
                    return response.json();
                })
                .then((data) => {
                    var formdata2 = new FormData();
                    formdata2.append("exchange", data["id"]);
                    // 後端會將 # 依序替換成 兌換數量、商品名稱、兌換總點數、剩餘點數
                    formdata2.append(
                        "content",
                        "您兌換了 # 個 # ，使用點數共 # 點，剩餘點數為 # 點!"
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
                })
                .catch((error) => {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "兌換失敗!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                });
        }
    });
}
