@extends('layouts.basic')

@section('metatags')
<title>クラブ新規登録</title>
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
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">クラブ情報入力</h4>
        </div>
        <div class="card-body">
          <form action="/newclub" method="post">
            @csrf
            <div class="row">
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>クラブ名称</label>
                  <input type="text" class="form-control" name="club_name" value="{{old('club_name')}}">
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>代表者</label>
                  <select name="club_representative" class="form-control">
                    <option value="">-</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>クラブURL</label>
                  <input type="text" class="form-control" name="club_url" value="{{old('club_url')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>都道府県協会</label>
                  <select name="prefecture_federation" class="form-control">
                    <option value="1302">東京都2ブロック</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>市町村協会</label>
                  <select name="city_association" class="form-control">
                    <option value="131229">葛飾区</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
		  <label>有効/無効</label>
                  <select name="club_status" class="form-control">
                    <option value="0" @if (old('cancel') == 0) selected @endif>有効</option>
                    <option value="1" @if (old('cancel') == 1) selected @endif>無効</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>追加コーチ</label>
                  <input type="number" class="form-control" name="coach" step="0" min="1" max="10" value="{{old('coach')}}">
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>追加選手</label>
                  <input type="number" class="form-control" name="user" step="0" min="1" max="99" value="{{old('user')}}">
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>入学年度</label>
                  <select name="entrance_year" class="form-control">
                    <option value="2023">2023年度</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>メール頭文字</label>
                  <input type="text" class="form-control" name="mail_head" value="{{old('mail_head')}}">
                  </select>
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
