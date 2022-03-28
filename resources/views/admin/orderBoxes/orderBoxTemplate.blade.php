<div class="form-group box-section border-bottom">
    <div class="row">
        <h3  class="card-title">新箱子</h3>
        <a href="javascript:void(0);" class="delete-box btn btn-sm btn-outline-danger ml-3">
            <i class="fa fa-times"> 刪除箱子</i>
        </a>
    </div>
    <div class="form-group row">
        <div class="form-group col-md-2">
            <label for="box_weight">GW 毛重(KG)</label>
            <input type="number" class="form-control form-required" name="box_weight[]" id="box_weight"  min="0" step="0.1">
        </div>
        <div class="form-group col-md-1 align-self-center">
            <label>材積(CM) :</label>
        </div>
        <div class="form-group col-md-1">
            <label for="box_length">長</label>
            <input type="number" class="form-control form-required" name="box_length[]" id="box_length"  min="0" step="0.1">
        </div>
        <div class="form-group col-md-1">
            <label for="box_width">寬</label>
            <input type="number" class="form-control form-required" name="box_width[]" id="box_width"  min="0" step="0.1">
        </div>
        <div class="form-group col-md-1">
            <label for="box_height">高</label>
            <input type="number" class="form-control form-required" name="box_height[]" id="box_height"  min="0" step="0.1">
        </div>
        <div class="form-group col-md-2">
            <label for="box_price">箱子費用(未稅)</label>
            <input type="number" class="form-control form-required" name="box_price[]" id="box_price">
        </div>
        <div class="form-group col-md-4">
            <label for="tracking_number">宅配單號</label>
            <input type="text" class="form-control" name="tracking_number[]" id="tracking_number">
        </div>
    </div>
    <div class="row mb-2 add-item-div">
        <h3 class="card-title">裝箱內容</h3>
        <a href="javascript:void(0);" class="add-item btn btn-sm btn-outline-secondary ml-3">
            <i class="fa fa-plus"> 新增內容</i>
        </a>
    </div>
    <div class="item-wrapper bg-gray-light ">
        <input type="hidden" class="box-item-num" name="box_items_num[]" value="1" >
        <div class="form-group row item-section">
            <div class="form-group col-md-3">
                <label for="item_name">商品描述</label>
                <input type="text" class="form-control form-required" name="item_name[]" id="item_name" placeholder="請填寫英文">
            </div>
            <div class="form-group col-md-3">
                <label for="item_num">數量</label>
                <input type="number" class="form-control form-required" name="item_num[]" id="item_num">
            </div>
            <div class="form-group col-md-3">
                <label for="unit_price">單價(USD)</label>
                <input type="number" class="form-control form-required" name="unit_price[]" id="unit_price"  min="0" step="0.1">
            </div>
            <div class="form-group col-md-1">
                <a href="javascript:void(0);" class="delete-item btn btn-sm btn-danger ml-3">
                    <i class="fa fa-minus"> 刪除</i>
                </a>
            </div>
        </div>
    </div>
</div>
