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
@endsection

@section('contents')
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">直近の試合結果</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
                @foreach ($results as $result)
                <tr>
                  <td>{{$result->match_id}}</td>
                  @if ($login_user->user_auth<=6)
                  <td><a href="{{url("/match_edit?match_id=" . $result->match_id)}}">{{$result->match_date}} {{$result->schedule_start}}</a></td>
                  @else
                  <td>{{$result->match_date}} {{$result->schedule_start}}</td>
                  @endif
                  <td><a href="{{url("/match?match_id=" . $result->match_id)}}">{{$result->home_name}} vs {{$result->away_name}}</a></td>
                  <td><a href="{{$result->movie_url}}">動画</a></td>
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
