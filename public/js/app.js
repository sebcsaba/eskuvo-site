function Model() {

	this.api = 'app.php';

	this.list = function(cb){
		$.getJSON(this.api+'/wish', null, cb);
	};

	this.reserve = function(id, email, cb){
		var data = {
			id: id,
			email: email
		};
//		$.getJSON(this.api+'/reserve', data, cb);
		cb();
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
			'Lefoglalom!': function(){
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
		app.model.reserve(id, email, function(){
			app.submitted();
		});
		app.dialog.dialog('close');
	};

	this.submitted = function() {
		app.thx.dialog('open');
	};
}
