<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class InfoController extends Controller
{
    //user_edit
    public function user_edit(Request $request) {
        //ユーザ情報を取得
        $user = DB::table('users')
            ->where('id', $request->id)
            ->first();
        //dd($users);
        $clubs = DB::table('clubs')
		->get();

        return view('pages.user_edit', ['user' => $user, 'clubs' => $clubs]);
    }

    public function user_submit(Request $request){
        //dd($request);
        //usersを更新
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
	
        $updates = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nickname' => $request->nickname,
            'sex' => $request->sex,
            'birth' => $request->birth,
            'club_id' => $request->club_id,
            'category' => $request->category,
            'entrance_year' => $request->entrance_year,
            'number' => $request->number,
            'position' => $request->position,
            'remarks' => $request->remarks,
            'user_auth' => $request->user_auth,
            'user_status' => $request->user_status,
            'users_updated_at' => $now,
        ];
        DB::table('users')->insert($param);
            ->where('id',$request->id[$i])
	    ->update($updates);

        return redirect('/');
    }

    //newuser
    public function newuser(Request $request) {
        $clubs = DB::table('clubs')
		->get();

        return view('pages.newuser', ['clubs' => $clubs]);
    }

    public function newuser_submit(Request $request){
        //dd($request);
        //クラブを新規追加
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
	
        $param = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nickname' => $request->nickname,
            'sex' => $request->sex,
            'birth' => $request->birth,
            'club_id' => $request->club_id,
            'category' => $request->category,
            'entrance_year' => $request->entrance_year,
            'number' => $request->number,
            'position' => $request->position,
            'remarks' => $request->remarks,
            'user_auth' => $request->user_auth,
            'user_status' => $request->user_status,
            'users_created_at' => $now,
        ];
        DB::table('users')->insert($param);

        return redirect('/');
    }

}
