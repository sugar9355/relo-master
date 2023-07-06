$(function () {
	$("#flexTime").hide();
	// $("#specificTime").hide();
	$("#specificDate").hide();
	initDateRangePicker();
	initTimeSlider();

	$("#dataFormBtn").on("click", event => {
		$("#timeListModal").modal();
		let $timeList = $("#timeList");
		$timeList.html("Please Wait!");
		let dateTimeType = $("#time_date").val();
		if (dateTimeType == "FF") {
			event.preventDefault();
			let dates = $("#date").val().split(',');
			$timeList.html(null);
			dates.forEach((date, index) => {
				let html = `<h1>${date}</h1>`;
				html += getModalContent(index + 1);
				$timeList.append(html);
			});
		}
	});
});

function saveVal(me) {
	let value = $(me).val();
	$("#preferTime").val(value);
}

function submitForm() {
	/*let secondaryDates = $("#date").val().split(',');
	let valueList = [];
	for (let i = 0; i < secondaryDates.length; i++) {
		let number = i+1;
		let selector = "time_"+number;
		let list = [];
		let checkboxes = $("#timeListModal input[name^="+selector+"]");
		for (let j = 0; j < checkboxes.length; j++) {
			let checkbox = $(checkboxes[j]);
			if (checkbox.prop("checked")) {
				list.push(checkbox.val());
			}
		}
		valueList[secondaryDates[i]] = list;
	}
	$("#time").val(valueList);*/
	$("#dateForm").submit();
}

function getModalContent(index) {
	return `<ul class="list-unstyled">
	            <li class="py-2">
	                <input type="checkbox" class="myCheckbox" value="Any Time" name="time_${index}[]" id="box-${index}-1">
	                <label for="box-${index}-1" class="myCheckboxLabel">Any Time</label>
	            </li>
	            <li class="py-2">
	                <input type="checkbox" class="myCheckbox" value="Morning" name="time_${index}[]" id="box-${index}-2">
	                <label for="box-${index}-2" class="myCheckboxLabel">Morning</label>
	            </li>
	            <li class="py-2">
	                <input type="checkbox" class="myCheckbox" value="Afternoon" name="time_${index}[]" id="box-${index}-3">
	                <label for="box-${index}-3" class="myCheckboxLabel">Afternoon</label>
	            </li>
	            <li class="py-2">
	                <input type="checkbox" class="myCheckbox" value="Evening" name="time_${index}[]" id="box-${index}-4">
	                <label for="box-${index}-4" class="myCheckboxLabel">Evening</label>
	            </li>
	        </ul>`;
}

function changeTimeDatePref(me) {
	let val = $(me).val();
	let flexTimeSelector = $("#flexTime");
	let flexDateSelector = $("#dateRange");
	let specificTimeSelector = $("#specificTime");
	let specificDateSelector = $("#specificDate");
	flexDateSelector.hide();
	flexTimeSelector.hide();
	specificTimeSelector.hide();
	specificDateSelector.hide();
	if (val == "FS") {
		flexDateSelector.show();
		specificTimeSelector.show();
		initTimeSlider();
	}
	if (val == "FF") {
		flexDateSelector.show();
		flexTimeSelector.show();
		// initTimeRangeSlider();
	}
	if (val == "SS") {
		specificDateSelector.show();
		specificTimeSelector.show();
		initDatePicker();
		initTimeSlider();
	}
	if (val == "SF") {
		specificDateSelector.show();
		flexTimeSelector.show();
		initDatePicker();
	}
}

function initDateRangePicker() {
	$(".daterangepicker").datepicker({
		language: "en",
		multipleDates: true,
		multipleDatesSeparator: ",",
		dateFormat: 'yyyy-mm-dd',
		minDate: new Date(), // Now can select only dates, which goes after today
		onSelect: function (formattedDate) {
			$("#date").val(formattedDate);
		}
	});

	initPreferDatePicker();
}

function initPreferDatePicker() {
	$("#preferDate").datepicker({
		language: "en",
		dateFormat: 'yyyy-mm-dd',
		minDate: new Date(), // Now can select only dates, which goes after today
		onSelect: function (formattedDate) {
			$("input#preferDate").val(formattedDate);
		}
	});
	$('#preferDate').datepicker().data('datepicker').selectDate(new Date());
}

function initDatePicker() {
	let $datepicker = $("#datepicker");
	$datepicker.datepicker({
		language: "en",
		dateFormat: 'yyyy-mm-dd',
		minDate: new Date(), // Now can select only dates, which goes after today
		onSelect: function (formattedDate) {
			$("#date").val(formattedDate);
		}
	});
	$datepicker.datepicker().data('datepicker').selectDate(new Date());

}

function initTimeSlider() {
	let slider1 = document.getElementById('slider-specific');

	noUiSlider.create(slider1, {
		start: [0],
		range: {
			'min': 0,
			'max': 600
		},
		step: 15,
		format: wNumb({
			decimals: 0,
		})
	});
	slider1.noUiSlider.on('update', function (ui, e) {
		var hours1 = Math.floor(ui[0] / 60);
		var minutes1 = ui[0] - (hours1 * 60);

		if (hours1.toString().length == 1) hours1 = '0' + hours1;
		if (minutes1.toString().length == 1) minutes1 = '0' + minutes1;

		if (minutes1 == 0) minutes1 = '00';
		if (hours1 >= 4) {
			if (hours1 == 4) {
				hours1 = 12;
				minutes1 = minutes1 + " PM";
			} else {
				hours1 = hours1 - 4;
				minutes1 = minutes1 + " PM";
			}
		} else {
			hours1 = parseInt(hours1) + 8;
			minutes1 = minutes1 + " AM";
		}
		if (hours1 == 0) {
			hours1 = 8;
			minutes1 = minutes1;
		}

		$('.slider-specific-time').html(hours1 + ':' + minutes1);
		let timeRange = $("#specificPickedTime").text().replace(/\s/g, "");
		$("#time").val(timeRange);
	});
}

/*function initTimeRangeSlider(){
	let slider = document.getElementById("slider-range");
	noUiSlider.create(slider, {

		range: {
			'min': 0,
			'max': 1440
		},
		step: 15,
		start: [600, 720],
		connect: true,
		behaviour: 'tap-drag',
		format: wNumb({
			decimals: 0,
		})
	});
	slider.noUiSlider.on('update',function (ui, e) {
		var hours1 = Math.floor(ui[0] / 60);
		var minutes1 = ui[0] - (hours1 * 60);

		if (hours1.toString().length == 1) hours1 = '0' + hours1;
		if (minutes1.toString().length == 1) minutes1 = '0' + minutes1;
		if (minutes1 == 0) minutes1 = '00';
		if (hours1 >= 12) {
			if (hours1 == 12) {
				hours1 = hours1;
				minutes1 = minutes1 + " PM";
			} else {
				hours1 = hours1 - 12;
				minutes1 = minutes1 + " PM";
			}
		} else {
			hours1 = hours1;
			minutes1 = minutes1 + " AM";
		}
		if (hours1 == 0) {
			hours1 = 12;
			minutes1 = minutes1;
		}



		$('.slider-time').html(hours1 + ':' + minutes1);

		var hours2 = Math.floor(ui[1] / 60);
		var minutes2 = ui[1] - (hours2 * 60);

		if (hours2.toString().length == 1) hours2 = '0' + hours2;
		if (minutes2.toString().length == 1) minutes2 = '0' + minutes2;
		if (minutes2 == 0) minutes2 = '00';
		if (hours2 >= 12) {
			if (hours2 == 12) {
				hours2 = hours2;
				minutes2 = minutes2 + " PM";
			} else if (hours2 == 24) {
				hours2 = 11;
				minutes2 = "59 PM";
			} else {
				hours2 = hours2 - 12;
				minutes2 = minutes2 + " PM";
			}
		} else {
			hours2 = hours2;
			minutes2 = minutes2 + " AM";
		}

		$('.slider-time2').html(hours2 + ':' + minutes2);

		let timeRange = $("#PickedTimeRange").text().replace(/\s/g, "");
		$("#time").val(timeRange);

	})
}*/