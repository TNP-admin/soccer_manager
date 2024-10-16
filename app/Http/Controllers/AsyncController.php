<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Lib\createPlayingTimeClass;

class AsyncController extends Controller
{
    //
    public function match_start(Request $request){
        //dd($request);
	//開始をクリックすると、クリックした時間のtimestampがmatchesのmatch_startに入る。
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        if ($request->period == 1 OR $request->period == 2 OR $request->period == 11) {
            $updates['match_start'] = $now;
            $updates['period_start'] = $now;
        } elseif ($request->period >= 3 AND $request->period <= 5) {
            $updates['period_start'] = $now;
        } elseif ($request->period >= 12 AND $request->period <= 13) {
            $updates['period_start'] = $now;
        } elseif ($request->period == 6) {
            //PK画面を開く
        }
        $updates['matches_updated_at'] = $now;
	//dd($updates);
	    
        DB::table('matches')
            ->where('match_id',$request->match_id)
            ->update($updates); 
	
	$list = array(
            'status' => 'period_start success!',
            'period_start' => $now
	);
	echo json_encode($list);
    }

    public function match_end(Request $request){
        //dd('async!');
        //終了をクリックすると、クリックした時間のtimestampがmatchesのmatch_startに入る。
        //periodが前半の場合には後半に変更する。
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $updates['period_start'] = NULL;
	$list = array(
            'status' => 'period_end success!'
	);
        if ($request->period == 1) {
            $updates['period'] = 7;
            $list['period'] = 7;
	} elseif ($request->period == 2) {
            $updates['period'] = 3;
            $list['period'] = 3;
        } elseif ($request->period == 3 AND $request->overtime == 0 AND $request->pk == 0) {
            $updates['period'] = 7;
	    $list['period'] = 7;
        //延長がなくPKがある場合には終了後PKに入るか判定する
        } elseif ($request->period == 3 AND $request->overtime == 0 AND $request->pk == 1) {
            //scoreが違えば終了。同じであれば、PK。
            if ($home_scores != $away_score) {
                $updates['period'] = 7;
	        $list['period'] = 7;
            } else {
                $updates['period'] = 6;
                $list['period'] = 6;
            }
        //延長がある場合には前後半終了後延長に入るか判定する
        } elseif ($request->period == 3 AND $request->overtime == 1) {
            //scoreが違えば終了。同じであれば、延長。
            if ($home_scores != $away_score) {
                $updates['period'] = 7;
	        $list['period'] = 7;
            } else {
                $updates['period'] = 4;
                $list['period'] = 4;
            }
	} elseif ($request->period == 4) {
            $updates['period'] = 5;
            $list['period'] = 5;
	} elseif ($request->period == 5 AND $request->pk == 0) {
            $updates['period'] = 7;
            $list['period'] = 7;
        //PKの設定がされている場合延長終了後PKに入るか判定する
	} elseif ($request->period == 5 AND $request->pk == 1) {
            //scoreが違えば終了。同じであれば、PK。
            if ($home_scores != $away_score) {
                $updates['period'] = 7;
	        $list['period'] = 7;
            } else {
                $updates['period'] = 6;
                $list['period'] = 6;
            }
        }
        $updates['matches_updated_at'] = $now;
	    
        DB::table('matches')
            ->where('match_id',$request->match_id)
            ->update($updates); 

	echo json_encode($list);
    }

    public function match_pause(Request $request){
        //dd($request->pause_time);
	//再開をクリックすると、matchesのperiod_startにpause_timeを足してupdate。
        $match = DB::table('matches')
            ->select(DB::raw('period_start'))
            ->where('match_id',$request->match_id)
            ->first(); 
	
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $new_period_start = date('Y-m-d H:i:s', strtotime($match->period_start) + intval($request->pause_time)/1000);
        $updates['period_start'] = $new_period_start;
        $updates['matches_updated_at'] = $now;
	    
        DB::table('matches')
            ->where('match_id',$request->match_id)
            ->update($updates); 

	$list = array(
            'status' => 'match_pause success!',
            'period_start' => $new_period_start,
            'pre_period_start' => $match->period_start
	);
	echo json_encode($list);
    }

    public function score_display(Request $request){
	//得点をクリックすると、playersから該当するmatch_id・club_idでoffがNULLのものを抜き出す。
        $players = DB::table('players')
            ->select(DB::raw('players.id, users.nickname, users.number'))
            ->leftjoin('users', 'users.id', 'players.id')
            ->where('players.match_id',$request->match_id)
            ->whereIn('players.club_id',[$request->club_id, $request->club2_id, $request->club3_id, $request->club4_id])
            ->where('players.off', NULL)
            ->orderBy('players.club_id')
            ->orderBy('users.number')
            ->get(); 
	
	$list = array(
            'status' => 'score_display success!',
            'players' => $players
	);
	echo json_encode($list);
    }

    public function score_submit(Request $request){
	//dd($request);
        //得点をクリックすると、scoresにレコードを挿入する
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $match_id = $request->match_id;
        $match = DB::table('matches')
            ->select(DB::raw('period, regulation_time, home, home_2, home_3, home_4, away, away_2, away_3, away_4'))
            ->where('match_id',$match_id)
	    ->first(); 
        $score_time = "00:".strval($request->score_time);

        //DBに登録
        $param = [
            'match_id' => $request->match_id,
            'id' => $request->scorer,
            'assist_id' => $request->assist,
            'club_id' => $request->club_id,
            'score_time' => $score_time,
            'score_period' => $request->score_period,
            'owngoal' => $request->owngoal,
            'scores_created_at' => $now,
        ];
        DB::table('scores')->insert($param);

        $home = $match->home;
        $home2 = $match->home_2;
        $home3 = $match->home_3;
        $home4 = $match->home_4;
        $away = $match->away;
        $away2 = $match->away_2;
        $away3 = $match->away_3;
        $away4 = $match->away_4;

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

	$list = array(
            'status' => 'score_submit success!',
            'home_score' => $home_score,
            'away_score' => $away_score
	);
	echo json_encode($list);
    }

    public function foul_display(Request $request){
	//得点をクリックすると、playersから該当するmatch_id・club_idでoffがNULLのものを抜き出す。
        $players = DB::table('players')
            ->select(DB::raw('players.id, users.nickname, users.number'))
            ->leftjoin('users', 'users.id', 'players.id')
            ->where('players.match_id',$request->match_id)
            ->whereIn('players.club_id',[$request->club_id, $request->club2_id, $request->club3_id, $request->club4_id])
            ->where('players.off', NULL)
            ->get(); 
	
	$list = array(
            'status' => 'foul_display success!',
            'players' => $players
	);
	echo json_encode($list);
    }

    public function foul_submit(Request $request){
	//dd($request);
        //得点をクリックすると、foulsにレコードを挿入する
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $match_id = $request->match_id;
        $match = DB::table('matches')
            ->select(DB::raw('period, regulation_time, home, home_2, home_3, home_4, away, away_2, away_3, away_4'))
            ->where('match_id',$match_id)
	    ->first(); 
        $foul_time = "00:".strval($request->foul_time);

        //DBに登録
        $param = [
            'match_id' => $request->match_id,
            'id' => $request->violator,
            'club_id' => $request->club_id,
            'foul_time' => $foul_time,
            'foul_period' => $request->foul_period,
            'foul_cards' => $request->foul_cards,
            'fouls_created_at' => $now,
        ];
        DB::table('fouls')->insert($param);

	$list = array(
            'status' => 'foul_submit success!'
	);
	echo json_encode($list);
    }

    public function change_submit(Request $request){
	//dd($request);
        //確定をクリックすると、playersにレコードを挿入する
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $change_time = "00:".strval($request->change_time);
        $match_id = $request->match_id;
        $change_period = $request->change_period;
//        $player_id = $request->player_id[0];

	$list = [];

	for ($i = 0; $i < COUNT($request->substitute); $i++) {
            if ($request->substitute[$i] != NULL) {
		//交代するplayerにoffの時間を入れる
                $updates['off'] = $change_time;
                $updates['off_period'] = $change_period;
                $updates['players_updated_at'] = $now;
                //dd($updates);

                DB::table('players')
                    ->where('player_id',$request->player_id[$i])
                    ->update($updates);

                $id = $request->substitute[$i];
                $user = DB::table('users')
                    ->select(DB::raw('club_id, number, nickname'))
                    ->where('id',$id)
                    ->first(); 

                //新しく入るplayerを追加する
                $param = [
                    'match_id' => $match_id,
                    'id' => $id,
                    'club_id' => $user->club_id,
                    'match_position' => $request->match_position[$i],
                    'on_period' => $change_period,
                    'on' => $change_time,
                    'off_period' => NULL,
                    'off' => NULL,
                    'player_remarks' => NULL,
                    'players_created_at' => $now,
                ];
                DB::table('players')->insert($param);
                $player_id = DB::getPdo()->lastInsertId();
                $add = [
                    'pre_player_id' => $request->player_id[$i],
                    'match_position' => $request->match_position[$i],
                    'id' => $id,
                    'match_id' => $match_id,
                    'player_id' => $player_id,
                    'club_id' => $user->club_id,
                    'number' => $user->number,
                    'nickname' => $user->nickname,
                    'on_period' => $change_period,
                    'on_time' => $change_time,
		];
                array_push($list, $add);
	    }
        }

        $match = DB::table('matches')
            ->select(DB::raw('period, regulation_time, home, home_2, home_3, home_4, away, away_2, away_3, away_4'))
            ->where('match_id',$match_id)
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
                        ->where('users.category', 3);
                })
            ->whereNotExists(function ($query) use($match_id, $home, $home2, $home3, $home4) {
               $query->from('players')
                     ->whereColumn('players.id', 'members.id')
                     ->where('players.match_id', $match_id)
                     ->whereNull('players.off')
                     ->whereIn('players.club_id', [$home, $home2, $home3, $home4]);
                })
            ->get();
        array_push($list, $home_sub_members);

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
                        ->where('users.category', 3);
                })
            ->whereNotExists(function ($query) use($match_id, $away, $away2, $away3, $away4) {
               $query->from('players')
                     ->whereColumn('players.id', 'members.id')
                     ->where('players.match_id', $match_id)
                     ->whereNull('players.off')
                     ->whereIn('players.club_id', [$away, $away2, $away3, $away4]);
                })
            ->get();
        array_push($list, $away_sub_members);

	echo json_encode($list);
    }

    public function playingtime_insert(Request $request){
        $match_id = $request->match_id;
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        
        $match = DB::table('matches')
            ->select(DB::raw('period, regulation_time, extra_time'))
            ->where('match_id',$match_id)
            ->first(); 

        $players = DB::table('players')
            ->select(DB::raw('player_id, `on`, on_period, off, off_period'))
            ->where('match_id', $match_id)
            ->get(); 
        //dd($players);

        for ($i = 0; $i < COUNT($players); $i++) {
            //DBに登録
            $updates = [
                'playing_time' => createPlayingTimeClass::createPlayingTime($players[$i]->on, $players[$i]->on_period, $players[$i]->off, $players[$i]->off_period, $match->regulation_time, $match->extra_time, $match->period),
                'players_updated_at' => $now,
            ];
            dd($updates);
            DB::table('players')
                ->where('player_id',$players[$i]->player_id)
                ->update($updates); 
            
        }
    }
}
