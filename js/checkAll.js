function checkAll(){
var boxes = document.getElementsByTagName("input");
	for (var i = 0; i < boxes.length; i++) {
	myType = boxes[i].getAttribute("type");
		if ( myType == "checkbox") {
		boxes[i].checked=1;
		}
	}
}
function checkNone(){
	var boxes = document.getElementsByTagName("input");
	for (var i = 0; i < boxes.length; i++) {
	myType = boxes[i].getAttribute("type");
		if ( myType == "checkbox") {
		boxes[i].checked=0;
		}
	}
}
