var jsonData = [];

function setupQuotes(file){
	var jsonObj = new XMLHttpRequest();
	jsonObj.addEventListener("load", reqListener);
	jsonObj.open("GET", file);
	jsonObj.send();
}

function reqListener(){
		jsonData = JSON.parse(this.responseText);
		newQuote();
}

function newQuote(){
	var Qnumber = Math.floor(Math.random() * jsonData["quotes"].length)
	document.getElementById("Quote").innerHTML = '"' + jsonData["quotes"][Qnumber]["Quote"] + '"';
	document.getElementById("Source").innerHTML = '-' + jsonData["quotes"][Qnumber]["Source"];
	setTimeout(newQuote, 9000);
}