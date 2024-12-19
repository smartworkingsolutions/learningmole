jQuery(document).ready(function() {
	// Buttons append to mobile menu.
	jQuery(".header-buttons")
		.clone()
		.removeClass("hidden lg:flex")
		.addClass("grid mt-6")
		.appendTo(".clone")
		.find('.hidden')
		.removeClass('hidden');
	
	jQuery('.wpProQuiz_certificate a').text('PRINT YOUR BADGE');
});

jQuery(document).ready(function() {
    // Show dropdown menu on hover
    jQuery('.menu-item-has-children').hover(function() {
        jQuery(this).find('.dropdown-menu').toggleClass('hidden');
    });

	jQuery('.mega-menu a').on( 'click', function() {
        jQuery(this).parent().find('.mega-menu-container').toggleClass('hidden');
		jQuery(this).parent().find('span.caret').toggleClass('rotate-180');
    });
});

jQuery(document).ready(function($) {
    var contentLoadedLessons = false; // Flag to track whether lessons content is already loaded
    var contentLoadedTopics = false; // Flag to track whether topics content is already loaded

    // Function to trigger AJAX request to fetch lessons
    function fetchLessons() {
        if (!contentLoadedLessons) {
            $.ajax({
                url: learningmole_ajax_filter.url, // WordPress AJAX handler URL
                type: 'POST',
                data: {
                    action: 'fetch_learndash_lessons' // Action to trigger in WordPress
                },
                beforeSend: function(xhr) {
                    $('.ajax-show-lessons').html('<div class="spinner | text-xl flex items-center gap-4">Loading Playlists <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>');
                },
                success: function(response) {
                    $('.ajax-show-lessons').html(response);
                    contentLoadedLessons = true;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }

    // Function to trigger AJAX request to fetch topics
    function fetchTopics() {
        if (!contentLoadedTopics) {
            $.ajax({
                url: learningmole_ajax_filter.url, // WordPress AJAX handler URL
                type: 'POST',
                data: {
                    action: 'fetch_learndash_topics' // Action to trigger in WordPress
                },
                beforeSend: function(xhr) {
                    $('.ajax-show-topics').html('<div class="spinner | text-xl flex items-center gap-4">Loading Video Lessons <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>');
                },
                success: function(response) {
                    $('.ajax-show-topics').html(response);
                    contentLoadedTopics = true;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }

    // Function to check if #lesson or #topic is in the URL
    function checkUrlForLesson() {
        if (window.location.hash === '#lesson' && !contentLoadedLessons) {
            fetchLessons();
        }
        if (window.location.hash === '#topic' && !contentLoadedTopics) {
            fetchTopics();
        }
    }

    // Trigger AJAX request when lesson tab button is clicked
    $('#load-lessons').on('click', function(e) {
        e.preventDefault();
        fetchLessons();
    });

    // Trigger AJAX request when topic tab button is clicked
    $('#load-topics').on('click', function(e) {
        e.preventDefault();
        fetchTopics();
    });

    // Check if #lesson or #topic is in the URL on page load
    checkUrlForLesson();
});

// Validate the password field in Register Form.
document.getElementById('custom-registration-form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const passwordError = document.getElementById('password-error');

    // Regular expression to validate password criteria
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!passwordPattern.test(password)) {
        e.preventDefault(); // Prevent form submission
        passwordError.classList.remove('hidden');
        passwordError.classList.add('grid');
    } else {
        passwordError.classList.add('hidden');
        passwordError.classList.remove('grid');
    }
});
