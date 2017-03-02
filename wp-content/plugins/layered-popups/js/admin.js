function ulp_reset_cookie() {
	jQuery("#ulp-reset-loading").fadeIn(350);
	var data = {action: "ulp_reset_cookie"};
	jQuery.post(ulp_ajax_handler, data, function(data) {
		jQuery("#ulp-reset-loading").fadeOut(350);
	});
	return false;
}
function ulp_save_settings() {
	jQuery(".ulp-popup-form").find("#ulp-save-loading").fadeIn(350);
	jQuery(".ulp-popup-form").find(".ulp-message").slideUp(350);
	jQuery(".ulp-popup-form").find(".ulp-button").attr("disabled", "disabled");
	jQuery.post(ulp_ajax_handler, 
		jQuery(".ulp-popup-form").serialize(),
		function(return_data) {
			//alert(return_data);
			jQuery(".ulp-popup-form").find("#ulp-save-loading").fadeOut(350);
			jQuery(".ulp-popup-form").find(".ulp-button").removeAttr("disabled");
			var data;
			try {
				var data = jQuery.parseJSON(return_data);
				var status = data.status;
				if (status == "OK") {
					location.href = data.return_url;
				} else if (status == "ERROR") {
					jQuery(".ulp-popup-form").find(".ulp-message").html(data.message);
					jQuery(".ulp-popup-form").find(".ulp-message").slideDown(350);
				} else {
					jQuery(".ulp-popup-form").find(".ulp-message").html("Service is not available.");
					jQuery(".ulp-popup-form").find(".ulp-message").slideDown(350);
				}
			} catch(error) {
				jQuery(".ulp-popup-form").find(".ulp-message").html("Service is not available.");
				jQuery(".ulp-popup-form").find(".ulp-message").slideDown(350);
			}
		}
	);
	return false;
}

function ulp_save_campaign() {
	jQuery(".ulp-campaign-form").find(".ulp-loading").fadeIn(350);
	jQuery(".ulp-campaign-form").find(".ulp-message").slideUp(350);
	jQuery(".ulp-campaign-form").find(".ulp-button").attr("disabled", "disabled");
	jQuery.post(ulp_ajax_handler, 
		jQuery(".ulp-campaign-form").serialize(),
		function(return_data) {
			//alert(return_data);
			jQuery(".ulp-campaign-form").find(".ulp-loading").fadeOut(350);
			jQuery(".ulp-campaign-form").find(".ulp-button").removeAttr("disabled");
			var data;
			try {
				var data = jQuery.parseJSON(return_data);
				var status = data.status;
				if (status == "OK") {
					location.href = data.return_url;
				} else if (status == "ERROR") {
					jQuery(".ulp-campaign-form").find(".ulp-message").html(data.message);
					jQuery(".ulp-campaign-form").find(".ulp-message").slideDown(350);
				} else {
					jQuery(".ulp-campaign-form").find(".ulp-message").html("Service is not available.");
					jQuery(".ulp-campaign-form").find(".ulp-message").slideDown(350);
				}
			} catch(error) {
				jQuery(".ulp-campaign-form").find(".ulp-message").html("Service is not available.");
				jQuery(".ulp-campaign-form").find(".ulp-message").slideDown(350);
			}
		}
	);
	return false;
}

function ulp_save_popup() {
	jQuery(".ulp-popup-form").find("#ulp-loading").fadeIn(350);
	jQuery(".ulp-popup-form").find("#ulp-message").slideUp(350);
	jQuery(".ulp-popup-form").find(".ulp-button").attr("disabled", "disabled");
	jQuery.post(ulp_ajax_handler, 
		jQuery(".ulp-popup-form").serialize(),
		function(return_data) {
			//alert(return_data);
			jQuery(".ulp-popup-form").find("#ulp-loading").fadeOut(350);
			jQuery(".ulp-popup-form").find(".ulp-button").removeAttr("disabled");
			var data;
			try {
				var data = jQuery.parseJSON(return_data);
				var status = data.status;
				if (status == "OK") {
					location.href = data.return_url;
				} else if (status == "ERROR") {
					jQuery(".ulp-popup-form").find("#ulp-message").html(data.message);
					jQuery(".ulp-popup-form").find("#ulp-message").slideDown(350);
				} else {
					jQuery(".ulp-popup-form").find("#ulp-message").html("Service is not available.");
					jQuery(".ulp-popup-form").find("#ulp-message").slideDown(350);
				}
			} catch(error) {
				jQuery(".ulp-popup-form").find("#ulp-message").html("Service is not available.");
				jQuery(".ulp-popup-form").find("#ulp-message").slideDown(350);
			}
		}
	);
	return false;
}
function ulp_add_layer() {
	jQuery("#ulp-overlay").fadeIn(350);
	jQuery("#ulp-new-layer").append(jQuery(".ulp-layer-options"));
	jQuery.each(ulp_default_layer_options, function(key, value) {
		if (key == "scrollbar" || key == "confirmation_layer" || key == "inline_disable") {
			if (value == "on") jQuery("[name=\'ulp_layer_"+key+"\']").attr("checked", "checked");
			else jQuery("[name=\'ulp_layer_"+key+"\']").removeAttr("checked");
		} else jQuery("[name=\'ulp_layer_"+key+"\']").val(value);
	});
	jQuery("[name=\'ulp_layer_id\']").val("0");
	ulp_active_layer = 0;
	jQuery("#ulp-new-layer").slideDown(350);
	return false;
}
function ulp_edit_layer(object) {
	var layer_item_id = jQuery(object).parentsUntil(".ulp-layers-item").parent().attr("id");
	layer_item_id = layer_item_id.replace("ulp-layer-", "");
	jQuery("#ulp-overlay").fadeIn(350);
	jQuery("#ulp-edit-layer-"+layer_item_id).append(jQuery(".ulp-layer-options"));
	jQuery.each(ulp_default_layer_options, function(key, value) {
		if (key == "scrollbar" || key == "confirmation_layer" || key == "inline_disable") {
			if (jQuery("[name=\'ulp_layer_"+layer_item_id+"_"+key+"\']").val() == "on") jQuery("[name=\'ulp_layer_"+key+"\']").attr("checked", "checked");
			else jQuery("[name=\'ulp_layer_"+key+"\']").removeAttr("checked");
		} else jQuery("[name=\'ulp_layer_"+key+"\']").val(jQuery("[name=\'ulp_layer_"+layer_item_id+"_"+key+"\']").val());
	});
	jQuery("[name=\'ulp_layer_id\']").val(layer_item_id);
	ulp_active_layer = layer_item_id;
	jQuery("#ulp-preview-layer-"+layer_item_id).addClass("ulp-preview-layer-active");
	jQuery("#ulp-edit-layer-"+layer_item_id).slideDown(350);
	return false;
}
function ulp_delete_layer(object) {
	var answer = confirm("Do you really want to remove this layer?")
	if (answer) {
		var layer_item_id = jQuery(object).parentsUntil(".ulp-layers-item").parent().attr("id");
		layer_item_id = layer_item_id.replace("ulp-layer-", "");
		jQuery("#ulp-edit-layer-"+layer_item_id).remove();
		jQuery("#ulp-layer-"+layer_item_id).fadeOut(350, function() {
			jQuery("#ulp-layer-"+layer_item_id).remove();
			jQuery.post(ulp_ajax_handler, 
				"action=ulp_delete_layer&ulp_layer_id="+layer_item_id,
				function(return_data) {
					ulp_build_preview();
				}
			);
		});
	}
	return false;
}
function ulp_copy_layer(object) {
	var answer = confirm("Do you really want to duplicate this layer?")
	if (answer) {
		var layer_item_id = jQuery(object).parentsUntil(".ulp-layers-item").parent().attr("id");
		layer_item_id = layer_item_id.replace("ulp-layer-", "");
		jQuery.post(ulp_ajax_handler, 
			"action=ulp_copy_layer&ulp_layer_id="+layer_item_id,
			function(return_data) {
				var data = jQuery.parseJSON(return_data);
				var status = data.status;
				if (status == "OK") {
					jQuery("#ulp-layers-data").append("<section class=\'ulp-layers-item\' id=\'ulp-layer-"+data.layer_id+"\' style=\'display: none;\'></section><div class=\'ulp-edit-layer\' id=\'ulp-edit-layer-"+data.layer_id+"\'></div>");
					jQuery("#ulp-layer-"+data.layer_id).html(jQuery("#ulp-layers-item-container").html());
					jQuery("#ulp-layer-"+data.layer_id).find("h4").html(data.title);
					jQuery("#ulp-layer-"+data.layer_id).find("p").html(data.content);
					jQuery("#ulp-layer-"+data.layer_id).append(data.options_html);
					jQuery("#ulp-layer-"+data.layer_id).slideDown(350);
					ulp_build_preview();
				}
			}
		);
	}
	return false;
}
function ulp_cancel_layer(object) {
	jQuery("#ulp-overlay").fadeOut(350);
	var container = jQuery(object).parentsUntil(".ulp-layer-options").parent().parent();
	jQuery("#"+jQuery(container).attr("id")).slideUp(350, function() {
		jQuery("#ulp-layer-options-container").append(jQuery(".ulp-layer-options"));
		jQuery(".ulp-preview-layer-active").removeClass(".ulp-preview-layer-active");
		ulp_active_layer = -1;
		ulp_build_preview();
	});
	return false;
}
function ulp_save_layer() {
	jQuery(".ulp-layer-options").find(".ulp-loading").fadeIn(350);
	jQuery(".ulp-layer-options").find(".ulp-message").slideUp(350);
	jQuery(".ulp-layer-options").find(".ulp-button").attr("disabled", "disabled");
	jQuery.post(ulp_ajax_handler, 
		jQuery(".ulp-layer-options input, .ulp-layer-options select, .ulp-layer-options textarea").serialize(),
		function(return_data) {
			//alert(return_data);
			jQuery(".ulp-layer-options").find(".ulp-loading").fadeOut(350);
			jQuery(".ulp-layer-options").find(".ulp-button").removeAttr("disabled");
			var data;
			try {
				var data = jQuery.parseJSON(return_data);
				var status = data.status;
				if (status == "OK") {
					jQuery("#ulp-overlay").fadeOut(350);
					if(jQuery("#ulp-layers-data").find("#ulp-layer-"+data.layer_id).length == 0) {
						jQuery("#ulp-new-layer").slideUp(350, function() {
							jQuery("#ulp-layer-options-container").append(jQuery(".ulp-layer-options"));
						});
						jQuery("#ulp-layers-data").append("<section class=\'ulp-layers-item\' id=\'ulp-layer-"+data.layer_id+"\' style=\'display: none;\'></section><div class=\'ulp-edit-layer\' id=\'ulp-edit-layer-"+data.layer_id+"\'></div>");
						jQuery("#ulp-layer-"+data.layer_id).html(jQuery("#ulp-layers-item-container").html());
						jQuery("#ulp-layer-"+data.layer_id).find("h4").html(data.title);
						jQuery("#ulp-layer-"+data.layer_id).find("p").html(data.content);
						jQuery("#ulp-layer-"+data.layer_id).append(data.options_html);
						jQuery("#ulp-layer-"+data.layer_id).slideDown(350);
						ulp_active_layer = -1;
						jQuery(".ulp-preview-layer-active").removeClass(".ulp-preview-layer-active");
						ulp_build_preview();
					} else {
						jQuery("#ulp-edit-layer-"+data.layer_id).slideUp(350, function() {
							jQuery("#ulp-layer-options-container").append(jQuery(".ulp-layer-options"));
						});
						jQuery("#ulp-layer-"+data.layer_id).fadeOut(350, function() {
							jQuery("#ulp-layer-"+data.layer_id).html(jQuery("#ulp-layers-item-container").html());
							jQuery("#ulp-layer-"+data.layer_id).find("h4").html(data.title);
							jQuery("#ulp-layer-"+data.layer_id).find("p").html(data.content);
							jQuery("#ulp-layer-"+data.layer_id).append(data.options_html);
							jQuery("#ulp-layer-"+data.layer_id).fadeIn(350);
							ulp_active_layer = -1;
							jQuery(".ulp-preview-layer-active").removeClass(".ulp-preview-layer-active");
							ulp_build_preview();
						});
					}
				} else if (status == "ERROR") {
					jQuery(".ulp-layer-options").find(".ulp-message").html(data.message);
					jQuery(".ulp-layer-options").find(".ulp-message").slideDown(350);
				} else {
					jQuery(".ulp-layer-options").find(".ulp-message").html("Service is not available.");
					jQuery(".ulp-layer-options").find(".ulp-message").slideDown(350);
				}
			} catch(error) {
				jQuery(".ulp-layer-options").find(".ulp-message").html("Service is not available.");
				jQuery(".ulp-layer-options").find(".ulp-message").slideDown(350);
			}
		}
	);
	return false;
}

function ulp_save_ext_settings() {
	jQuery(".ulp-popup-form").find(".ulp-loading").fadeIn(350);
	jQuery(".ulp-popup-form").find(".ulp-message").slideUp(350);
	jQuery(".ulp-popup-form").find(".ulp-button").attr("disabled", "disabled");
	jQuery.post(ulp_ajax_handler, 
		jQuery(".ulp-popup-form").serialize(),
		function(return_data) {
			//alert(return_data);
			jQuery(".ulp-popup-form").find(".ulp-loading").fadeOut(350);
			jQuery(".ulp-popup-form").find(".ulp-button").removeAttr("disabled");
			var data;
			try {
				var data = jQuery.parseJSON(return_data);
				var status = data.status;
				if (status == "OK") {
					location.href = data.return_url;
				} else if (status == "ERROR") {
					jQuery(".ulp-popup-form").find(".ulp-message").html(data.message);
					jQuery(".ulp-popup-form").find(".ulp-message").slideDown(350);
				} else {
					jQuery(".ulp-popup-form").find(".ulp-message").html("Service is not available.");
					jQuery(".ulp-popup-form").find(".ulp-message").slideDown(350);
				}
			} catch(error) {
				jQuery(".ulp-popup-form").find(".ulp-message").html("Service is not available.");
				jQuery(".ulp-popup-form").find(".ulp-message").slideDown(350);
			}
		}
	);
	return false;
}
function ulp_submitOperation() {
	var answer = confirm("Do you really want to continue?")
	if (answer) return true;
	else return false;
}
function ulp_utf8encode(string) {
	string = string.replace(/\x0d\x0a/g, "\x0a");
	var output = "";
	for (var n = 0; n < string.length; n++) {
		var c = string.charCodeAt(n);
		if (c < 128) {
			output += String.fromCharCode(c);
		} else if ((c > 127) && (c < 2048)) {
			output += String.fromCharCode((c >> 6) | 192);
			output += String.fromCharCode((c & 63) | 128);
		} else {
			output += String.fromCharCode((c >> 12) | 224);
			output += String.fromCharCode(((c >> 6) & 63) | 128);
			output += String.fromCharCode((c & 63) | 128);
		}
	}
	return output;
}
function ulp_encode64(input) {
	var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	var output = "";
	var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
	var i = 0;
	input = ulp_utf8encode(input);
	while (i < input.length) {
		chr1 = input.charCodeAt(i++);
		chr2 = input.charCodeAt(i++);
		chr3 = input.charCodeAt(i++);
		enc1 = chr1 >> 2;
		enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
		enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
		enc4 = chr3 & 63;
		if (isNaN(chr2)) {
			enc3 = enc4 = 64;
		} else if (isNaN(chr3)) {
			enc4 = 64;
		}
		output = output + keyString.charAt(enc1) + keyString.charAt(enc2) + keyString.charAt(enc3) + keyString.charAt(enc4);
	}
	return output;
}
function ulp_utf8decode(input) {
	var string = "";
	var i = 0;
	var c = c1 = c2 = 0;
	while ( i < input.length ) {
		c = input.charCodeAt(i);
		if (c < 128) {
			string += String.fromCharCode(c);
			i++;
		} else if ((c > 191) && (c < 224)) {
			c2 = input.charCodeAt(i+1);
			string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
			i += 2;
		} else {
			c2 = input.charCodeAt(i+1);
			c3 = input.charCodeAt(i+2);
			string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
			i += 3;
		}
	}
	return string;
}
function ulp_decode64(input) {
	var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	var output = "";
	var chr1, chr2, chr3;
	var enc1, enc2, enc3, enc4;
	var i = 0;
	input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
	while (i < input.length) {
		enc1 = keyString.indexOf(input.charAt(i++));
		enc2 = keyString.indexOf(input.charAt(i++));
		enc3 = keyString.indexOf(input.charAt(i++));
		enc4 = keyString.indexOf(input.charAt(i++));
		chr1 = (enc1 << 2) | (enc2 >> 4);
		chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
		chr3 = ((enc3 & 3) << 6) | enc4;
		output = output + String.fromCharCode(chr1);
		if (enc3 != 64) {
			output = output + String.fromCharCode(chr2);
		}
		if (enc4 != 64) {
			output = output + String.fromCharCode(chr3);
		}
	}
	output = ulp_utf8decode(output);
	return output;
}
function ulp_2hex(c) {
	var hex = c.toString(16);
	return hex.length == 1 ? "0" + hex : hex;
}
function ulp_rgb2hex(r, g, b) {
	return "#" + ulp_2hex(r) + ulp_2hex(g) + ulp_2hex(b);
}
function ulp_hex2rgb(hex) {
	var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
	hex = hex.replace(shorthandRegex, function(m, r, g, b) {
		return r + r + g + g + b + b;
	});
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? {
		r: parseInt(result[1], 16),
		g: parseInt(result[2], 16),
		b: parseInt(result[3], 16)
	} : false;
}
function ulp_inarray(needle, haystack) {
	var length = haystack.length;
	for(var i = 0; i < length; i++) {
		if(haystack[i] == needle) return true;
	}
	return false;
}
function ulp_self_close() {
	return false;
}
function ulp_seticon(object, prefix) {
	var icon = jQuery(object).children().attr("class");
	icon = icon.replace("fa ", "");
	jQuery("#"+prefix).val(icon);
	jQuery("#"+prefix+"-image i").removeClass();
	jQuery("#"+prefix+"-image i").addClass("fa "+icon);
	jQuery("#"+prefix+"-set .ulp-icon-active").removeClass("ulp-icon-active");
	jQuery(object).addClass("ulp-icon-active");
	jQuery("#"+prefix+"-set").slideUp(300);
	ulp_build_preview();
}
function ulp_customfields_addfield(field_type) {
	jQuery("#ulp-customfields-loading").fadeIn(350);
	jQuery("#ulp-customfields-message").slideUp(350);
	jQuery("#ulp-customfields-selector").toggle(200);
	jQuery("#ulp-customfields-selector").attr("disabled", "disabled");
	jQuery.post(ulp_ajax_handler, 
		"action=ulp-customfields-addfield&ulp_type="+field_type,
		function(return_data) {
			//alert(return_data);
			jQuery("#ulp-customfields-loading").fadeOut(350);
			jQuery("#ulp-customfields-selector").removeAttr("disabled");
			var data;
			try {
				var data = jQuery.parseJSON(return_data);
				var status = data.status;
				if (status == "OK") {
					jQuery("#ulp-customfields").append(data.html);
					jQuery("#ulp-customfields-field-"+data.id).slideDown(350);
				} else if (status == "ERROR") {
					jQuery("#ulp-customfields-message").html(data.message);
					jQuery("#ulp-customfields-message").slideDown(350);
				} else {
					jQuery("#ulp-customfields-message").html("Service is not available.");
					jQuery("#ulp-customfields-message").slideDown(350);
				}
			} catch(error) {
				jQuery("#ulp-customfields-message").html("Service is not available.");
				jQuery("#ulp-customfields-message").slideDown(350);
			}
		}
	);
	return false;
}
function ulp_delete_custom_field(field_id) {
	jQuery("#ulp-customfields-field-"+field_id).slideUp(350, function() {
		jQuery("#ulp-customfields-field-"+field_id).remove();
		ulp_build_preview();
	});
	return false;
}
function ulp_escape_html(text) {
	var map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#039;'
	};
	return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}