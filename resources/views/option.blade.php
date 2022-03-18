@extends('layouts.app')

@section('content')
<div class="main-wrapper">
<section id="option-page" class="container py-5">
        <div class="row">
            <div class="member-card member-regular col-md-6">
                <div class="card">
                    <div class="card-top">
                        <div class="card-title">個人寄送</div>
                        <div class="card-subtitle pb-3">個人寄送</div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-body">
                            <p>適用對象 : 商務人士, 旅遊者, 跨國搬家</p>
                            <ul>
                                <li>需多額外加3000報關文件處理費

                                </li>
                                <li>僅能送到一個地點</li>
                            </ul>
                            <img id="card-reqular" class="d-flex m-auto img-fluid" src="/storage/image/card-reqular.svg" alt="">
                        </div>
                        <button type="button" class="btn btn-solid btn-lg btn-block btn-blue open-TAC" data-toggle="modal" data-target="#tandc-modal" data-link="/individual-form/{{$sailing_id}}">我要個人寄送</button>
                    </div>
                </div>
            </div>
            <div class="member-card member-group col-md-6 mt-5 mt-md-0">
                <div class="card">
                    <div class="card-top">
                        <div class="card-title">揪團集運</div>
                        <div class="card-subtitle pb-3">一人主揪多人一起寄送</div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-body">
                            <p>適用對象 : 海外留學生, 空服人員</p>
                            <ul>
                                <li>由主揪為進口人報關</li>
                                <li>主揪享有一箱免費之優惠<div class="back-space">及免除報關文件費3000元</div>
                                </li>
                                <li>一團須至少10箱以上</li>
                                <li>可支援送到多個收貨點</li>
                                <li>若該團未滿10箱則後續會跟<div class="back-space">主揪加收差額</div>
                                </li>
                            </ul>
                            <img id="card-group" class="d-flex m-auto img-fluid" src="/storage/image/card-group.svg" alt="">
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-solid btn-lg w-100 btn-orange open-TAC" data-toggle="modal" data-target="#tandc-modal" data-link="/group-form-initiator/{{$sailing_id}}">我要主揪</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-solid btn-lg btn-blue w-100 mt-3 mt-md-0" data-toggle="modal" data-target="#confirm-modal">我要跟團</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- 驗證 modal -->
<form class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true"
    data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left px-5 my-5">
            <div class="d-block align-items-center">
                     <input class="form-control form-control-lg mb-3" name="captcha" id="captcha" type="text" placeholder="請輸入驗證碼">
                    <button type="button" class="btn btn-lg btn-solid btn-orange btn-block mt-3 mt-md-0" id="confirm-token" data-link="/group-form-member/{{$sailing_id}}">送出</button>
              </div>
            </div>
        </div>
    </div>
</form>


@endsection