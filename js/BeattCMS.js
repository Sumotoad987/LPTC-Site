function tooltipRight(){
	$('[data-toggle="tooltip"]').tooltip({ placement: 'right'});
}

function setValue(input, output, defaultVal){
	var text = input.val();
	if(text == ""){
		output.text(defaultVal);
	}else{
		output.text(text);
	}
}       

function updateOnChange(input, output, defaultVal){
	//or this
	input.keyup(function(){
		setValue(input, output, defaultVal);
	});
	//and this for good measure
	input.change(function(){
		setValue(input, output, defaultVal); //or direct assignment $('#txtHere').html($(this).val());
	});
	setValue(input, output, defaultVal);
}

$( document ).ready(function() {
	$(".item-anchor").click(function (e){
		if($(e.target).is(".in-a-submit")){
			console.log(e.target.parentNode);
			e.preventDefault();
			e.target.parentNode.submit();
		}
	});
	$(".form-submit").click(function (e){		
		e.target.parentNode.submit();
	});
	$(".toolbar-item").click(function (e){	
		var items = $('.toolbar-item');
		for(var i=0; i<items.length; i++){
			$(items[i]).removeClass("selected");
		}
		$(e.target).addClass("selected");
	});
});

function prepareToolbar(){
	var items = $(".toolbar-item");
	for(var i=0; i<items.length; i++){
		previousWidth = typeof(items[i-1]) != "undefined" ? $(items[i-1]).width() : -8;
		$(items[i]).css('right', previousWidth + 9);
	}
}


