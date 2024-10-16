let IntervalId;

//スタートボタンクリックで処理を行う
startBtn.addEventListener("click", () => {
    const startBtn = document.getElementById("startBtn");
    const tmpBtn = document.getElementById("tmpBtn");
    const period = document.getElementById("period");
    const match_id = document.getElementById("match_id").value;
    const regulation_time = document.getElementById("regulation_time").value;
    const a_side = document.getElementById("a_side").value;
    const overtime = document.getElementById("overtime").value;
    const pk = document.getElementById("pk").value;
    const elasped_time = document.getElementById("elapsed_time");
    let home_tbl = document.getElementById("home_tbl");
    let home_rows = home_tbl.rows;
    let away_tbl = document.getElementById("away_tbl");
    let away_rows = away_tbl.rows;

    if (startBtn.value == "開始") {
        console.log("開始だよ");
        fetch('/match_start?match_id='+match_id+'&period='+period.value)
            .then((response) => response.json())
            .then((res) => {
                console.log('レスポンス成功!');
                //console.log(res.period_start);
                const period_start = new Date(res.period_start);

                IntervalId = setInterval(() => {
                    let now = new Date();
                    let elapsed = now-period_start;
                    let minute_num = ('00'+Math.trunc(elapsed/1000/60)).slice(-2);
                    let second_num = ('00'+Math.trunc((elapsed-minute_num*60*1000)/1000)).slice(-2);
                    let elapsed_text = minute_num.concat(':', second_num);
                    elapsed_time.value = elapsed_text;
                    }, 1000);

		//開始ボタンを終了に変更して、一時停止ボタンを有効にする。
                startBtn.value = "終了";
                startBtn.classList.toggle('btn-primary');
                startBtn.classList.toggle('btn-danger');
                tmpBtn.disabled = false;
                //得点ボタンと警告ボタンを有効にする。
                const a_num = home_rows.length + away_rows.length;
                console.log(a_num);
                for (let i = 0; i < a_num; i++) {
                    document.getElementById("score_submit"+("00"+i).slice(-2)).disabled = false;
                }
                for (let i = 0; i < a_num; i++) {
                    document.getElementById("foul_submit"+("00"+i).slice(-2)).disabled = false;
                }
            }) 
            .catch(error => {
                alert("実行失敗");　
                alert(error);
            })
    } else if (startBtn.value == "終了") {
        //console.log("終了だわ");
        fetch('/match_end?match_id='+match_id+"&period="+period.value+"&overtime="+overtime)
            .then((response) => response.json())
            .then((res) => {
                //console.log('レスポンス成功!');
                //console.log(res);

                clearInterval(IntervalId);
                IntervalId = null;
                let elapsed_text = '00:00';
                elapsed_time.value = elapsed_text;

                //終了ボタンを開始に変更して、一時停止ボタンを無効にする。
                startBtn.value = "開始";
                startBtn.classList.toggle('btn-danger');
                startBtn.classList.add('btn-primary');
                tmpBtn.disabled = true;
                //update後のperiodが帰ってくるので、2であれば前半に、3であれば後半に、9であれば終了に変更する
		if (res.period == 2) {
                    document.getElementById("period_text").textContent = "前半";
                    period.value = 2;
                } else if (res.period == 3) {
                    document.getElementById("period_text").textContent = "後半";
                    period.value = 3;
                } else if (res.period == 4) {
                    document.getElementById("period_text").textContent = "延長前半";
                    period.value = 4;
                } else if (res.period == 5) {
                    document.getElementById("period_text").textContent = "延長後半";
                    period.value = 5;
                } else if (res.period == 6) {
                    document.getElementById("period_text").textContent = "PK";
                    period.value = 6;
		} else if (res.period == 7) {
                    document.getElementById("period_text").textContent = "終了";
                    period.value = 7;
                    startBtn.disabled = true;
                    fetch('/playingtime_insert?match_id='+match_id)
                } else if (res.period == 8) {
                    document.getElementById("period_text").textContent = "延長終了";
                    period.value = 8;
                    startBtn.disabled = true;
                    fetch('/playingtime_insert?match_id='+match_id)
                } else if (res.period == 9) {
                    document.getElementById("period_text").textContent = "PK終了";
                    period.value = 9;
                    startBtn.disabled = true;
                    fetch('/playingtime_insert?match_id='+match_id)
                }
                //得点ボタンと警告ボタンを無効にする。
                //const a_num = parseInt(a_side)*2;
                const a_num = home_rows.length + away_rows.length;
                for (let i = 0; i < a_num; i++) {
                    document.getElementById("score_submit"+("00"+i).slice(-2)).disabled = true;
                    document.getElementById("foul_submit"+("00"+i).slice(-2)).disabled = true;
                }
                }) 
            .catch(error => {
                alert("実行失敗");　
                alert(error);
        })
    }
});

let pause_start;

//一時停止ボタンクリックで処理を行う
tmpBtn.addEventListener("click", () => {
    const startBtn = document.getElementById("startBtn");
    const tmpBtn = document.getElementById("tmpBtn");
    const match_id = document.getElementById("match_id").value;

    if (tmpBtn.value == "停止") {
        clearInterval(IntervalId);
        startBtn.disabled = true;
        tmpBtn.value = "再開";
        pause_start = new Date();
        console.log(new Date());
    } else if (tmpBtn.value == "再開") {
        const pause_end = new Date();
        const pause_time = pause_end - pause_start;
        fetch('/match_pause?match_id='+match_id+'&pause_time='+pause_time)
            .then((response) => response.json())
            .then((res) => {
                //console.log('レスポンス成功!');
                console.log(res.pre_period_start);
                console.log(res.period_start);
                const period_start = new Date(res.period_start);

                IntervalId = setInterval(() => {
                    let now = new Date();
                    let elapsed = now - period_start;
                    let minute_num = ('00'+Math.trunc(elapsed/1000/60)).slice(-2);
                    let second_num = ('00'+Math.trunc((elapsed - minute_num*60*1000)/1000)).slice(-2);
                    let elapsed_text = minute_num.concat(':', second_num);
                    elapsed_time.value = elapsed_text;
                    }, 1000);
                startBtn.disabled = false;
                tmpBtn.value = "停止";
                }) 
            .catch(error => {
                alert("実行失敗");　
                alert(error);
        })
        //console.log(new Date());
    }
});

//得点モーダルを開く際にid、club_id、match_idを引数とする
$('#scoreModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let clubusermatch = String(button.data('clubusermatch'));
    let modal = $(this);
    let num = parseInt(clubusermatch.substring(0, 2));
    let club = parseInt(clubusermatch.substring(2, 5));
    let user = parseInt(clubusermatch.substring(5, 9));
    let match = parseInt(clubusermatch.substring(9));
    let queSlct = "select#scorer option[value=\""+user+"\"]";
    let a_side = parseInt(document.getElementById("a_side").value);
    let elapsed_time = document.getElementById("elapsed_time").value;
    let period = document.getElementById("period").value;
    //console.log(a_side);

    let home = document.getElementById("home");
    let home_2 = document.getElementById("home_2");
    let home_3 = document.getElementById("home_3");
    let home_4 = document.getElementById("home_4");
    let away = document.getElementById("away");
    let away_2 = document.getElementById("away_2");
    let away_3 = document.getElementById("away_3");
    let away_4 = document.getElementById("away_4");
    //console.log(!(!away.value));
    //console.log(!(!away_2.value));
    //console.log(!(!away_3.value));
    //console.log(!(!away_4.value));
    //console.log(match);
    //ここで非同期でモーダル内のselectionのoptionを取得して、反映する。
    var fetch_url = "/score_display?match_id="+match;
    if (num < a_side) {
        var fetch_url = fetch_url+"&club_id="+home.value;
        if (!(!home_2.value)) {
            var fetch_url = fetch_url+"&club2_id="+home_2.value;
        }
        if (!(!home_3.value)) {
            var fetch_url = fetch_url+"&club3_id="+home_3.value;
        }
        if (!(!home_4.value)) {
            var fetch_url = fetch_url+"&club4_id="+home_4.value;
        }
    } else if (num >= a_side) {
        var fetch_url = fetch_url+"&club_id="+away.value;
        if (!(!away_2.value)) {
            var fetch_url = fetch_url+"&club2_id="+away_2.value;
        }
        if (!(!away_3.value)) {
            var fetch_url = fetch_url+"&club3_id="+away_3.value;
        }
        if (!(!away_4.value)) {
            var fetch_url = fetch_url+"&club4_id="+away_4.value;
        }
    }
    //console.log(fetch_url);
    fetch(fetch_url)
        .then((response) => response.json())
        .then((res) => {
            let players = res.players;
            //console.log(res.players);

            //selectionのscorerのoptionを削除して、現在のplayersからoptionを生成する
            let scorer = document.getElementById("scorer");
            let assist = document.getElementById("assist");

            let cnt = scorer.length;
            for ($i = 0; $i < cnt; $i++) {
                scorer.remove(0);
            }

            let assi_cnt = assist.length;
            for ($i = 0; $i < assi_cnt; $i++) {
                assist.remove(0);
            }

            //scorerとasssitは同時にoptionを追加しようとすると、下のしか追加されなかった。
            for ($i = 0; $i < players.length; $i++) {
                let opt = document.createElement("option");
                opt.value = players[$i].id;
                opt.text = players[$i].number+":"+players[$i].nickname;
                scorer.add(opt, null);
            }
                
            //assistは空の場合もあるので、空を追加。
            let opt = document.createElement("option");
            opt.value = "";
            opt.text = "-";
            assist.add(opt, null);

            for ($i = 0; $i < players.length; $i++) {
                let opt = document.createElement("option");
                opt.value = players[$i].id;
                opt.text = players[$i].number+":"+players[$i].nickname;
                assist.add(opt, null);
            }
        }) 
        .then(() => {
            document.querySelector(queSlct).selected=true;
            modal.find('.modal-body input#club_id').val(club);
            modal.find('.modal-body input#match_id').val(match);
            modal.find('.modal-body input#score_time').val(elapsed_time);
            modal.find('.modal-body input#score_period').val(period);
            if (period == 1) {
                modal.find('.modal-body input#score_period_txt').val("フル");
	    } else if (period == 2) {
                modal.find('.modal-body input#score_period_txt').val("前半");
	    } else if (period == 3) {
                modal.find('.modal-body input#score_period_txt').val("後半");
	    } else if (period == 4) {
                modal.find('.modal-body input#score_period_txt').val("延長前半");
	    } else if (period == 5) {
                modal.find('.modal-body input#score_period_txt').val("延長後半");
            }
	})    
        .catch(error => {
            alert("実行失敗");　
            alert(error);
        })
    
  })

//scoreのモーダルの確定ボタンクリックで処理を行う
scoreBtn.addEventListener("click", () => {
    const scorer = document.getElementById("scorer").value;
    const assist = document.getElementById("assist").value;
    const owngoal = document.getElementById("owngoal");
    const score_period = document.getElementById("score_period").value;
    const score_time = document.getElementById("score_time").value;
    const club_id = document.getElementById("club_id").value;
    const match_id = document.getElementById("match_id").value;
    if (owngoal.checked) {
        var owngoal_status = 1;
    } else {
        var owngoal_status = 0;
    }

    const home_score = document.getElementById("home_score");
    const away_score = document.getElementById("away_score");

    fetch('/score_submit?scorer='+scorer+'&assist='+assist+'&owngoal='+owngoal_status+'&score_period='+score_period+'&score_time='+score_time+'&club_id='+club_id+'&match_id='+match_id)
        .then((response) => response.json())
        .then((res) => {
            home_score.innerHTML = res.home_score;
            away_score.innerHTML = res.away_score;
            owngoal.checked = false;
        }) 
        .then(() => {
            $('#scoreModal').modal('hide');
        })
        .catch(error => {
            alert("実行失敗");　
            alert(error);
        })
});

//警告モーダルを開く際にid、club_id、match_idを引数とする
$('#foulModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let clubusermatch = String(button.data('clubusermatch'));
    let modal = $(this);
    let num = parseInt(clubusermatch.substring(0, 2));
    let club = parseInt(clubusermatch.substring(2, 5));
    let user = parseInt(clubusermatch.substring(5, 9));
    let match = parseInt(clubusermatch.substring(9));
    let queSlct = "select#violator option[value=\""+user+"\"]";
    let a_side = parseInt(document.getElementById("a_side").value);
    let elapsed_time = document.getElementById("elapsed_time").value;
    let period = document.getElementById("period").value;
    //console.log(a_side);

    let home = document.getElementById("home");
    let home_2 = document.getElementById("home_2");
    let home_3 = document.getElementById("home_3");
    let home_4 = document.getElementById("home_4");
    let away = document.getElementById("away");
    let away_2 = document.getElementById("away_2");
    let away_3 = document.getElementById("away_3");
    let away_4 = document.getElementById("away_4");
    //console.log(!(!away.value));
    //console.log(!(!away_2.value));
    //console.log(!(!away_3.value));
    //console.log(!(!away_4.value));
    //console.log(match);
    //ここで非同期でモーダル内のselectionのoptionを取得して、反映する。
    var fetch_url = "/foul_display?match_id="+match;
    if (num < a_side) {
        var fetch_url = fetch_url+"&club_id="+home.value;
        if (!(!home_2.value)) {
            var fetch_url = fetch_url+"&club2_id="+home_2.value;
        }
        if (!(!home_3.value)) {
            var fetch_url = fetch_url+"&club3_id="+home_3.value;
        }
        if (!(!home_4.value)) {
            var fetch_url = fetch_url+"&club4_id="+home_4.value;
        }
    } else if (num >= a_side) {
        var fetch_url = fetch_url+"&club_id="+away.value;
        if (!(!away_2.value)) {
            var fetch_url = fetch_url+"&club2_id="+away_2.value;
        }
        if (!(!away_3.value)) {
            var fetch_url = fetch_url+"&club3_id="+away_3.value;
        }
        if (!(!away_4.value)) {
            var fetch_url = fetch_url+"&club4_id="+away_4.value;
        }
    }
    //console.log(fetch_url);
    fetch(fetch_url)
        .then((response) => response.json())
        .then((res) => {
            let players = res.players;

            //selectionのviolatorのoptionを削除して、現在のplayersからoptionを生成する
            let violator = document.getElementById("violator");
            let cnt = violator.length;

            for ($i = 0; $i < cnt; $i++) {
                violator.remove(0);
            }

            for ($i = 0; $i < players.length; $i++) {
                let opt = document.createElement("option");
                opt.value = players[$i].id;
                opt.text = players[$i].number+":"+players[$i].nickname;
                violator.add(opt, null);
            }
        }) 
        .then(() => {
            document.querySelector(queSlct).selected=true;
            modal.find('.modal-body input#foul_club_id').val(club);
            modal.find('.modal-body input#foul_match_id').val(match);
            modal.find('.modal-body input#foul_time').val(elapsed_time);
            modal.find('.modal-body input#foul_period').val(period);
            if (period == 1) {
                modal.find('.modal-body input#foul_period_txt').val("フル");
            } else if (period == 2) {
                modal.find('.modal-body input#foul_period_txt').val("前半");
            } else if (period == 3) {
                modal.find('.modal-body input#foul_period_txt').val("後半");
            } else if (period == 4) {
                modal.find('.modal-body input#foul_period_txt').val("延長前半");
            } else if (period == 5) {
                modal.find('.modal-body input#foul_period_txt').val("延長後半");
            }
	})    
        .catch(error => {
            alert("実行失敗");　
            alert(error);
        })
});

//foulのモーダルの確定ボタンクリックで処理を行う
foulBtn.addEventListener("click", () => {
    const violator = document.getElementById("violator").value;
    const foul_period = document.getElementById("foul_period").value;
    const foul_time = document.getElementById("foul_time").value;
    const club_id = document.getElementById("foul_club_id").value;
    const match_id = document.getElementById("foul_match_id").value;
    const foul_cards = document.getElementsByName("foul_cards");
    let len = foul_cards.length;
    let checkCard = '';

    for (let i = 0; i < len; i++){
        if (foul_cards.item(i).checked){
            checkCard = foul_cards.item(i).value;
        }
    }

    console.log('/foul_submit?violator='+violator+'&foul_period='+foul_period+'&foul_time='+foul_time+'&foul_cards='+checkCard+'&club_id='+club_id+'&match_id='+match_id);
    fetch('/foul_submit?violator='+violator+'&foul_period='+foul_period+'&foul_time='+foul_time+'&foul_cards='+checkCard+'&club_id='+club_id+'&match_id='+match_id)
        .then((response) => response.json())
        .then((res) => {
            console.log(res);
            $('#foulModal').modal('hide');
        })
        .catch(error => {
            alert("実行失敗");
            alert(error);
        })
});

//交代モーダルを開く際にid、club_id、match_idを引数とする
$('#changeModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let modal = $(this);
    let match = parseInt(button.data('match'));
    let a_side = parseInt(document.getElementById("a_side").value);
    let elapsed_time = document.getElementById("elapsed_time").value;
    let period = document.getElementById("period").value;

    let home = document.getElementById("home");
    let home_2 = document.getElementById("home_2");
    let home_3 = document.getElementById("home_3");
    let home_4 = document.getElementById("home_4");
    let away = document.getElementById("away");
    let away_2 = document.getElementById("away_2");
    let away_3 = document.getElementById("away_3");
    let away_4 = document.getElementById("away_4");

    //memberの一覧からsubstituteを抜いて、順に見て変更が入っている箇所を表示させる。
    let home_change_tbl = document.getElementById("home_change_tbl");
    $("#home_change_tbl tr").remove();
    let home_tbl = document.getElementById("home_tbl");
    let home_rows = home_tbl.rows;

    for (i = 0; i < home_rows.length; i++) {
        let substi = "substitute"+i
        let substitute = document.getElementById(substi);
        if (substitute.value != "") {
            let position = "match_position"+i
            let match_position = document.getElementById(position);
            let player = "player_id"+i
            let player_id = document.getElementById(player);
            let club = "club_id"+i
            let club_id = document.getElementById(club);
            let number_ = "number"+i
            let number = document.getElementById(number_);
            let nickname_ = "nickname"+i
            let nickname = document.getElementById(nickname_);
            let substi_id = substitute.value.substring(0, 6);
            let substi_txt = substitute.value.substring(6);
            console.log(substi_id);
            console.log(substi_txt);

            let add_tr = home_change_tbl.insertRow(-1);
            let td1 = add_tr.insertCell(0);
            td1.innerHTML = match_position.value;
            let td2 = add_tr.insertCell(1);
            td2.innerHTML = number.value+":"+nickname.value;
            let td3 = add_tr.insertCell(2);
            td3.innerHTML = "→";
            let td4 = add_tr.insertCell(3);
            td4.innerHTML = substi_txt;
            let input_id = document.createElement("input");
            input_id.setAttribute("type", "hidden");
            input_id.setAttribute("value", player_id.value);
            input_id.setAttribute("name", "player_id[]");
            td4.appendChild(input_id);
            let input_position = document.createElement("input");
            input_position.setAttribute("type", "hidden");
            input_position.setAttribute("value", match_position.value);
            input_position.setAttribute("name", "match_position[]");
            td4.appendChild(input_position);
            let input_club = document.createElement("input");
            input_club.setAttribute("type", "hidden");
            input_club.setAttribute("value", club_id.value);
            input_club.setAttribute("name", "club_id[]");
            td4.appendChild(input_club);
            let input_substi = document.createElement("input");
            input_substi.setAttribute("type", "hidden");
            input_substi.setAttribute("value", parseInt(substi_id));
            input_substi.setAttribute("name", "substitute[]");
            td4.appendChild(input_substi);
        }
    }

    //memberの一覧からsubstituteを抜いて、順に見て変更が入っている箇所を表示させる。
    let away_change_tbl = document.getElementById("away_change_tbl");
    $("#away_change_tbl tr").remove();
    let away_tbl = document.getElementById("away_tbl");
    let away_rows = away_tbl.rows;
    //console.log(home_rows.length);
    //console.log(away_rows.length);

    for (i = home_rows.length; i < away_rows.length + home_rows.length; i++) {
        let substi = "substitute"+i
        let substitute = document.getElementById(substi);
        console.log(substi);
        if (substitute.value != "") {
            let position = "match_position"+i
            let match_position = document.getElementById(position);
            let player = "player_id"+i
            let player_id = document.getElementById(player);
            let club = "club_id"+i
            let club_id = document.getElementById(club);
            let number_ = "number"+i
            let number = document.getElementById(number_);
            let nickname_ = "nickname"+i
            let nickname = document.getElementById(nickname_);
            let substi_id = substitute.value.substring(0, 6);
            let substi_txt = substitute.value.substring(6);
            console.log(substi_id);
            console.log(substi_txt);

            let add_tr = away_change_tbl.insertRow(-1);
            let td1 = add_tr.insertCell(0);
            td1.innerHTML = match_position.value;
            let td2 = add_tr.insertCell(1);
            td2.innerHTML = number.value+":"+nickname.value;
            let td3 = add_tr.insertCell(2);
            td3.innerHTML = "→";
            let td4 = add_tr.insertCell(3);
            td4.innerHTML = substi_txt;
            let input_id = document.createElement("input");
            input_id.setAttribute("type", "hidden");
            input_id.setAttribute("value", player_id.value);
            input_id.setAttribute("name", "player_id[]");
            td4.appendChild(input_id);
            let input_position = document.createElement("input");
            input_position.setAttribute("type", "hidden");
            input_position.setAttribute("value", match_position.value);
            input_position.setAttribute("name", "match_position[]");
            td4.appendChild(input_position);
            let input_club = document.createElement("input");
            input_club.setAttribute("type", "hidden");
            input_club.setAttribute("value", club_id.value);
            input_club.setAttribute("name", "club_id[]");
            td4.appendChild(input_club);
            let input_substi = document.createElement("input");
            input_substi.setAttribute("type", "hidden");
            input_substi.setAttribute("value", parseInt(substi_id));
            input_substi.setAttribute("name", "substitute[]");
            td4.appendChild(input_substi);
        }
    }
    console.log(period);
    modal.find('.modal-body input#change_period').val(period);
    modal.find('.modal-body input#change_time').val(elapsed_time);
    if (period == 1) {
        modal.find('.modal-body input#change_period_txt').val("フル");
    } else if (period == 2) {
        modal.find('.modal-body input#change_period_txt').val("前半");
    } else if (period == 3) {
        modal.find('.modal-body input#change_period_txt').val("後半");
    } else if (period == 4) {
        modal.find('.modal-body input#change_period_txt').val("延長前半");
    } else if (period == 5) {
        modal.find('.modal-body input#change_period_txt').val("延長後半");
    }

});

//changeのモーダルの確定ボタンクリックで処理を行う
changeBtn.addEventListener("click", () => {
    const changeForm = document.getElementById('changeForm');
    console.log(changeForm);
    let formData = new FormData(changeForm);
    const home_tbl = document.getElementById('home_tbl');
    const home_rows = home_tbl.rows;
    const away_tbl = document.getElementById('away_tbl');
    const away_rows = away_tbl.rows;
    //console.log(home_tbl.rows);

    fetch('https://wfok.xyz/change_submit', {
            method: 'POST',
            body: formData
        }).then((response) => response.json())
        .then((res)  => {
            //console.log(res);
            let res_len = Object.keys(res).length;
            
            //まず、home_tbl・away_tblの表示変更
            for (let i = 0; i < res_len - 2; i++) {
                //console.log(res[i].pre_player_id);
                //console.log(home_rows.length);
                let find_flag = 0;
                for (let j = 0; j < home_rows.length; j++) {
                    //console.log(i+" "+j);
                    let txt = "player_id"+j;
                    let pre_player_id = document.getElementById(txt).value;
                    //console.log(home_rows[j].cells[1].innerHTML);
                    if (pre_player_id == res[i].pre_player_id) {
                        //console.log(i+" "+j);
                        //console.log(pre_player_id);
                        //console.log("あたり");
                        //home_tblの交代したplayerの表示変更
                        let club = "club_id"+j;
                        let club_id = document.getElementById(club).value;
                        let numb = "number"+j;
                        let number = document.getElementById(numb).value;
                        let nick = "nickname"+j;
                        let nickname = document.getElementById(nick).value;
                        pre_player_id = res[i].player_id;
                        club_id.value = res[i].club_id;
                        number = res[i].number;
                        nickname = res[i].nickname;
                        home_rows[j].cells[1].firstChild.nodeValue = res[i].number+":"+res[i].nickname;

                        //下の表は12/25以降に更新を追加する
                        find_flag = 1;
                        break;
                    }
                }
                //console.log(find_flag);

                if (find_flag == 0) {
                    //console.log(away_rows.length);
                    for (let j = home_rows.length; j < away_rows.length+home_rows.length; j++) {
                        //console.log(i+" "+j);
                        //console.log(j);
                        let txt = "player_id"+j;
                        let pre_player_id = document.getElementById(txt).value;
                        //console.log(pre_player_id);
                        if (pre_player_id == res[i].pre_player_id) {
                            //console.log(i+" "+j);
                            //console.log(pre_player_id);
                            //console.log("あたり");
                            //home_tblの交代したplayerの表示変更
                            let club = "club_id"+j;
                            let club_id = document.getElementById(club).value;
                            let numb = "number"+j;
                            let number = document.getElementById(numb).value;
                            let nick = "nickname"+j;
                            let nickname = document.getElementById(nick).value;
                            pre_player_id = res[i].player_id;
                            club_id = res[i].club_id;
                            number = res[i].number;
                            nickname = res[i].nickname;
                            //console.log("さる");
                            away_rows[j-8].cells[1].firstChild.nodeValue = res[i].number+":"+res[i].nickname;

                            //下の表は12/25以降に更新を追加する
                            break;
                        }
                    }
                }
            }
            //console.log("ぶた");
            //home_tblのsubstituteのoptionも更新する
            for (let j = 0; j < home_rows.length; j++) {
                //selectionのsubstituteのoptionを削除して、現在のplayersからoptionを生成する
                let substi = "substitute"+j;
                let substitute = document.getElementById(substi);
                let cnt = substitute.length;

                for ($i = 0; $i < cnt; $i++) {
                    substitute.remove(0);
                }

                //console.log(res[res_len-2]);
                let opts = res[res_len-2];

                //まず空のoptionを追加
                let opt = document.createElement("option");
                opt.value = "";
                opt.text = "-未選択-";
                substitute.add(opt, null);

                for ($i = 0; $i < opts.length; $i++) {
                    let opt = document.createElement("option");
                    opt.value = opts[$i].id6+opts[$i].number+opts[$i].nickname;
                    opt.text = opts[$i].number+":"+opts[$i].nickname;
                    substitute.add(opt, null);
                }
            }

            //away_tblのsubstituteのoptionも更新する
            for (let j = home_rows.length; j < away_rows.length+home_rows.length; j++) {
                //selectionのsubstituteのoptionを削除して、現在のplayersからoptionを生成する
                let substi = "substitute"+j;
                let substitute = document.getElementById(substi);
                let cnt = substitute.length;

                for ($i = 0; $i < cnt; $i++) {
                    substitute.remove(0);
                }

                //console.log(res[res_len-1]);
                let opts = res[res_len-1];

                //まず空のoptionを追加
                let opt = document.createElement("option");
                opt.value = "";
                opt.text = "-未選択-";
                substitute.add(opt, null);

                for ($i = 0; $i < opts.length; $i++) {
                    let opt = document.createElement("option");
                    opt.value = opts[$i].id6+opts[$i].number+opts[$i].nickname;
                    opt.text = opts[$i].number+":"+opts[$i].nickname;
                    substitute.add(opt, null);
                }
            }
        }).catch((error) => {
            alert("実行失敗");
            alert(error);
        });

    $('#changeModal').modal('hide');

});

//PKモーダルを開く際にid、club_id、match_idを引数とする
//PKはとりあえず5までテーブルを自動作成する
//テーブルは追加できるように
//キッカーはplayersから取得

$('#PKModal').on('show.bs.modal', function (event) {

    let button = $(event.relatedTarget);
    let modal = $(this);
    let match = parseInt(button.data('match'));
    let a_side = parseInt(document.getElementById("a_side").value);
    let elapsed_time = document.getElementById("elapsed_time").value;
    let period = document.getElementById("period").value;
/*
    let home = document.getElementById("home");
    let home_2 = document.getElementById("home_2");
    let home_3 = document.getElementById("home_3");
    let home_4 = document.getElementById("home_4");
    let away = document.getElementById("away");
    let away_2 = document.getElementById("away_2");
    let away_3 = document.getElementById("away_3");
    let away_4 = document.getElementById("away_4");
/*
    //memberの一覧からsubstituteを抜いて、順に見て変更が入っている箇所を表示させる。
    let pk_tbl = document.getElementById("pk_tbl");
    $("#pk_tbl tr").remove();
    let players_num = 5;
    let pk_rows = pk_tbl.rows;

    for (i = 0; i < home_rows.length; i++) {
        let substi = "substitute"+i
        let substitute = document.getElementById(substi);
        if (substitute.value != "") {
            let position = "match_position"+i
            let match_position = document.getElementById(position);
            let player = "player_id"+i
            let player_id = document.getElementById(player);
            let club = "club_id"+i
            let club_id = document.getElementById(club);
            let number_ = "number"+i
            let number = document.getElementById(number_);
            let nickname_ = "nickname"+i
            let nickname = document.getElementById(nickname_);
            let substi_id = substitute.value.substring(0, 6);
            let substi_txt = substitute.value.substring(6);
            console.log(substi_id);
            console.log(substi_txt);

            let add_tr = home_change_tbl.insertRow(-1);
            let td1 = add_tr.insertCell(0);
            td1.innerHTML = match_position.value;
            let td2 = add_tr.insertCell(1);
            td2.innerHTML = number.value+":"+nickname.value;
            let td3 = add_tr.insertCell(2);
            td3.innerHTML = "→";
            let td4 = add_tr.insertCell(3);
            td4.innerHTML = substi_txt;
            let input_id = document.createElement("input");
            input_id.setAttribute("type", "hidden");
            input_id.setAttribute("value", player_id.value);
            input_id.setAttribute("name", "player_id[]");
            td4.appendChild(input_id);
            let input_position = document.createElement("input");
            input_position.setAttribute("type", "hidden");
            input_position.setAttribute("value", match_position.value);
            input_position.setAttribute("name", "match_position[]");
            td4.appendChild(input_position);
            let input_club = document.createElement("input");
            input_club.setAttribute("type", "hidden");
            input_club.setAttribute("value", club_id.value);
            input_club.setAttribute("name", "club_id[]");
            td4.appendChild(input_club);
            let input_substi = document.createElement("input");
            input_substi.setAttribute("type", "hidden");
            input_substi.setAttribute("value", parseInt(substi_id));
            input_substi.setAttribute("name", "substitute[]");
            td4.appendChild(input_substi);
        }
    }

    //memberの一覧からsubstituteを抜いて、順に見て変更が入っている箇所を表示させる。
    let away_change_tbl = document.getElementById("away_change_tbl");
    $("#away_change_tbl tr").remove();
    let away_tbl = document.getElementById("away_tbl");
    let away_rows = away_tbl.rows;
    //console.log(home_rows.length);

    for (i = home_rows.length; i < away_rows.length + home_rows.length; i++) {
        let substi = "substitute"+i
        let substitute = document.getElementById(substi);
        //console.log(substitute);
        if (substitute.value != "") {
            let position = "match_position"+i
            let match_position = document.getElementById(position);
            let player = "player_id"+i
            let player_id = document.getElementById(player);
            let club = "club_id"+i
            let club_id = document.getElementById(club);
            let number_ = "number"+i
            let number = document.getElementById(number_);
            let nickname_ = "nickname"+i
            let nickname = document.getElementById(nickname_);
            let substi_id = substitute.value.substring(0, 6);
            let substi_txt = substitute.value.substring(6);
            console.log(substi_id);
            console.log(substi_txt);

            let add_tr = away_change_tbl.insertRow(-1);
            let td1 = add_tr.insertCell(0);
            td1.innerHTML = match_position.value;
            let td2 = add_tr.insertCell(1);
            td2.innerHTML = number.value+":"+nickname.value;
            let td3 = add_tr.insertCell(2);
            td3.innerHTML = "→";
            let td4 = add_tr.insertCell(3);
            td4.innerHTML = substi_txt;
            let input_id = document.createElement("input");
            input_id.setAttribute("type", "hidden");
            input_id.setAttribute("value", player_id.value);
            input_id.setAttribute("name", "player_id[]");
            td4.appendChild(input_id);
            let input_position = document.createElement("input");
            input_position.setAttribute("type", "hidden");
            input_position.setAttribute("value", match_position.value);
            input_position.setAttribute("name", "match_position[]");
            td4.appendChild(input_position);
            let input_club = document.createElement("input");
            input_club.setAttribute("type", "hidden");
            input_club.setAttribute("value", club_id.value);
            input_club.setAttribute("name", "club_id[]");
            td4.appendChild(input_club);
            let input_substi = document.createElement("input");
            input_substi.setAttribute("type", "hidden");
            input_substi.setAttribute("value", parseInt(substi_id));
            input_substi.setAttribute("name", "substitute[]");
            td4.appendChild(input_substi);
        }
    }
    console.log(period);
    modal.find('.modal-body input#change_period').val(period);
    modal.find('.modal-body input#change_time').val(elapsed_time);
    if (period == 1) {
        modal.find('.modal-body input#change_period_txt').val("フル");
    } else if (period == 2) {
        modal.find('.modal-body input#change_period_txt').val("前半");
    } else if (period == 3) {
        modal.find('.modal-body input#change_period_txt').val("後半");
    } else if (period == 4) {
        modal.find('.modal-body input#change_period_txt').val("延長前半");
    } else if (period == 5) {
        modal.find('.modal-body input#change_period_txt').val("延長後半");
    }
*/
});
