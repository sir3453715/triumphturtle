<div class="form-group row item-section">
    <div class="form-group col-md-3">
        <label for="item_name">商品描述</label>
        <input type="text" class="form-control form-required" name="item_name[]" id="item_name" value="" placeholder="請填寫英文">
    </div>
    <div class="form-group col-md-3">
        <label for="item_num">數量</label>
        <input type="number" class="form-control form-required" name="item_num[]" id="item_num" value="">
    </div>
    <div class="form-group col-md-3">
        <label for="unit_price">單價(USD)</label>
        <input type="number" class="form-control form-required" name="unit_price[]" id="unit_price"  min="0" step="0.1" value="">
    </div>
    <div class="form-group col-md-1">
        <a href="javascript:void(0);" class="delete-item btn btn-sm btn-danger ml-3">
            <i class="fa fa-minus"> 刪除</i>
        </a>
    </div>
</div>
