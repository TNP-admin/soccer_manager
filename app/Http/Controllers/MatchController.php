<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class MatchController extends Controller
{
    //top
    public function top() {
        return view('pages.top');
    }

    public function top_submit(Request $request){
        //dd($request);
        If ($request->login == 'user'){
            return redirect('/index');
	} elseif ($request->login == 'coach'){
            return redirect('/index_coach');
	} else {
            return redirect('/');
        }
    }

    //index_user
    public function index_user() {
        $login_info = Auth::user();
        $today = today();
        //dd(today());

        //今日行われる試合は開始時間順に全て取得
        $todays_matches = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") as schedule_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home_name2, home3.club_name as home_name3, home4.club_name as home_name4, away.club_name as away_name, away2.club_name as away_name2, away3.club_name as away_name3, away4.club_name as away_name4, match_status, movie_url'))
            //->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") as schedule_start, home, away, home.club_name as home_name, away.club_name as away_name, match_status'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', $today)
            ->orderBy('match_start', 'asc')
            ->get();
        //dd($todays_matches);
        //昨日までの試合を日付・開始時間順に5件取得
        $result = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") as schedule_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home_name2, home3.club_name as home_name3, home4.club_name as home_name4, away.club_name as away_name, away2.club_name as away_name2, away3.club_name as away_name3, away4.club_name as away_name4, match_status, movie_url'))
            //->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") AS schedule_start, home, away, home.club_name as home_name, away.club_name as away_name, match_status, movie_url'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', "<", $today)
            ->orderBy('match_date', 'desc')
            ->orderBy('match_start', 'asc')
            ->limit(5)
            ->get();

        //明日以降の試合を日付・開始時間順に5件取得
        $schedule = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") as schedule_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home_name2, home3.club_name as home_name3, home4.club_name as home_name4, away.club_name as away_name, away2.club_name as away_name2, away3.club_name as away_name3, away4.club_name as away_name4, match_status, movie_url'))
            //->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") AS schedule_start, home, away, home.club_name as home_name, away.club_name as away_name, match_status'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', ">", $today)
            ->orderBy('match_date', 'asc')
            ->orderBy('match_start', 'asc')
            ->limit(5)
            ->get();

	$login_user = [
            'name' => $login_info->name,
            'nickname' => $login_info->nickname,
            'id' => $login_info->id,
            'number' => $login_info->number,
            'user_cnt' => 6,
        ];
        //dd($result);

        return view('pages.index_user', ['todays_matches' => $todays_matches, 'result' => $result, 'schedule' => $schedule, 'login_user' => $login_user]);
    }

    //index_coach
    public function index_coach() {
        $login_info = Auth::user();
        $today = today();
        //dd($login_info);

        //今日行われる試合は開始時間順に全て取得
        $todays_matches = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") as schedule_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home_name2, home3.club_name as home_name3, home4.club_name as home_name4, away.club_name as away_name, away2.club_name as away_name2, away3.club_name as away_name3, away4.club_name as away_name4, match_status, movie_url, home_easyinput, away_easyinput'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', $today)
            ->orderBy('match_start', 'asc')
            ->get();
        //dd($todays_matches);
        //昨日までの試合を日付・開始時間順に5件取得
        $result = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") as schedule_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home_name2, home3.club_name as home_name3, home4.club_name as home_name4, away.club_name as away_name, away2.club_name as away_name2, away3.club_name as away_name3, away4.club_name as away_name4, match_status, movie_url, home_easyinput, away_easyinput'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', "<", $today)
            ->orderBy('match_date', 'desc')
            ->orderBy('match_start', 'asc')
            ->limit(5)
            ->get();

        //明日以降の試合を日付・開始時間順に5件取得
        $schedule = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") as schedule_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home_name2, home3.club_name as home_name3, home4.club_name as home_name4, away.club_name as away_name, away2.club_name as away_name2, away3.club_name as away_name3, away4.club_name as away_name4, match_status, movie_url, home_easyinput, away_easyinput'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', ">", $today)
            ->orderBy('match_date', 'asc')
            ->orderBy('match_start', 'asc')
            ->limit(5)
            ->get();

        //コーチ・選手の一覧情報を取得
        $users = DB::table('users')
            ->select(DB::raw('id, name, nickname, number'))
            ->where('club_id', $login_info->club_id)
            ->where('user_status', 0)
            ->orderBy('id', 'asc')
            ->get();

        $login_user = [
            'name' => $login_info->name,
            'nickname' => $login_info->nickname."コーチ",
            'id' => $login_info->id,
            'user_cnt' => 6,
        ];
        //dd($result);

        return view('pages.index_coach', ['todays_matches' => $todays_matches, 'result' => $result, 'schedule' => $schedule, 'login_user' => $login_user, 'users' => $users]);
    }

    //club
    public function club(Request $request) {
        $login_user = Auth::user();

        //代表者用のユーザ情報を取得
        $persons = DB::table('users')
            ->select(DB::raw('id, name'))
            ->where('club_id', 2)
            ->where('category', '!=', 3)
            ->where('user_status', 0)
            ->orderBy('id', 'asc')
            ->get();
        
        //コーチ・選手の一覧情報を取得
        $users = DB::table('users')
            ->select(DB::raw('id, name, nickname, position, number, user_status'))
            ->where('club_id', 2)
            ->where('user_status', 0)
            ->orderBy('id', 'asc')
            ->get();
        
        $club = DB::table('clubs')
            ->where('club_id', 2)
	    ->first();
        //dd($users);
        return view('pages.club', ['club' => $club, 'users' => $users, 'persons' => $persons]);
    }

    public function club_submit(Request $request){
        $login_user = Auth::user();
        //dd($request);
        //usersを更新
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
	
	//選手数だけ選手を新規登録
	for ($i = 0; $i < COUNT($request->nickname); $i++) {
            if ($request->nickname[$i] != $request->pre_nickname[$i] OR $request->number[$i] != $request->pre_number[$i] OR $request->user_status[$i] != $request->pre_user_status[$i] OR $request->position[$i] != $request->pre_position[$i]) {
                $updates = [
                'nickname' => $request->nickname[$i],
                'number' => $request->number[$i],
                'position' => $request->position[$i],
                'user_status' => $request->user_status[$i],
            ];
            DB::table('users')
                ->where('id',$request->id[$i])
	        ->update($updates);
            }
        }

        return redirect('/index_coach?id='.$login_user->id);
    }

    //newclub
    public function newclub(Request $request) {
        return view('pages.newclub');
    }

    public function newclub_submit(Request $request){
        $login_user = Auth::user();

        //dd($request);
        //クラブを新規追加
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $param = [
            'club_name' => $request->club_name,
            'club_representative' => $request->club_representative,
            'club_url' => $request->club_url,
            'prefecture_federation' => $request->prefecture_federation,
            'city_association' => $request->city_association,
            'club_status' => $request->club_status,
            'clubs_created_at' => $now,
        ];
        DB::table('clubs')->insert($param);

	$club_id = DB::getPdo()->lastInsertId();
	$cnt = 0;  //email用
        $num = 1;  //背番号用
	
	//コーチ数だけコーチを新規登録
	for ($i = 0; $i < $request->coach; $i++) {
            $param = [
                'name' => "- -",
                'email' => $request->mail_head . '-' . $cnt . "@gmail.com",
                'password' => 'aaa',
                'nickname' => '-',
                'sex' => 0,
                'birth' => '2016/04/02',
                'club_id' => $club_id,
                'category' => 2,
                'entrance_year' => $request->entrance_year,
                'number' => NULL,
                'position' => 9,
                'remarks' => NULL,
                'user_auth' => 6,
                'user_status' => 0,
                'users_created_at' => $now,
            ];
            DB::table('users')->insert($param);

            $cnt = $cnt + 1;
        }
	
	//選手数だけ選手を新規登録
	for ($i = 0; $i < $request->user; $i++) {
            $param = [
                'name' => "- -",
                'email' => $request->mail_head . '-' . $cnt . "@gmail.com",
                'password' => 'aaa',
                'nickname' => '-',
                'sex' => 0,
                'birth' => '2016/04/02',
                'club_id' => $club_id,
                'category' => 3,
                'entrance_year' => $request->entrance_year,
                'number' => $num,
                'position' => 0,
                'remarks' => NULL,
                'user_auth' => 9,
                'user_status' => 0,
                'users_created_at' => $now,
            ];
            DB::table('users')->insert($param);

            $cnt = $cnt + 1;
            $num = $num + 1;
        }

        return redirect('/index_coach?id='.$login_user->id);
        //return redirect('/');
    }

    //match_edit
    public function match_edit(Request $request) {
        //dd($request);
        $match_id =  $request->match_id;

	//試合情報の取得
	$match = DB::table('matches')
            ->where('match_id', $match_id)
	    ->first();
        $clubs = DB::table('clubs')
	    ->get();
	$pitches = DB::table('pitches')
	    ->get();
	//dd($clubs);

        return view('pages.match_edit', ['match' => $match, 'clubs' => $clubs, 'pitches' => $pitches]);
    }

    public function match_submit(Request $request){
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
	$login_user = Auth::user();
        $match_id = $request->match_id;

        If ($request->submit == '保存'){
            $updates = [
                'match_name' => $request->match_name,
                'match_status' => $request->match_status,
                'pitch_id' => $request->pitch_id,
                'cancel' => $request->cancel,
                'match_date' => $request->match_date,
                'schedule_start' => $request->schedule_start,
                'regulation_time' => $request->regulation_time,
                'period_setting' => $request->period_setting,
                'period' => $request->period_setting,
                'a_side' => $request->a_side,
                'overtime' => $request->overtime,
                'pk' => $request->pk,
                'extra_time' => $request->extra_time,
                'home_easyinput' => $request->home_easyinput,
                'away_easyinput' => $request->away_easyinput,
                'home' => $request->home,
                'home_2' => $request->home_2,
                'home_3' => $request->home_3,
                'home_4' => $request->home_4,
                'away' => $request->away,
                'away_2' => $request->away_2,
                'away_3' => $request->away_3,
                'away_4' => $request->away_4,
                'weather' => $request->weather,
                'temperature' => $request->temperature,
                'humidity' => $request->humidity,
                'wind' => $request->wind,
                'grass' => $request->grass,
                'condition' => $request->condition,
                'movie_url' => $request->movie_url,
                'match_remarks' => $request->match_remarks,
                'matches_created_at' => $now,
            ];
            DB::table('matches')
                ->where('match_id',$match_id)
		->update($updates);

	    //簡易入力の場合
            //memberとplayerを先頭から順にa_side分設定する
            //先に入っていれば、そのまま利用する
            If ($request->home_easyinput == 1) {
                $home = $request->home;
                $home2 = $request->home_2;
                $home3 = $request->home_3;
                $home4 = $request->home_4;

                $players = DB::table('players')
                    ->whereIn('club_id', [$home, $home2, $home3, $home4])
                    ->where('match_id', $match_id)
                    ->get();

                $members = DB::table('members')
                    ->whereIn('club_id', [$home, $home2, $home3, $home4])
                    ->where('match_id', $match_id)
                    ->get();
                //dd(COUNT($members));

		if (COUNT($players) == 0) {
                    if (COUNT($members) == 0) {
                        $insert_members = DB::table('users')
                            ->whereIn('club_id', [$home, $home2, $home3, $home4])
                            //->where(function($query) use($home, $home2, $home3, $home4) {
                            //    $query->where('club_id', $home)
                            //        ->orWhere('club_id', $home_2)
                            //        ->orWhere('club_id', $home_3)
                            //        ->orWhere('club_id', $home_4);
                            //    })
                            ->where('category', 7)
                            ->limit($request->a_side)
                            ->get();
			//dd($insert_members);
                        $cnt = 1;
                        foreach ($insert_members as $insert_member) {
                            $param_mem = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'competition' => 0,
                                'member_remarks' => '簡易入力',
                                'members_created_at' => $now,
                            ];
                            DB::table('members')->insert($param_mem);

                            $param_ply = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'match_position' => $cnt,
                                'player_remarks' => '簡易入力',
                                'players_created_at' => $now,
                            ];
			    DB::table('players')->insert($param_ply);
                            $cnt = $cnt + 1;
                        } 
		    } else {
                        $insert_members = DB::table('users')
                            ->whereIn('club_id', [$home, $home2, $home3, $home4])
                            //->where(function($query) use($home, $home2, $home3, $home4) {
                            //    $query->where('club_id', $home)
                            //        ->orWhere('club_id', $home_2)
                            //        ->orWhere('club_id', $home_3)
                            //        ->orWhere('club_id', $home_4);
                            //    })
                            ->where('category', 7)
                            ->limit($request->a_side)
                            ->get();
			//dd($insert_members);
                        $cnt = 1;
                        foreach ($insert_members as $insert_member) {
                            $param_ply = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'match_position' => $cnt,
                                'player_remarks' => '簡易入力',
                                'players_created_at' => $now,
                            ];
			    DB::table('players')->insert($param_ply);
                            $cnt = $cnt + 1;
                        } 
                    }
                }
            }

	    //簡易入力の場合
            //memberとplayerを先頭から順にa_side分設定する
            //先に入っていれば、そのまま利用する
            If ($request->away_easyinput == 1) {
                $away = $request->away;
                $away2 = $request->away_2;
                $away3 = $request->away_3;
                $away4 = $request->away_4;

                $players = DB::table('players')
                    ->whereIn('club_id', [$away, $away2, $away3, $away4])
                    ->where('match_id', $match_id)
                    ->get();

                $members = DB::table('members')
                    ->whereIn('club_id', [$away, $away2, $away3, $away4])
                    ->where('match_id', $match_id)
                    ->get();
                //dd(COUNT($members));

		if (COUNT($players) == 0) {
                    if (COUNT($members) == 0) {
                        $insert_members = DB::table('users')
                            ->whereIn('club_id', [$away, $away2, $away3, $away4])
                            //->where(function($query) use($away, $away2, $away3, $away4) {
                            //    $query->where('club_id', $away)
                            //        ->orWhere('club_id', $away_2)
                            //        ->orWhere('club_id', $away_3)
                            //        ->orWhere('club_id', $away_4);
                            //    })
                            ->where('category', 7)
                            ->limit($request->a_side)
                            ->get();
			//dd($insert_members);
                        $cnt = 1;
                        foreach ($insert_members as $insert_member) {
                            $param_mem = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'competition' => 0,
                                'member_remarks' => '簡易入力',
                                'members_created_at' => $now,
                            ];
                            DB::table('members')->insert($param_mem);

                            $param_ply = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'match_position' => $cnt,
                                'player_remarks' => '簡易入力',
                                'players_created_at' => $now,
                            ];
			    DB::table('players')->insert($param_ply);
                            $cnt = $cnt + 1;
                        } 
		    } else {
                        $insert_members = DB::table('users')
                            ->whereIn('club_id', [$away, $away2, $away3, $away4])
                            //->where(function($query) use($away, $away2, $away3, $away4) {
                            //    $query->where('club_id', $away)
                            //        ->orWhere('club_id', $away_2)
                            //        ->orWhere('club_id', $away_3)
                            //        ->orWhere('club_id', $away_4);
                            //    })
                            ->where('category', 7)
                            ->limit($request->a_side)
                            ->get();
			//dd($insert_members);
                        $cnt = 1;
                        foreach ($insert_members as $insert_member) {
                            $param_ply = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'match_position' => $cnt,
                                'player_remarks' => '簡易入力',
                                'players_created_at' => $now,
                            ];
			    DB::table('players')->insert($param_ply);
                            $cnt = $cnt + 1;
                        } 
                    }
                }
            }
            return redirect('/index_coach');
	    
        } elseif ($request->submit == '試合コピー'){
            return redirect('/copy_match?match_id='.$request->match_id);
        } 

    }

    //copy_match
    public function copy_match(Request $request) {
        //dd($request);
        $match_id =  $request->match_id;

	//試合情報の取得
	$match = DB::table('matches')
            ->where('match_id', $match_id)
	    ->first();
        $clubs = DB::table('clubs')
	    ->get();
	$pitches = DB::table('pitches')
	    ->get();
	//dd($clubs);

        return view('pages.copy_match', ['match' => $match, 'clubs' => $clubs, 'pitches' => $pitches]);
    }

    public function copy_match_submit(Request $request){
        //dd($request);
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $login_user = Auth::user();

        $param = [
            'match_name' => $request->match_name,
            'match_status' => $request->match_status,
            'pitch_id' => $request->pitch_id,
            'cancel' => $request->cancel,
            'match_date' => $request->match_date,
            'schedule_start' => $request->schedule_start,
            'regulation_time' => $request->regulation_time,
            'period_setting' => $request->period_setting,
            'period' => $request->period_setting,
            'a_side' => $request->a_side,
            'overtime' => $request->overtime,
            'pk' => $request->pk,
            'extra_time' => $request->extra_time,
            'home_easyinput' => $request->home_easyinput,
            'away_easyinput' => $request->away_easyinput,
            'home' => $request->home,
            'home_formation' => 0,
            'away_formation' => 0,
            'home_2' => $request->home_2,
            'home_3' => $request->home_3,
            'home_4' => $request->home_4,
            'away' => $request->away,
            'away_2' => $request->away_2,
            'away_3' => $request->away_3,
            'away_4' => $request->away_4,
            'weather' => $request->weather,
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'wind' => $request->wind,
            'grass' => $request->grass,
            'condition' => $request->condition,
            'movie_url' => $request->movie_url,
            'match_remarks' => $request->match_remarks,
            'confirm' => 0,
            'home_confirm' => 0,
            'away_confirm' => 0,
            'matches_created_at' => $now,
        ];
        DB::table('matches')->insert($param);
	$match_id = DB::getPdo()->lastInsertId();

        //簡易入力の場合(home)
        //memberとplayerを先頭から順にa_side分設定する
        If ($request->home_easyinput == 1) {
            $home = $request->home;
            $home2 = $request->home_2;
            $home3 = $request->home_3;
            $home4 = $request->home_4;

            $insert_members = DB::table('users')
                ->whereIn('club_id', [$home, $home2, $home3, $home4])
                //->where(function($query) use($home, $home2, $home3, $home4) {
                //    $query->where('club_id', $home)
                //        ->orWhere('club_id', $home_2)
                //        ->orWhere('club_id', $home_3)
                //        ->orWhere('club_id', $home_4);
                //    })
                ->where('category', 7)
                ->limit($request->a_side)
                ->get();
                //dd($insert_members);
            $cnt = 1;
            foreach ($insert_members as $insert_member) {
                $param_mem = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'competition' => 0,
                    'member_remarks' => '簡易入力',
                    'members_created_at' => $now,
                ];
                DB::table('members')->insert($param_mem);

                $param_ply = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'match_position' => $cnt,
                    'player_remarks' => '簡易入力',
                    'players_created_at' => $now,
                ];
                DB::table('players')->insert($param_ply);
                $cnt = $cnt + 1;
            } 
        }

        //簡易入力の場合(away)
        //memberとplayerを先頭から順にa_side分設定する
        If ($request->away_easyinput == 1) {
            $away = $request->away;
            $away2 = $request->away_2;
            $away3 = $request->away_3;
            $away4 = $request->away_4;

            $insert_members = DB::table('users')
                ->whereIn('club_id', [$away, $away2, $away3, $away4])
                //->where(function($query) use($away, $away2, $away3, $away4) {
                //    $query->where('club_id', $away)
                //        ->orWhere('club_id', $away_2)
                //        ->orWhere('club_id', $away_3)
                //        ->orWhere('club_id', $away_4);
                //    })
                ->where('category', 7)
                ->limit($request->a_side)
                ->get();
                //dd($insert_members);
            $cnt = 1;
            foreach ($insert_members as $insert_member) {
                $param_mem = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'competition' => 0,
                    'member_remarks' => '簡易入力',
                    'members_created_at' => $now,
                ];
                DB::table('members')->insert($param_mem);

                $param_ply = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'match_position' => $cnt,
                    'player_remarks' => '簡易入力',
                    'players_created_at' => $now,
                ];
                DB::table('players')->insert($param_ply);
                $cnt = $cnt + 1;
            } 
        }

        return redirect('/index_coach');
        //return redirect('/');
    }

    //newmatch
    public function newmatch(Request $request) {

	//試合情報の取得
        $clubs = DB::table('clubs')
	    ->get();
	$pitches = DB::table('pitches')
	    ->get();

        return view('pages.newmatch', ['clubs' => $clubs, 'pitches' => $pitches]);
    }

    public function newmatch_submit(Request $request){
        //dd($request);
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $login_user = Auth::user();

        $param = [
            'match_name' => $request->match_name,
            'match_status' => $request->match_status,
            'pitch_id' => $request->pitch_id,
            'cancel' => $request->cancel,
            'match_date' => $request->match_date,
            'schedule_start' => $request->schedule_start,
            'regulation_time' => $request->regulation_time,
            'period_setting' => $request->period_setting,
            'period' => $request->period_setting,
            'a_side' => $request->a_side,
            'overtime' => $request->overtime,
            'pk' => $request->pk,
            'extra_time' => $request->extra_time,
            'home_easyinput' => $request->home_easyinput,
            'away_easyinput' => $request->away_easyinput,
            'home' => $request->home,
            'home_formation' => 0,
            'away_formation' => 0,
            'home_2' => $request->home_2,
            'home_3' => $request->home_3,
            'home_4' => $request->home_4,
            'away' => $request->away,
            'away_2' => $request->away_2,
            'away_3' => $request->away_3,
            'away_4' => $request->away_4,
            'weather' => $request->weather,
            'temperature' => $request->temperature,
            'humidity' => $request->humidity,
            'wind' => $request->wind,
            'grass' => $request->grass,
            'condition' => $request->condition,
            'movie_url' => $request->movie_url,
            'match_remarks' => $request->match_remarks,
            'confirm' => 0,
            'home_confirm' => 0,
            'away_confirm' => 0,
            'matches_created_at' => $now,
        ];
        DB::table('matches')->insert($param);
	$match_id = DB::getPdo()->lastInsertId();

        //簡易入力の場合(home)
        //memberとplayerを先頭から順にa_side分設定する
        If ($request->home_easyinput == 1) {
            $home = $request->home;
            $home2 = $request->home_2;
            $home3 = $request->home_3;
            $home4 = $request->home_4;

            $insert_members = DB::table('users')
                ->whereIn('club_id', [$home, $home2, $home3, $home4])
                //->where(function($query) use($home, $home2, $home3, $home4) {
                //    $query->where('club_id', $home)
                //        ->orWhere('club_id', $home_2)
                //        ->orWhere('club_id', $home_3)
                //        ->orWhere('club_id', $home_4);
                //    })
                ->where('category', 7)
                ->limit($request->a_side)
                ->get();
                //dd($insert_members);
            $cnt = 1;
            foreach ($insert_members as $insert_member) {
                $param_mem = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'competition' => 0,
                    'member_remarks' => '簡易入力',
                    'members_created_at' => $now,
                ];
                DB::table('members')->insert($param_mem);

                $param_ply = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'match_position' => $cnt,
                    'player_remarks' => '簡易入力',
                    'players_created_at' => $now,
                ];
                DB::table('players')->insert($param_ply);
                $cnt = $cnt + 1;
            } 
        }

        //簡易入力の場合(away)
        //memberとplayerを先頭から順にa_side分設定する
        If ($request->away_easyinput == 1) {
            $away = $request->away;
            $away2 = $request->away_2;
            $away3 = $request->away_3;
            $away4 = $request->away_4;

            $insert_members = DB::table('users')
                ->whereIn('club_id', [$away, $away2, $away3, $away4])
                //->where(function($query) use($away, $away2, $away3, $away4) {
                //    $query->where('club_id', $away)
                //        ->orWhere('club_id', $away_2)
                //        ->orWhere('club_id', $away_3)
                //        ->orWhere('club_id', $away_4);
                //    })
                ->where('category', 7)
                ->limit($request->a_side)
                ->get();
                //dd($insert_members);
            $cnt = 1;
            foreach ($insert_members as $insert_member) {
                $param_mem = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'competition' => 0,
                    'member_remarks' => '簡易入力',
                    'members_created_at' => $now,
                ];
                DB::table('members')->insert($param_mem);

                $param_ply = [
                    'match_id' => $match_id,
                    'id' => $insert_member->id,
                    'club_id' => $insert_member->club_id,
                    'match_position' => $cnt,
                    'player_remarks' => '簡易入力',
                    'players_created_at' => $now,
                ];
                DB::table('players')->insert($param_ply);
                $cnt = $cnt + 1;
            } 
        }

        return redirect('/index_coach');
        //return redirect('/');
    }

    public function home_members(Request $request) {
        $match_id =  $request->match_id;

	//試合情報の取得
	$match = DB::table('matches')
            ->where('match_id', $match_id)
	    ->first();
	$home = $match->home;
	$home2 = $match->home_2;
	$home3 = $match->home_3;
	$home4 = $match->home_4;

	//membersに登録があれば、home_membersを取得
	$members = DB::table('members')
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$home, $home2, $home3, $home4])
            ->get();
	$players = DB::table('players')
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$home, $home2, $home3, $home4])
            //->where('club_id', $home)
            ->get();
        //dd(COUNT($players));

        if (COUNT($members) == 0) {
	    $home_members = DB::table('users')
                ->select(DB::raw('id, name, nickname, number, home.club_name, 0 as member_id, 0 as competition, NULL as match_position, NULL as member_remarks, NULL as player_id'))
                ->leftjoin('clubs as home', 'home.club_id', 'users.club_id')
                //->where('club_id', $home)
                ->whereIn('users.club_id', [$home, $home2, $home3, $home4])
                ->where('users.category', 7)
                ->get();
	} elseif (COUNT($members) != 0 AND COUNT($players) == 0) {
            $home_members = DB::table('members')
                ->select(DB::raw('users.id, users.name, users.nickname, users.number, home.club_name, members.member_id, members.competition, NULL as match_position, members.member_remarks, NULL as player_id'))
                ->leftjoin('clubs as home', 'home.club_id', 'members.club_id')
                ->leftJoin('users', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('users.id', '=', 'members.id')
                        ->whereIn('users.club_id', [$home, $home2, $home3, $home4])
                        ->where('users.category', 7);
                })
                //->where('users.club_id', $home)
                ->whereIn('members.club_id', [$home, $home2, $home3, $home4])
                ->where('members.match_id', $match_id)
                ->get();
	} elseif (COUNT($members) != 0 AND COUNT($players) != 0) {
            $home_members = DB::table('members')
                ->select(DB::raw('users.id, users.name, users.nickname, users.number, home.club_name, members.member_id, members.competition, players.match_position, members.member_remarks, players.player_id'))
                ->leftjoin('clubs as home', 'home.club_id', 'members.club_id')
                ->leftJoin('users', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('users.id', '=', 'members.id')
                        //->where('users.club_id', $home)
                        ->whereIn('users.club_id', [$home, $home2, $home3, $home4])
                        ->where('users.category', 7);
                })
                ->leftJoin('players', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('users.id', '=', 'players.id')
                        ->where('players.match_id', $match_id)
                        //->where('players.club_id', $home);
                        ->whereIn('players.club_id', [$home, $home2, $home3, $home4]);
                })
                ->where('members.match_id', $match_id)
                ->whereIn('members.club_id', [$home, $home2, $home3, $home4])
                //->where('members.club_id', $home)
                ->get();
	        //dd($home_members);
	}
	
	//試合情報の取得
	$today = date('Y-m-d H:i:s', strtotime(date('Y')."-".date('m')."-".date('d')));
	$pre_matches = DB::table('matches')
            ->select(DB::raw('matches.match_id, matches.match_date, TIME_FORMAT(matches.schedule_start, "%H:%i") AS schedule_start, home.club_name as home, home2.club_name as home2, home3.club_name as home3, home4.club_name as home4, away.club_name as away, away2.club_name as away2, away3.club_name as away3, away4.club_name as away4'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', ">=",  $today)
            ->where('match_id', "!=",  $match_id)
            ->get();
        //dd($pre_match);

        return view('pages.home_members', ['match' => $match, 'home_members' => $home_members, 'pre_matches' => $pre_matches]);
    }

    public function home_members_submit(Request $request){
        //dd($request);
        //match_positionがa_side分入っているか確認する    
        //memberの数がa_sideに足りない時はNULLがないかを確認する
        //またpositionが全て入っているかも確認する
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $login_user = Auth::user();

	if ($request->parti_submit == "メンバーコピー") {
            //dd($request);
            //$pre_match_idが空でなければ、追加する
            $match_id = $request->match_id[0];
	    $pre_match_id = $request->pre_match[0];

            if ($pre_match_id != NULL) {
                //$match_idでのmembersを出力して、空であればmembersに追加する
                $match = DB::table('matches')
                    ->select(DB::raw('home, home_2, home_3, home_4'))
                    ->where('match_id', $match_id)
		    ->first();
		$home = $match->home;
		$home2 = $match->home_2;
		$home3 = $match->home_3;
		$home4 = $match->home_4;

                $members = DB::table('members')
                    ->whereIn('club_id', [$home, $home2, $home3, $home4])
                    ->where('match_id', $match_id)
                    ->get();
                //dd(COUNT($members));

                if (COUNT($members) == 0) {
                    //現在の試合のhomeを取得して、pre_matchのhome、awayと全く同じ方のmemberとplayerをコピーする
                    $pre_match = DB::table('matches')
                        ->select(DB::raw('home, home_2, home_3, home_4, away, away_2, away_3, away_4'))
                        ->where('match_id', $pre_match_id)
                        ->first();
                    //dd($match);

                    if ($match->home == $pre_match->home AND $match->home_2 == $pre_match->home_2 AND $match->home_3 == $pre_match->home_3 AND $match->home_4 == $pre_match->home_4) {
                        //dd("homeと同じ");
                        //dd($pre_match_id);
                        $insert_members = DB::table('members')
                            ->where('match_id', $pre_match_id)
                            ->where(function($query) use($pre_match) {
                                $query->where('club_id', $pre_match->home)
                                    ->orWhere('club_id', $pre_match->home_2)
                                    ->orWhere('club_id', $pre_match->home_3)
                                    ->orWhere('club_id', $pre_match->home_4);
                                })
                            ->get();
                        //dd($insert_members);
                        foreach ($insert_members as $insert_member) {
                            $param = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'competition' => $insert_member->competition,
                                'member_remarks' => $insert_member->member_remarks,
                                'members_created_at' => $now,
                            ];
                            DB::table('members')->insert($param);    
                        }
                    } elseif ($match->home == $pre_match->away AND $match->home_2 == $pre_match->away_2 AND $match->home_3 == $pre_match->away_3 AND $match->home_4 == $pre_match->away_4) {
                        //dd($pre_match_id);
                        $insert_members = DB::table('members')
                            ->where('match_id', $pre_match_id)
                            ->where(function($query) use($pre_match) {
                                $query->where('club_id', $pre_match->away)
                                    ->orWhere('club_id', $pre_match->away_2)
                                    ->orWhere('club_id', $pre_match->away_3)
                                    ->orWhere('club_id', $pre_match->away_4);
                                })
                            ->get();
                        //dd($insert_members);
                        foreach ($insert_members as $insert_member) {
                            $param = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'competition' => $insert_member->competition,
                                'member_remarks' => $insert_member->member_remarks,
                                'members_created_at' => $now,
                            ];
                            DB::table('members')->insert($param);    
                        }
                    }
                    return redirect('/home_members?match_id='.$match_id)->with('flash_message','前の試合の出欠をコピーしました。');
                } else {
                    return redirect('/home_members?match_id='.$match_id)->with('flash_message','すでに出欠の登録がされているので、コピーできません。');
	        }
            } else {
                return redirect('/home_members?match_id='.$match_id)->with('flash_message','コピーする試合を選択してください。');
            }
	} elseif ($request->parti_submit == "一時保存" OR $request->parti_submit == "確定") {
            $checks = [];
            for ($i = 1; $i <= $request->a_side; $i++) {
                array_push($checks, $i);
            }
            $checks_list = $checks;
    
            //dd(COUNT($checks_list));
            $num = 0;
            $match_positions = $request->match_position;
            //dd($match_positions);
            foreach ($match_positions as $match_position) {
                //dd($match_position);
                if ($match_position != NULL) {
                    for($i = 0; $i < COUNT($checks_list); $i++) {
                        //dd($checks[$i]);
                        if ($match_position == $checks_list[$i]) {
                            unset($checks[$i]);
                            break;
                        }
                    }
                    $num = $num + 1;
                }
            }
            //dd(COUNT($checks));
            //memberに登録がなければ、memberに追加する。
            $members = DB::table('members')
                ->select(DB::raw('member_id, match_id, id, club_id'))
                ->where('match_id', $request->match_id[0])
                ->where('club_id', $request->club_id[0])
                ->get();

            if (COUNT($members) == 0) {
                for ($i = 0; $i < COUNT($request->id); $i++) {
                    $param = [
                        'match_id' => $request->match_id[$i],
                        'id' => $request->id[$i],
                        'club_id' => $request->club_id[$i],
                        'competition' => $request->competition[$i],
                        'member_remarks' => $request->member_remarks[$i],
                        'members_created_at' => $now,
                    ];
                    DB::table('members')->insert($param);
                }
            } else {
                $updates = [];
                for ($i = 0; $i < COUNT($request->id); $i++) {
                    //competitionが変更されていれば、updatesに入れる
                    if ($request->competition[$i] != $request->pre_competition[$i]) {
                        $updates['competition'] = $request->competition[$i];
                    }
    
                    //member_remarksが変更されていれば、updatesに入れる
                    if ($request->member_remarks[$i] != $request->pre_member_remarks[$i]) {
                        $updates['member_remarks'] = $request->member_remarks[$i];
                    }
    
                    if (COUNT($updates) != 0) {
                        //dd($updates);
                        $updates['members_updated_at'] = $now;
                        DB::table('members')
                            ->where('member_id',$request->member_id[$i])
                            ->update($updates); 
    			//break;
                    }
                } 
            }

            if ($num < $request->a_side) {
                return redirect('/home_members?match_id='.$request->match_id[0])->with('flash_message','ポジションは全て入れてください。');
            } elseif ($num > $request->a_side) {
                return redirect('/home_members?match_id='.$request->match_id[0])->with('flash_message','出場者を入れすぎです。');
            } elseif ($num == $request->a_side AND COUNT($checks) > 0) {
                return redirect('/home_members?match_id='.$request->match_id[0])->with('flash_message','ポジションが重複しています。');
            } elseif ($num == $request->a_side AND COUNT($checks) == 0) {
                //入力に問題がなければ、登録する。
                //playerに登録がなければ、playerに追加する。
    	        $players = DB::table('players')
                    ->select(DB::raw('player_id, id, match_position'))
                    ->where('match_id', $request->match_id[0])
                    ->where('club_id', $request->club_id[0])
                    ->get();
                $match = DB::table('matches')
                    ->select(DB::raw('period'))
                    ->where('match_id', $request->match_id[0])
		    ->first();
 
    	        if (COUNT($players) == 0) {
                    for ($i = 0; $i < COUNT($request->id); $i++) {
                        if ($request->match_position[$i] != NULL) {
                            $param = [
                                'match_id' => $request->match_id[$i],
                                'id' => $request->id[$i],
                                'club_id' => $request->club_id[$i],
                                'match_position' => $request->match_position[$i],
                                'on_period' => $match->period,
                                'on' => '00:00:00',
                                'off_period' => NULL,
                                'off' => NULL,
                                'player_remarks' => NULL,
                                'players_created_at' => $now,
                            ];
                        DB::table('players')->insert($param);
                        }
                    }
                } else {
                    $updates = [];
                    for ($i = 0; $i < COUNT($request->id); $i++) {
                        //match_positionが変更されていれば、
                        //取得していた$playersのmatch_positionのが同じplayer_idのidを更新する
                        if ($request->match_position[$i] != NULL AND $request->match_position[$i] != $request->pre_match_position[$i]) {
                            foreach ($players as $player) {
                                if ($player->match_position == $request->match_position[$i]) {
                                    $updates['id'] = $request->id[$i];
                                    $updates['players_updated_at'] = $now;
                                    //dd($updates);

                                    DB::table('players')
                                        ->where('player_id',$player->player_id)
                                        ->update($updates);
                                    break;
                                }
                            }
                        }
                    }
                }
               
                //確定ボタンであれば、matchのhome_confirmを確定に更新する。
                if ($request->parti_submit == "確定") {
                    $updates['home_confirm'] = 1;
                    $updates['matches_updated_at'] = $now;
                    //dd($updates);

                    DB::table('matches')
                        ->where('match_id',$request->match_id[0])
                        ->update($updates); 
                } 
                return redirect('/index_coach?id='.$login_user->id);
            } else {
                return redirect('/home_members?match_id='.$request->match_id[0])->with('flash_message','予期しないエラーです。管理者に連絡してください。');
            }
        }
    }

    //away_members
    public function away_members(Request $request) {
        $match_id =  $request->match_id;

	//試合情報の取得
	$match = DB::table('matches')
            ->where('match_id', $match_id)
	    ->first();
	$away = $match->away;
	$away2 = $match->away_2;
	$away3 = $match->away_3;
	$away4 = $match->away_4;

	//membersに登録があれば、away_membersを取得
	$members = DB::table('members')
            ->where('match_id', $match_id)
            //->where('club_id', $away)
            ->whereIn('club_id', [$away, $away2, $away3, $away4])
            ->get();
	$players = DB::table('players')
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$away, $away2, $away3, $away4])
            //->where('club_id', $away)
            ->get();
        //dd(COUNT($members));

        if (COUNT($members) == 0) {
	    $away_members = DB::table('users')
                ->select(DB::raw('id, name, nickname, number, users.club_id, away.club_name, NULL as member_id, 0 as competition, NULL as match_position, NULL as member_remarksi, NULL as player_id'))
                //->where('club_id', $away)
                ->leftjoin('clubs as away', 'away.club_id', 'users.club_id')
                ->whereIn('users.club_id', [$away, $away2, $away3, $away4])
                ->where('users.category', 7)
	        ->get();
	        //dd($away_members);
	} elseif (COUNT($members) != 0 AND COUNT($players) == 0) {
            $away_members = DB::table('members')
                ->select(DB::raw('users.id, users.name, users.nickname, users.number, away.club_name, members.member_id, members.competition, NULL as match_position, members.member_remarks, NULL as player_id'))
                ->leftjoin('clubs as away', 'away.club_id', 'members.club_id')
                ->leftJoin('users', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('users.id', '=', 'members.id')
                        ->whereIn('users.club_id', [$away, $away2, $away3, $away4])
                        ->where('users.category', 7);
                })
                ->whereIn('members.club_id', [$away, $away2, $away3, $away4])
                ->where('members.match_id', $match_id)
                //->where('users.club_id', $away)
	        ->get();
	} elseif (COUNT($members) != 0 AND COUNT($players) != 0) {
            $away_members = DB::table('members')
                ->select(DB::raw('users.id, users.name, users.nickname, users.number, away.club_name, members.member_id, members.competition, players.match_position, members.member_remarks, players.player_id'))
                ->leftjoin('clubs as away', 'away.club_id', 'members.club_id')
                ->leftJoin('users', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('users.id', '=', 'members.id')
                        //->where('users.club_id', $away)
                        ->whereIn('users.club_id', [$away, $away2, $away3, $away4])
                        ->where('users.category', 7);
                })
                ->leftJoin('players', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('users.id', '=', 'players.id')
                        ->where('players.match_id', $match_id)
                        //->where('players.club_id', $away);
                        ->whereIn('players.club_id', [$away, $away2, $away3, $away4]);
                })
                ->whereIn('members.club_id', [$away, $away2, $away3, $away4])
                //->where('members.club_id', $away)
                ->where('members.match_id', $match_id)
	        ->get();
	        //dd($away_members);
	}
	
	//試合情報の取得
	$today = date('Y-m-d H:i:s', strtotime(date('Y')."-".date('m')."-".date('d')));
	$pre_matches = DB::table('matches')
            ->select(DB::raw('matches.match_id, matches.match_date, TIME_FORMAT(matches.schedule_start, "%H:%i") AS schedule_start, home.club_name as home, home2.club_name as home2, home3.club_name as home3, home4.club_name as home4, away.club_name as away, away2.club_name as away2, away3.club_name as away3, away4.club_name as away4'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->where('match_date', ">=",  $today)
            ->where('match_id', "!=",  $match_id)
            ->get();
        //dd($pre_match);

        return view('pages.away_members', ['match' => $match, 'away_members' => $away_members, 'pre_matches' => $pre_matches]);
    }

    public function away_members_submit(Request $request){
        //dd($request);
        //match_positionがa_side分入っているか確認する    
        //memberの数がa_sideに足りない時はNULLがないかを確認する
        //またpositionが全て入っているかも確認する
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $login_user = Auth::user();

	if ($request->parti_submit == "メンバーコピー") {
            //dd($request);
            //$pre_match_idが空でなければ、追加する
            $match_id = $request->match_id[0];
	    $pre_match_id = $request->pre_match[0];

            if ($pre_match_id != NULL) {
                //$match_idでのmembersを出力して、空であればmembersに追加する
                $match = DB::table('matches')
                    ->select(DB::raw('away, away_2, away_3, away_4'))
                    ->where('match_id', $match_id)
		    ->first();
		$away = $match->away;
		$away2 = $match->away_2;
		$away3 = $match->away_3;
		$away4 = $match->away_4;

                $members = DB::table('members')
                    ->whereIn('club_id', [$away, $away2, $away3, $away4])
                    ->where('match_id', $match_id)
                    ->get();
                //dd($members);

                if (COUNT($members) == 0) {
                    //現在の試合のawayを取得して、pre_matchのhome、awayと全く同じ方のmemberとplayerをコピーする
                    $pre_match = DB::table('matches')
                        ->select(DB::raw('home, home_2, home_3, home_4, away, away_2, away_3, away_4'))
                        ->where('match_id', $pre_match_id)
                        ->first();
                    //dd($match);

                    if ($match->away == $pre_match->home AND $match->away_2 == $pre_match->home_2 AND $match->away_3 == $pre_match->home_3 AND $match->away_4 == $pre_match->home_4) {
                        //dd("homeと同じ");
                        //dd($pre_match_id);
                        $insert_members = DB::table('members')
                            ->where('match_id', $pre_match_id)
                            ->where(function($query) use($pre_match) {
                                $query->where('club_id', $pre_match->home)
                                    ->orWhere('club_id', $pre_match->home_2)
                                    ->orWhere('club_id', $pre_match->home_3)
                                    ->orWhere('club_id', $pre_match->home_4);
                                })
                            ->get();
                        //dd($insert_members);
                        foreach ($insert_members as $insert_member) {
                            $param = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'competition' => $insert_member->competition,
                                'member_remarks' => $insert_member->member_remarks,
                                'members_created_at' => $now,
                            ];
                            DB::table('members')->insert($param);    
                        }
                    } elseif ($match->away == $pre_match->away AND $match->away_2 == $pre_match->away_2 AND $match->away_3 == $pre_match->away_3 AND $match->away_4 == $pre_match->away_4) {
                        //dd($pre_match_id);
                        $insert_members = DB::table('members')
                            ->where('match_id', $pre_match_id)
                            ->where(function($query) use($pre_match) {
                                $query->where('club_id', $pre_match->away)
                                    ->orWhere('club_id', $pre_match->away_2)
                                    ->orWhere('club_id', $pre_match->away_3)
                                    ->orWhere('club_id', $pre_match->away_4);
                                })
                            ->get();
                        //dd($insert_members);
                        foreach ($insert_members as $insert_member) {
                            $param = [
                                'match_id' => $match_id,
                                'id' => $insert_member->id,
                                'club_id' => $insert_member->club_id,
                                'competition' => $insert_member->competition,
                                'member_remarks' => $insert_member->member_remarks,
                                'members_created_at' => $now,
                            ];
                            DB::table('members')->insert($param);    
                        }
                    }
                    return redirect('/away_members?match_id='.$match_id)->with('flash_message','前の試合の出欠をコピーしました。');
                } else {
                    return redirect('/away_members?match_id='.$match_id)->with('flash_message','すでに出欠の登録がされているので、コピーできません。');
	        }
            } else {
                return redirect('/away_members?match_id='.$match_id)->with('flash_message','コピーする試合を選択してください。');
            }
	} elseif ($request->parti_submit == "一時保存" OR $request->parti_submit == "確定") {
            $checks = [];
            for ($i = 1; $i <= $request->a_side; $i++) {
                array_push($checks, $i);
            }
            $checks_list = $checks;

            //dd(COUNT($checks_list));
            $num = 0;
            $match_positions = $request->match_position;
            //dd($match_positions);
            foreach ($match_positions as $match_position) {
                //dd($match_position);
                if ($match_position != NULL) {
                    for($i = 0; $i < COUNT($checks_list); $i++) {
                    //dd($checks[$i]);
                        if ($match_position == $checks_list[$i]) {
                            unset($checks[$i]);
                            break;
                        }
                    }
                    $num = $num + 1;
                }
	    }
            //dd($checks);
            //dd($request->a_side);
            //memberに登録がなければ、memberに追加する。
            $members = DB::table('members')
                ->select(DB::raw('member_id, match_id, id, club_id'))
                ->where('match_id', $request->match_id[0])
                ->where('club_id', $request->club_id[0])
                ->get();
            //dd($members);

            if (COUNT($members) == 0) {
                for ($i = 0; $i < COUNT($request->id); $i++) {
                    $param = [
                        'match_id' => $request->match_id[$i],
                        'id' => $request->id[$i],
                        'club_id' => $request->club_id[$i],
                        'competition' => $request->competition[$i],
                        'member_remarks' => $request->member_remarks[$i],
                        'members_created_at' => $now,
                    ];
                    DB::table('members')->insert($param);
                }
            } else {
                $updates = [];
                //dd($request);
                for ($i = 0; $i < COUNT($request->id); $i++) {
                    //competitionが変更されていれば、updatesに入れる
                    if ($request->competition[$i] != $request->pre_competition[$i]) {
                        $updates['competition'] = $request->competition[$i];
		    }

                    //member_remarksが変更されていれば、updatesに入れる
                    if ($request->member_remarks[$i] != $request->pre_member_remarks[$i]) {
                        $updates['member_remarks'] = $request->member_remarks[$i];
                    }

                    if (COUNT($updates) != 0) {
                        //dd($request->member_id[$i]);
                        $updates['members_updated_at'] = $now;
                        DB::table('members')
                            ->where('member_id',$request->member_id[$i])
                            ->update($updates); 
                        //break;
                    }
                } 
            }

            if ($num < $request->a_side) {
                return redirect('/away_members?match_id='.$request->match_id[0])->with('flash_message','ポジションは全て入れてください。');
            } elseif ($num > $request->a_side) {
                return redirect('/away_members?match_id='.$request->match_id[0])->with('flash_message','出場者を入れすぎです。');
            } elseif ($num == $request->a_side AND COUNT($checks) > 0) {
                return redirect('/away_members?match_id='.$request->match_id[0])->with('flash_message','ポジションが重複しています。');
            } elseif ($num == $request->a_side AND COUNT($checks) == 0) {
	        //入力に問題がなければ、登録する。
                //playerに登録がなければ、playerに追加する。
                $players = DB::table('players')
                    ->select(DB::raw('player_id, id, match_position'))
                    ->where('match_id', $request->match_id[0])
                    ->where('club_id', $request->club_id[0])
                    ->get();
	        //dd($players);
                $match = DB::table('matches')
                    ->select(DB::raw('period'))
                    ->where('match_id', $request->match_id[0])
		    ->first();

	        if (COUNT($players) == 0) {
                    for ($i = 0; $i < COUNT($request->id); $i++) {
                        if ($request->match_position[$i] != NULL) {
                            $param = [
                                'match_id' => $request->match_id[$i],
                                'id' => $request->id[$i],
                                'club_id' => $request->club_id[$i],
                                'match_position' => $request->match_position[$i],
                                'on_period' => $match->period,
                                'on' => '00:00:00',
                                'off_period' => NULL,
                                'off' => NULL,
                                'player_remarks' => NULL,
                                'players_created_at' => $now,
                            ];
                            DB::table('players')->insert($param);
                        }
                    }
                } else {
                    $updates = [];
                    for ($i = 0; $i < COUNT($request->id); $i++) {
                        //match_positionが変更されていれば、
                        //取得していた$playersのmatch_positionのが同じplayer_idのidを更新する
                        if ($request->match_position[$i] != NULL AND $request->match_position[$i] != $request->pre_match_position[$i]) {
                            foreach ($players as $player) {
                                if ($player->match_position == $request->match_position[$i]) {
                                    $updates['id'] = $request->id[$i];
                                    $updates['players_updated_at'] = $now;
                                    //dd($updates);

                                DB::table('players')
                                    ->where('player_id',$player->player_id)
                                    ->update($updates);
                                break;
                                }
                            }
                        }
                    } 
                }

                //確定ボタンであれば、matchのhome_confirmを確定に更新する。
                if ($request->parti_submit == "確定") {
                    $updates['home_confirm'] = 1;
                    $updates['matches_updated_at'] = $now;
                    //dd($updates);
    
                    DB::table('matches')
                        ->where('match_id',$request->match_id[0])
                        ->update($updates); 
                } 
                return redirect('/index_coach?id='.$login_user->id);
            } else {
                return redirect('/away_members?match_id='.$request->match_id[0])->with('flash_message','予期しないエラーです。管理者に連絡してください。');
            }
        }
    }

    //match_contents
    public function match_contents(Request $request) {
        $match_id =  $request->match_id;

	//試合情報の取得
	$match = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y/%m/%d") AS match_date, match_start, period_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home2_name, home3.club_name as home3_name, home4.club_name as home4_name, away.club_name as away_name, away2.club_name as away2_name, away3.club_name as away3_name, away4.club_name as away4_name, regulation_time, a_side, pitches.pitch_name, period, schedule_start, match_status, overtime, pk, home_easyinput, away_easyinput'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->leftjoin('pitches', 'pitches.pitch_id', 'matches.pitch_id')
            ->where('match_id', $match_id)
	    ->first();
	$home = $match->home;
	$home2 = $match->home_2;
	$home3 = $match->home_3;
	$home4 = $match->home_4;
	$away = $match->away;
	$away2 = $match->away_2;
	$away3 = $match->away_3;
	$away4 = $match->away_4;

	//membersに登録があれば、home_membersを取得
        $home_m = function ($query) use($match_id, $home, $home2, $home3, $home4) {
            $query->from('members')
                ->selectRaw('id, member_id, club_id, match_id')
                ->where('match_id', $match_id)
                ->where('competition', 0)
                ->whereIn('club_id', [$home, $home2, $home3, $home4]);
        };
        $home_sub_members = DB::table($home_m, 'members')
            ->selectRaw('members.id, members.member_id, lpad(members.id, 6, "0") AS id6, members.club_id, members.match_id, users.nickname, users.number')
            ->leftJoin('users', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                $join->on('users.id', 'members.id')
                    ->whereIn('users.club_id', [$home, $home2, $home3, $home4])
                    ->where('users.category', 7);
            })
            ->whereNotExists(function ($query) use($match_id, $home, $home2, $home3, $home4) {
                $query->from('players')
                    ->whereColumn('players.id', 'members.id')
                    ->where('players.match_id', $match_id)
                    ->whereNull('players.off')
                    ->whereIn('players.club_id', [$home, $home2, $home3, $home4]);
            })
            ->get();

	//membersに登録があれば、away_membersを取得
        $away_m = function ($query) use($match_id, $away, $away2, $away3, $away4) {
            $query->from('members')
                ->selectRaw('id, member_id, club_id, match_id')
                ->where('match_id', $match_id)
                ->where('competition', 0)
                ->whereIn('club_id', [$away, $away2, $away3, $away4]);
        };
	$away_sub_members = DB::table($away_m, 'members')
            ->selectRaw('members.id, members.member_id, lpad(members.id, 6, "0") AS id6, members.club_id, members.match_id, users.nickname, users.number')
            ->leftJoin('users', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('users.id', 'members.id')
                        ->whereIn('users.club_id', [$away, $away2, $away3, $away4])
                        ->where('users.category', 7);
                })
            ->whereNotExists(function ($query) use($match_id, $away, $away2, $away3, $away4) {
               $query->from('players')
                     ->whereColumn('players.id', 'members.id')
                     ->where('players.match_id', $match_id)
                     ->whereNull('players.off')
                     ->whereIn('players.club_id', [$away, $away2, $away3, $away4]);
                })
            ->get();

	//playersに登録があれば、home_playersを取得
	//home_easyinputが1の場合には1名のみ。交代も取得しない
	if ($match->home_easyinput == 0) {
            $home_p = function ($query) use($match_id, $home, $home2, $home3, $home4) {
                $query->from('players')
                    ->selectRaw('id, player_id, club_id, match_id, match_position')
                    ->where('match_id', $match_id)
                    ->whereNull('off')
                    ->whereIn('club_id', [$home, $home2, $home3, $home4]);
            };
            $home_players = DB::table($home_p, 'players')
                ->selectRaw('players.id, players.player_id, players.club_id, players.match_id, match_position, users.nickname, users.number')
                ->leftJoin('users', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('users.id', 'players.id')
                        ->whereIn('users.club_id', [$home, $home2, $home3, $home4])
                        ->where('users.category', 7);
                })
                ->leftJoin('members', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('members.id', 'players.id')
                        ->where('members.match_id', $match_id)
                        ->whereIn('members.club_id', [$home, $home2, $home3, $home4]);
                })
                ->orderBy('match_position')
	        ->get();
        } elseif ($match->home_easyinput == 1) {
            $home_p = function ($query) use($match_id, $home, $home2, $home3, $home4) {
                $query->from('players')
                    ->selectRaw('id, player_id, club_id, match_id, match_position')
                    ->where('match_id', $match_id)
                    ->whereNull('off')
                    ->whereIn('club_id', [$home, $home2, $home3, $home4]);
            };
            $home_players = DB::table($home_p, 'players')
                ->selectRaw('players.id, players.player_id, players.club_id, players.match_id, match_position, users.nickname, users.number')
                ->leftJoin('users', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('users.id', 'players.id')
                        ->whereIn('users.club_id', [$home, $home2, $home3, $home4])
                        ->where('users.category', 7);
                })
                ->leftJoin('members', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('members.id', 'players.id')
                        ->where('members.match_id', $match_id)
                        ->whereIn('members.club_id', [$home, $home2, $home3, $home4]);
                })
                ->limit(1)
	        ->get();
        }

	//membersに登録があれば、away_membersを取得
	if ($match->away_easyinput == 0) {
            $away_p = function ($query) use($match_id, $away, $away2, $away3, $away4) {
                $query->from('players')
                    ->selectRaw('id, player_id, club_id, match_id, match_position')
                    ->where('match_id', $match_id)
                    ->whereNull('off')
                    ->whereIn('club_id', [$away, $away2, $away3, $away4]);
            };
            $away_players = DB::table($away_p, 'players')
                ->selectRaw('players.id, players.player_id, players.club_id, players.match_id, match_position, users.nickname, users.number')
                ->leftJoin('users', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('users.id', 'players.id')
                        ->whereIn('users.club_id', [$away, $away2, $away3, $away4])
                        ->where('users.category', 7);
                })
                ->leftJoin('members', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('members.id', 'players.id')
                        ->where('members.match_id', $match_id)
                        ->whereIn('members.club_id', [$away, $away2, $away3, $away4]);
                })
                ->orderBy('match_position')
	        ->get();
	} elseif ($match->away_easyinput == 1) {
            $away_p = function ($query) use($match_id, $away, $away2, $away3, $away4) {
                $query->from('players')
                    ->selectRaw('id, player_id, club_id, match_id, match_position')
                    ->where('match_id', $match_id)
                    ->whereNull('off')
                    ->whereIn('club_id', [$away, $away2, $away3, $away4]);
            };
            $away_players = DB::table($away_p, 'players')
                ->selectRaw('players.id, players.player_id, players.club_id, players.match_id, match_position, users.nickname, users.number')
                ->leftJoin('users', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('users.id', 'players.id')
                        ->whereIn('users.club_id', [$away, $away2, $away3, $away4])
                        ->where('users.category', 7);
                })
                ->leftJoin('members', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('members.id', 'players.id')
                        ->where('members.match_id', $match_id)
                        ->whereIn('members.club_id', [$away, $away2, $away3, $away4]);
                })
                ->limit(1)
	        ->get();
        }
	//dd($home_members);

        //得点を取得
        $scores = DB::table('scores')
            ->select(DB::raw('"score" as type, scores.id, scores.club_id, clubs.club_name, scorers.nickname, scorers.number, scores.score_period as period, scores.score_time AS time_full, CASE WHEN scores.score_time = "00:00:00" THEN "00" ELSE DATE_FORMAT(ADDTIME(scores.score_time, "00:01:00"), "%i") END as time, owngoal AS tmp1'))
            ->leftjoin('clubs', 'clubs.club_id', 'scores.club_id')
            ->leftjoin('users as scorers', 'scores.id', 'scorers.id')
            ->leftjoin('users as assists', 'scores.assist_id', 'assists.id')
            ->where('scores.match_id', $match_id);

        //ファールを取得
        $fouls = DB::table('fouls')
            ->select(DB::raw('"foul" as type, fouls.id, fouls.club_id, clubs.club_name, users.nickname, users.number, fouls.foul_period as period, fouls.foul_time AS time_full, CASE WHEN fouls.foul_time = "00:00:00" THEN "00" ELSE DATE_FORMAT(ADDTIME(fouls.foul_time, "00:01:00"), "%i") END as time, foul_cards AS tmp1'))
            ->leftjoin('clubs', 'clubs.club_id', 'fouls.club_id')
            ->leftjoin('users', 'users.id', 'fouls.id')
            ->where('fouls.match_id', $match_id);

	//交代を取得
	$events = DB::table('players')
            ->select(DB::raw('"change" as type, players.id, players.club_id, clubs.club_name, users.nickname, users.number, players.off_period as period, players.off AS time_full ,CASE WHEN players.off = "00:00:00" THEN "00" ELSE DATE_FORMAT(ADDTIME(players.off, "00:01:00"), "%i") END as time, "" AS tmp1'))
            ->leftjoin('users', 'users.id', 'players.id')
            ->leftjoin('clubs', 'clubs.club_id', 'players.club_id')
            ->where('players.match_id', $match_id)
	    ->whereNotNull('players.off')
            ->union($scores)
            ->union($fouls)
            ->orderBy('period')
            ->orderBy('time')
            ->get();
        //dd($events);

        //homeの得点を取得
        $away_own = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 1)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$away, $away2, $away3, $away4]);
        $home_goal = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 0)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$home, $home2, $home3, $home4])
            ->union($away_own)
            ->get();
        $home_score = COUNT($home_goal);

        //awayの得点を取得
        $home_own = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 1)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$home, $home2, $home3, $home4]);
        $away_goal = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 0)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$away, $away2, $away3, $away4])
            ->union($home_own)
            ->get();
        $away_score = COUNT($away_goal);

	return view('pages.match_contents', ['match' => $match, 'home_sub_members' => $home_sub_members, 'away_sub_members' => $away_sub_members, 'events' => $events, 'home_score' => $home_score, 'away_score' => $away_score, 'home_players' => $home_players, 'away_players' => $away_players]); 
    }

    //match
    public function match(Request $request) {
        $match_id =  $request->match_id;

	//試合情報の取得
	$match = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y/%m/%d") AS match_date, match_start, period_start, home, home_2, home_3, home_4, away, away_2, away_3, away_4, home.club_name as home_name, home2.club_name as home2_name, home3.club_name as home3_name, home4.club_name as home4_name, away.club_name as away_name, away2.club_name as away2_name, away3.club_name as away3_name, away4.club_name as away4_name, regulation_time, a_side, pitches.pitch_name, period, schedule_start, match_status, overtime, pk'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as home2', 'home2.club_id', 'matches.home_2')
            ->leftjoin('clubs as home3', 'home3.club_id', 'matches.home_3')
            ->leftjoin('clubs as home4', 'home4.club_id', 'matches.home_4')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->leftjoin('clubs as away2', 'away2.club_id', 'matches.away_2')
            ->leftjoin('clubs as away3', 'away3.club_id', 'matches.away_3')
            ->leftjoin('clubs as away4', 'away4.club_id', 'matches.away_4')
            ->leftjoin('pitches', 'pitches.pitch_id', 'matches.pitch_id')
            ->where('match_id', $match_id)
	    ->first();
	$home = $match->home;
	$home2 = $match->home_2;
	$home3 = $match->home_3;
	$home4 = $match->home_4;
	$away = $match->away;
	$away2 = $match->away_2;
	$away3 = $match->away_3;
	$away4 = $match->away_4;

	//playersに登録があれば、home_playersを取得
        $home_p = function ($query) use($match_id, $home, $home2, $home3, $home4) {
            $query->from('players')
                ->selectRaw('id, player_id, club_id, match_id, match_position')
                ->where('match_id', $match_id)
                ->whereNull('off')
                ->whereIn('club_id', [$home, $home2, $home3, $home4]);
        };
        $home_players = DB::table($home_p, 'players')
            ->selectRaw('players.id, players.player_id, players.club_id, players.match_id, match_position, users.nickname, users.number')
            ->leftJoin('users', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('users.id', 'players.id')
                        ->whereIn('users.club_id', [$home, $home2, $home3, $home4])
                        ->where('users.category', 7);
                })
            ->leftJoin('members', function ($join) use($match_id, $home, $home2, $home3, $home4) {
                    $join->on('members.id', 'players.id')
                        ->where('members.match_id', $match_id)
                        ->whereIn('members.club_id', [$home, $home2, $home3, $home4]);
                })
            ->orderBy('match_position')
	    ->get();

	//membersに登録があれば、away_membersを取得
        $away_p = function ($query) use($match_id, $away, $away2, $away3, $away4) {
            $query->from('players')
                ->selectRaw('id, player_id, club_id, match_id, match_position')
                ->where('match_id', $match_id)
                ->whereNull('off')
                ->whereIn('club_id', [$away, $away2, $away3, $away4]);
        };
        $away_players = DB::table($away_p, 'players')
            ->selectRaw('players.id, players.player_id, players.club_id, players.match_id, match_position, users.nickname, users.number')
            ->leftJoin('users', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('users.id', 'players.id')
                        ->whereIn('users.club_id', [$away, $away2, $away3, $away4])
                        ->where('users.category', 7);
                })
            ->leftJoin('members', function ($join) use($match_id, $away, $away2, $away3, $away4) {
                    $join->on('members.id', 'players.id')
                        ->where('members.match_id', $match_id)
                        ->whereIn('members.club_id', [$away, $away2, $away3, $away4]);
                })
            ->orderBy('match_position')
	    ->get();
	//dd($home_members);

        //得点を取得
        $scores = DB::table('scores')
            ->select(DB::raw('"score" as type, scores.id, scores.club_id, clubs.club_name, scorers.nickname, scorers.number, scores.score_period as period, scores.score_time AS time_full, CASE WHEN scores.score_time = "00:00:00" THEN "00" ELSE DATE_FORMAT(ADDTIME(scores.score_time, "00:01:00"), "%i") END as time, owngoal AS tmp1'))
            ->leftjoin('clubs', 'clubs.club_id', 'scores.club_id')
            ->leftjoin('users as scorers', 'scores.id', 'scorers.id')
            ->leftjoin('users as assists', 'scores.assist_id', 'assists.id')
            ->where('scores.match_id', $match_id);

        //ファールを取得
        $fouls = DB::table('fouls')
            ->select(DB::raw('"foul" as type, fouls.id, fouls.club_id, clubs.club_name, users.nickname, users.number, fouls.foul_period as period, fouls.foul_time AS time_full, CASE WHEN fouls.foul_time = "00:00:00" THEN "00" ELSE DATE_FORMAT(ADDTIME(fouls.foul_time, "00:01:00"), "%i") END as time, foul_cards AS tmp1'))
            ->leftjoin('clubs', 'clubs.club_id', 'fouls.club_id')
            ->leftjoin('users', 'users.id', 'fouls.id')
            ->where('fouls.match_id', $match_id);

	//交代を取得
	$events = DB::table('players')
            ->select(DB::raw('"change" as type, players.id, players.club_id, clubs.club_name, users.nickname, users.number, players.off_period as period, players.off AS time_full, CASE WHEN players.off = "00:00:00" THEN "00" ELSE DATE_FORMAT(ADDTIME(players.off, "00:01:00"), "%i") END as time, "" AS tmp1'))
            ->leftjoin('users', 'users.id', 'players.id')
            ->leftjoin('clubs', 'clubs.club_id', 'players.club_id')
            ->where('players.match_id', $match_id)
	    ->whereNotNull('players.off')
            ->union($scores)
            ->union($fouls)
            ->orderBy('period')
            ->orderBy('time_full')
            ->get();
        //dd($events);

        //homeの得点を取得
        $away_own = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 1)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$away, $away2, $away3, $away4]);
        $home_goal = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 0)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$home, $home2, $home3, $home4])
            ->union($away_own)
            ->get();
        $home_score = COUNT($home_goal);

        //awayの得点を取得
        $home_own = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 1)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$home, $home2, $home3, $home4]);
        $away_goal = DB::table('scores')
            ->select(DB::raw('score_id'))
            ->where('owngoal', 0)
            ->where('match_id', $match_id)
            ->whereIn('club_id', [$away, $away2, $away3, $away4])
            ->union($home_own)
            ->get();
        $away_score = COUNT($away_goal);

	return view('pages.match', ['match' => $match, 'events' => $events, 'home_score' => $home_score, 'away_score' => $away_score, 'home_players' => $home_players, 'away_players' => $away_players]); 
    }

    public function match_contents_submit(Request $request){
        $submit = mb_substr($request->players_submit[0], 0, 2);
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $match = DB::table('matches')
            ->select(DB::raw('match_start, regulation_time, period'))
            ->where('match_id', $request->match_id[0])
            ->first();
        //dd($match);
        //dd(date('H:i:s', strtotime($now) - strtotime($match->match_start) + strtotime('00:'.strval($match->regulation_time/2).':00')));
	if ($match->period == 1) {
            $elapsed_time = date('H:i:s', strtotime($now) - strtotime($match->match_start));
	} elseif ($match->period == 2) {
            $elapsed_time = date('H:i:s', strtotime($now) - strtotime($match->match_start));
	} elseif ($match->period == 3) {
            $elapsed_time = date('H:i:s', strtotime($now) - strtotime($match->match_start) + strtotime('00:'.strval($match->regulation_time/2).':00'));
        }
        //dd($request);

        If ($submit == '交代'){
	//substituteを順に見て、NULLでないところのplayer_idのoffに現在時刻を入れる
	//また、substituteのuser_idをplayersにinsertする
	    for ($i = 0; $i < COUNT($request->substitute); $i++) {
                if ($request->substitute[$i] != NULL) {
                    $id = $request->substitute[$i];
                    //dd($id);
		    //交代するplayerにoffの時間を入れる
                    $updates['off'] = $elapsed_time;
                    $updates['players_updated_at'] = $now;
	            //dd($updates);
	    
                    DB::table('players')
                        ->where('id',$request->id[$i])
		        ->update($updates);

		    //新しく入るplayerを追加する
                    $param = [
                        'match_id' => $request->match_id[0],
                        'id' => $id,
                        'club_id' => $request->club_id[$i],
                        'match_position' => $request->match_position[$i],
                        'on' => $elapsed_time,
                        'off' => NULL,
                        'player_remarks' => NULL,
                        'players_created_at' => $now,
                    ];
                    DB::table('players')->insert($param);
	        }
            }
	} elseif ($submit == '得点') {
            //dd($request);
            //得点をクリックすると、scoresにレコードを挿入する
            $num = mb_substr($request->players_submit[0], 2, NULL);
            $id = $request->id[$num];

            //DBに登録
            $param = [
                'match_id' => $request->match_id[0],
                'id' => $id,
                'assist_id' => NULL,
                'club_id' => $request->club_id[$num],
                'score_time' => $elapsed_time,
                'owngoal' => 0,
                'scores_created_at' => $now,
            ];
            DB::table('scores')->insert($param);
        } elseif ($submit == '警告') {
	    //警告をクリックすると、foulsにレコードを挿入する
            $num = mb_substr($request->players_submit[0], 2, NULL);
	    $id = $request->id[$num];

            //DBに登録
            $param = [
                'match_id' => $request->match_id[0],
                'id' => $id,
                'club_id' => $request->club_id[$num],
                'foul_cards' => 0,
                'foul_time' => $elapsed_time,
                'fouls_created_at' => $now,
            ];
            DB::table('fouls')->insert($param);
	} elseif ($submit == '開始') {
	    //開始をクリックすると、クリックした時間のtimestampがmatchesのmatch_startに入る。
            $updates['match_start'] = $now;
            $updates['matches_updated_at'] = $now;
	    //dd($updates);
	    
            DB::table('matches')
                ->where('match_id',$request->match_id[0])
                ->update($updates); 
	} elseif ($submit == '終了') {
            //終了をクリックすると、クリックした時間のtimestampがmatchesのmatch_startに入る。
	    //periodが前半の場合には後半に変更する。
            $updates['match_start'] = NULL;
	    if ($request->period[0] == 2) {
                $updates['period'] = 3;
            } elseif ($request->period[0] == 3) {
                $updates['period'] = 2;
            }
	    
            DB::table('matches')
                ->where('match_id',$request->match_id[0])
                ->update($updates); 
	}
	
	return redirect('/match_contents?match_id='.$request->match_id[0]);
    }
}
