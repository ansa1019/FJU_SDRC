<!DOCTYPE html>
<html>

<head>
    <title>驗證碼發送信件</title>
</head>

<body>
    <h3 style="color: black;">您好{{ $user_name }}：</h3>
    <h3 style="color: black;">我們收到您在莎莉聊療吧重設密碼的要求，為了確認這真的是您本人，請輸入下方驗證碼至莎莉聊療吧官網重設密碼，謝謝！</h3>
    <h2 style="color: black;">您的驗證碼：<span style="color: blue;">{{ $verification_code }}</span></h2>
    <h3 style="color: black;">若有任何問題，請來信客服信箱，謝謝！</h3>

</body>

</html>
