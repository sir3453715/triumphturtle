
@inject('html', 'App\Presenters\Html\HtmlPresenter')
<div class="row shipment">
    @foreach($sailings as $sailing)
        <div class="col-12 col-lg-6 col-xl-4 my-4 px-3 px-md-2">
            <div class="card {{($sailing->status == 1)?'':'card-disabled'}}">
                <div class="card-top">
                    <div class="data-header">
                        <div class="data-header-top">
                            <img class="img-circle" src="/storage/image/shipment-icon.svg" alt="">
                            <div>
                                <div class="data-header-title cus-row">
                                    <p>{{$sailing->title}}</p>
                                    {!! $html->sailingStatus($sailing->status) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail-info">
                        <p class="mb-3">
                            <span class="data-label">成團單價:</span>
                            <span class="unit-price">NT$ {{number_format($sailing->price)}}</span> / 箱
                        </p>
                        {!! $html->sailingPrice($sailing) !!}
                    </div>
                </div>
                <hr>
                <div class="card-bottom">
                    <div class="data-content">
                        <div class="data-content-item">
                            <p class="item-label">結單時間</p>
                            <p class="item-date">{{date('m / d',strtotime($sailing->statement_time))}}</p>
                        </div>
                        <div class="center-center my-2 my-md-0">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                        <div class="data-content-item">
                            <p class="item-label">包裹進倉<br>截止日</p>
                            <p class="item-date">{{date('m / d',strtotime($sailing->parcel_deadline))}}</p>
                        </div>
                        <div class="center-center my-2 my-md-0">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </div>
                        <div class="data-content-item">
                            <p class="item-label">抵達目的地<br>倉庫</p>
                            <p class="item-date">{{date('m / d',strtotime($sailing->arrival_date))}}</p>
                        </div>
                    </div>
                    @if($sailing->status == 1)
                        <a href="{{route('option',['id'=>$sailing->id])}}" class="btn btn-lg btn-solid btn-blue btn-block mt-4">來去揪團</a>
                    @else
                        <button type="button" class="btn btn-lg btn-solid btn-blue btn-block mt-4">已結單，下次請早</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- Pagination -->
{{ $sailings->appends(request()->except('page'))->links() }}
