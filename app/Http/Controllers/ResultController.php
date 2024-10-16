<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ResultController extends Controller
{
    //match_results
    public function match_results() {
        $today = today();
	$login_user = Auth::user();
        //dd($login_user);

        //昨日までの試合を日付・開始時間順に全件取得
        $results = DB::table('matches')
            ->select(DB::raw('match_id, DATE_FORMAT(match_date, "%Y年%m月%d日") AS match_date, TIME_FORMAT(schedule_start, "%H:%i") AS schedule_start, home, away, home.club_name as home_name, away.club_name as away_name, match_status, movie_url'))
            ->leftjoin('clubs as home', 'home.club_id', 'matches.home')
            ->leftjoin('clubs as away', 'away.club_id', 'matches.away')
            ->where('match_date', "<", $today)
            ->orderBy('match_date', 'desc')
            ->orderBy('match_start', 'asc')
            ->get();

        return view('pages.match_results', ['results' => $results, 'login_user' => $login_user]);
    }

    //individual_results
    public function individual_results() {
        $today = today();
        $login_user = Auth::user();
        $club_id = $login_user->club_id;
        //dd($login_user);

	//選手の一覧情報を取得
	//得点を取得
        $scores = DB::table('scores')
            ->select(DB::raw('id, COUNT(id) AS scores'))
            ->where('club_id', $club_id)
            ->groupBy('id');

	//ファールを取得
        $fouls = DB::table('fouls')
            ->select(DB::raw('id, COUNT(id) AS fouls'))
            ->where('club_id', $club_id)
            ->groupBy('id');

        //出場時間を取得
        $times = DB::table('players')
            ->select(DB::raw('id, sec_to_time(SUM(time_to_sec(playing_time))) AS times'))
            ->where('club_id', $club_id)
            ->groupBy('id');
        

        $users = DB::table('users')
            ->select(DB::raw('users.id, users.name, users.nickname, users.number, scores.scores, fouls.fouls, players.times'))
            ->leftJoinSub($scores, 'scores', function ($join) {
                $join->on('users.id', '=', 'scores.id');
                })
            ->leftJoinSub($fouls, 'fouls', function ($join) {
                $join->on('users.id', '=', 'fouls.id');
                })
            ->leftJoinSub($times, 'players', function ($join) {
                $join->on('users.id', '=', 'players.id');
                })
            ->where('users.club_id', $club_id)
            ->where('users.user_status', 0)
            ->where('users.user_auth', 9)
            ->orderBy('users.number', 'asc')
            ->get();
         //dd($users);

        return view('pages.individual_results', ['users' => $users, 'login_user' => $login_user]);
    }

    //期間・試合の種類で検索する
    public function individual_results_submit(Request $request){
        //dd($request);
        $now = date('Y-m-d H:i:s', strtotime('+9 hour'));
        $start = $request->start_date;
	$end = $request->end_date;
        $match_status = $request->match_status;

	//選手の一覧情報を取得
	//得点を取得
        $scores = DB::table('scores')
            ->select(DB::raw('id, COUNT(id) AS scores'))
            ->where('club_id', $club_id)
            ->groupBy('id');

	//ファールを取得
        $fouls = DB::table('fouls')
            ->select(DB::raw('id, COUNT(id) AS fouls'))
            ->where('club_id', $club_id)
            ->groupBy('id');

        //出場時間を取得
        $times = DB::table('players')
            ->select(DB::raw('id, sec_to_time(SUM(time_to_sec(playing_time))) AS times'))
            ->where('club_id', $club_id)
            ->groupBy('id');
        

        $users = DB::table('users')
            ->select(DB::raw('users.id, users.name, users.nickname, users.number, scores.scores, fouls.fouls, players.times'))
            ->leftJoinSub($scores, 'scores', function ($join) {
                $join->on('users.id', '=', 'scores.id');
                })
            ->leftJoinSub($fouls, 'fouls', function ($join) {
                $join->on('users.id', '=', 'fouls.id');
                })
            ->leftJoinSub($times, 'players', function ($join) {
                $join->on('users.id', '=', 'players.id');
                })
            ->where('users.club_id', $club_id)
            ->where('users.user_status', 0)
            ->where('users.user_auth', 9)
            ->orderBy('users.number', 'asc')
            ->get();
         //dd($users);

        return view('pages.individual_results', ['users' => $users]);
    }
}
