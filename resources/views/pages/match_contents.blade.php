@extends('layouts.match_contents')

@section('metatags')
<title>試合情報入力</title>
<head prefix=”og:http://ogp.me/ns#”>
<meta property="og:title" content="東京小説読書会" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://wfok.xyz" />
<meta property="og:image" content="https://wfok.xyz/img/main-logo.png" />
@endsection

@section('header')
  <header>
    <div class="header-nav">
      <nav id="g-nav">
        <ul class="gnavi">
          <li><a href="https://wfok.xyz/index_coach">TOP</a></li>
          <li class="current"><a href="https://wfok.xyz/match_results">試合一覧</a></li>
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
  <form action="/match_contents" method="post">
    @csrf
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$match->match_date}} {{$match->home_name}}@if ($match->home_2 != NULL) /{{$match->home2_name}} @endif @if ($match->home_3 != NULL) /{{$match->home3_name}} @endif @if ($match->home_4 != NULL) /{{$match->home4_name}} @endif VS {{$match->away_name}}@if ($match->away_2 != NULL) /{{$match->away2_name}} @endif @if ($match->away_3 != NULL) /{{$match->away3_name}} @endif @if ($match->away_4 != NULL) /{{$match->away4_name}} @endif {{$match->a_side}}人制</h4>
          <div class="row">
            <!-- <div class="col-md-4"> -->
            <div class="col-4">
	      <h1 class="card-title text-right" id="home_score">{{$home_score}}<h1>
            </div>
            <div class="col-4">
            <!-- <div class="col-md-4"> -->
              <div class="row">
                <div class="col-md-12">
              @if ($match->period == 1)
	        <h5 class="card-title text-center" id="period_text">フル</h4>
              @elseif ($match->period == 2)
                <h5 class="card-title text-center" id="period_text">前半</h4>
              @elseif ($match->period == 3)
                <h5 class="card-title text-center" id="period_text">後半</h4>
              @elseif ($match->period == 4)
                <h5 class="card-title text-center" id="period_text">延長前半</h4>
              @elseif ($match->period == 5)
                <h5 class="card-title text-center" id="period_text">延長後半</h4>
              @elseif ($match->period == 9)
                <h5 class="card-title text-center" id="period_text">試合終了</h4>
	      @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mx-auto lead">
                <!-- <div class="col-xs-2 mx-auto lead"> -->
		  @if ($match->match_start == "")
                  <input type="text" class="text-center border-0 mx-auto input_width_change" id="elapsed_time" value="{{substr($match->schedule_start, 0, 5)}} 開始予定" readonly>
                  @else
                  <input type="text" class="text-center border-0 mx-auto input_width_change" id="elapsed_time" value="00:00" readonly>
                  @endif
                </div>
              </div>
            </div>
            <div class="col-4">
            <!-- <div class="col-md-4"> -->
              <h1 class="card-title" id="away_score">{{$away_score}}<h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="update ml-auto mr-auto">
            <input type="button" class="btn btn-primary btn-circle btn-lg" id="startBtn" value="開始">
          </div>
          <div class="update ml-auto mr-auto">
            <button type="button" class="btn btn-info btn-circle btn-lg" id="change_submit" data-toggle="modal" data-target="#changeModal" data-match="{{sprintf('%04d', $match->match_id)}}">交代</button>
          </div>
          <div class="update ml-auto mr-auto">
            <input type="button" class="btn btn-warning btn-circle btn-lg" id="tmpBtn" value="停止" disabled>
          </div>
        </div>
        <input type="hidden" class="form-control" name="period[]" id="period" value="{{$match->period}}">
        <input type="hidden" class="form-control" name="period_start[]" id="period_start" value="{{$match->period_start}}">
        <input type="hidden" class="form-control" name="regulation_time[]" id="regulation_time" value="{{$match->regulation_time}}">
        <input type="hidden" class="form-control" name="match_id[]" id="match_id" value="{{$match->match_id}}">
        <input type="hidden" class="form-control" name="a_side[]" id="a_side" value="{{$match->a_side}}">
        <input type="hidden" class="form-control" name="overtime" id="overtime" value="{{$match->overtime}}">
        <input type="hidden" class="form-control" name="pk" id="pk" value="{{$match->pk}}">
        <input type="hidden" class="form-control" name="home" id="home" value="{{$match->home}}">
        <input type="hidden" class="form-control" name="home_2" id="home_2" value="{{$match->home_2}}">
        <input type="hidden" class="form-control" name="home_3" id="home_3" value="{{$match->home_3}}">
        <input type="hidden" class="form-control" name="home_4" id="home_4" value="{{$match->home_4}}">
        <input type="hidden" class="form-control" name="away" id="away" value="{{$match->away}}">
        <input type="hidden" class="form-control" name="away_2" id="away_2" value="{{$match->away_2}}">
        <input type="hidden" class="form-control" name="away_3" id="away_3" value="{{$match->away_3}}">
        <input type="hidden" class="form-control" name="away_4" id="away_4" value="{{$match->away_4}}">
        <div class="card-body">
	  <div class="table-responsive">
            <div class="row">
            <div class="col-md-6">
	      <table class="table" id="home_tbl">
                <?php $num = 0 ?>
                @foreach ($home_players as $home_players)
                <tr>
                  <td>{{$home_players->match_position}}</td>
                  <td>{{$home_players->number}}:{{$home_players->nickname}}</td>
                  <input type="hidden" class="form-control" name="match_id[]" id="match_id{{$num}}" value="{{$match->match_id}}">
                  <input type="hidden" class="form-control" name="player_id[]" id="player_id{{$num}}" value="{{$home_players->player_id}}">
                  <input type="hidden" class="form-control" name="club_id[]" id="club_id{{$num}}" value="{{$match->home}}">
                  <input type="hidden" class="form-control" name="number[]" id="number{{$num}}" value="{{$home_players->number}}">
                  <input type="hidden" class="form-control" name="nickname[]" id="nickname{{$num}}" value="{{$home_players->nickname}}">
                  <input type="hidden" class="form-control" name="match_position[]" id="match_position{{$num}}" value="{{$home_players->match_position}}">
                  <input type="hidden" class="form-control" name="num[]" id="num[]" value="{{$num}}">
		  <td>
                  @if ($match->home_easyinput == 0)
                    <select name="substitute" id="substitute{{$num}}" class="form-control">
	              <option value="">-未選択-</option>
		      @foreach ($home_sub_members as $home_sub_member)
                        @if ($home_sub_member->id != $home_players->id)
                          <option value="{{$home_sub_member->id6}}{{$home_sub_member->number}}:{{$home_sub_member->nickname}}">{{$home_sub_member->number}}:{{$home_sub_member->nickname}}</option>
                        @endif
                      @endforeach
		    </select>
                  @elseif ($match->home_easyinput == 1)
                    <select name="substitute" id="substitute{{$num}}" class="form-control">
	              <option value="">-未選択-</option>
		    </select>
                  @endif
                  </td>
		  <td>
                    <button type="button" class="btn btn-primary btn-sm" id="score_submit{{sprintf('%02d', $num)}}" data-toggle="modal" data-target="#scoreModal" data-clubusermatch="{{sprintf('%02d', $num)}}{{sprintf('%03d', $home_players->club_id)}}{{sprintf('%04d', $home_players->id)}}{{sprintf('%04d', $home_players->match_id)}}" disabled>得点</button>
                    <button type="button" class="btn btn-warning btn-sm" id="foul_submit{{sprintf('%02d', $num)}}" data-toggle="modal" data-target="#foulModal" data-clubusermatch="{{sprintf('%02d', $num)}}{{sprintf('%03d', $home_players->club_id)}}{{sprintf('%04d', $home_players->id)}}{{sprintf('%04d', $home_players->match_id)}}" disabled>警告</button>
                  </td>
                </tr>
                <?php $num = $num + 1 ?>
		@endforeach
	      </table>
            </div>
            <div class="col-md-6">
              <table class="table" id="away_tbl">
                @foreach ($away_players as $away_players)
                <tr>
                  <td>{{$away_players->match_position}}</td>
                  <td>{{$away_players->number}}:{{$away_players->nickname}}</td>
                  <input type="hidden" class="form-control" name="match_id[]" id="match_id{{$num}}" value="{{$match->match_id}}">
                  <input type="hidden" class="form-control" name="player_id[]" id="player_id{{$num}}" value="{{$away_players->player_id}}">
                  <input type="hidden" class="form-control" name="club_id[]" id="club_id{{$num}}" value="{{$match->away}}">
                  <input type="hidden" class="form-control" name="number[]" id="number{{$num}}" value="{{$away_players->number}}">
                  <input type="hidden" class="form-control" name="nickname[]" id="nickname{{$num}}" value="{{$away_players->nickname}}">
                  <input type="hidden" class="form-control" name="match_position[]" id="match_position{{$num}}" value="{{$away_players->match_position}}">
		  <td>
                  @if ($match->away_easyinput == 0)
                    <select name="substitute" id="substitute{{$num}}" class="form-control">
	              <option value="">-未選択-</option>
		      @foreach ($away_sub_members as $away_sub_member)
                        @if ($away_sub_member->id != $away_players->id)
			  <option value="{{$away_sub_member->id6}}{{$away_sub_member->number}}:{{$away_sub_member->nickname}}">{{$away_sub_member->number}}:{{$away_sub_member->nickname}}</option>
                        @endif
                      @endforeach
                    </select>
                  @elseif ($match->away_easyinput == 1)
                    <select name="substitute" id="substitute{{$num}}" class="form-control">
	              <option value="">-未選択-</option>
                    </select>
                  @endif
                  </td>
		  <td>
                    <button type="button" class="btn btn-primary btn-sm" id="score_submit{{sprintf('%02d', $num)}}" data-toggle="modal" data-target="#scoreModal" data-clubusermatch="{{sprintf('%02d', $num)}}{{sprintf('%03d', $away_players->club_id)}}{{sprintf('%04d', $away_players->id)}}{{sprintf('%04d', $away_players->match_id)}}" disabled>得点</button>
                    <button type="button" class="btn btn-warning btn-sm" id="foul_submit{{sprintf('%02d', $num)}}" data-toggle="modal" data-target="#foulModal" data-clubusermatch="{{sprintf('%02d', $num)}}{{sprintf('%03d', $away_players->club_id)}}{{sprintf('%04d', $away_players->id)}}{{sprintf('%04d', $away_players->match_id)}}" disabled>警告</button>
                  </td>
                </tr>
                <?php $num = $num + 1 ?>
                @endforeach
              </table>
	    </div>
            </div>
          </div>
        </div>
	<a href="{{url('/')}}" class="btn btn-primary ml-auto mr-auto">TOP</a>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">試合経過</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  @foreach ($events as $event)
                  <tr>
                    @if ($event->club_id == $match->home or $event->club_id == $match->home_2 or $event->club_id == $match->home_3 or $event->club_id == $match->home_4)
                      @if ($event->type == "score" and $event->tmp1 == 1)
                        <td></td>
                        <td></td>
			<td></td>
                        @if ($event->period == 2)
                          <td>前半 {{$event->time}}分</td>
                        @elseif ($event->period == 3)
                          <td>後半 {{$event->time}}分</td>
                        @elseif ($event->period == 4)
                          <td>延長前半 {{$event->time}}分</td>
                        @elseif ($event->period == 5)
			  <td>延長後半 {{$event->time}}分</td>
                        @elseif ($event->period == 1)
			  <td>フル {{$event->time}}分</td>
                        @endif
                        <td>Goal!</td>
                        <td>{{$event->club_name}}</td>
                        <td>owngoal</td>
                      @else
                        @if ($event->type == "score")
                          <td>Goal!</td>
                        @elseif ($event->type == "foul")
                          <td>警告</td>
                        @elseif ($event->type == "change")
                          <td>交代</td>
                        @endif
                          <td>{{$event->club_name}}</td>
                          <td>{{$event->number}}.{{$event->nickname}}</td>
                        @if ($event->period == 2)
                          <td>前半 {{$event->time}}分</td>
                        @elseif ($event->period == 3)
                          <td>後半 {{$event->time}}分</td>
                        @elseif ($event->period == 4)
                          <td>延長前半 {{$event->time}}分</td>
                        @elseif ($event->period == 5)
			  <td>延長後半 {{$event->time}}分</td>
                        @elseif ($event->period == 1)
			  <td>フル {{$event->time}}分</td>
                        @endif
                        <td></td>
                        <td></td>
			<td></td>
                      @endif
                    @elseif ($event->club_id == $match->away or $event->club_id == $match->away_2 or $event->club_id == $match->away_3 or $event->club_id == $match->away_4)
                      @if ($event->type == "score" and $event->tmp1 == 1)
                        <td>Goal!</td>
                        <td>{{$event->club_name}}</td>
                        <td>owngoal</td>
                        @if ($event->period == 2)
                          <td>前半 {{$event->time}}分</td>
                        @elseif ($event->period == 3)
                          <td>後半 {{$event->time}}分</td>
                        @elseif ($event->period == 4)
                          <td>延長前半 {{$event->time}}分</td>
                        @elseif ($event->period == 5)
			  <td>延長後半 {{$event->time}}分</td>
                        @elseif ($event->period == 1)
			  <td>フル {{$event->time}}分</td>
                        @endif
                        <td></td>
                        <td></td>
                        <td></td>
                      @else
                        <td></td>
                        <td></td>
                        <td></td>
                        @if ($event->period == 2)
                          <td>前半 {{$event->time}}分</td>
                        @elseif ($event->period == 3)
                          <td>後半 {{$event->time}}分</td>
                        @elseif ($event->period == 4)
                          <td>延長前半 {{$event->time}}分</td>
                        @elseif ($event->period == 5)
			  <td>延長後半 {{$event->time}}分</td>
                        @elseif ($event->period == 1)
			  <td>フル {{$event->time}}分</td>
                        @endif
                        @if ($event->type == "score")
                          <td>Goal!</td>
                        @elseif ($event->type == "foul")
                          <td>警告</td>
                        @elseif ($event->type == "change")
                          <td>交代</td>
                        @endif
                        <td>{{$event->club_name}}</td>
                        <td>{{$event->number}}.{{$event->nickname}}</td>
                      @endif
                    @endif
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('modal')
<div class="modal fade" id="scoreModal" tabindex="-1" aria-labelledby="scoreModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="scoreModalLabel">得点入力</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="/score_submit" method="post">
      @csrf
        <div class="modal-body">
          <div class="row">
            <label class="form-control">得点者
            <select name="scorer" id="scorer" class="form-control">
              <option value=""></option>
            </select>
          </div>
          <div class="row">
            <label class="form-control">アシスト
            <select name="assist" id="assist" class="form-control">
              <option value=""></option>
            </select>
          </div>
          <div class="row">
            <label class="form-control">オウンゴール<input type="checkbox" class="form-control" name="owngoal" id="owngoal"></label>
          </div>
          <div class="row ml-auto">
            <input type="text" class="text-center" name="score_period_txt" id="score_period_txt" value="前半" readonly>
            <input type="text" class="text-center" name="score_time" id="score_time" value="00:00">
          </div>
          <input type="hidden" class="form-control" name="score_period" id="score_period" value="">
          <input type="hidden" class="form-control" name="club_id" id="club_id" value="">
          <input type="hidden" class="form-control" name="match_id" id="match_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <input type="button" class="btn btn-primary" name="score_submit" id="scoreBtn" value="確定">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="foulModal" tabindex="-1" aria-labelledby="foulModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="foulModalLabel">警告入力</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="/foul_submit" method="post">
      @csrf
        <div class="modal-body">
          <div class="row">
            <label class="form-control">警告者
            <select name="violator" id="violator" class="form-control">
              <option value=""></option>
            </select>
          </div>
          <div class="row">
	    <label class="form-control">反則種類
            <div class="radio-inline">
              <input type="radio" class="form-control" name="foul_cards" id="foul_none" value="0" checked>
              <label>なし</label>
            </div>
            <div class="radio-inline">
              <input type="radio" class="form-control" name="foul_cards" id="foul_yellow" value="1">
              <label>イエロー</label>
            </div>
            <div class="radio-inline">
              <input type="radio" class="form-control" name="foul_cards" id="foul_red" value="2">
              <label>レッド</label>
            </div>
          </div>
          <div class="row ml-auto">
            <input type="text" class="text-center" name="foul_period_txt" id="foul_period_txt" value="前半" readonly>
            <input type="text" class="text-center" name="foul_time" id="foul_time" value="00:00">
          </div>
          <input type="hidden" class="form-control" name="foul_period" id="foul_period" value="">
          <input type="hidden" class="form-control" name="club_id" id="foul_club_id" value="">
          <input type="hidden" class="form-control" name="match_id" id="foul_match_id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <input type="button" class="btn btn-primary" name="foul_submit" id="foulBtn" value="確定">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="changeModal" tabindex="-1" aria-labelledby="changeModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="changeModalLabel">交代確認</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="/change_submit" method="post" id="changeForm">
      @csrf
        <div class="modal-body">
          <div class="row">
            <input type="hidden" class="form-control" name="period" id="period" value="{{$match->period}}">
            <input type="hidden" class="form-control" name="match_id" id="change_match_id" value="{{$match->match_id}}">
            <table class="table" id="home_change_tbl">
            </table>
            <table class="table" id="away_change_tbl">
            </table>
          </div>
          <div class="row ml-auto">
            <input type="text" class="text-center" name="change_period_txt" id="change_period_txt" value="前半" readonly>
            <input type="hidden" class="form-control" name="change_period" id="change_period" value="">
            <input type="text" class="text-center" name="change_time" id="change_time" value="00:00">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <input type="button" class="btn btn-primary" name="change_submit" id="changeBtn" value="確定">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="PKModal" tabindex="-1" aria-labelledby="PKModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="PKModalLabel">PK入力</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form action="/pk_submit" method="post" id="PKForm">
      @csrf
        <div class="modal-body">
          <div class="row">
            <input type="hidden" class="form-control" name="period" id="period" value="{{$match->period}}">
            <input type="hidden" class="form-control" name="match_id" id="change_match_id" value="{{$match->match_id}}">
            <table class="table" id="pk_tbl">
                <tbody>
                    <tr>
                        <th colspan="2" id='home_club'></th>
                        <th colspan="2" id='away_club'></th>
                    </tr>
                    <tr>
                        <th>成功</th>
                        <th>キッカー</th>
                        <th>キッカー</th>
                        <th>成功</th>
                    </tr>
                    <tr>
                        <td id="home_result1"></td>
                        <td id="home_name1"></td>
                        <td id="away_id1"></td>
                        <td id="away_result1"></td>
                    </tr>
                    <tr>
                        <td id="home_result2"></td>
                        <td id="home_id2"></td>
                        <td id="away_id2"></td>
                        <td id="away_result2"></td>
                    </tr>
                    <tr>
                        <td id="home_result3"></td>
                        <td id="home_id3"></td>
                        <td id="away_id3"></td>
                        <td id="away_result3"></td>
                    </tr>
                    <tr>
                        <td id="home_result4"></td>
                        <td id="home_id4"></td>
                        <td id="away_id4"></td>
                        <td id="away_result4"></td>
                    </tr>
                    <tr>
                        <td id="home_result5"></td>
                        <td id="home_id5"></td>
                        <td id="away_id5"></td>
                        <td id="away_result5"></td>
                    </tr>
	        </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <input type="button" class="btn btn-primary" name="pk_submit" id="pkBtn" value="確定">
        </div>
      </form>
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
