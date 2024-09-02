@isset($nickname)
    <script>
        var user = "{{ session('user_email') }}";
        var user_image = "{{ session('user_image') }}";
        var nickname = "{{ session('nickname') }}";
        var blacklist = @json(session('blacklist')) || {article: [], comment: [], chat: []};
        var banlist = @json(session('banlist'));

        console.log(banlist);
        console.log(blacklist)
    </script>
@endisset



<!-- 建立檢舉 Modal -->
<div class="modal fade" id="denounce" tabindex="-1" data-bs-focus="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h3 class="modal-title fs-5 ct-txt-2 fw-bold"><i class="fa fa-exclamation-circle fa-sm"></i> 檢舉原因
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: var(--fs-18)">
                <input type="text" style="display: none" id="denounce_cate">
                <input type="text" style="display: none" id="denounce_id">
                <input type="text" style="display: none" id="denounce_name">
                <input type="text" style="display: none" id="denounce_msg">
                <input type="text" style="display: none" id="denounce_reason">
                <div>
                    <input class="form-check-input" type="radio" name="reason" id="reason_1"
                        value="中傷、歧視、挑釁或謾罵他人" />
                    <label class="form-check-label" for="reason_1">中傷、歧視、挑釁或謾罵他人</label>
                </div>
                <div>
                    <input class="form-check-input" type="radio" name="reason" id="reason_2" value="惡意洗版、重複張貼" />
                    <label class="form-check-label" for="reason_2">惡意洗版、重複張貼</label>
                </div>
                <div>
                    <input class="form-check-input" type="radio" name="reason" id="reason_3"
                        value="發表內容包含色情、性騷擾、恐怖血腥等讓人不舒服之內容" />
                    <label class="form-check-label" for="reason_3">發表內容包含色情、性騷擾、恐怖血腥等讓人不舒服之內容</label>
                </div>
                <div id="denounce_other">
                    <input class="form-check-input" type="radio" name="reason" id="reason_4" value="其他">
                    <label class="form-check-label" for="reason_4">其他</label>
                    <input type="text" id="reason_other" placeholder="請說明檢舉原因"
                        class="form-control col-auto input_underline" style="display: none;width: auto">
                </div>
            </div>
            <div class="modal-footer" style="border: none;">
                <button type="button" class="btn btn-c2 rounded-pill px-3 py-1" onclick="denounce()">確定</button>
                <button type="button" class="btn ct-sub-1" data-bs-dismiss="modal" aria-label="Close">取消</button>
            </div>
        </div>
    </div>
</div>
