
	$(".autocompleteStart").click(function(){
		var parentElem = $(this).parent();
		var str = null;
		var teacherID = null;
		var programID = null;
		$(this).toggleClass('hidden');
		parentElem.find('.autocompleteForm').toggleClass('hidden');
		parentElem.find('.autocomplete').autocomplete({
				serviceUrl: 'index.php?r=ajax/data',
				onSelect: function (suggestion) {
				str = suggestion.value;
				teacherID = suggestion.data;
				programID = parentElem.parent().parent().attr('data-key');
				console.log(str + ' ' + teacherID + ' ' + programID);
				},
		});
		parentElem.find('.autocompleteButton').click(function(){
			$.ajax('index.php?r=ajax/process', {
				data: {
					program_id: programID,
					teacher_id: teacherID,
				},
				success: function(data){
					parentElem.find('.autocompleteForm').html(data);
				},
				error: function(data){
					parentElem.find('.autocompleteForm').html('Error!');
				},
			});
		});
	});




