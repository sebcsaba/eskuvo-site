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
		$.getJSON(this.api, data, cb);
	};

}

function App() {

	this.model = new Model();

	var initList = function(list) {
		var items = [];
		$.each(list, function(key,val) {
			items.push('<li id="'+val.id+'">' + val.description + '</li>');
		});
		$('<ul/>', { html: items.join('') }).appendTo('#list');
	}
	this.model.list(initList);

}
