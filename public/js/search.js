$("#search").bind("keyup change", function(e) 
{

	
   var keyword = $('#search').val();

   $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

   $.ajax({
	        url: '/search-result',
	        type: "post",
	        data: {'keyword':keyword},
	        success: function(results) 
	        { 

		        $('#search_result').html(results.data);

	        }
	    });
});





