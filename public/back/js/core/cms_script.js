$(function(){

	function delete_confirm(title){
		if(title === '' || title === null){ title = 'Are you sure ?'; }		
		bootbox.confirm(title,function(res){
			console.log(res);
		});		
	}

});