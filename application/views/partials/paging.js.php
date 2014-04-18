<script type="text/javascript">
var currentPage = 0;
var viewName = "<?=$page?>";
var totalPages = <?=$pages?>;

function refreshPage() {
	_loadPage(0);
}

function next() {
	if(currentPage >= totalPages - 1) return false;
	_loadPage(++currentPage);
	
	if(currentPage >= totalPages - 1) $('#nav_next').hide();
	$('#nav_back').show();
}

function back() {
	if(currentPage <= 0) return false;
	_loadPage(--currentPage);
	
	if(currentPage <= 0) $('#nav_back').hide();
	$('#nav_next').show();
}

function _loadPage(n){
	$.get("<?=base_url()?>" + viewName + "/" + n.toString())
	.done(function(profiles){
	
		for(var i = 0; i < 6; i++){
			if(profiles[i])
				_replaceCard(i, profiles[i]);
			else
				_clearCard(i);
		}	
	})
	.fail(function(jqxhr, status, err){
		alert("An error occurred: " + err);
	});
}

function _clearCard(i){
	$('#card_' + i).html('');
}

function _replaceCard(i, profile){

	$('#card_' + i).html('\
	<div class="profileCard">\
		<div class="center">\
			<a href="<?=base_url()?>profiles/details/'+profile.userid+'">\
				<div class="avatar">\
					<img src="<?=avatar_url()?>' + profile.userid +'" />' +
					(profile.like ? '<span>&#10084;</span>' : '') +
					(profile.liked ? '<span class="like_me">&#10084;</span>' : '') +
				'</div>\
			</a>\
			<br/>\
			<a href="<?=base_url()?>profiles/details/'+profile.userid+'"><b>' + profile.nickname + '</b></a> ('+profile.age+', '+profile.gender[0].toUpperCase()+')</a>\
		</div>\
		\
		<br/>\
		\
		<b>Personality:</b> '+profile.personality+'<br/>\
		<b>Brands:</b> '+profile.brand_names.slice(0, 5).join(", ")+'<br/><br/>'+
		profile.description +
	'</div>');
}
</script>