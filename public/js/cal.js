jQuery(document).ready(function($) {
$('#calendar').fullCalendar(
    // full calendarをカスタマイズする際にここにオプションを記述する。
	{height: 306,
	dayClick: function(date){ //イベントじゃないところをクリックしたとき(日をクリックしたとき)に実行
	var day = JSON.stringify(date);
	day = day.replace("\"", '');
	day = day.replace("\"", '');
	window.location.href="blog-list.html?date="+day;
	},
}
);
  });
