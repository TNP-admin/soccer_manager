@extends('layouts.basic')

@section('metatags')
<title>クラブ情報変更</title>
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
  <div class="row">
    <div class="col-md-12">
    <form action="/club" method="post">
    @csrf
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">クラブ情報入力</h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>クラブ名称</label>
                  <input type="text" class="form-control" name="club_name" value="{{$club->club_name}}" disabled>
                  <input type="hidden" class="form-control" name="club_id" value="{{$club->club_id}}">
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
		  <label>代表者</label>
                  <select name="club_representative" class="form-control" disabled>
                    <option value="">-</option>
                    @foreach ($persons as $person)
                    <option value="{{$person->id}}">{{$person->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>クラブURL</label>
                  <input type="text" class="form-control" name="club_url" value="{{$club->club_url}}" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>都道府県協会</label>
                  <select name="prefecture_federation" class="form-control" disabled>
                    <option value="1302">東京都2ブロック</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>市町村協会</label>
                  <select name="city_association" class="form-control" disabled>
                    <option value="131229">葛飾区</option>
                  </select>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">選手情報</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <div class="row">
              <table class="table">
                @foreach ($users as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
		  <td>
		    <input type="hidden" class="form-control" name="id[]" value="{{$user->id}}">
                    <input type="text" class="form-control" name="nickname[]" value="{{$user->nickname}}">
		    <input type="hidden" class="form-control" name="pre_nickname[]" value="{{$user->nickname}}">
                  </td>
		  <td>
                    <input type="number" class="form-control" name="number[]" step="1" min="1" max="99" value="{{$user->number}}">
                    <input type="hidden" class="form-control" name="pre_number[]" value="{{$user->number}}">
                  </td>
		  <td>
                    <select name="position[]" class="form-control">
                      <option value="0" @if ($user->position == 0) selected @endif>-</option>
                      <option value="1" @if ($user->position == 1) selected @endif>GK</option>
                      <option value="3" @if ($user->position == 3) selected @endif>DF</option>
                      <option value="5" @if ($user->position == 5) selected @endif>MF</option>
                      <option value="7" @if ($user->position == 7) selected @endif>FW</option>
                      <option value="9" @if ($user->position == 9) selected @endif>その他</option>
                    </select>
                    <input type="hidden" class="form-control" name="pre_position[]" value="{{$user->position}}">
                  </td>
		  <td>
                    <select name="user_status[]" class="form-control">
                      <option value="0" @if ($user->user_status == 0) selected @endif>有効</option>
                      <option value="1" @if ($user->user_status == 1) selected @endif>無効</option>
                    </select>
                    <input type="hidden" class="form-control" name="pre_user_status[]" value="{{$user->number}}">
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <div class="row">
              <div class="update ml-auto mr-auto">
                <button type="submit" class="btn btn-primary btn-round" value="send">保存</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
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
