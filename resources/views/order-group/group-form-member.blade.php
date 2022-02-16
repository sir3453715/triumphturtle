@extends('layouts.app')

@section('content')
<div class="main-wrapper">
    <section class="banner-wrapper">
        <div class="banner container">
            <div><img src="/storage/image/group-member-icon.svg" alt="下線寄送">
                <h1>下線寄送</h1>
            </div>
        </div>
    </section>
    <section class="container">
        <form class="cus-form cus-form-fill" action="">
            <fieldset class="cus-form-wrap">
                <div class="cus-form-header">
                    <img src="/storage/image/box-out-icon.svg" alt="寄件資訊圖示">
                    <h2>寄件資訊</h2>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="name">姓名*</label>
                        <input type="text" class="form-control" placeholder="請填寫中文姓名">
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">聯絡電話*</label>
                        <input type="text" class="form-control" placeholder="聯絡電話">
                    </div>
                    <div class="form-group col-12">
                        <label for="address">地址*</label>
                        <input type="text" class="form-control" placeholder="請填寫中文地址">
                    </div>
                    <div class="form-group col-6">
                        <label for="email">電子信箱*</label>
                        <input type="text" class="form-control" placeholder="輸入電子信箱">
                    </div>
                    <div class="form-group col-6">
                        <label for="emailConfirm">再次輸入電子信箱*</label>
                        <input type="text" class="form-control" placeholder="再次輸入電子信箱">
                        <div class="invalid-feedback">輸入電子信箱錯誤</div>
                    </div>
                </div>
            </fieldset>
            <hr>
            <fieldset class="cus-form-wrap">
                <div class="cus-form-header">
                    <img src="/storage/image/box-in-icon.svg" alt="收件資訊圖示">
                    <h2>收件資訊</h2>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="name">姓名*</label>
                        <input type="text" class="form-control" placeholder="請填寫中文姓名">
                    </div>
                    <div class="form-group col-6">
                        <label for="phone">聯絡電話*</label>
                        <input type="text" class="form-control" placeholder="聯絡電話">
                    </div>
                    <div class="form-group col-12">
                        <label for="address">地址*</label>
                        <input type="text" class="form-control" placeholder="請填寫中文地址">
                    </div>
                </div>
            </fieldset>
            <hr>
            <fieldset class="cus-form-wrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="cus-form-header mb-0">
                        <img src="/storage/image/box-form-icon.svg" alt="裝箱資訊圖示">
                        <h2>裝箱資訊</h2>
                    </div>
                    <div>
                        <button type="button" class="btn btn-md btn-orange">＋新增一箱</button>
                    </div>
                </div>
                <!-- 裝箱卡 -->
                <div class="add-box">
                    <button type="button" class="btn btn-md btn-red mb-3">刪除箱子</button>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="">毛重 <small class="help">(kg)</small></label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                    </div>
                    <h5 class="mb-2">材積（CM)</h5>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="">長</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-4">
                            <label for="">寬</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-4">
                            <label for="">高</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="d-block d-md-flex align-items-center mt-4 mb-3">
                        <div class="cus-form-header mb-0">
                            <img src="/storage/image/box-plus-icon.svg" alt="裝箱商品描述圖示">
                            <h2 class="mr-4">裝箱商品描述</h2>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-dark-gray mt-2 mt-md-0">＋新增內容</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-12">
                            <label for="">商品描述</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label for="">數量</label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label for="">單價<small class="help">(USD)</small></label>
                            <input type="number" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label for="">價值<small class="help">(USD)</small></label>
                            <div> XXX <small class="help">USD</small></div>
                        </div>
                        <div class="col-6 col-md-3 d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-red">刪除</button>
                        </div>
                    </div>
                </div>
            </fieldset>
            <hr>
            <fieldset class="cus-form-wrap">
                <div class="cus-form-header">
                    <img src="/storage/image/paper-icon.svg" alt="發票圖示">
                    <h2>發票</h2>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name">發票選擇*<small class="help">(需額外加5%)</small></label>
                        <select class="form-control">
                            <option value="" hidden>請選擇發票類型</option>
                            <option>三聯</option>
                            <option>二聯</option>
                            <option>不需要</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-lg btn-solid btn-blue btn-block mt-4 mb-4">填寫完畢送出</button>
            </fieldset>
        </form>

    </section>
</div>
@endsection