<link href='/public/assets/css/schedule/fullcalendar.css' rel='stylesheet' />
<link href='/public/assets/css/schedule/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/public/assets/js/schedule/moment.min.js'></script>
<script src='/public/assets/js/schedule/fullcalendar.js'></script>

<script>

	function fillZeros(n, digits) {
		var zero = '';
		n = n.toString();

		if (n.length < digits) {
			for (i = 0; i < digits - n.length; i++)
				zero += '0';
		}
		return zero + n;
	}

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '2016-05-12',
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				start = moment(start).format('YYYY-MM-DD');
				end = moment(end);
				end = new Date(end);
				end.setDate(end.getDate() - 1);
				var ends = fillZeros(end.getFullYear(), 4) + '-' +
					fillZeros(end.getMonth() + 1, 2) + '-' +
					fillZeros(end.getDate(), 2);
				window.alert(start);
				window.alert(ends);
				$('#uploadSchedule').modal('show');
				$('#calendar').fullCalendar('unselect');
			},
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2016-05-01'
				},
				{
					title: 'Long Event',
					start: '2016-05-07',
					end: '2016-05-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-05-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2016-05-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2016-05-11',
					end: '2016-05-13'
				},
				{
					title: 'Meeting',
					start: '2016-05-12T10:30:00',
					end: '2016-05-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2016-05-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2016-05-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2016-05-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2016-05-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2016-05-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2016-05-28'
				}
			]
		});

	});

</script>


<!-- 모달 팝업 -->

<div class="container">
	<div class="modal fade" id="uploadSchedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel"></h4>
					<h1 style="color: black">Login</h1>
				</div>
				<div class="modal-body">
					<form method="post" action="/Member/login">
						<p style="color: black"><input type="text" name="uid" placeholder="ID"></p>
						<p style="color: black"><input type="password" name="upwd" placeholder="PASSWORD"></p>
						<p>
							<input type="submit" value="로그인" name="submit_login">
							<input type="button" value="회원가입" onclick="location.href='/Member/join'">
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<style>

	#calendar {
		max-width: 900px;
		margin: 0 auto;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

</style>
	<div id='calendar'></div>

