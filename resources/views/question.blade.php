@extends('layouts.app')

@section('content')
<div class="main-wrapper">
  <section class="banner-wrapper">
    <div class="banner container">
      <div><img src="/storage/image/question-icon.svg" alt="常見問題標誌">
        <h1>常見問題</h1>
      </div>
    </div>
  </section>
  <section id="question-page" class="container mt-5">
    <div class="list mt-5">
      <!-- 下面是使用wysiwyg編輯器-->
      <div class="edit-box mb-5">
          <div class="edit-content">
              {!! app('Option')->faq !!}
          </div>
      </div>

    </div>

  </section>
</div>
@endsection
