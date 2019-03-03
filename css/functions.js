function toggleTbody(id) {
	if (document.getElementById) {
		var tbod = document.getElementById(id);
			if (tbod && typeof tbod.className == 'string') {
				if (tbod.className == 'off') {
					tbod.className = 'on';
				} else {
					tbod.className = 'off';
				}
			}
		}
	return false;
}

function optionsWin(path) {
	var imgWindow = window.open(path, 'slideshow', 'scrollbars=yes,titlebar=yes,location=no,status=no,toolbar=no,resizable=yes,width=880,height=600');
	imgWindow.focus();
}

function editInfoWin(path) {
	var imgWindow = window.open(path, 'slideshow', 'scrollbars=yes,titlebar=yes,location=no,status=no,toolbar=no,resizable=yes,width=750,height=625');
	imgWindow.focus();
}

function userCodeWin(path) {
	var imgWindow = window.open(path, 'slideshow', 'scrollbars=yes,titlebar=no,location=no,status=no,toolbar=no,resizable=yes,width=400,height=400');
	imgWindow.focus();
}

//Accepts two parameters: The first of which is the check_all_box - it should be a 
//FIELD level reference to your checkbox (not a form or a checked status or a value).
// If you use the onchange method to switch it like I do then all you need to do is 
//pass the ‘this’ keyword to it. See my example below.
//Parameter two is the obj_set_name which is the name of the "object set" or the name 
//you use for your checkbox list. This is what allows the use of multiple lists on one page.
function switchSetting(check_all_box, obj_set_name)
{
	var selection_status = check_all_box.checked;

//This is weird because intuitivly, once you click it the first time it would be 
//true - for some reason javascript hasn’t yet registered the click so it still thinks it is false.
//This also occurs if the box is already checked - javascript still thinks its checked 
//even after you click it.
	if(selection_status == false){
		uncheckAll(obj_set_name);
	}
	else{
		checkAll(obj_set_name);
	}
}

function checkAll(obj_set_name){
	var checkboxes = document.getElementsByName(obj_set_name);
	var total_boxes = checkboxes.length;

	for(i=0; i<total_boxes; i++ ){
		current_value = checkboxes[i].checked;

		if(current_value == false){
			checkboxes[i].checked = true;
		}
	}
}


function uncheckAll(obj_set_name){
	var checkboxes = document.getElementsByName(obj_set_name);
	var total_boxes = checkboxes.length;

	for(i=0; i<total_boxes; i++ ){
		current_value = checkboxes[i].checked;

		if(current_value == true){
			checkboxes[i].checked = false;
		}
	}
}

function hideUnhideDiv(what){
	if(document.getElementById(what).style.display=="none"){
		document.getElementById(what).style.display="block";
	}
	else if(document.getElementById(what).style.display=="block"){
		document.getElementById(what).style.display="none";
	}
}
