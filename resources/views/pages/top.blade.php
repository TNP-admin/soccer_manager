@extends('layouts.basic')

@section('metatags')
<title>管理ページ</title>
<head prefix=”og:http://ogp.me/ns#”>
<meta property="og:title" content="サッカー情報入力" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://wfok.xyz" />
<meta property="og:image" content="https://wfok.xyz/img/main-logo.png" />
@endsection

@section('header')
@endsection

@section('contents')
<div class="row">
  <form action="/top" method="post">
    @csrf
    <div class="col-md-12">
      <div class="card card-user">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 pr-1">
              <div class="form-group">
                <label>入学年度</label>
                <select name="entrance_year" class="form-control">
                  <option value="2023">2023年度</option>
                  <option value="2024">2024年度</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="update ml-auto mr-auto">
            <label>コーチ</label>
            <button type="submit" class="btn btn-primary btn-round" name="login" value="coach">ログイン</button>
          </div>
	  <div class="update ml-auto mr-auto">
            <label>選手</label>
            <button type="submit" class="btn btn-primary btn-round" name="login" value="user">ログイン</button>
          </div>
        </div>
      </div>
    </div>
  </form>
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
