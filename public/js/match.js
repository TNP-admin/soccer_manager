$(function (exchange_clubs) {
  $('#change').click(function() {
    // 上入力欄の内容取得 
    let homes = document.getElementById('home');
    let home = homes.options[homes.selectedIndex].index;
    let homes_2 = document.getElementById('home_2');
    let home_2 = homes_2.options[homes_2.selectedIndex].index;
    let homes_3 = document.getElementById('home_3');
    let home_3 = homes_3.options[homes_3.selectedIndex].index;
    let homes_4 = document.getElementById('home_4');
    let home_4 = homes_4.options[homes_4.selectedIndex].index;

    // 下入力欄の内容取得 
    let aways = document.getElementById('away');
    let away = aways.options[aways.selectedIndex].index;
    let aways_2 = document.getElementById('away_2');
    let away_2 = aways_2.options[aways_2.selectedIndex].index;
    let aways_3 = document.getElementById('away_3');
    let away_3 = aways_3.options[aways_3.selectedIndex].index;
    let aways_4 = document.getElementById('away_4');
    let away_4 = aways_4.options[aways_4.selectedIndex].index;

    //console.log(home);
    homes.selectedIndex = away;
    homes_2.selectedIndex = away_2;
    homes_3.selectedIndex = away_3;
    homes_4.selectedIndex = away_4;
    aways.selectedIndex = home;
    aways_2.selectedIndex = home_2;
    aways_3.selectedIndex = home_3;
    aways_4.selectedIndex = home_4;
  });
});
