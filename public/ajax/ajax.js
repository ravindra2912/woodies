$(function () {

	var scrollIntoView = true;
	$(".formaction").on('submit', (function (e) {
		e.preventDefault();

		var form = this;

		// check form validation start
		const requiredInputs = form.querySelectorAll('input.required, select.required, textarea.required');
		let requiredInputsArray = {};

		requiredInputs.forEach(input => {
			// Check if the element is visible on screen (including Select2 edge case)
			const isVisible = !!(input.offsetParent !== null || input.getClientRects().length);

			// Get value correctly, even for Select2
			let value = input.value;

			if (isVisible && (!value || !value.toString().trim())) {
				let label = input.name.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
				requiredInputsArray[input.name] = ['The ' + label + ' field is required.'];
			}
		});

		if (Object.keys(requiredInputsArray).length > 0) {
			obj_handler(requiredInputsArray, form);
			return; // stop form submit or ajax
		}
		// check form validation End

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
				$(form).find('.btn_action #buttonText').addClass('d-none');
				$(form).find('.btn_action #loader').removeClass('d-none');
				$(form).find('.btn_action').prop('disabled', true);
			},
			success: function (result) {
				$(form).find('.btn_action #buttonText').removeClass('d-none');
				$(form).find('.btn_action #loader').addClass('d-none');
				$(form).find('.btn_action').prop('disabled', false);
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
					$(form).find('.btn_action #buttonText').removeClass('d-none');
					$(form).find('.btn_action #loader').addClass('d-none');
					$(form).find('.btn_action').prop('disabled', false);
				}
			}
		});
	}));

	function error_handler(error, form) {
		if (typeof error === 'string') {
			toastr.error(error);
		} else if (typeof error === 'object' && error !== null) {
			obj_handler(error, form);
		} else {
			console.error('Unknown error type:', error);
			toastr.error('Something went wrong. Please try again.');
		}
	}

	function obj_handler(obj, form) {
		const values = Object.values(obj);
		const keys = Object.keys(obj);

		keys.forEach((key, index) => {
			// Handle dot notation (e.g., "benefits.benefit1")
			if (key.includes('.')) {
				const parts = key.split('.');
				key = `${parts[0]}[${parts[1]}]`;
			}

			const formSelector = form.id ? `#${form.id} ` : '';
			const errorMessage = values[index][0];

			const fieldSelectors = [
				`input[name="${key}"]`,
				`select[name="${key}"]`,
				`select[name="${key}[]"]`,
				`textarea[name="${key}"]`
			];

			let field = null;
			for (let selector of fieldSelectors) {
				const el = document.querySelector(formSelector + selector);
				if (el) {
					field = el;
					break;
				}
			}

			if (field) {
				const $field = $(field);
				// $field.addClass('is-invalid');

				// Remove any existing error message
				// $field.siblings(`#error-${key}`).remove();
				$field.siblings(`#error-${CSS.escape(key)}`).remove();

				console.log($field);

				// Get the next element
				let $nextElement = $field.next();

				// Insert error after the next element
				if ($nextElement.length) {
					$nextElement.after(`<div class="text-danger errors" id="error-${key}">${errorMessage.replace(/\[\]/g, '')}</div>`);
				} else {
					// Fallback: if no next element, insert after the field
					$field.after(`<div class="text-danger errors" id="error-${key}">${errorMessage.replace(/\[\]/g, '')}</div>`);
				}
			}

			// Scroll and focus on first error
			if (index === 0) {
				if (scrollIntoView) {
					form.scrollIntoView({ behavior: 'smooth' });
				}
				field?.focus();
			}
		});
	}

	function remove_error() {
		// Remove all validation styling from inputs
		$(".form-control, .form-select, textarea").removeClass("is-invalid");

		// Remove error messages next to the inputs
		$(".errors").remove();
	}

	// onchange remove error
	$(".formaction input, .formaction select, .formaction textarea").on('change keyup', function () {
		$(this).removeClass("is-invalid");

		// Remove any `.errors` element next to the field
		$(this).siblings(".errors").remove();

		// Optionally, remove from parent `.form-group` if needed
		$(this).closest('.form-group').find('.errors').remove();
	});

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
