jQuery.validator.addMethod("lettersonly", function(value, element) {
	return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
  }, "Letters only please"); 

jQuery.validator.addMethod('minStrict', function (value, el, param) {
    return (value <= param && value > 0);
});

jQuery( document ).ready(function() {
	jQuery('#radioBtn a').on('click', function(){
		var sel = jQuery(this).data('title');
		var tog = jQuery(this).data('toggle');
		jQuery('#'+tog).prop('value', sel);

		jQuery('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
		jQuery('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
	});
   /* Profile Post Request Ajax Code*/
   /* Profile Post Request Ajax Code*/
	jQuery("form[id='modalProfileSubmit']").validate({
		ignore: '',
		rules: {
			adminemail: {
				required: true,
				email: true
			},
			first_name: {
				required: true,
			},
			last_name: {
				required: true,
			}
		},
		// Specify validation error messages
		messages: {
			adminemail: {
				required: 'Email address is required',
				email: 'Provide an valid email address',
			},
			first_name: {
				required: 'First name field is required',
			},
			last_name: {
				required: 'Last name field is required',
			}
		},
		submitHandler: function(form) {
			jQuery("#successMsgP").html('');
			jQuery("#errorsDeprtP").html('');
			var btnText = jQuery("#savedBtnP").html();
			jQuery("#savedBtnP").html(btnText + '<i class="fa fa-spinner fa-spin"></i>');
			jQuery("#savedBtnP").attr("disabled", true);
			var formData = new FormData(form);
			var formdata = jQuery(form);
			var urls = formdata.prop('action');
			jQuery.ajax({
				type: "POST",
				url: urls,
				data: formData,
				dataType: 'json',
						cache:false,
						contentType: false,
						processData: false,
				success: function(data) {
					if (data.success == true) {
						jQuery("#successMsgP").html('<p class="inputsuccess">' + data.msg + '</p>');
						jQuery("#successMsgP").removeClass("hidden");
						jQuery("#errorsDeprtP").addClass("hidden");
						setTimeout(function() {
							location.reload(true);
						}, 1000);

					} else if(data.success == false){
						jQuery("#errorsDeprtP").html('<p class="inputerror">' + data.msg + '</p>');
						jQuery("#errorsDeprtP").removeClass("hidden");
						jQuery("#successMsgP").addClass("hidden");
						jQuery("#savedBtnP").html('Update');
						jQuery("#savedBtnP").attr("disabled", false);
					}
				},
				error: function (jqXHR, exception) {
					var msg = '';
					
					if (jqXHR.status === 302) {
						swal({
							title: "Warning",
							text: "Session timeout!",
							icon: "warning",
						});
						window.location.reload();
					}
					else if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						var errors = jQuery.parseJSON(jqXHR.responseText);
						var erro = '';
						jQuery.each(errors['errors'], function(n, v) {
							erro += '<p class="inputerror">' + v + '</p>';
						});
						jQuery("#errorsDeprtP").html(erro);
						jQuery("#errorsDeprtP").removeClass("hidden");
						jQuery("#successMsgP").addClass("hidden");
						jQuery("#savedBtnP").html('Update');
						jQuery("#savedBtnP").attr("disabled", false);
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					console.info(msg);
				}
			});
		}
	});
	//Common Delete confirmation
	jQuery('.delete-confirm').on('click', function (event) {
		event.preventDefault();
		const url = jQuery(this).attr('href');
		swal({
			title: 'Are you sure?',
			text: 'This record and it`s details will be permanantly deleted!',
			icon: 'warning',
			buttons: ["Cancel", "Yes!"],
		}).then(function(value) {
			if (value) {
				window.location.href = url;
			}
		});
	});
	// Password Change Code
	jQuery("form[id='modalchangepassSubmit']").validate({
		ignore: '',
		rules: {
			oldpassword: {
				required: true,
			},
			newpassword: {
				required: true,
			}
		},
		// Specify validation error messages
		messages: {
			oldpassword: {
				required: 'Old password is required',
			},
			newpassword: {
				required: 'New password field is required',
			}
		},
		submitHandler: function(form) {
			jQuery("#successMsgPass").html('');
			jQuery("#errorsDeprtPass").html('');
			var btnText = jQuery("#savedBtnPass").html();
			jQuery("#savedBtnPass").html(btnText + '<i class="fa fa-spinner fa-spin"></i>');
			jQuery("#savedBtnPass").attr("disabled", true);
			var formData = jQuery(form);
			var urls = formData.prop('action');
			jQuery.ajax({
				type: "POST",
				url: urls,
				data: formData.serialize(),
				dataType: 'json',
				success: function(data) {
					if (data.success == true) {
						jQuery("#successMsgPass").html('<p class="inputsuccess">' + data.msg + '</p>');
						jQuery("#successMsgPass").removeClass("hidden");
						jQuery("#errorsDeprtPass").addClass("hidden");
						setTimeout(function() {
							location.reload(true);
						}, 1000);

					} else if(data.success == false){
						jQuery("#errorsDeprtPass").html('<p class="inputerror">' + data.msg + '</p>');
						jQuery("#errorsDeprtPass").removeClass("hidden");
						jQuery("#successMsgPass").addClass("hidden");
						jQuery("#savedBtnPass").html('Update');
						jQuery("#savedBtnPass").attr("disabled", false);
					}
				},
				error: function (jqXHR, exception) {
					var msg = '';
					
					if (jqXHR.status === 302) {
						swal({
							title: "Warning",
							text: "Session timeout!",
							icon: "warning",
						});
						window.location.reload();
					}
					else if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						var errors = jQuery.parseJSON(jqXHR.responseText);
						var erro = '';
						jQuery.each(errors['errors'], function(n, v) {
							erro += '<p class="inputerror">' + v + '</p>';
						});
						jQuery("#errorsDeprtPass").html(erro);
						jQuery("#errorsDeprtPass").removeClass("hidden");
						jQuery("#successMsgPass").addClass("hidden");
						jQuery("#savedBtnPass").html('Update');
						jQuery("#savedBtnPass").attr("disabled", false);
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					console.info(msg);
				}
			});
		}
	}); 
	
});
