function ui_sort_asc(id) {
	sort_reset(id, 'asc');
	$(id).removeClass();
	$(id).addClass('sortable asc');
	$(id).removeAttr('data-sort');
	$(id).attr('data-sort', 'asc');
}

function ui_sort_desc(id) {
	sort_reset(id, 'desc');
	$(id).removeClass();
	$(id).addClass('sortable desc');
	$(id).removeAttr('data-sort');
	$(id).attr('data-sort', 'desc');
}

function sort_reset(id, sort) {
	$('.sortable thead tr th').each(function () {
		var id = (this.id);
		if (id != "") {
			var id = "#" + (this.id);
			$(id).removeClass();
			$(id).addClass('sortable');
		}
	});
	var new_class = "sortable " + sort;
	$(id).addClass(new_class);
}

function sort_finish(id, sort) {
	if (sort == "asc") {
		ui_sort_asc(id)
	} else if (sort == "desc") {
		ui_sort_desc(id)
	} else {
		ui_sort_asc(id)
	}
}