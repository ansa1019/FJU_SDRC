<fieldset>
    <p>親愛的 <span>{{ $nickname }}</span>：</p>
    <p>
        不知道現在的你過得好嗎？我相信這段時間你經歷了各種大大小小的事情，
        <br>有歡笑、有淚水，你很勇敢且努力的到了現在，我覺得你真的很棒！
    </p>
    <p>
        寫信的當下我 {{ $age2 }} 歲 (生日為 {{ $birthday }} )，
        身高 {{ $height }} 公分、體重 {{ $weight }} 公斤，
        我很喜歡現在我的樣子，你也一樣喜歡現在的自己嗎？
        我現在 {{ $married_state }}
        @if(!empty($pregnant_state))，而且 {{ $pregnant_state }}，不過我 {{ $birth_plan }}@endif，
        不知道未來看到信的你是否還是這樣呢？
    </p>
    <p>
        @if($disease == 0 && $allergy_state == 0 && $order == 0 && $drug == 0)
            現在的我整體都還可以，希望你也一切都好～
        @else
            現在的我 {{ $disease }} {{ $allergy_state }} {{ $order }} {{ $drug }}，不過整體都還可以，希望你也一切都好～
        @endif
    </p>
    <p>
        最後，不要忘記那個充滿熱情和夢想的自己……
    </p>
    <p class="mt-3">{{ $user_name }} 敬上</p>
    <span class="float-end">註冊日期{{ $today }}</span>
</fieldset>
