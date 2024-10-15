@extends('layouts.masterpage')
@section('title', '莎莉聊療吧 - 優德莎莉')
@section('content')
    <style>
        #calendar {
            font-size: var(--fs-18);
        }

        /* #events .list {
                    height: 150px;
                    overflow-y: auto;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
                }
                #events .list .event-item {
                    line-height: 24px;
                    min-height: 24px;
                    padding: 2px 5px;
                    border-top: 1px solid rgba(0, 0, 0, 0.2);
                }
                #events .list .event-item .close {
                    font-family: Tahoma, Geneva, sans-serif;
                    font-weight: bold;
                    font-size: 12px;
                    color: #000;
                    border-radius: 8px;
                    height: 14px;
                    width: 14px;
                    line-height: 12px;
                    text-align: center;
                    float: right;
                    border: 1px solid rgba(0, 0, 0, 0.5);
                    padding: 0px;
                    margin: 5px;
                    display: block;
                    overflow: hidden;
                    background: #f44336;
                    cursor: pointer;
                } */
    </style>
    <?php
    $json = json_encode($subPersonalCalendar);
    echo "<script>
                    var subPersonalCalendar = $json;
                    subPersonalCalendar.sort((a,b) => a.last_nom - b.last_nom);
                </script>";
    ?>
    <div class="container-xxl">
        <div class="row pt-3 px-md-5">
            <div class="col-12 my-2">
                <nav class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">個人資料</a></li>
                        <li class="breadcrumb-item active" aria-current="page">專屬月曆</li>
                    </ol>
                </nav>
                <div class="row d-flex align-items-center">
                    <h2 class="class-title col-auto ps-0"><i class="fab fa-gratipay me-1 ct-txt-1"></i>專屬月曆</h2>
                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-primary text-center">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row px-md-5">
            <div class="col-md col-lg-9 pe-md-4">
                <div class="row mt-2 d-flex align-items-center justify-content-end">
                    <div class="col-sm-12 col-md-auto px-0">
                        <button id="today_btn" type="button" class="btn btn-c2 rounded-pill mx-1">Today</button>
                    </div>
                    <div class="col-md px-0 text-end" style="font-size: var(--fs-15); font-style: italic">
                        <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #ffc64c"></i>生理期</span>
                        <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #f6511d"></i>小產期</span>
                        <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #fe72a9"></i>懷孕期</span>
                        <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #53d2dc"></i>產後期</span>
                        <span class="me-1"><i class="bi bi-circle-fill px-1" style="color: #808080"></i>更年期</span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md col-lg-auto px-0 d-flex justify-content-center">
                        <div id="calendar" class="material-theme mx-auto" tabindex="-1"></div>
                    </div>
                    <div class="col-md-12 col-lg p-4">
                        <h4 class="fw-bold" id="event-title" style="font-size: var(--fs-24)"></h4>
                        @if ($nickname != '')
                            @php
                                // 檢查 $personalCalendar 是否為空
                                if (!empty($personalCalendar)) {
                                    $period = end($personalCalendar)['type'];
                                } else {
                                    $period = 'general';
                                }
                            @endphp
                        @else
                            @php
                                $period = 'general';
                            @endphp
                        @endif
                        @php
                            $generalCalmsg = [
                                '脂肪含量高的食物，例如：高脂、油炸食品，會讓消化速度變得緩慢，氣體可能會滯留在消化道中，可能導致脹氣。',
                                '吃飽後，建議避免躺下、坐著或趴下睡覺，可以散步多走動20分鐘，以避免脹氣。',
                                '專心吃飯、少喝產氣飲料、三餐規律進食，同時避免一下子採取高纖維飲食，或是短時間內吃太快、太多的高纖維蔬菜，可避免脹氣。',
                                '建議可以找尋容易讓自己脹氣的食物，並加以避免或是減少攝取，同時，建議可以選擇低腹敏食物，例如：白米、糙米、蛋、葉菜類青菜、奇異果、木瓜等。',
                                '由於加工食品的內部鈉含量較高，容易使身體傾向於保住水分而有脹氣感。',
                                '由於脂肪含量高食物，其飽和脂肪較多，容易造成胃排空減慢，導致脹氣。',
                                '由於豆類食品的內含寡糖、膳食纖維飽腹感強，到達結腸前無法分解消化，若將豆類煮熟後，會有白色泡沫浮起，這些泡沫為造成脹氣的棉籽糖成分，可以將白色泡沫撈起，能降低脹氣的狀況。',
                                '由於十字花科蔬菜，成分內含單醣與寡糖，小腸無法吸收消化，容易停在腸道裡發酵產氣， 或導致過多水分移至腸道中，因此大量食用十字花科蔬菜容易導致脹氣',
                                '益生菌服用以外，日常餐食需搭配足量膳食纖維，才可以讓好菌定居於腸道喔！',
                                '根據2020年衛生福利部公告新版（第8版）「國人 膳食營養素參考攝取量(DRIs)」指出，19歲以上成人每日膳食纖維建議攝取量大約為20-38公克（依年齡、性別、活動量、總熱量攝取而不同），有足量膳食纖維，可減少排便不順喔！',
                                '腸道菌叢可以將纖維切碎成短鏈脂肪酸，運輸至血液與肝臟提供能量運用，強化保護腸道的黏液， 並穩定免疫細胞，減少全身性的發炎反應。',
                                '若排便不順，飲食可多選用纖維豐富的蔬菜、未精緻（未去除外層）的全榖雜糧類與堅果種子，種類越多樣越好，例如：南瓜、糙米、白鳳豆、豌豆仁、木耳、毛豆、小黃瓜、紅鳳菜等。',
                                '若排便不順，一天可以攝取至少2000毫升的液體；若有胃食道逆流問題，可以固態、液態分開吃，飯前半小時與飯後一小時不要喝水， 讓足夠消化液與胃酸分泌，以利消化食物。',
                                '益生菌可透過保健食品規律補充外，天然發酵食物如：味噌、康普茶、優格，也可以幫助腸道好菌生長與維持多元性，尤其壓力大、正在使用抗生素的人與銀髮族需要額外補充益生菌。 ',
                                '運動足夠的成人，罹患心臟病和中風的機率較低，血壓及血脂肪也較低。每週累積150分鐘的中等費力身體活動（例如：韻律活動、健走、騎腳踏車、游泳等），可以降低罹患心血管疾病的風險，而每週達到200分鐘可以降更多心血管疾病的風險。',
                                '良好的心肺耐力，可以減少疲勞、降低冠狀動脈心臟疾病、高血壓、糖尿病和其他慢性病的危險因子，建議每週至少規律運動三次，每次至少二十分鐘，強度為稍流汗並自覺有點喘又不會太喘，例如：跑步、快走、游泳、踩腳踏車等。',
                                '強大的肌力可以增加抬舉物品的能力，並降低肌肉骨骼性的傷害，建議每週至少規律運動二次，每次至少一至三回合，每回合之間休息2～3分鐘，每次訓練8～10個身體部位，例如：引體向上、伏地挺身、重量訓練等。',
                                '每週120至150分鐘的中等費力有氧運動（例如：韻律活動、健走、騎腳踏車、游泳等）可以有效降低第二型糖尿病（非胰島素依賴型）和代謝症候群（例如：血壓偏高、腹部肥胖、血糖偏高、血脂偏高等）的危險。',
                                '良好的下背及腿後肌群柔軟度，可以減少發生下背痛及其他骨骼、關節受傷的問題，建議每週規律運動三次到五次，每次訓練8～10個身體部位，強度為伸展至肌肉有明顯繃緊的狀態(不會過於疼痛)，例如伸展操、瑜伽等。',
                                '18~64歲成人最佳睡眠時數建議為7~9小時/天，良好的睡眠習慣如：安靜舒適的睡眠環境、固定的生活作息，睡前避免做劇烈運動、滑手機、看電視、少喝含咖啡因的飲料，可以讓身心處在平靜狀態，讓我們夜夜好眠！',
                                '研究證實每週3-5天，一次 30-60分鐘的有氧和肌力強化活動，可以降低憂鬱和認知功能衰退，同時也能提昇睡眠品質，而即便是輕度的身體活動，對促進心理健康一樣有幫助。',
                                '清潔私密處時，以溫水清潔尤佳，不要過度搓洗，且勿過度使用清潔產品，以免破壞陰道菌叢環境，若陰道菌叢環境被破壞，會導致酸鹼值提高，使異物、壞菌趁虛而入，造成私密處搔癢、發炎、白帶變多的情況，而有敏感肌肌膚的女生更是不能使用清潔產品。 ',
                                '女生私密處存有許多細菌，其中以乳酸菌為主的好菌有助於維持私密處呈現弱酸的環境（陰道的酸鹼值約pH3.5至4.5，外陰部為pH5.5），可減少壞菌侵入並預防黴菌滋生。',
                                '因女生泌尿道與陰道距離很近，當陰道過於乾燥或酸鹼值改變而滋生細菌，就容易於泌尿道孳生，一路衍伸到陰道使陰道感染，因此建議可以多喝水，藉由排尿將細菌沖出體外，降低發炎與感染的風險。',
                                '為了避免緊身衣物造成女生私密處潮濕悶熱，影響陰道乳酸菌叢失衡，引發陰道炎，建議平時盡量穿著寬鬆衣物或棉質的內褲，降低發炎與感染的風險。',
                                '作息不正常、熬夜都會使免疫力下降，造成私密處反覆發炎，建議平常作息規律、少熬夜，使免疫力維持，降低發炎與感染的風險。',
                                '由於涼性與刺激性食物容易造成寒濕體質，增加私密處感染風險，因此建議少吃刺激性、涼性食物，並均衡攝取六大類食物。 ',
                                '因性行為容易帶來外部細菌與改變陰道原有平衡狀態，建議單一性伴侶，來減少感染風險，同時性行為後可排空膀胱尿液並適度清潔，可幫助保護私密處衛生安全。',
                            ];
                            $menstruationCalmsg = [
                                '補充水分可以減輕經痛的症狀，記得避免酒精與咖啡因喔，因為酒精與咖啡因會利尿，容易造成身體缺水的情況。',
                                '吃營養食物可以緩解經痛，可以多攝取含有維生素 E、B1、B6、鎂、鋅、omega-3脂肪酸食物喔！像是堅果、鮭魚、鯖魚、魚油都是很好的食物，能緩解肌肉痙攣與發炎。',
                                '可以在醫師或營養師指示下補充維生素E，在生理期前兩天開始使用至經期第三天，透過每日兩次維生素E，一次是200國際單位，或每日一次，一次 500國際單位。',
                                '建議可以吃薑、富含鈣（如：小魚干、芝麻牛奶、板豆腐、莧菜、堅果）、鎂（如：菠菜、芥菜等等深綠色蔬菜、南瓜子）的食物，以及好油脂（omega-3脂肪酸），如：含 EPA與 DHA食物與油性魚類（鯖魚、秋刀魚、鮭魚與鮪魚）。',
                                '若生理期無明顯症狀可以正常運動，如果有經痛問題可透過適當伸展與瑜珈緩解不適。',
                                '生理期間盡量避開高強度核心訓練，避免下腹腫脹時額外的刺激與出力。',
                                '經期來時（約4-5天）可安排休息日、伸展與瑜珈，經期流量高峰結束後可以進行上肢訓練。 ',
                                '如果有在做重量訓練，想要突破重量與增加訓練次數總量，可於經期結束後，開始著重於下肢與稍高強度的訓練，以大重量、低組數的方式，刺激休息快一週的肌群，有經痛者請依專業建議調整。',
                                '有在做重量訓練的話，生理期前一週是黃體期（接近經期的時間），適合減量（減少重量與組數）訓練，增加有氧訓練的頻率，有經痛者請依專業建議調整。',
                                '生理期前，建議可以多吃含膳食纖維、維生素B群(B1、B6)與優質蛋白質喔，例如：海鮮、魚肉、豆腐、豆干或無糖豆漿等等。',
                            ];
                            $menopauseCalmsg = [
                                '根據過去研究顯示，三高疾病、心臟病及腦血管疾病會對更年期後的女性造成威脅，因此應該避免不良生活習慣與定期量測血壓，建議婦女可每年至少量測一次血壓，血壓異常者則應每天早晚各量測一次， 監測自我狀況，也避免過度飲用咖啡與熬夜。 ',
                                '女性更年期後，因為賀爾蒙的變化，骨質流失的速度也會加快，建議可以規律運動與控制體重，透過每週150分鐘以上中等強度身體活動，可選擇阻力運動並循序漸進練習，並配合飲食與適當日曬增加骨質密度與增加肌肉含量、降低跌倒、衰弱問題發生率。',
                                '女性更年期後，因為賀爾蒙的變化，骨質流失的速度也會加快，除了運動外，建議進行健康飲食與增加鈣質攝取， 鈣質攝取來源包含黑芝麻、牛奶、優酪乳、起司等。',
                                '女性更年期後，因為賀爾蒙的變化，建議多補充鐵質、維生素 D、蛋白質、適量原型食物的植物雌激素，減緩生理與心理的不適。',
                            ];
                            $miscarriageCalmsg = [
                                '小產後，惡露（出血）期間建議多休息，確保充足睡眠。',
                                '由於小產後子宮相對脆弱，如果使用到腹部力量運動類型容易造成再次出血，建議從輕度運動（散步、瑜珈）開始，循序漸進增加強度喔！',
                                '小產後，至少一個月內避免劇烈運動、搬重物、抱小孩、久站或長時間走動。',
                                '小產後，避免衛生棉條以免阻礙出血或增加感染風險，可使用夜用或量多型衛生棉，並勤勞更換。',
                                '小產後，避免任何泡水活動，包含泡溫泉、游泳、泡澡等，洗澡建議採用淋浴的方式喔！',
                                '小產後，可以維持適度日常活動、適度散步有助於子宮收縮排血，避免長時間臥床。',
                                '小產後，避免工作過勞、長時間走路或久站、跑步、重量訓練等激烈運動，以免造成再次出血。',
                                '小產後，由於子宮相對脆弱，盡量避免爬樓梯、搬提重物等刺激腹部收縮的動作。',
                                '小產後，體力許可情況下是可以正常上班，若身體虛弱則建議請假休息1-3天。',
                                '小產一個月內暫停性行為，三個月內確實避孕（高齡產婦情況特殊可另行與醫生討論）。',
                            ];
                            if ($period == 'menstruation') {
                                $calmsg = $menstruationCalmsg;
                            } elseif ($period == 'menopause') {
                                $calmsg = $menopauseCalmsg;
                            } elseif ($period == 'miscarriage period') {
                                $calmsg = $miscarriageCalmsg;
                            } else {
                                $calmsg = $generalCalmsg;
                            }
                            $rdmcalmsg = $calmsg[array_rand($calmsg)];
                        @endphp
                        <div class="my-3" id="events"
                            style="font-size: var(--fs-16); line-height: var(--fs-28); text-align: justify">
                            <p class="ct-sub-1" style="line-height: 1.75rem; letter-spacing: 1px">{{ $rdmcalmsg }}
                            </p>
                            <!-- 顯示下次生理期預測 -->
                            @if ($nextMenstrualDate)
                                <div id="next-menstrual" class="mt-2" style="font-size: var(--fs-16);">
                                    下次生理期預計：{{ \Carbon\Carbon::parse($nextMenstrualDate)->format('n月j日') }}
                                </div>
                            @endif



                            <div class="h5 my-3 list px-1" id="event-reminder" style="display: none"></div>
                            <div class="my-3 list px-1" id="event-content">
                                <div id="nextMenstrualDateDisplay" class="h5"></div>
                            </div>
                        </div>

                        <!--判斷用戶是否初次使用-專屬月曆-->
                        @if (!empty($personalCalendar))
                            <button class="btn btn-c2 rounded-pill me-1" data-bs-toggle="modal"
                                data-bs-target="#daily_modal"
                                onclick="open_modal('{{ array_pop($personalCalendar)['type'] }}')">寫下今天的身體日記</button>
                        @else
                            <!--初次使用-專屬月曆 顯示該按鈕-->
                            <button class="btn btn-c2 rounded-pill me-1" data-bs-toggle="modal"
                                data-bs-target="#first_daily_modal" onclick="open_modal('undefined')">寫下今天的身體日記</button>
                        @endif
                    </div>
                </div>
            </div>
            @include('layouts.sidebar')
        </div>

        @include('layouts.calendar')
    </div>
@endsection
