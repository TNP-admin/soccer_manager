@extends('layouts.basic')

@section('metatags')
<title>メンバー登録(Home)</title>
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
  </header>
@endsection

@section('contents')
<form action="/home_members" method="post">
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
                <option value="{{$pre_match->match_id}}">{{$pre_match->match_date}} {{$pre_match->schedule_start}} {{$pre_match->home}}@if ($pre_match->home2 != NULL) /{{$pre_match->home2}} @endif @if ($pre_match->home3 != NULL) /{{$pre_match->home3}} @endif @if ($pre_match->home4 != NULL) /{{$pre_match->home4}} @endif vs{{$pre_match->away}}@if ($pre_match->away2 != NULL) /{{$pre_match->away2}} @endif @if ($pre_match->away3 != NULL) /{{$pre_match->away3}} @endif @if ($pre_match->away4 != NULL) /{{$pre_match->away4}} @endif</option>
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
                @foreach ($home_members as $home_members)
                <tr>
                  <td>{{$home_members->club_name}}</td>
                  <td>{{$home_members->number}}</td>
                  <td>{{$home_members->name}}</td>
                  <td>{{$home_members->nickname}}</td>
                  <input type="hidden" class="form-control" name="match_id[]" value="{{$match->match_id}}">
                  <input type="hidden" class="form-control" name="id[]" value="{{$home_members->id}}">
                  <input type="hidden" class="form-control" name="member_id[]" value="{{$home_members->member_id}}">
                  <input type="hidden" class="form-control" name="player_id[]" value="{{$home_members->player_id}}">
                  <input type="hidden" class="form-control" name="club_id[]" value="{{$match->home}}">
                  <td>
                    <select name="competition[]" class="form-control">
                      <option value="0" @if ($home_members->competition == 0) selected @endif>出場</option>
                      <option value="1" @if ($home_members->competition == 1) selected @endif>欠場</option>
                    </select>
                    <input type="hidden" class="form-control" name="pre_competition[]" value="{{$home_members->competition}}">
                  </td>
		  <td>
                    <select name="match_position[]" class="form-control">
		      <option value="">-</option>
                      @php
                        $a_side = $match->a_side;
                      @endphp
                      @if (EMPTY($home_members->match_position))
                        @for ($i = 1; $i <= $a_side; $i++)
			  <option value="{{$i}}">{{$i}}</option>
                        @endfor
                      @else
                        @for ($i = 1; $i <= $a_side; $i++)
                          @if ($i != $home_members->match_position) 
			    <option value="{{$i}}">{{$i}}</option>
                          @else
			    <option value="{{$i}}" selected>{{$i}}</option>
			  @endif
                        @endfor
                      @endif
                    </select>
                    <input type="hidden" class="form-control" name="pre_match_position[]" value="{{$home_members->match_position }}">
                  </td>
		  <td>
                    <input type="text" class="form-control" name="member_remarks[]" value="{{$home_members->member_remarks}}">
                    <input type="hidden" class="form-control" name="pre_member_remarks[]" value="{{$home_members->member_remarks}}">
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
