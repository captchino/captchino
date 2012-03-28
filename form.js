/*
# Captchino - eye appealing, easy, modular captcha
#
# iVar < http://ivartech.com > - March 2012.
# See AUTHORS for author information.
# See COPYING for licence information.
#
# Drives the form events and requests verification from verify.php
# Current structure is only for demo purposes. Change it as you like.
*/

function sendMessage()
{
	clearErrors();
	var email = $("#message-email").val();
	var subject = $("#message-subject").val();
	var text = $("#message-text").val();
	var captcha = $("#message-captcha").val();
	
	if(validateFields(email, subject, text, captcha))
	{
		var url = "verify.php?" + jQuery.param({
			email: email, 
			subject: subject, 
			text: text, 
			captcha: captcha});
			
		jQuery.ajax(url, {
			dataType: "json",
			success: function(response)
			{
				if(response.status == "ok")
				{
					$("#message-sent").slideDown("fast");
					newCaptcha();
					if(onMessageSent != undefined)
						onMessageSent(response);
				}
				else
				{
					for(var i in response.errors)
					{
						appendError(response.errors[i][1]);
						if(onMessageError != undefined)
							onMessageError(response.errors[i]);
					}
					showErrors();
					newCaptcha();
				}
				
			},
			error: function(e)
			{
				appendError("Sending failed. Please try again later. Error : " + e.responseText);
				showErrors();
				newCaptcha();
			}
		});
	}
}

function validateFields(email, subject, text, captcha)
{
	/**client side validacija**/
	return true;
}

function clearErrors()
{
	$("#message-errors ul").empty();
	$("#message-errors").hide();
	$("#message-sent").hide();
}

function newCaptcha()
{
	$("#message-captcha").val('');
	$("#captcha .captcha-container").empty().append($("<img src=\"captchino.php?size=28\"/>"));
	
}

function showErrors()
{
	$("#message-errors").slideDown("fast");
}

function appendError(error)
{
	$('#message-errors ul').append('<li>'+error+'</li>');
}

function onMessageError(response) {
		$('.'+response[0]).addClass('error');
		$('.'+response[0]+' .controls').append('<span class="help-inline">'+ response[1] +'</span>');
}

$(document).ready(function()
{
	clearErrors();
	newCaptcha();
	
	$('.close').click(function() {
		$(this).parent().hide();
	});
	
	$('input,textarea').focus(function() {
		var ctrlgrp = $(this).parent().parent();
		console.log($(ctrlgrp).html());
		if($(ctrlgrp).hasClass('error')) {
			$(ctrlgrp).removeClass('error');
			$(ctrlgrp).find('.help-inline').remove();
		}
	});
});

