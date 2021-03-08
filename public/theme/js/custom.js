$(document).ready(function () {
	// $("body").on('submit', '.jsSaveField', function (e) {

	// 	e.preventDefault();

	// 	var form = $(this);

	// 	$.ajax({
	// 		type: 'get',
	// 		url: '/tariffs/activate',
	// 		data: form.serialize(),
	// 		success: function (data) {
	// 			if (form.is('.jsChangeState')) {
	// 				var btnVisible = form.find('button').not('[hidden]'),
	// 					btnHidden = form.find('button[hidden]'),
	// 					inputField = form.find('input[name=fieldValue]'),
	// 					inputFieldValue = inputField.val();

	// 				btnVisible.attr('hidden', 'hidden');
	// 				btnHidden.removeAttr('hidden');
	// 				inputField.val(1 - inputFieldValue);

	// 			} else {
	// 				form.replaceWith(data);
	// 			}
	// 		},
	// 		error: function () {
	// 		},
	// 		complete: function () {

	// 		}
	// 	});
	// });
});