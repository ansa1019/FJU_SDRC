<fieldset>
    <p>
        親愛的
        <span class="step-tabs" id="nickname">{{ $nickname }}</span>
        ：
    </p>
    <p>
        不知道現在的你過得好嗎？我相信這段時間你經歷了各種大大小小的事情，
        <br />
        有歡笑、有淚水，你很勇敢且努力的到了現在，我覺得你真的很棒！
    </p>
    <p>
        寫信的當下我
        <span class="step-tabs" id="age2">{{ $age2 }}</span>
        歲(生日為
        <span class="step-tabs" id="birthday">{{ $birthday }}</span>
        )， 身高
        <span class="step-tabs" id="user_height">{{ $height }}</span>
        公分、體重
        <span class="step-tabs" id="user_weight">{{ $weight }}</span>
        公斤， 我很喜歡現在我的樣子，你也一樣喜歡現在的自己嗎？我現在
        <span class="step-tabs" id="married_state">{{ $married_state }}</span>
        <span class="onyly-show-famele">
            ， 而且
            <span class="step-tabs" id="pregnant_state">{{ $pregnant_state }}</span>
            ，不過我
            <span class="step-tabs" id="birth_plan">{{ $birth_plan }}</span>
        </span>
        ，不知道未來看到信的你是否還是這樣呢？
        <span class="onyly-show-famele">還是你已經邁入人生下一段旅程了呢？</span>
    </p>
    <p>
        現在的我
        <span class="step-tabs" id="disease">{{ $disease }}</span>
        <span class="step-tabs" id="allergy_state">{{ $allergy_state }}</span>
        <span class="step-tabs" id="order">{{ $order }}</span>
        <span class="step-tabs" id="drug">{{ $drug }}</span>
        ，不過整體都還可以，希望你也一切都好～
    </p>
    <p>
        最後，不要忘記那個充滿熱情和夢想的自己，或許時間會帶來許多變化，但是我希望你能一直保持那份初心和熱情，同時，我相信你現在也一定成為一個更好的人，希望未來的日子裡，你能找到屬於自己的步調，繼續成為一個更好的自己。
    </p>
    <p class="mt-3">
        <span class="step-tabs" id="username">{{ $user_name }}</span>
        敬上
    </p>
    <span class="float-end" id="today">註冊日期{{ $today }}</span>
</fieldset>
