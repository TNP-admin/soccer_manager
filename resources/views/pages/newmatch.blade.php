@extends('layouts.basic')

@section('metatags')
<title>試合情報新規登録</title>
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
  </header>
@endsection

@section('contents')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">試合情報入力</h4>
        </div>
        <div class="card-body">
          <form action="/newmatch" method="post">
            @csrf
            <div class="row">
              <div class="col-md-4 pr-1">
                <div class="form-group">
                  <label>試合名称</label>
                  <input type="text" class="form-control" name="match_name" value="{{old('match_name')}}">
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
		  <label>種類</label>
                  <select name="match_status" class="form-control">
                    <option value="0" @if (old('match_status') == 0) selected @endif>公式戦</option>
                    <option value="1" @if (old('match_status') == 1) selected @endif>練習試合</option>
                    <option value="2" @if (old('match_status') == 2) selected @endif>その他</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>開催場所</label>
                  <select name="pitch_id" class="form-control">
                    @foreach ($pitches as $pitches)
                        <option value="{{$pitches->pitch_id}}" @if (old('pitch_id') == $pitches->pitch_id) selected @endif>{{$pitches->pitch_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
		  <label>開催/中止</label>
                  <select name="cancel" class="form-control">
                    <option value="0" @if (old('cancel') == 0) selected @endif>開催</option>
                    <option value="1" @if (old('cancel') == 1) selected @endif>中止</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>試合日 <span class="badge badge-danger">必須</span></label>
                  <input type="date" class="form-control" name="match_date" value="{{old('match_date')}}">
                  @error('event_date')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
		  <label>開始予定時間 <span class="badge badge-danger">必須</span></label>
                  <input type="time" min="06:00:00" max="22:00:00" class="form-control" name="schedule_start"  value="{{old('schedule_start')}}">
                  @error('start')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                    <label>人制</label>
                    <select name="a_side" class="form-control">
                        <option value="6" {{old('a_side') == 6 ? 'selected' : ''}}>6人制</option>
                        <option value="8" {{old('a_side') == 8 ? 'selected' : ''}}>8人制</option>
                        <option value="11" {{old('a_side') == 11 ? 'selected' : ''}}>11人制</option>
                    </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 pr-1">
                <div class="form-group">
		  <label>フル・前後半</label>
                  <select name="period_setting" class="form-control">
                    <option value="1" @if (old('period_setting') == 1) selected @endif>フル</option>
                    <option value="2" @if (old('period_setting') == 2) selected @endif>前後半</option>
                    <option value="11" @if (old('period_setting') == 11) selected @endif>3ピリオド</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>試合時間 <span class="badge badge-danger">必須</span></label>
                  <input type="number" class="form-control" name="regulation_time" step="1" min="1" max="99" value="{{old('regulation_time')}}">
                  @error('assigned_book')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-1 pr-1">
                <div class="form-group">
                  <input type="hidden" id="overtime" name="overtime" value="0">
                  <label><input type="checkbox" id="overtime" name="overtime" value="1"> 延長</label>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>延長時間</label>
                  <input type="number" class="form-control" name="extra_time" step="1" min="1" max="99" value="{{old('extra_time')}}">
                </div>
              </div>
              <div class="col-md-1 pr-1">
                <div class="form-group">
                  <input type="hidden" id="pk" name="pk" value="0">
                  <label><input type="checkbox" id="pk" name="pk" value="1">PK</label>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <input type="hidden" id="home_easyinput" name="home_easyinput" value="0">
                  <label><input type="checkbox" id="home_easyinput" name="home_easyinput" value="1"> home簡易入力</label>
                </div>
                <div class="form-group">
                  <input type="hidden" id="away_easyinput" name="away_easyinput" value="0">
                  <label><input type="checkbox" id="away_easyinput" name="away_easyinput" value="1"> away簡易入力</label>
                </div>
              </div>
            </div>
        <div class="row">
          <div class="col">
            <div class="row">
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>ホーム1 <span class="badge badge-danger">必須</span></label>
                  <select name="home" id="home" class="form-control">
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('home')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>ホーム2</label>
                  <select name="home_2" id="home_2" class="form-control">
                    <option value="">-</option>
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('home_2')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>ホーム3</label>
                  <select name="home_3" id="home_3" class="form-control">
                    <option value="">-</option>
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('home_3')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>ホーム4</label>
                  <select name="home_4" id="home_4" class="form-control">
                    <option value="">-</option>
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('home_4')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>アウェイ1 <span class="badge badge-danger">必須</span></label>
                  <select name="away" id="away" class="form-control">
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('away')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>アウェイ2</label>
                  <select name="away_2" id="away_2" class="form-control">
                    <option value="">-</option>
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('away_2')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>アウェイ3</label>
                  <select name="away_3" id="away_3" class="form-control">
                    <option value="">-</option>
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('away_3')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>アウェイ4</label>
                  <select name="away_4" id="away_4" class="form-control">
                    <option value="">-</option>
                    @for ($i = 0; $i < COUNT($clubs); $i++)
                        <option value={{$clubs[$i]->club_id}} @if ($clubs[$i]->club_id == old('away_4')) selected @endif>{{$clubs[$i]->club_name}}</option>
                    @endfor
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col col-md-1 pr-1 d-flex align-items-center">
            <input type="button" id="change" value="↓↑">
          </div>
        </div>
            <div class="row">
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>天気</label>
                  <select name="weather" class="form-control">
                    <option value="0" {{old('weather') == 0 ? 'selected' : ''}}>-</option>
                    <option value="1" {{old('weather') == 1 ? 'selected' : ''}}>晴</option>
                    <option value="2" {{old('weather') == 2 ? 'selected' : ''}}>曇り</option>
                    <option value="3" {{old('weather') == 3 ? 'selected' : ''}}>雨</option>
                    <option value="4" {{old('weather') == 4 ? 'selected' : ''}}>雪</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>気温</label>
                  <input type="number" class="form-control" name="temperature" step="1" min="1" max="100" value="{{old('temperature')}}">
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>湿度</label>
                  <input type="number" class="form-control" name="humidity" step="1" min="1" max="100" value="{{old('humidity')}}">
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>風</label>
                  <input type="text" class="form-control" name="wind" value="{{old('wind')}}">
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>芝</label>
                  <select name="grass" class="form-control">
                    <option value="0" {{old('grass') == 0 ? 'selected' : ''}}>-</option>
                    <option value="1" {{old('grass') == 1 ? 'selected' : ''}}>土</option>
                    <option value="2" {{old('grass') == 2 ? 'selected' : ''}}>人工芝</option>
                    <option value="3" {{old('grass') == 3 ? 'selected' : ''}}>天然芝</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label>コンディション</label>
                  <input type="text" class="form-control" name="condition" value="{{old('condition')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label>試合動画URL</label>
                  <input type="text" class="form-control" name="movie_url" value="{{old('movie_url')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label>特記事項</label>
                  <input type="textarea" class="form-control" name="match_remarks" value="{{old('match_remarks')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="update ml-auto mr-auto">
                <button type="submit" class="btn btn-primary btn-round" value="send">保存</button>
              </div>
            </div>
          </form>
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
