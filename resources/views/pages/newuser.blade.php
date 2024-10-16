@extends('layouts.basic')

@section('title', 'ユーザー情報登録')

@section('contents')
<div class="row">
    <div class="col-md-12">
      <div class="card card-user">
        <div class="card-header">
          <h5 class="card-title">ユーザー情報登録</h5>
        </div>
        <div class="card-body">
            @if (session('flash_message'))
                <div class="flash_message bg-success ">
                    {{ session('flash_message')}}
                </dic>
            @endif
          <form action="/newuser" method="post">
            @csrf
            <div class="row">
              <div class="col-md-4 pr-1">
                <div class="form-group">
                  <label>お名前 <span class="badge badge-danger">必須</span></label>
                  <input type="text" class="form-control" name="name" value="{{old('name')}}">
                  @error('name')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 pr-1">
                <div class="form-group">
                  <label>ニックネーム <span class="badge badge-danger">必須</span></label>
                  <input type="text" class="form-control" name="nickname" value="{{old('nickname')}}">
                  @error('nickname')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-1 pr-1">
                <div class="form-group">
                  <label>性別 <span class="badge badge-danger">必須</span></label>
                  <select name="sex" class="form-control">
                    <option value="0" selected>男</option>
                    <option value="1">女</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>生年月日</label>
                  <input type="date" class="form-control" name="birth" value="{{old('birth')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 pr-1">
                <div class="form-group">
                  <label>メールアドレス <span class="badge badge-danger">必須</span></label>
                  <input type="email" class="form-control" name="email" value="{{old('email')}}">
                  @error('email')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 pr-1">
                <div class="form-group">
                  <label>パスワード <span class="badge badge-danger">必須</span></label>
                  <input type="password" class="form-control" name="password">
                </div>
              </div>
              <div class="col-md-4 pr-1">
                <div class="form-group">
                  <label>パスワード（確認用） <span class="badge badge-danger">必須</span></label>
                  <input type="password" class="form-control" name="password_c">
                  @error('password_c')
                    <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>所属チーム</label>
                  <select type="text" class="form-control" name="club_id">
                    @foreach ($clubs as $club)
                    <option value="$club->club_id" {{old('club_id') == $club->club_id?"selected":""}}>{{$club->club_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>入学年度</label>
                  <input type="number" class="form-control" name="entrance_year" min="2015" value="{{old('entrance_year')}}">
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>背番号</label>
                  <input type="number" class="form-control" name="number" value="{{old('number')}}">
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>ポジション <span class="badge badge-danger">必須</span></label>
                  <select name="position" class="form-control">
                    <option value="0" selected>なし</option>
                    <option value="1">GK</option>
                    <option value="3">DF</option>
                    <option value="5">MF</option>
                    <option value="7">FW</option>
                    <option value="9">その他</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>区分 <span class="badge badge-danger">必須</span></label>
                  <select name="category" class="form-control">
                    <option value="0" selected>なし</option>
                    <option value="3">代表</option>
                    <option value="5">学年コーチ</option>
                    <option value="6">コーチ</option>
                    <option value="7">選手</option>
                    <option value="8">父母</option>
                    <option value="9">その他</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label>備考</label>
                  <input type="text" class="form-control" name="remarks" value="{{old('remarks')}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>権限</label>
                  <select name="user_auth" class="form-control" placeholder="user_auth">
                    <option value="0">sadmin</option>
                    <option value="1">admin</option>
                    <option value="3">represetative</option>
                    <option value="5">headcoach</option>
                    <option value="6">coach</option>
                    <option value="9" selected>user</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2 pr-1">
                <div class="form-group">
                  <label>有効無効</label>
                  <select name="user_status" class="form-control" placeholder="user_status">
                    <option value="0" selected>有効</option>
                    <option value="1">無効</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="insert ml-auto mr-auto">
                <button type="submit" class="btn btn-primary btn-round" value ="send">新規登録</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
