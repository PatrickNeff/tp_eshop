$(document).ready(function()
{
	$(".check").click(function()
	{
	    $(this).parent().siblings(".stock").children().removeAttr('disabled');
	});
});