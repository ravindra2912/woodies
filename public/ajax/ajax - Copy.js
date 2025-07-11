$(function () {

	var scrollIntoView = true;
	$(".formaction").on('submit', (function (e) {
		e.preventDefault();

		var form = this;

		if ($(form).data('scroll') == false) {
			scrollIntoView = false;
		}

		$.ajax({
			url: this.action,
			type: "POST",
			data: new FormData(this),
			dataType: "json",
			//headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () {
				remove_error();
				$('.btn_action #buttonText').addClass('d-none');
				$('.btn_action #loader').removeClass('d-none');
				$('.btn_action').prop('disabled', true);
			},
			success: function (result) {
				$('.btn_action #buttonText').removeClass('d-none');
				$('.btn_action #loader').addClass('d-none');
				$('.btn_action').prop('disabled', false);
				remove_error();
				if (result.success) {
					if ($(form).data('tost') == null || $(form).data('tost') == true) {
						toastr.success(result.message);
					}

					//cleare form after submite
					if ($(form).data('reset')) {
						form.reset();
					}

					if ($(form).data('action') == 'reload') {
						setTimeout(function () { location.reload(); }, 1000);
					} else if ($(form).data('action') == 'call') {
						responce(result);
					} else if ($(form).data('action') == 'redirect') {
						if (result.redirect != null) {
							setTimeout(function () { window.location.href = result.redirect }, 1000);
						} else {
							setTimeout(function () { history.back() }, 1000);
						}
					} else if ($(form).data('action') == 'back') {
						setTimeout(function () { history.back() }, 1000);
						// setTimeout(function () { window.location.href = '{{ url()->previous() }}' }, 1000);
					}


				} else {
					error_handler(result.message, form);
					if (typeof ajaxFailResponce === 'function') {
						ajaxFailResponce(result);
					}

					//console.log(result.message);
				}

			},
			error: function (xhr, status, error) {
				console.log(xhr);
				if (xhr.status === 419) {
					toastr.error('Your session has expired, please login again');
					setTimeout(function () {
						location.reload();
					}, 3000);
				} else {
					toastr.error('Something Wrong');
					$('.btn_action #buttonText').removeClass('d-none');
					$('.btn_action #loader').addClass('d-none');
					$('.btn_action').prop('disabled', false);
				}
			}
		});
	}));

	function error_handler(error, form) {
		//console.log(typeof error);
		if (typeof error == 'string') {
			toastr.error(error);
			//console.log('string');
		} else if (typeof error == 'object') {
			obj_handler(error, form);
		} else {
			toastr.error('Something Wrong');
		}
	}

	function obj_handler(obj, form) {
		const Values = Object.values(obj);
		var result = Object.keys(obj).map((key, index) => {

			//for multy data on same name like 'name="benifits[benifit1]"' start
			var check_dot = key.includes('.') ? "true" : "false";
			if (check_dot == 'true') {
				const myArray = key.split(".");
				key = myArray[0] + '[' + myArray[1] + ']';
			}
			//end
			// if (key == 'sports') {
			// 	var element = $('select[name="' + key + '[]"]');
			// 	// var element = document.getElementsByName(key);
			// 	// var element = document.getElementsByName(key+'[]');
			// 	console.log(element[0].tagName);
			// 	console.log(element[0].nextElementSibling.tagName == 'SPAN');
			// 	console.log(key);
			// }
			// console.log(key);

			if (form.id != '') {
				if ($("#" + form.id + ' select[name="' + key + '[]"]')[0] != undefined) {
					var element = $("#" + form.id + ' select[name="' + key + '[]"]')[0]
					if (element.nextElementSibling.tagName == 'SPAN') {
						$(element.nextElementSibling).addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					} else {
						$("#" + form.id + ' select[name="' + key + '[]"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					}

				} else {
					$("#" + form.id + ' input[name="' + key + '"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					$("#" + form.id + ' select[name="' + key + '"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					$("#" + form.id + ' select[name="' + key + '[]"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					$("#" + form.id + ' textarea[name="' + key + '"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
				}
			} else {
				if ($('select[name="' + key + '[]"]')[0] != undefined) {
					var element = $('select[name="' + key + '[]"]')[0]
					if (element.nextElementSibling.tagName == 'SPAN') {
						$(element.nextElementSibling).addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					} else {
						$('select[name="' + key + '[]"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					}

				} else {
					$('input[name="' + key + '"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					$('select[name="' + key + '"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					$('select[name="' + key + '[]"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
					$('textarea[name="' + key + '"]').addClass("is-invalid").after('<div class="text-danger errors" id="error-' + key + '">' + Values[index][0] + '</div>');
				}
			}

			if (index == 0) {
				if (scrollIntoView) {
					form.scrollIntoView({
						behavior: 'smooth'
					});
				}


				document.getElementsByName(key)[0].focus();
			}

		});
	}

	function remove_error() {
		$(".form-control").removeClass("is-invalid");
		$(".errors").remove();

	}

	// onchnage remove error
	$(".formaction input, .formaction select, .formaction textarea").on('change keyup', (function (e) {
		$(this).removeClass("is-invalid");
		if (this.closest('.form-group') != null) {
			var ele = this.closest('.form-group').children;
			for (var i = 0; i <= ele.length - 1; i++) {
				if (ele[i] != undefined && ele[i].classList.contains('errors')) {
					ele[i].remove();
				}
			}
		}
	}));

	/*$(document).ajaxError(function(e) {
	 var e = eval("(" + e.responseText + ")");
	 if (e.message == "CSRF token mismatch.") {
		toastr.error('Your session has expired');
		setTimeout(function() {
		   location.reload();
		}, 3000);
	 }
  });*/




});
