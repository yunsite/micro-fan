function cState()
{
	var len = $.trim($("#entry").val()).length;

	len = 140 - len;

	if( len < 0 )
	{
		$("#input_count").css("color","red");
	}
	else
	{
		$("#input_count").css("color","#333333");
	}

	$("#input_count").html(len);
}
