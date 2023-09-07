let $employer, $date, $promotion, $hours;
let iRadio;

const noHoursAlert = `<div class="alert alert-danger" role="alert">
    <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el médico en el día seleccionado.
</div>`;

$(function () {
  $promotion = $('#promotion');
  $employer = $('#employer');
  $date = $('#date');
  $hours = $('#hours');

  $promotion.change(() => {
    const promotionId = $promotion.val();
    const url = `/api/promociones/${promotionId}/employers`;
    $.getJSON(url, onemployersLoaded);
  });

  $employer.change(loadHours);
  $date.change(loadHours);
});    

function onemployersLoaded(employers) {
  let htmlOptions = '';
  employers.forEach(employer => {
    htmlOptions += `<option value="${employer.id}">${employer.name}</option>`;
  });
  $employer.html(htmlOptions);
  loadHours(); // side-effect
}

function loadHours() {
	const selectedDate = $date.val();
	const employerId = $employer.val();
	const url = `/api/schedule/hours?date=${selectedDate}&employer_id=${employerId}`;
    $.getJSON(url, displayHours);
}

function displayHours(data) {
	if (!data.morning && !data.afternoon || 
		data.morning.length===0 && data.afternoon.length===0) {

		$hours.html(noHoursAlert);
		return;
	}

	let htmlHours = '';
	iRadio = 0;

	if (data.morning) {
		const morning_intervals = data.morning;
		morning_intervals.forEach(interval => {
			htmlHours += getRadioIntervalHtml(interval);
		});
	}
	if (data.afternoon) {
		const afternoon_intervals = data.afternoon;
		afternoon_intervals.forEach(interval => {
			htmlHours += getRadioIntervalHtml(interval);
		});
	}
	$hours.html(htmlHours);
}

function getRadioIntervalHtml(interval) {
	const text = `${interval.start} - ${interval.end}`;

	return `<div class="custom-control custom-radio mb-3">
  <input name="scheduled_time" value="${interval.start}" class="custom-control-input" id="interval${iRadio}" type="radio" required>
  <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
</div>`;
}