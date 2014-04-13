<h1><?=$title?></h1>

<script type="text/javascript">
var currentPage = 1;
var viewName = "<?=$page?>";
var totalPages = <?=$pages?>;

function next() {
	if(currentPage >= totalPages - 1) return false;
	_loadPage(++currentPage);
}

function back() {
	if(currentPage <= 0) return false;
	_loadPage(--currentPage);
}

function _loadPage(n){
	$.get("<?=base_url()?>" + viewName + "/" + n.toString())
	.done(function(profiles){
	
		for(var i = 0; i < Math.min(profiles.length, 6); i++){
			_replaceCard(i, profiles[i]);
		}	
	})
	.fail(function(jqxhr, status, err){
		alert("An error occurred: " + err);
	});
}

function _replaceCard(i, profile){

	$('#card_' + i).html('\
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
		profile.description);
}
</script>


<?php 
$this->load->view('partials/profile_cards', array('profiles' => $profiles));
?>

<a href="#" onclick="back(); return false;" class="hidden">&lsaquo; Previous page</a>
<a href="#" onclick="next(); return false;" class="right<?php if($pages <= 1) { echo ' hidden'; } ?>">Next page &rsaquo;</a>