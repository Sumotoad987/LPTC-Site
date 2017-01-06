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