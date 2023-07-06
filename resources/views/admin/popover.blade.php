<script>
	$(function() {
		try{
			$('[data-toggle="popover"]').popover({
				trigger: 'hover',
			});
		}catch (e) {
			console.log(e);
		}
		$('#calender').fullCalendar({
			eventSources: [
				{
					url: '{{ route('admin.getAllEvents') }}', // use the `url` property
					color: 'yellow',    // an option!
					textColor: 'black'  // an option!
				}
			],
			eventRender:function(eventObj, $el) {
				let title = $el.find( '.fc-title' );
				title.html( title.text() );
				let name='Description';
				if(eventObj.name!=undefined){
					name=eventObj.name;
				}
				try{
					$el.popover({
						title: name,
						content: 'Name :'+ eventObj.description,
						trigger: 'hover',
						placement: 'top',
						container: 'body',
						html: true,
					}).popover('show');
				}catch (e) {
					console.log(e);
				}

			}
		});
	});
</script>
