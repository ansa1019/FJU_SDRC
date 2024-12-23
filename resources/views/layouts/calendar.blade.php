<!--日記彈出視窗-->
<!--初次記錄-->
<form method="POST" action="{{ route('Calendar') }}" enctype="multipart/form-data" id="daily_form">
    @csrf
    <div class="modal fade" id="first_daily_modal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">歡迎使用<label class="ct-txt-1">專屬月曆</label></h1>
                    <button type="button" class="btn-close" onclick="close_modal()" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: var(--fs-18)">
                    <div class="row d-flex justify-content-center py-3">
                        <p class="text-center">
                            每天記錄身體的日記，除了可以追蹤身體變化<br />
                            也可以讓我們為您推薦飲食和運動的建議，一起呵護婦科健康喔！
                        </p>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <label for="health_type" class="col-form-label">請選擇您目前的身體狀態<span
                                        class="i-imp">*</span></label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" id="health_type" name="health_type"
                                    onchange="daily_select_type(this)">
                                    <option selected value="menstruation">生理期：目前有月經；沒有小產或懷孕</option>
                                    <option value="miscarriage period">小產期：已進行小產或準備進行小產，且月經尚未恢復</option>
                                    <option value="pregnancy">懷孕期：正在懷孕</option>
                                    <option value="postpartum_period">產後期：已生產，月經尚未恢復</option>
                                    <option value="menopause">更年期</option>
                                </select>
                            </div>
                        </div>
                        <!--生理期-->
                        <div class="py-3 ps-lg-4 health_type" id="health_type_1">
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="type1_q1" class="col-form-label">・生理期週期(天)<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="number" id="type1_q1" name="menstrualCycle" class="form-control" 
                                        value="{{ $cycle ?? '' }}" />
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="type1_q2" class="col-form-label">・上次生理期開始日<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                    <input type="date" id="type1_q2" name="lastMenstrual" 
                                        class="form-control" onkeydown="return false;"  value="{{ $lastMenstrual ?? '' }}"@if($lastMenstrual) disabled @endif />
                                        <!-- <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="type1_q3" class="col-form-label">・每次月經大約來多少天<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="number" id="type1_q3" name="menstruationLast" class="form-control" 
                                        value="{{ $cycle_days ?? '' }}" />
                                </div>
                            </div>
                        </div>

                        <!--小產期-->
                        <div class="py-3 ps-lg-4 health_type d-none" id="health_type_2">
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="type2_q1" class="col-form-label">・小產的日期<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="text" id="type2_q1" name="miscarriageDay"
                                            class="form-control datepicker" onkeydown="return false;" />
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--懷孕期-->
                        <div class="py-3 ps-lg-4 health_type d-none" id="health_type_3">
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="type3_q1" class="col-form-label">・懷孕的週數<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="number" id="type3_q1" name="weeksPregnancy"
                                            class="form-control" value="{{ $cycle ?? '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="type3_q2" class="col-form-label">・預產的日期<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="date" id="dueDate" name="dueDate" class="form-control" onkeydown="return false;"
                                        value="{{ $dueDate ?? '' }}" />
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <!--產後期-->
                        <div class="py-3 ps-lg-4 health_type d-none" id="health_type_4">
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="type4_q1" class="col-form-label">・生產的日期<span class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="text" id="type4_q1" name="productionPeriod"
                                            class="form-control datepicker" onkeydown="return false;"/>
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--更年期-->
                        <div class="py-3 ps-lg-4 health_type d-none" id="health_type_5"></div>
                        <div class="row justify-content-center align-items-center mt-2">
                            <div class="col-auto">
                                <a class="btn btn-c2 rounded-pill" style="font-size: var(--fs-18)"
                                    onclick="first_daily_set(event)">前往記錄身體日記</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--日常記錄-->
    <div class="modal fade" id="daily_modal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <button class="btn float-start" data-bs-toggle="modal" data-bs-target="#first_daily_modal"><i
                                    class="bi bi-chevron-left"></i></button> --}}
                    <h1 class="modal-title fs-5 ct-txt-1">專屬月曆</h1>
                    <button type="button" class="btn-close" onclick="close_modal()" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: var(--fs-18)">
                    <div class="row d-flex justify-content-center mb-2">
                        <!--生理期-->
                        <div class="ps-sm-2 ps-md-4 daily_type" id="daily_type_1">
                            <div class="row align-items-center mb-1">
                                <div class="col-auto">
                                    <label for="type1_q1" class="col-form-label fw-bold">狀態</label>
                                </div>
                                <div class="col-auto">
                                    <label class="btn btn-c1 rounded-pill" id="health_type">生理期</label>
                                    <a class="btn btn-outline-c3 rounded-pill" onclick="toggle_modal()"><i
                                            class="fas fa-pen"></i></a>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="d_type1_q1" class="col-form-label fw-bold">日期</label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="text" id="d_type1_q1" name="menstrualPeriod"
                                            class="form-control datepicker" />
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <label for="d_type1_q2" class="col-form-label fw-bold">月經<span
                                            class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="radio" class="btn-check m-1" name="has_mc_type" id="has_mc"
                                        value="有" />
                                    <label class="btn btn-outline-c3 rounded-pill" for="has_mc">有月經</label>
                                    <input type="radio" class="btn-check m-1" name="has_mc_type" id="no_mc"
                                        value="沒有" />
                                    <label class="btn btn-outline-c3 rounded-pill" for="no_mc">沒有月經</label>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type1_q2" class="col-form-label">・月經量<span
                                                class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" name="mc_amount" id="mc_less"
                                            value="量少" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="mc_less">量少🩸</label>
                                        <input type="radio" class="btn-check m-1" name="mc_amount" id="mc_normal"
                                            value="量適中" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="mc_normal">量適中🩸🩸</label>
                                        <input type="radio" class="btn-check m-1" name="mc_amount" id="mc_more"
                                            value="量多" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="mc_more">量多🩸🩸🩸</label>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type1_q2" class="col-form-label">・經痛程度<span class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" name="pain_level" id="pain_no" value="不痛" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="pain_no">完全不痛</label>
                                        <input type="radio" class="btn-check m-1" name="pain_level" id="pain_less" value="輕微" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="pain_less">輕微(悶痛可忍)</label>
                                        <input type="radio" class="btn-check m-1" name="pain_level" id="pain_normal" value="中度" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="pain_normal">中度(止痛藥可緩解)</label>
                                        <input type="radio" class="btn-check m-1" name="pain_level" id="pain_more" value="嚴重" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="pain_more">嚴重(止痛藥無法緩解)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <label for="d_type1_q3" class="col-form-label fw-bold">症狀</label>
                                </div>
                                <div class="col-auto mt-0">
                                    <input type="checkbox" class="btn-check" name="menstrualPeriodHeadache"
                                        id="type1_q3_1" value="頭痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_1">頭痛</label>
                                    <input type="checkbox" class="btn-check" name="backache" id="type1_q3_2"
                                        value="腰痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_2">腰痛</label>
                                    <input type="checkbox" class="btn-check" name="hecticFever" id="type1_q3_3"
                                        value="潮熱" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_3">潮熱</label>
                                    <input type="checkbox" class="btn-check" name="breastTenderness" id="type1_q3_4"
                                        value="乳房脹痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_4">乳房脹痛</label>
                                    <input type="checkbox" class="btn-check" name="OvulationPain" id="type1_q3_5"
                                        value="排卵痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_5">排卵痛</label>
                                    <input type="checkbox" class="btn-check" name="menstrualPeriodConstipate"
                                        id="type1_q3_6" value="便秘" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_6">便秘</label>
                                    <input type="checkbox" class="btn-check" name="diarrhea" id="type1_q3_7"
                                        value="腹瀉" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_7">腹瀉</label>
                                    <input type="checkbox" class="btn-check" name="increasedSecretions"
                                        id="type1_q3_8" value="分泌物增加" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_8">分泌物增加</label>
                                    <input type="checkbox" class="btn-check" name="spottingHemorrhage"
                                        id="type1_q3_9" value="點狀出血" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type1_q3_9">點狀出血</label>
                                    <input type="checkbox" class="btn-check" id="type1_q3_10" value="其他" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type1_q3_10">其他：(請在右方填寫症狀)</label>
                                    <div class="d-inline-flex input-group w-auto">
                                        <input type="text" class="form-control input_underline ms-1"
                                            style="font-size: var(--fs-16)" name="menstrualPeriodOther"
                                            id="type1_q3_other" placeholder="請填寫其他症狀" />
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="d_type1_q4" class="col-form-label fw-bold">同房<span
                                            class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="radio" class="btn-check" name="roommate_type" id="noRoommate"
                                        value="沒有同房" />
                                    <label class="btn btn-outline-c3 rounded-pill my-1" for="noRoommate">沒有同房</label>
                                    <input type="radio" class="btn-check" name="roommate_type"
                                        id="roommateContraception" value="有，且有避孕" />
                                    <label class="btn btn-outline-c3 rounded-pill my-1"
                                        for="roommateContraception">有同房，有避孕</label>
                                    <input type="radio" class="btn-check" name="roommate_type"
                                        id="roommateNoContraception" value="有，但沒有避孕" />
                                    <label class="btn btn-outline-c3 rounded-pill my-1"
                                        for="roommateNoContraception">有同房，沒有避孕</label>
                                </div>
                            </div>
                        </div>
                        <!--小產期-->
                        <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_2">
                            <div class="row align-items-center mb-1">
                                <div class="col-auto">
                                    <label for="type1_q1" class="col-form-label fw-bold">狀態</label>
                                </div>
                                <div class="col-auto">
                                    <label class="btn btn-c1 rounded-pill" id="health_type">小產期</label>
                                    <a class="btn btn-outline-c3 rounded-pill" onclick="toggle_modal()"><i
                                            class="fas fa-pen"></i></a>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="d_type2_q1" class="col-form-label fw-bold">日期</label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="text" id="d_type2_q1" name="miscarriagePeriod"
                                            class="form-control datepicker" />
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <label for="d_type2_q2" class="col-form-label fw-bold">惡露<span
                                            class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="radio" class="btn-check m-1" id="miscarriagePeriodHas_loc"
                                        name="has_loc_type" value="有" />
                                    <label class="btn btn-outline-c3 rounded-pill"
                                        for="miscarriagePeriodHas_loc">有惡露</label>
                                    <input type="radio" class="btn-check m-1" id="miscarriagePeriodNo_loc"
                                        name="has_loc_type" value="沒有" />
                                    <label class="btn btn-outline-c3 rounded-pill"
                                        for="miscarriagePeriodNo_loc">沒有惡露</label>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type1_q2" class="col-form-label">・惡露量<span
                                                class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" id="miscarriagePeriodLoc_less"
                                            name="loc_amount" value="量少" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="miscarriagePeriodLoc_less">量少🩸</label>
                                        <input type="radio" class="btn-check m-1" id="miscarriagePeriodLoc_normal"
                                            name="loc_amount" value="量適中" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="miscarriagePeriodLoc_normal">量適中🩸🩸</label>
                                        <input type="radio" class="btn-check m-1" id="miscarriagePeriodLoc_more"
                                            name="loc_amount" value="量多" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="miscarriagePeriodLoc_more">量多🩸🩸🩸</label>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type1_q2" class="col-form-label">・惡露顏色<span
                                                class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" id="miscarriagePeriodLoc_red"
                                            name="loc_color" value="鮮紅色" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="miscarriagePeriodLoc_red">鮮紅色<i class="fas fa-tint ms-1"
                                                style="color: red"></i></label>
                                        <input type="radio" class="btn-check m-1" id="miscarriagePeriodLoc_darkred"
                                            name="loc_color" value="暗紅色" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="miscarriagePeriodLoc_darkred">暗紅色<i class="fas fa-tint ms-1"
                                                style="color: darkred"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <label for="d_type2_q3" class="col-form-label fw-bold">症狀</label>
                                </div>
                                <div class="col-auto mt-0">
                                    <input type="checkbox" class="btn-check" name="miscarriagePeriodContractions"
                                        id="type2_q3_1" value="宮縮陣痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_1">宮縮陣痛</label>
                                    <input type="checkbox" class="btn-check" name="miscarriagePeriodBackache"
                                        id="type2_q3_2" value="腰痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_2">腰痛</label>
                                    <input type="checkbox" class="btn-check" name="largeBloodClots" id="type2_q3_3"
                                        value="大量血塊" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type2_q3_3">大量的大塊血塊(直徑約5cm)</label>
                                    <input type="checkbox" class="btn-check" name="fever" id="type2_q3_4"
                                        value="發燒" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_4">發燒</label>
                                    <input type="checkbox" class="btn-check" name="nausea" id="type2_q3_5"
                                        value="噁心" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_5">噁心</label>
                                    <input type="checkbox" class="btn-check" name="vomit" id="type2_q3_6"
                                        value="嘔吐" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_6">嘔吐</label>
                                    <input type="checkbox" class="btn-check" name="dizziness" id="type2_q3_7"
                                        value="暈眩" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_7">暈眩</label>
                                    <input type="checkbox" class="btn-check" name="chestPain" id="type2_q3_8"
                                        value="胸部脹痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type2_q3_8">胸部脹痛</label>
                                    <input type="checkbox" class="btn-check" id="type2_q3_9" value="其他" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type2_q3_9">其他：(請在右方填寫症狀)</label>
                                    <div class="d-inline-flex input-group w-auto">
                                        <input type="text" class="form-control input_underline ms-1"
                                            style="font-size: var(--fs-16)" name="miscarriagePeriodOther"
                                            id="type2_q3_other" placeholder="請填寫其他症狀" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--懷孕期-->
                        <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_3">
                            <div class="row align-items-center mb-1">
                                <div class="col-auto">
                                    <label for="type3_q1" class="col-form-label fw-bold">狀態</label>
                                </div>
                                <div class="col-auto">
                                    <label class="btn btn-c1 rounded-pill" id="health_type">懷孕期</label>
                                    <a class="btn btn-outline-c3 rounded-pill" onclick="toggle_modal()"><i
                                            class="fas fa-pen"></i></a>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="d_type3_q1" class="col-form-label fw-bold">日期</label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="text" id="pregnancyPeriod" name="pregnancyPeriod"
                                            class="form-control datepicker" />
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <label for="d_type3_q2" class="col-form-label fw-bold">出血<span
                                            class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="radio" class="btn-check m-1" name="has_blood_type" id="has_blood"
                                        value="有" />
                                    <label class="btn btn-outline-c3 rounded-pill" for="has_blood">有出血</label>
                                    <input type="radio" class="btn-check m-1" name="has_blood_type" id="no_blood"
                                        value="沒有" />
                                    <label class="btn btn-outline-c3 rounded-pill" for="no_blood">沒有出血</label>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type3_q2" class="col-form-label">・出血量<span
                                                class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" name="blood_amount"
                                            id="blood_less" value="量少" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="blood_less">量少🩸</label>
                                        <input type="radio" class="btn-check m-1" name="blood_amount"
                                            id="blood_normal" value="量適中" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="blood_normal">量適中🩸🩸</label>
                                        <input type="radio" class="btn-check m-1" name="blood_amount"
                                            id="blood_more" value="量多" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="blood_more">量多🩸🩸🩸</label>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type3_q2" class="col-form-label">・出血顏色<span
                                                class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" name="blood_color"
                                            id="blood_pink" value="粉紅色" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="blood_pink">粉紅色<i
                                                class="fas fa-tint ms-1" style="color: deeppink"></i></label>
                                        <input type="radio" class="btn-check m-1" name="blood_color"
                                            id="blood_red" value="鮮紅色" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="blood_red">鮮紅色<i
                                                class="fas fa-tint ms-1" style="color: red"></i></label>
                                        <input type="radio" class="btn-check m-1" name="blood_color"
                                            id="blood_darkred" value="暗紅色" />
                                        <label class="btn btn-outline-c3 rounded-pill" for="blood_darkred">暗紅色<i
                                                class="fas fa-tint ms-1" style="color: darkred"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <label for="d_type3_q3" class="col-form-label fw-bold">症狀</label>
                                </div>
                                <div class="col-auto mt-0">
                                    <input type="checkbox" class="btn-check" name="vaginalBleeding" id="type3_q3_1"
                                        value="陰道出血" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_1">陰道出血</label>
                                    <input type="checkbox" class="btn-check" name="backPain" id="type3_q3_2"
                                        value="腰痠背痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_2">腰痠背痛</label>
                                    <input type="checkbox" class="btn-check" name="pregnancyChestPain"
                                        id="type3_q3_3" value="胸部脹痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_3">胸部脹痛</label>
                                    <input type="checkbox" class="btn-check" name="lowerAbdominalPain"
                                        id="type3_q3_4" value="下腹疼痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_4">下腹疼痛</label>
                                    <input type="checkbox" class="btn-check" name="pregnancyNausea" id="type3_q3_5"
                                        value="噁心" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_5">噁心</label>
                                    <input type="checkbox" class="btn-check" name="pregnancyVomit" id="type3_q3_6"
                                        value="嘔吐" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_6">嘔吐</label>
                                    <input type="checkbox" class="btn-check" name="pregnancyDizziness"
                                        id="type3_q3_7" value="頭暈" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_7">頭暈</label>
                                    <input type="checkbox" class="btn-check" name="pregnancyConstipate"
                                        id="type3_q3_8" value="便秘" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_8">便秘</label>
                                    <input type="checkbox" class="btn-check" name="pregnancyFrequentUrination"
                                        id="type3_q3_9" value="頻尿" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_9">頻尿</label>
                                    <input type="checkbox" class="btn-check" name="upsetStomach" id="type3_q3_10"
                                        value="胃部不適" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_10">胃部不適</label>
                                    <input type="checkbox" class="btn-check" name="pregnancyIndigestion"
                                        id="type3_q3_11" value="消化不良" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type3_q3_11">消化不良</label>
                                    <input type="checkbox" class="btn-check" id="type3_q3_12" value="其他" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type3_q3_12">其他：(請在右方填寫症狀)</label>
                                    <div class="d-inline-flex input-group w-auto align-items-center">
                                        <input type="text" class="form-control input_underline ms-1"
                                            style="font-size: var(--fs-16)" name="pregnancyOther" id="type3_q3_other"
                                            placeholder="請填寫其他症狀" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--產後期-->
                        <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_4">
                            <div class="row align-items-center mb-1">
                                <div class="col-auto">
                                    <label for="type4_q1" class="col-form-label fw-bold">狀態</label>
                                </div>
                                <div class="col-auto">
                                    <label class="btn btn-c1 rounded-pill" id="health_type">產後期</label>
                                    <a class="btn btn-outline-c3 rounded-pill" onclick="toggle_modal()"><i
                                            class="fas fa-pen"></i></a>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="d_type4_q1" class="col-form-label fw-bold">日期</label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="text" id="d_type4_q1" name="postpartumPeriod"
                                            class="form-control datepicker" />
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <label for="d_type4_q2" class="col-form-label fw-bold">惡露<span
                                            class="i-imp">*</span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="radio" class="btn-check m-1" id="postpartumPeriodHas_loc1"
                                        name="has_loc_type1" value="有" />
                                    <label class="btn btn-outline-c3 rounded-pill"
                                        for="postpartumPeriodHas_loc1">有惡露</label>
                                    <input type="radio" class="btn-check m-1" id="postpartumPeriodNo_loc1"
                                        name="has_loc_type1" value="沒有" />
                                    <label class="btn btn-outline-c3 rounded-pill"
                                        for="postpartumPeriodNo_loc1">沒有惡露</label>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type4_q2" class="col-form-label">・惡露量<span
                                                class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" id="postpartumPeriodLoc_less"
                                            name="loc_amount4" value="量少" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="postpartumPeriodLoc_less">量少🩸</label>
                                        <input type="radio" class="btn-check m-1" id="postpartumPeriodLoc_normal"
                                            name="loc_amount4" value="量適中" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="postpartumPeriodLoc_normal">量適中🩸🩸</label>
                                        <input type="radio" class="btn-check m-1" id="postpartumPeriodLoc_more"
                                            name="loc_amount4" value="量多" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="postpartumPeriodLoc_more">量多🩸🩸🩸</label>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-1">
                                    <div class="col-auto">
                                        <label for="type4_q2" class="col-form-label">・惡露顏色<span
                                                class="i-imp">*</span></label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="radio" class="btn-check m-1" id="postpartumPeriodLoc_red"
                                            name="loc_color4" value="鮮紅色" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="postpartumPeriodLoc_red">鮮紅色<i class="fas fa-tint ms-1"
                                                style="color: red"></i></label>
                                        <input type="radio" class="btn-check m-1" id="postpartumPeriodLoc_darkred"
                                            name="loc_color4" value="暗紅色" />
                                        <label class="btn btn-outline-c3 rounded-pill"
                                            for="postpartumPeriodLoc_darkred">暗紅色<i class="fas fa-tint ms-1"
                                                style="color: darkred"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <label for="d_type4_q3" class="col-form-label fw-bold">症狀</label>
                                </div>
                                <div class="col-auto mt-0">
                                    <input type="checkbox" class="btn-check" name="postpartumPeriodContractions"
                                        id="type4_q3_1" value="宮縮陣痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_1">宮縮陣痛</label>
                                    <input type="checkbox" class="btn-check" name="postpartumPeriodBackache"
                                        id="type4_q3_2" value="腰痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_2">腰痛</label>
                                    <input type="checkbox" class="btn-check" name="postpartumPeriodLargeBloodClots"
                                        id="type4_q3_3" value="大量血塊" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type4_q3_3">大量的大塊血塊(直徑約5cm)</label>
                                    <input type="checkbox" class="btn-check" name="lossOfAppetite" id="type4_q3_4"
                                        value="食慾不振" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_4">食慾不振</label>
                                    <input type="checkbox" class="btn-check" name="postpartumPeriodIndigestion"
                                        id="type4_q3_5" value="消化不良" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_5">消化不良</label>
                                    <input type="checkbox" class="btn-check" name="postpartumPeriodConstipate"
                                        id="type4_q3_6" value="便秘" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_6">便秘</label>
                                    <input type="checkbox" class="btn-check" name="itching" id="type4_q3_7"
                                        value="私密處搔癢/異味" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type4_q3_7">私密處搔癢/異味</label>
                                    <input type="checkbox" class="btn-check" name="postpartumPeriodChestPain"
                                        id="type4_q3_8" value="胸部脹痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type4_q3_8">胸部脹痛</label>
                                    <input type="checkbox" class="btn-check" id="type4_q3_9" value="其他" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type4_q3_9">其他：(請在右方填寫症狀)</label>
                                    <div class="d-inline-flex input-group w-auto">
                                        <input type="text" class="form-control input_underline ms-1"
                                            style="font-size: var(--fs-16)" name="postpartumPeriodOther"
                                            id="type4_q3_other" placeholder="請填寫其他症狀" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--更年期-->
                        <div class="ps-sm-2 ps-md-4 daily_type d-none" id="daily_type_5">
                            <div class="row align-items-center mb-1">
                                <div class="col-auto">
                                    <label for="type5_q1" class="col-form-label fw-bold">狀態</label>
                                </div>
                                <div class="col-auto">
                                    <label class="btn btn-c1 rounded-pill" id="health_type">更年期</label>
                                    <a class="btn btn-outline-c3 rounded-pill" onclick="toggle_modal()"><i
                                            class="fas fa-pen"></i></a>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <label for="d_type5_q2" class="col-form-label fw-bold">日期</label>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <input type="text" id="d_type5_q2" name="menopausePeriod"
                                            class="form-control datepicker" />
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <label for="d_type5_q3" class="col-form-label fw-bold">症狀</label>
                                </div>
                                <div class="col-auto mt-0">
                                    <input type="checkbox" class="btn-check" name="hotFlashes" id="type5_q3_1"
                                        value="熱潮紅" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_1">熱潮紅</label>
                                    <input type="checkbox" class="btn-check" name="nightSweats" id="type5_q3_2"
                                        value="盜汗" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_2">盜汗</label>
                                    <input type="checkbox" class="btn-check" name="coldHandsAndFeet" id="type5_q3_3"
                                        value="手腳冰冷" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_3">手腳冰冷</label>
                                    <input type="checkbox" class="btn-check" name="difficultyFallingAsleep"
                                        id="type5_q3_4" value="不易入睡" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_4">不易入睡</label>
                                    <input type="checkbox" class="btn-check" name="vaginalDryness" id="type5_q3_5"
                                        value="陰道乾澀" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_5">陰道乾澀</label>
                                    <input type="checkbox" class="btn-check" name="vaginalItching" id="type5_q3_6"
                                        value="陰道搔癢" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_6">陰道搔癢</label>
                                    <input type="checkbox" class="btn-check" name="menopauseFrequentUrination"
                                        id="type5_q3_7" value="頻尿" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_7">頻尿</label>
                                    <input type="checkbox" class="btn-check" name="menopauseHeadache"
                                        id="type5_q3_8" value="頭痛" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1" for="type5_q3_8">頭痛</label>
                                    <input type="checkbox" class="btn-check" id="type5_q3_9" value="其他" />
                                    <label class="btn btn-outline-c3 rounded-pill m-1"
                                        for="type5_q3_9">其他：(請在右方填寫症狀)</label>
                                    <div class="d-inline-flex input-group w-auto">
                                        <input type="text" class="form-control input_underline ms-1"
                                            style="font-size: var(--fs-16)" name="menopauseOther" id="type5_q3_other"
                                            placeholder="請填寫其他症狀" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center align-items-center mt-2">
                            <div class="col-auto">
                                <button type="submit" id="add_daily_btn" class="btn btn-c2 rounded-pill"
                                    style="font-size: var(--fs-18)">記錄</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
