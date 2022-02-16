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
