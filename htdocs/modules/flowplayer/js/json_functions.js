/**
 * Function for lodging player with content and block. 
 */

function flowplayer_dojson_player(xoops_url, dirname, resolve, useragent) {
	var params = new Array();
 	$.getJSON(xoops_url+"/modules/"+dirname+"/dojson_player.php?resolve="+resolve+"&useragent="+useragent, params, flowplayerdisplayplayer);
}

