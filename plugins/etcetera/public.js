( function( $ ) {
	'use strict';

	$(document).ready(function() {
		clearAll();
		$('#clear-all').on('click', clearAll);
				
		sessionStorage.setItem( "filterQuery", $('.etcetera-real-estate-container').data('query') );
		loadRealEstates();
		
		$(document).on('click', '.load-more', function(event) {
			loadRealEstates();
		});
		
		$(document).on('submit', '#etcetera-form', function(event) {
			event.preventDefault();			
			let self = $(this);
// 			console.log( self.serializeArray() );
			sessionStorage.setItem( "filterQuery", JSON.stringify( self.serializeArray() ) );
			let filterData = sessionStorage.getItem( "filterQuery" );

			$('.etcetera-real-estate-container ul').empty();
			loadRealEstates();
			return false;
		});
	});

	function loadRealEstates() {
// 		console.log( $('.etcetera-real-estate-container').data('numberposts') );

		$.ajax({
			url: etcHelper.ajaxUrl,
			data: {
				'action': 'load_real_estate',
				'nonce': etcHelper.security,
				'offset': $('.etcetera-real-estate-container li').length,
				'numberposts': $('.etcetera-real-estate-container').data('numberposts'),
				'formData': sessionStorage.getItem("filterQuery"),
			},
			beforeSend : function() {
				$('.etcetera-real-estate-container').addClass('freeze-while-load');
			},
			success: function( result ){
				let parsed = JSON.parse(result);
// 				console.log( parsed );
				$('.etcetera-real-estate-container').removeClass('freeze-while-load');
				$('.etcetera-real-estate-container ul').append( parsed['html'] );

				if ( parsed['total'] <= $('.etcetera-real-estate-container li').length ) {
					$('.load-more').hide();
				} else {
					$('.load-more').show();
				}
				return false;
			},
			error: function (request, status, error) {
				console.log(request, status, error);
				$('.etcetera-real-estate-container').removeClass('wait');
				return false;
			}
		});
	}
	
	function clearAll() {
		$('#etcetera-form input[type=text], #etcetera-form input[type=number]').removeAttr('value');
		$('#etcetera-form select').val('');
		$('#etcetera-form input[type=radio]').prop("checked", false);
	}
	
} )( jQuery );