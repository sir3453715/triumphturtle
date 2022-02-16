<div class="add-box box-section">
    <button type="button" class="btn btn-md btn-red mb-3 remove-box">刪除箱子</button>
    <div class="row">
        <div class="form-group col-12">
            <label for="">毛重 <small class="help">(kg)</small></label>
            <input type="number" class="form-control form-required" name="box_weight[]" id="box_weight" min="0" step="0.1">
        </div>
    </div>
    <h5 class="mb-2">材積（CM)</h5>
    <div class="row">
        <div class="form-group col-4">
            <label for="">長</label>
            <input type="number" class="form-control form-required" name="box_length[]" id="box_length" min="0" step="0.1">
        </div>
        <div class="form-group col-4">
            <label for="">寬</label>
            <input type="number" class="form-control form-required" name="box_width[]" id="box_width" min="0" step="0.1">
        </div>
        <div class="form-group col-4">
            <label for="">高</label>
            <input type="number" class="form-control form-required" name="box_height[]" id="box_height" min="0" step="0.1">
        </div>
    </div>
    <div class="d-block d-md-flex align-items-center mt-4 mb-3 add-item-div">
        <div class="cus-form-header mb-0">
            <img src="/storage/image/box-plus-icon.svg" alt="裝箱商品描述圖示">
            <h2 class="mr-4">裝箱商品描述</h2>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-dark-gray mt-2 mt-md-0 add-item-btn">＋新增內容</button>
        </div>
    </div>
    <div class="item-wrapper">
        <input type="hidden" class="box-item-num" name="box_items_num[]" value="1">
        <div class="row mb-3 item-section">
            <div class="form-group col-12">
                <label for="">商品描述</label>
                <input type="text" class="form-control form-required" name="item_name[]" id="item_name">
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="">數量</label>
                <input type="number" class="form-control form-required change-num" name="item_num[]" id="item_num">
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="">單價<small class="help">(USD)</small></label>
                <input type="number" class="form-control form-required change-price" name="unit_price[]" id="unit_price" min="0" step="0.1">
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="">價值<small class="help">(USD)</small></label>
                <div> <span class="show-price">XXX</span><small class="help">USD</small></div>
            </div>
            <div class="col-6 col-md-3 d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-red remove-item">刪除</button>
            </div>
        </div>
    </div>
</div>
