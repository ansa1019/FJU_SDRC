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
                        @php
                            $calmsg = [
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
                            ];
                            $rdmcalmsg = array_rand($calmsg);
                        @endphp
                        <div class="my-3" id="events"
                            style="font-size: var(--fs-16); line-height: var(--fs-28); text-align: justify">
                            <p class="ct-sub-1" style="line-height: 1.75rem; letter-spacing: 1px">{{ $calmsg[$rdmcalmsg] }}
                            </p>
                            <div class="subtitle badge rounded-pill bg-secondary" style="color: white">No events</div>
                            <div class="h5 my-3 list px-1" id="event-reminder" style="display: none"></div>
                            <div class="my-3 list px-1" id="event-content"></div>
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
