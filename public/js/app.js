function Model() {

	this.api = 'app.php';

	this.list = function(cb){
		$.getJSON(this.api+'/wish', null, cb);
	};

	this.reserve = function(id, email, cb, onFail){
		var data = {
			id: id,
			email: email
		};
		$.post(this.api+'/reserve', data, cb, 'json').fail(onFail);
	};

	this.cancel = function(id, email, code, cb, onFail){
		var data = {
			id: id,
			email: email,
			code: code
		};
		$.post(this.api+'/cancel', data, cb, 'json').fail(onFail);
	};

}

function App() {
	app = this;

	this.model = new Model();

	var initList = function(list) {
		var items = [];
		$.each(list, function(key,val) {
			items.push('<li id="'+val.id+'">' + val.description + '</li>');
		});
		$('#list').html($('<ul/>', { html: items.join('') }));
	}
	this.model.list(initList);

	this.dialog = $('#dialog-form').dialog({
		autoOpen: false,
		modal: true,
		height: 200,
		width: 400,
		buttons: {
			'Igen!': function(){
				app.onSubmit();
			},
			'Mégsem': function(){
				app.dialog.dialog('close');
			}
		}
	});

	this.thx = $('#dialog-thx').dialog({
		autoOpen: false,
		modal: true,
		height: 200,
		width: 250,
		buttons: {
			'Bezárás': function(){
				app.thx.dialog('close');
			}
		},
		close: function(){
			app.model.list(initList);
		}
	});

	this.cancelDialog = $('#dialog-cancel').dialog({
		autoOpen: false,
		modal: true,
		height: 200,
		width: 450,
		buttons: {
			'Bezárás': function(){
				app.cancelDialog.dialog('close');
			}
		},
		close: function(){
			app.model.list(initList);
		}
	});

	$('#list').on('click', 'li', function(){
		var id = $(this).attr('id');
		var text = $(this).html();
		$('#dialog-form input[name=id]').val(id);
		app.dialog.dialog('option','title',text);
		app.dialog.dialog('open');
	});

	this.onSubmit = function() {
		var id = $('#dialog-form input[name=id]').val();
		var email = $('#dialog-form input[name=email]').val();
		app.model.reserve(id, email, app.submitted, app.onFail);
		app.dialog.dialog('close');
	};

	this.submitted = function() {
		app.thx.dialog('open');
	};

	this.emailPattern = new RegExp("^[^@]+@[^@]+$");
	this.verifyEmail = function() {
		var email = $('#dialog-form input[name=email]').val();
		var valid = app.emailPattern.test(email);
		$('#dialog-form').closest('.ui-widget').find('.ui-dialog-buttonset button:first-of-type').prop('disabled', !valid);
	};

	$('#dialog-form').on('keypress change focus', 'input[name=email]', this.verifyEmail);

	this.handleUrlRequest = function(param) {
		var m = decodeURIComponent(param).match(/^#cancel\|(.*)\|(.*)\|(.*)/);
		if (m) {
			app.model.cancel(m[1],m[2],m[3],app.onCancel, app.onFail);
		}
	};

	this.onCancel = function() {
		app.cancelDialog.dialog('open');
	};

	this.onFail = function() {
		alert('Valami hiba történt, keresd meg vele Csabát!');
	};

}
