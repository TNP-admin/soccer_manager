<?php

namespace app\Lib;

use Illuminate\Support\Facades\Log;

class createPlayingTimeClass
{
    public static function createPlayingTime($on, $on_period, $off, $off_period, $regulation_time, $extra_time, $period)
    {
        //入る時間出る時間をphpで計算できるよう、今日の日付を付ける。
        //引き算になる場合には日付をつけて、offそのままの場合には日付はつけない
        $Date = date("Y-m-d");
	$on_time = strtotime($Date." ".$on);
	$off_time = strtotime($Date." ".$off);
        $regulation = strtotime("1970/1/1 00:".$regulation_time.":00");
        $extra = strtotime("1970/1/1 00:".$extra_time.":00");

        //出場時間の計算
        if ($on_period == 1 AND $off_period == 1) {
            $playing_time = $off_time - $on_time;
        } elseif ($on_period != NULL AND $off_period != NULL AND $on_period == $off_period) {
            $playing_time = $off_time - $on_time;
	} elseif ($on_period == NULL AND $off_period == 2) {
            $playing_time = $off_time;
	} elseif ($on_period == NULL AND $off_period == 3) {
            $playing_time = $off_time + $regulation/2;
	} elseif ($on_period == NULL AND $off_period == 4) {
            $playing_time = $off_time + $regulation;
	} elseif ($on_period == NULL AND $off_period == 5) {
            $playing_time = $off_time + $regulation + $extra/2;
	} elseif ($on_period == 2 AND $off_period == 3) {
            $playing_time = $off_time + $regulation/2 - $on_time;
	} elseif ($on_period == 2 AND $off_period == 4) {
            $playing_time = $off_time + $regulation - $on_time;
	} elseif ($on_period == 2 AND $off_period == 5) {
            $playing_time = $off_time + $regulation + $extra/2 - $on_time;
	} elseif ($on_period == 3 AND $off_period == 4) {
            $playing_time = $off_time + $regulation/2 - $on_time;
	} elseif ($on_period == 3 AND $off_period == 5) {
            $playing_time = $off_time + $extra/2 + $regulation/2 - $on;
	} elseif ($on_period == 4 AND $off_period == 5) {
            $playing_time = $off_time + $extra/2 - $on;
	} elseif ($on_period == NULL AND $off_period == NULL) {
            //periodが7:終了であれば$regulation_timeを、8:延長終了であれば$extra_timeも
            if ($period == 7) {
                $playing_time = $regulation;
	    } elseif ($period == 8) {
                $playing_time = $regulation + $extra;
            }
	} elseif ($on_period == 2 AND $off_period == NULL) {
            //periodが7:終了であれば$regulation_timeを、8:延長終了であれば$extra_timeも
            if ($period == 7) {
                $playing_time = $regulation - $on_time;
	    } elseif ($period == 8) {
                $playing_time = $regulation + $extra - $on_time;
            }
	} elseif ($on_period == 3 AND $off_period == NULL) {
            //periodが7:終了であれば$regulation_timeを、8:延長終了であれば$extra_timeも
            if ($period == 7) {
                $playing_time = $regulation/2 - $on_time;
	    } elseif ($period == 8) {
                $playing_time = $regulation/2 + $extra - $on_time;
            }
	} elseif ($on_period == 4 AND $off_period == NULL) {
            $playing_time = $extra - $on_time;
	} elseif ($on_period == 5 AND $off_period == NULL) {
            $playing_time = $extra/2 - $on_time;
        }

        return date("H:i:s", $playing_time);
    }
}
