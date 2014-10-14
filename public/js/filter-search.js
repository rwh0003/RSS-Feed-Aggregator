$(document).ready(function() {
	$('.filter-search').keyup(function() {
		var key = $(this).val();
		$('tbody[tab='+$(this).attr('tab')+'] .entry:not(:contains('+key+'))').hide();
		$('tbody[tab='+$(this).attr('tab')+'] .entry:contains('+key+')').show();
	});
});
