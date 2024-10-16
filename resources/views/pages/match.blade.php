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
@endsection

@section('contents')
<div class="row">
  <form action="/match_contents" method="post">
    @csrf
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$match->home_name}}@if ($match->home_2 != NULL) /{{$match->home2_name}} @endif @if ($match->home_3 != NULL) /{{$match->home3_name}} @endif @if ($match->home_4 != NULL) /{{$match->home4_name}} @endif VS {{$match->away_name}}@if ($match->away_2 != NULL) /{{$match->away2_name}} @endif @if ($match->away_3 != NULL) /{{$match->away3_name}} @endif @if ($match->away_4 != NULL) /{{$match->away4_name}} @endif</h4>
          <div class="row">
            <div class="col-4">
	      <h1 class="card-title text-right" id="home_score">{{$home_score}}<h1>
            </div>
            <div class="col-4">
              <div class="row">
                <div class="col-md-12">
              @if ($match->period == 1)
	        <h5 class="card-title text-center" id="half_text">フル</h5>
              @elseif ($match->period == 2)
                <h5 class="card-title text-center" id="half_text">前半</h5>
              @elseif ($match->period == 3)
                <h5 class="card-title text-center" id="half_text">後半</h5>
              @elseif ($match->period == 4)
                <h5 class="card-title text-center" id="half_text">延長前半</h5>
              @elseif ($match->period == 5)
                <h5 class="card-title text-center" id="half_text">延長後半</h5>
              @elseif ($match->period == 9)
                <h5 class="card-title text-center" id="half_text">試合終了</h5>
	      @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 mx-auto lead">
                  @if (EMPTY($match->match_start))
                  <input type="text" class="text-center border-0 mx-auto input_width_chnage" id="elapsed_time" value="{{substr($match->schedule_start, 0, 5)}} 開始予定" readonly>
                  @elseif (!EMPTY($match->match_start) AND $match->period != 9)
                  <input type="text" class="text-center border-0 mx-auto input_width_chnage" id="elapsed_time" value="{{substr($match->match_start, 11, 5)}} 開始" readonly>
                  @elseif (!EMPTY($match->match_start) AND $match->period == 9)
                  @endif
                </div>
              </div>
            </div>
            <div class="col-4">
              <h1 class="card-title" id="away_score">{{$away_score}}<h1>
            </div>
          </div>
        </div>
        <div class="card-body">
	  <div class="table-responsive">
            <div class="row">
            <div class="col-md-6">
              {{$match->home_name}}@if ($match->home_2 != NULL) /{{$match->home2_name}} @endif @if ($match->home_3 != NULL) /{{$match->home3_name}} @endif @if ($match->home_4 != NULL) /{{$match->home4_name}} @endif
	      <table class="table" id="home_tbl">
                <?php $num = 0 ?>
                @foreach ($home_players as $home_players)
                <tr>
                  <td>{{$home_players->match_position}}</td>
                  <td>{{$home_players->number}}:{{$home_players->nickname}}</td>
                </tr>
                <?php $num = $num + 1 ?>
		@endforeach
	      </table>
            </div>
	    <div class="col-md-6">
              {{$match->away_name}}@if ($match->away_2 != NULL) /{{$match->away2_name}} @endif @if ($match->away_3 != NULL) /{{$match->away3_name}} @endif @if ($match->away_4 != NULL) /{{$match->away4_name}} @endif
              <table class="table" id="away_tbl">
                @foreach ($away_players as $away_players)
                <tr>
                  <td>{{$away_players->match_position}}</td>
                  <td>{{$away_players->number}}:{{$away_players->nickname}}</td>
                </tr>
                <?php $num = $num + 1 ?>
                @endforeach
              </table>
	    </div>
            </div>
          </div>
        </div>
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
