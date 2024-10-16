@extends('layouts.basic')

@section('metatags')
<title>試合結果ページ</title>
<head prefix=”og:http://ogp.me/ns#”>
<meta property="og:title" content="サッカー" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://wfok.xyz" />
<meta property="og:image" content="https://wfok.xyz/img/main-logo.png" />
@endsection

@section('header')
  <header>
    <div id="page-header">
      <a href="https://wfok.xyz">
      <picture>
        <source srcset="{{ asset('img/main-logo.webp') }}" type="image/webp"/>
        <img src="{{ asset('img/main-logo.png') }}" alt="ロゴ">
      <picture>
        
      </a>
    </div>
    <div class="header-nav">
      <nav id="g-nav">
        <ul class="gnavi">
          <li><a href="https://wfok.xyz/index_coach">TOP</a></li>
          <li><a href="https://wfok.xyz/match_results">試合一覧</a></li>
          <li class="current"><a href="https://wfok.xyz/individual_results">個人成績</a></li>
          <li><a href="https://wfok.xyz/user_edit?id=">ユーザ情報</a></li>
          <li><a href="https://wfok.xyz/clubs">他チーム一覧</a></li>
          <li><a href="https://wfok.xyz/logout">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="openbtn"><span></span><span></span><span></span></div>
@endsection

@section('contents')
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
	  <h4 class="card-title">個人成績</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
	      <thead>
		<tr>
                  <th>背番号</th>
                  <th>ニックネーム</th>
                  <th>得点</th>
                  <th>警告</th>
		  <th>出場時間</th>
                </tr>
              </thead>
                @foreach ($users as $user)
                <tr>
                  <td><a href="{{url("/indivisual_result?id=" . $user->id)}}">{{$user->number}}</a></td>
                  <td>{{$user->nickname}}</td>
                  <td>{{$user->scores}}</td>
                  <td>{{$user->fouls}}</td>
                  <td>{{$user->times}}</td>
                </tr>
                @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('paginate')
  <!-- <div class="container">
  </div>
    <div id="pager">
    </div>
    <div id="pager">
      <span class="back">&laquo;前へ</span>
    </div>
   -->
@endsection
