$(document).ready(function($) {
    //$("#calendar").fullCalendar();
    //過去10日出力する
    for (var i=9;i>=0;i--) {
    var now = new Date();
    var yesterday = new Date(now.getFullYear(), now.getMonth(), now.getDate() - i);
     var y=yesterday.getFullYear();
     var m=yesterday.getMonth()+1;
     var d=yesterday.getDate();
     var w=yesterday[now.getDay()];
    var value = m+"月"+d+"日";

    var month = ('0' + m).slice(-2);
    var date = ('0' + d).slice(-2);
    var value2 = y+"-"+month+"-"+date;
    var h = "<li><a href='blog-list.html?date="+value2+"'>"+value+"</a></li>";
    $('.date-slide-list').append(h);
    }
});
