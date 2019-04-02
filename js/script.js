jQuery(function($){
	var $modal = $('#editor-modal'),
		$editor = $('#editor'),
		$editorTitle = $('#editor-title'),
		ft = FooTable.init('#locations-overview', {
			columns: $.get("config/columns.json"),
			rows: $.get("config/rows.json"),
			editing: {
				addRow: function(){
					$modal.removeData('row');
					$editor[0].reset();
					$editorTitle.text('Add a new row');
					$modal.modal('show');
				},
				editRow: function(row){
					var values = row.val();
					$editor.find('#id').val(values.id);
					$editor.find('#name').val(values.Name);
					$editor.find('#apb').val(values.Apbnumber);
					$editor.find('#address').val(values.Address);
					$editor.find('#zipcode').val(values.Zipcode);
					$editor.find('#city').val(values.City);
					$editor.find('#phone').val(values.Phone);
					$editor.find('#email').val(values.Email);
					$editor.find('#website').val(values.Website);
					$editor.find('#mon').val(values.Mon);
					$editor.find('#tue').val(values.Tue);
					$editor.find('#wed').val(values.Wed);
					$editor.find('#thu').val(values.Thu);
					$editor.find('#fri').val(values.Fri);
					$editor.find('#sat').val(values.Sat);
					$editor.find('#sun').val(values.Sun);
					$editor.find('#state').val(values.State);
					//$editor.find('#dob').val(values.dob.format('YYYY-MM-DD'));
					$modal.data('row', row);
					$editorTitle.text('Edit row #' + values.Id);
					$modal.modal('show');
				},
				deleteRow: function(row){
					if (confirm('Are you sure you want to delete the row?')){
						row.delete();
					}
				}
			}
		}),
		uid = 10001;

	$editor.on('submit', function(e){
		if (this.checkValidity && !this.checkValidity()) return;
		e.preventDefault();
		var row = $modal.data('row'),
			values = {
				id: $editor.find('#id').val(),
				Name: $editor.find('#name').val(),
				Apbnumber: $editor.find('#apb').val(),
				Address: $editor.find('#address').val(),
				Zipcode: $editor.find('#zipcode').val(),
				City: $editor.find('#city').val(),
				Phone: $editor.find('#phone').val(),
				Email: $editor.find('#email').val(),
				Website: $editor.find('#website').val(),
				Mon: $editor.find('#mon').val(),
				Tue: $editor.find('#tue').val(),
				Wed: $editor.find('#wed').val(),
				Thu: $editor.find('#thu').val(),
				Fri: $editor.find('#fri').val(),
				Sat: $editor.find('#sat').val(),
				Sun: $editor.find('#sun').val(),
				State: $editor.find('#state option:selected').val()
			};

		if (row instanceof FooTable.Row){
			row.val(values);
		} else {
			values.id = uid++;
			ft.rows.add(values);
		}
		$modal.modal('hide');
	});
});