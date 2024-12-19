jQuery(document).ready(function() {

	const coursesPostDiv = jQuery('.courses-post-container')
	const lessonsPostDiv = jQuery('.lessons-post-container')
	const topicsPostDiv = jQuery('.topics-post-container')

	function getFilterValues( name ) {
		var checked = []
		jQuery( "input[name='" + name + "[]']:checked" ).each( function() {
			checked.push( jQuery( this ).val() )
		} )
		return checked
	}

	function getFilters() {
		return {
			cats: getFilterValues('cat_filter'),
			tags: getFilterValues('tag_filter'),
		}
	}

	function catAjaxRequest() {
        // console.log(getFilters());
		return jQuery.ajax({
			type: 'POST',
			url: learningmole_ajax_filter.url,
			data: {
				action: 'cat_filter_taxonomy',
				filter: getFilters(),
			},
			beforeSend: function(xhr) {
				coursesPostDiv.html('<div class="spinner"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>')
			},
            success:function(data){
                // console.log(data);
				coursesPostDiv.html(data); // insert data
				jQuery('.pagination').addClass('hidden');
			}
		})
	}

    jQuery('.filter-section').on( 'change', '.tax-filter', function(e) {
		e.preventDefault()
		catAjaxRequest()
	} )

    function ajaxRequest() {
        // console.log(getFilters());
		return jQuery.ajax({
			type: 'POST',
			url: learningmole_ajax_filter.url,
			data: {
				action: 'filter_taxonomy',
				filter: getFilters(),
			},
			beforeSend: function(xhr) {
				lessonsPostDiv.html('<div class="spinner"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>')
			},
            success:function(data){
                // console.log(data);
				lessonsPostDiv.html(data); // insert data
				jQuery('.pagination').addClass('hidden');
			}
		})
	}

    jQuery('.filter-section').on( 'change', '.tax-filter', function(e) {
		e.preventDefault()
		ajaxRequest()
	} )

	function topicAjaxRequest() {
        // console.log(getFilters());
		return jQuery.ajax({
			type: 'POST',
			url: learningmole_ajax_filter.url,
			data: {
				action: 'topic_filter_taxonomy',
				filter: getFilters(),
			},
			beforeSend: function(xhr) {
				topicsPostDiv.html('<div class="spinner"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>')
			},
            success:function(data){
                // console.log(data);
				topicsPostDiv.html(data); // insert data
				jQuery('.pagination').addClass('hidden');
			}
		})
	}

    jQuery('.filter-section').on( 'change', '.tax-filter', function(e) {
		e.preventDefault()
		topicAjaxRequest()
	} )

} )
