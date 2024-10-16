@extends('layouts.basic')

@section('metatags')
<title>メンバー登録(Away)</title>
<head prefix=”og:http://ogp.me/ns#”>
<meta property="og:title" content="東京小説読書会" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://tokyonovelsparty.com" />
<meta property="og:image" content="https://tokyonovelsparty.com/img/main-logo.png" />
@endsection

@section('header')
  <header>
    <div id="page-header">
      <a href="https://tokyonovelsparty.com">
      <picture>
        <source srcset="{{ asset('img/main-logo.webp') }}" type="image/webp"/>
        <img src="{{ asset('img/main-logo.png') }}" alt="ロゴ">
      <picture>
        
      </a>
    </div>
    <div class="header-nav">
      <nav id="g-nav">
        <ul class="gnavi">
          <li class="current"><a href="https://tokyonovelsparty.com">Home</a></li>
          <li><a href="https://tokyonovelsparty.com/about">About</a></li>
          <li><a href="https://tokyonovelsparty.com/info_top">お知らせ</a></li>
          <li><a href="https://tokyonovelsparty.com/reserve">参加申込</a></li>
          <li><a href="https://tokyonovelsparty.com/blog_top">開催報告</a></li>
          <li><a href="https://tokyonovelsparty.com/qa">Q&A</a></li>
          <li><a href="https://tokyonovelsparty.com/watching_nobel_prize_in_literature">ノーベル文学賞を見守る会</a></li>
          <li><a href="https://tokyonovelsparty.com/inquiry">問い合わせ</a></li>
          @if (Auth::check())
            @if (Auth::user()->user_auth <= 8)
              <li><a href="https://tokyonovelsparty.com/index">INDEXページへ</a></li>
            @else
              <li><a href="https://tokyonovelsparty.com/index_user">INDEXページへ</a></li>
            @endif
          <li><a href="https://tokyonovelsparty.com/logout">ログアウト</a></li>
          @else
          <li class="login_text"><a href="https://tokyonovelsparty.com/index_user">ログイン</a></li>
          @endif
        </ul>
        @if (Auth::check() == false)
        <a href="{{url('/index_user')}}" class="btn btn-primary header_btn_pc">ログイン</a>
        @endif
      </nav>
    </div>
  </header>
  <div class="openbtn"><span></span><span></span><span></span></div>
@endsection

@section('contents')
<form action="/away_members" method="post">
  @csrf
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">メンバー</h4>
        </div>
        <div class="card-body">
          @if (session('flash_message'))
              <div class="flash_message bg-warning">
                {{ session('flash_message') }}
              </div>
          @endif
	  <div class="row">
            <div class="col-md-5 float-right">
            <select name="pre_match[]" class="form-control">
              <option value="">-</option>
              @foreach ($pre_matches as $pre_match)
                <option value="{{$pre_match->match_id}}">{{$pre_match->match_date}} {{$pre_match->schedule_start}} {{$pre_match->home}}@if ($pre_match->home2 != NULL) /{{$pre_match->home2}} @endif @if ($pre_match->home3 != NULL) /{{$pre_match->home3}} @endif @if ($pre_match->home4 != NULL) /{{$pre_match->home4}} @endif vs{{$pre_match->away}}@if ($pre_match->away2 != NULL) /{{$pre_match->away2}} @endif @if ($pre_match->away3 != NULL) /{{$pre_match->away3}} @endif @if ($pre_match->away4 != NULL) /{{$prematch->away4}} @endif</option>
              @endforeach
            </select>
            </div>
            <div class="ml-auto col-md-1 float-right">
              <input type="submit" class="btn btn-primary btn-round float-right" name="parti_submit" value="メンバーコピー">
            </div>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>クラブ名</th><th>背番号</th><th>名前</th><th>ニックネーム</th><th>参加/不参加</th><th>先発</th><th>備考</th>
              <input type="hidden" class="form-control" name="a_side" value="{{$match->a_side}}">
              </thead>
              <tbody>
                @foreach ($away_members as $away_members)
                <tr>
                  <td>{{$away_members->club_name}}</td>
                  <td>{{$away_members->number}}</td>
                  <td>{{$away_members->name}}</td>
                  <td>{{$away_members->nickname}}</td>
                  <input type="hidden" class="form-control" name="match_id[]" value="{{$match->match_id}}">
                  <input type="hidden" class="form-control" name="id[]" value="{{$away_members->id}}">
                  <input type="hidden" class="form-control" name="member_id[]" value="{{$away_members->member_id}}">
                  <input type="hidden" class="form-control" name="player_id[]" value="{{$away_members->player_id}}">
                  <input type="hidden" class="form-control" name="club_id[]" value="{{$match->away}}">
                  <td>
                    <select name="competition[]" class="form-control">
                      <option value="0" @if ($away_members->competition == 0) selected @endif>出場</option>
                      <option value="1" @if ($away_members->competition == 1) selected @endif>欠場</option>
                    </select>
                    <input type="hidden" class="form-control" name="pre_competition[]" value="{{$away_members->competition}}">
                  </td>
		  <td>
                    <select name="match_position[]" class="form-control">
		      <option value="">-</option>
                      @php
                        $a_side = $match->a_side;
                      @endphp
                      @if (EMPTY($away_members->match_position))
                        @for ($i = 1; $i <= $a_side; $i++)
			  <option value="{{$i}}">{{$i}}</option>
                        @endfor
                      @else
                        @for ($i = 1; $i <= $a_side; $i++)
                          @if ($i != $away_members->match_position) 
			    <option value="{{$i}}">{{$i}}</option>
                          @else
			    <option value="{{$i}}" selected>{{$i}}</option>
			  @endif
                        @endfor
                      @endif
                    </select>
                    <input type="hidden" class="form-control" name="pre_match_position[]" value="{{$away_members->match_position }}">
                  </td>
                  <td>
                    @if (EMPTY($away_members->member_remarks))
                      <input type="text" class="form-control" name="member_remarks[]" value="">
                    <input type="hidden" class="form-control" name="pre_member_remarks[]" value="">
                    @else
                      <input type="text" class="form-control" name="member_remarks[]" value="{{$away_members->member_remarks}}">
                    <input type="hidden" class="form-control" name="pre_member_remarks[]" value="{{$away_members->member_remarks}}">
		    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="row">
              <div class="update ml-auto mr-auto">
                <input type="submit" class="btn btn-primary btn-round" name="parti_submit" value="一時保存">
              </div>
              <div class="update ml-auto mr-auto">
                <input type="submit" class="btn btn-primary btn-round" name="parti_submit" value="確定">
              </div>
	      <a href="{{url('/')}}" class="btn btn-primary ml-auto mr-auto">TOP</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
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
