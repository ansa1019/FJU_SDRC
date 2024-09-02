// public/js/api.js

document.addEventListener('DOMContentLoaded', function() {
    // 获取按钮元素
    const fetchDataButton = document.getElementById('get_article_fetchDataButton');

    // 添加点击事件处理程序
    fetchDataButton.addEventListener('click', function() {
        // 发送 Fetch 请求到指定的 API
        fetch("{{ env('API_IP') }}/api/content/textEditorPost/")
            .then(response => response.json())
            .then(data => {
                // 处理返回的数据
                console.log(data);
                // 在页面上显示数据或执行其他操作
            })
            .catch(error => {
                console.error('Fetch Error:', error);
            });
    });
});