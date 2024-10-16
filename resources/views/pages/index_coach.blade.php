@extends('layouts.basic')

@section('metatags')
<title>管理ページ</title>
<head prefix=”og:http://ogp.me/ns#”>
<meta property="og:title" content="東京小説読書会" />
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
          <li class="current"><a href="https://wfok.xyz/index_coach">TOP</a></li>
          <li><a href="https://wfok.xyz/match_results">試合一覧</a></li>
          <li><a href="https://wfok.xyz/individual_results">個人成績</a></li>
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
    <div class="col-md-4">
      <div class="card card-user">
        <div class="image">
          <!-- <img src="../assets/img/damir-bosnjak.jpg" alt="..."> -->
        </div>
        <div class="card-body">
          <div class="author">
            <img class="avatar" src="{{ asset('/img/default-avatar.png') }}" alt="user img">
            <h5 class="title">{{$login_user['name']}}</h5>
            <p class="description">{{$login_user['nickname']}}</p>
          </div>
            <p class="description text-center">
              ログインありがとうございます。<br>登録情報変更は<a href="">こちら</a>
            </p>
          </div>
          <div class="card-footer">
            <hr>
            <div class="button-container">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-6 ml-auto mr-auto">
                  <h5><small>今年度の<br>試合参加</small><br>{{$login_user['user_cnt']}}回</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">本日の試合</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
                @foreach ($todays_matches as $todays_matches)
                <tr>
                  <td>{{$todays_matches->match_id}}</td>
		  <td><a href="{{url('/match_edit?match_id=' . $todays_matches->match_id)}}">{{$todays_matches->match_date}} {{$todays_matches->schedule_start}}</a></td>
                  @if ($todays_matches->home_easyinput == 0)
                    <td><a href="{{url('/home_members'. "?match_id=" . $todays_matches->match_id)}}">{{$todays_matches->home_name}}@if ($todays_matches->home_name2 != NULL) /{{$todays_matches->home_name2}} @endif @if ($todays_matches->home_name3 != NULL) /{{$todays_matches->home_name3}} @endif @if ($todays_matches->home_name4 != NULL) /{{$todays_matches->home_name4}} @endif</a></td>
                  @else
                    <td>{{$todays_matches->home_name}}@if ($todays_matches->home_name2 != NULL) /{{$todays_matches->home_name2}} @endif @if ($todays_matches->home_name3 != NULL) /{{$todays_matches->home_name3}} @endif @if ($todays_matches->home_name4 != NULL) /{{$todays_matches->home_name4}} @endif</td>
                  @endif
                  @if ($todays_matches->away_easyinput == 0)
                    <td><a href="{{url('/away_members'. "?match_id=" . $todays_matches->match_id)}}">{{$todays_matches->away_name}}@if ($todays_matches->away_name2 != NULL) /{{$todays_matches->away_name2}} @endif @if ($todays_matches->away_name3 != NULL) /{{$todays_matches->away_name3}} @endif @if ($todays_matches->away_name4 != NULL) /{{$todays_matches->away_name4}} @endif</a></td>
                  @else
                    <td>{{$todays_matches->away_name}}@if ($todays_matches->away_name2 != NULL) /{{$todays_matches->away_name2}} @endif @if ($todays_matches->away_name3 != NULL) /{{$todays_matches->away_name3}} @endif @if ($todays_matches->away_name4 != NULL) /{{$todays_matches->away_name4}} @endif</td>
                  @endif
                  <td><a href="{{url('/match_contents'. "?match_id=" . $todays_matches->match_id)}}">試合内容登録</a></td>
                </tr>
                @endforeach
            </table>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">直近の試合結果</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
                @foreach ($result as $result)
                <tr>
                  <td>{{$result->match_id}}</td>
                  <td><a href="{{url("/match?match_id=" . $result->match_id)}}">{{$result->match_date}} {{$result->schedule_start}}</a></td>
                  <td><a href="{{url('/match_contents'. "?match_id=" . $result->match_id)}}">{{$result->home_name}}@if ($result->home_name2 != NULL) /{{$result->home_name2}} @endif @if ($result->home_name3 != NULL) /{{$result->home_name3}} @endif @if ($result->home_name4 != NULL) /{{$result->home_name4}} @endif vs {{$result->away_name}}@if ($result->away_name2 != NULL) /{{$result->away_name2}} @endif @if ($result->away_name3 != NULL) /{{$result->away_name3}} @endif @if ($result->away_name4 != NULL) /{{$result->away_name4}} @endif</a></td>
                  <td><a href="{{$result->movie_url}}">動画</a></td>
                </tr>
                @endforeach
            </table>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">これからの試合</h4>
	    <a href="{{url('/newmatch')}}" class="btn btn-primary float-right">新規登録</a>
	    <a href="{{url('/newclub')}}" class="btn btn-primary float-right">クラブ登録</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              @foreach ($schedule as $schedule)
                <tr>
                  <td>{{$schedule->match_id}}</td>
                  <td><a href="{{url('/match_edit?match_id=' . $schedule->match_id)}}">{{$schedule->match_date}} {{$schedule->schedule_start}}</a></td>
                  @if ($schedule->home_easyinput == 0)
                    <td><a href="{{url('/home_members'. "?match_id=" . $schedule->match_id)}}">{{$schedule->home_name}}@if ($schedule->home_name2 != NULL) /{{$schedule->home_name2}} @endif @if ($schedule->home_name3 != NULL) /{{$schedule->home_name3}} @endif @if ($schedule->home_name4 != NULL) /{{$schedule->home_name4}} @endif</a></td>
                  @else
                    <td>{{$schedule->home_name}}@if ($schedule->home_name2 != NULL) /{{$schedule->home_name2}} @endif @if ($schedule->home_name3 != NULL) /{{$schedule->home_name3}} @endif @if ($schedule->home_name4 != NULL) /{{$schedule->home_name4}} @endif</td>
                  @endif
                  @if ($schedule->away_easyinput == 0)
                    <td><a href="{{url('/away_members'. "?match_id=" . $schedule->match_id)}}">{{$schedule->away_name}}@if ($schedule->away_name2 != NULL) /{{$schedule->away_name2}} @endif @if ($schedule->away_name3 != NULL) /{{$schedule->away_name3}} @endif @if ($schedule->away_name4 != NULL) /{{$schedule->away_name4}} @endif</a></td>
                  @else
                    <td>{{$schedule->away_name}}@if ($schedule->away_name2 != NULL) /{{$schedule->away_name2}} @endif @if ($schedule->away_name3 != NULL) /{{$schedule->away_name3}} @endif @if ($schedule->away_name4 != NULL) /{{$schedule->away_name4}} @endif</td>
                  @endif
                  <td><a href="{{url('/match_contents'. "?match_id=" . $schedule->match_id)}}">試合内容登録</a></td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">選手情報</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
                @foreach ($users as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->nickname}}</td>
                  <td>{{$user->number}}</td>
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
