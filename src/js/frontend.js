;(function ($) {
    const app = {
        init: function () {
            //Handle ajax search delay 500ms
            let timer;
            $('.wptoffeedocs-search-field').on('keyup', function () {
                clearTimeout(timer);

                timer = setTimeout(function () {
                    app.handleSearch();
                }, 700);
            });

            if($('.single-docs').length > 0 ){
                app.openAccordion();
            }

            $('.wptoffeedocs-search-form').on('submit', app.handleSearch);
            $('.wptoffeedocs-search-close').on('click', app.handleSearchClose);
            $('.wptoffeedocs-category-select').on('change', app.handleSearch);
            $('.docs-section-title').on('click', app.handleAccordion);
        },

        handleSearch: function (e) {
            let search = $('.wptoffeedocs-search-field').val();

            if (e) {
                e.preventDefault();
            } else {
                if (search.length < 3) {
                    return;
                }
            }

            const category = $('.wptoffeedocs-category-select').val();

            wp.ajax.send('wptoffeedocs_search', {
                data: {
                    search,
                    category,
                },
                success: function (response) {
                    $('.wptoffeedocs-search-results-wrap').addClass('active');
                    $('.wptoffeedocs-search-results').html(response);
                },
                beforeSend: function () {
                    $('.wptoffeedocs-search-loader').addClass('active');
                },
                complete: function () {
                    $('.wptoffeedocs-search-loader').removeClass('active');
                    $('.wptoffeedocs-search-close').addClass('active');
                }
            });
        },

        handleSearchClose: function () {
            $('.wptoffeedocs-search-results-wrap').removeClass('active');
            $('.wptoffeedocs-search-results').html('');
            $('.wptoffeedocs-search-field').val('');
            $('.wptoffeedocs-search-close').removeClass('active');
        },

        handleAccordion: function() {
            $(this).toggleClass("is-open");

            var content = $(this).next();

            if (content.css("max-height") !== "0px") {
                content.css("max-height", "0");
            } else {
                content.css("max-height", content[0].scrollHeight + "px");
            }
        },

        openAccordion: function() {
            var content = $('.active').parent();
            content.prev().addClass('is-open');
            content.css('max-height', content[0].scrollHeight + 'px');
        }
    }

    $(document).ready(app.init);
})(jQuery);