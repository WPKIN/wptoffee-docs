<?php

$args = array(
	'taxonomy'   => 'docs_category',
	'hide_empty' => false,
    'parent'     => 0
);

$categories = get_categories( $args );

?>

<div class="wptoffeedocs-search-wrap">

    <div class="wptoffeedocs-search-label">
        <label for="search-keyword">What are you looking for?</label>
        <p>Search here to get answers to you questions.</p>
    </div>

    <form id="wptoffeedocs-search-form" class="wptoffeedocs-search-form">

        <div class="wptoffeedocs-search-field-wrap">
            <input name="s" id="search-keyword" class="wptoffeedocs-search-field" autocomplete="off" type="text"
                   placeholder="Search for topics or questions....">

            <div class="wptoffeedocs-search-loader">
                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <style>.spinner_OSmW {
                            transform-origin: center;
                            animation: spinner_T6mA .75s step-end infinite
                        }

                        @keyframes spinner_T6mA {
                            8.3% {
                                transform: rotate(30deg)
                            }
                            16.6% {
                                transform: rotate(60deg)
                            }
                            25% {
                                transform: rotate(90deg)
                            }
                            33.3% {
                                transform: rotate(120deg)
                            }
                            41.6% {
                                transform: rotate(150deg)
                            }
                            50% {
                                transform: rotate(180deg)
                            }
                            58.3% {
                                transform: rotate(210deg)
                            }
                            66.6% {
                                transform: rotate(240deg)
                            }
                            75% {
                                transform: rotate(270deg)
                            }
                            83.3% {
                                transform: rotate(300deg)
                            }
                            91.6% {
                                transform: rotate(330deg)
                            }
                            100% {
                                transform: rotate(360deg)
                            }
                        }</style>
                    <g class="spinner_OSmW">
                        <rect x="11" y="1" width="2" height="5" opacity=".14"/>
                        <rect x="11" y="1" width="2" height="5" transform="rotate(30 12 12)" opacity=".29"/>
                        <rect x="11" y="1" width="2" height="5" transform="rotate(60 12 12)" opacity=".43"/>
                        <rect x="11" y="1" width="2" height="5" transform="rotate(90 12 12)" opacity=".57"/>
                        <rect x="11" y="1" width="2" height="5" transform="rotate(120 12 12)" opacity=".71"/>
                        <rect x="11" y="1" width="2" height="5" transform="rotate(150 12 12)" opacity=".86"/>
                        <rect x="11" y="1" width="2" height="5" transform="rotate(180 12 12)"/>
                    </g>
                </svg>
            </div>

            <div class="wptoffeedocs-search-close">
                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <style>.close_1q1x {
                            fill: none;
                            stroke: currentColor;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-width: 2px
                        }</style>
                    <path class="close_1q1x" d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </div>

        </div>

        <select class="wptoffeedocs-category-select">
            <option value="">All Categories</option>
			<?php

			if ( ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
				}
			}

			?>
        </select>

        <button class="wptoffeedocs-btn wptoffeedocs-search-submit">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <g>
                        <circle cx="11.7666" cy="11.7666" r="8.98856" stroke="#130F26" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.0183 18.4851L21.5423 22" stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </g>
                </g>
            </svg>
            <span>Search</span>
        </button>

        <div class="wptoffeedocs-search-results-wrap">
            <div class="wptoffeedocs-search-results"></div>
        </div>

    </form>

</div>