/*!
 * Developer (mtc) : Kwabena A. Dougan
 *
 * Includes Ajax.js
 * 
 *
 * Copyright Luci Foundation and other contributors
 * Released under the MIT license
 *
 * Date: 2017-11-05T19:26TM
 */

function get(x){
		return document.getElementById(x);
}
function ajaxObj(math,url ) {
	var x = new XMLHttpRequest();
	x.open(math, url, true );
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	return x;
}
function ajaxReturn(x){
	if(x.readyState == 4 && x.status == 200){
		return true;
	}
}