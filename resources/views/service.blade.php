@extends('layouts.app')

@section('content')
<div class="main-wrapper">
    <section id="service-page" class="container py-5">
        <div class="cus-grid">
        <div class="display-box display-box-outline">
            <div class="d-flex">
                <img src="/storage/image/truck-icon.svg" alt="">
            <h2>服務項目</h2>
            </div>
                 <p class="mt-4">突破海運的限制!!</p>
                <p>首創揪團集運平台</p> 
        </div>
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
                            <img class="d-flex m-auto img-fluid" src="/storage/image/card-reqular.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="member-card member-group mt-5 mt-md-0 col-md-6">
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
                            <img class="d-flex m-auto img-fluid" src="/storage/image/card-group.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
      
    </section>

    <section id="shipping-des" class="container-fluid">
        <div class="container position-relative">
            <div class="display-box m-auto"><img src="/storage/image/box-white.svg" alt="">
                <h2>揪團集運方式說明</h2>
            </div>
            <div class="des-box des-box-blue">
                <ol>
                    <li>每月發船一次, 每次航行時間1~3個月</li>
                    <li>需要超過低消才會成團, 若不成團客服人員會主動與客戶安排後續事宜</li>
                    <li>費用以箱計價, 箱數越多會越便宜 不分個人及揪團集運</li>
                    <li>航班過結單日後系統會主動通知成團的優惠單價給寄件者</li>
                    <li>當包裹到達目的地倉庫後系統會根據您實際裝箱尺寸發送請款單給寄件人請款</li>
                    <li>若有產生進口稅金或查驗費將實報實銷由進口人負擔, 若為多人揪團則是以主揪負責</li>
                    <li>後送行李享有20,000免稅額(託運人入境時向海關申報, 並提供後送行李申報單給客服人員</li>
                    <li>若為私人行李寄送則免稅額為2000</li>
                    <li>紙箱限制三邊加總不可超過150CM, 單箱重量不可超過25KG</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="container d-grid mb-5">
        <div class="display-box display-box-outline display-box-down m-auto"><img src="/storage/image/steps.svg" alt="">
            <h2>作業流程說明</h2>
        </div>
        <div class="border-box">
            <img class="img-fluid d-none d-md-block" src="/storage/image/process-step.svg" alt="">
            <img class="img-fluid d-block d-md-none" src="/storage/image/process-step-mb.svg" alt="">
        </div>
    </section>

    <a href="/" class="btn-round mr-auto ml-auto mb-5">
        <img src="/storage/image/truck-icon.svg" alt="">
        <p>前去集運</p>
    </a>
</div>

@endsection