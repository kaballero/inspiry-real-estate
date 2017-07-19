<?php

if ( ! function_exists( 'inspiry_thumbnail' ) ) :
	/**
	 * Display thumbnail
	 *
	 * @param string $size
	 */
	function inspiry_thumbnail( $size = 'inspiry-grid-thumbnail' ) {
		?>
		<a href="<?php the_permalink(); ?>">
			<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( $size, array( 'class' => 'img-responsive' ) );
				} else {
					inspiry_image_placeholder( $size, 'img-responsive' );
				}
			?>
		</a>
		<?php
	}
endif;

if ( ! function_exists( 'inspiry_animation_class' ) ) :
	/**
	 * Return animation class to enable animation.
	 *
	 * @since 1.0.0
	 *
	 * @param   bool $generate
	 *
	 * @return  string
	 */
	function inspiry_animation_class( $generate = false ) {
		global $inspiry_options;
		if ( $generate || ( $inspiry_options['inspiry_animation'] == 1 ) ) {
			return 'animated';
		}

		return '';
	}

endif;

if ( ! function_exists( 'inspiry_col_animation_class' ) ) {
	/**
	 * Provide animation class based on columns and index
	 *
	 * @param int $number_of_cols number of columns
	 * @param int $col_index column's index
	 *
	 * @return string   animation class
	 */
	function inspiry_col_animation_class( $number_of_cols = 3, $col_index ) {

		// For 1 Column Layout
		if ( $number_of_cols == 1 ) {
			return 'fade-in-up';
		}

		// For 2 Columns Layout
		if ( $number_of_cols == 2 ) {
			if ( $col_index % 2 == 0 ) {
				return 'fade-in-right';
			} else {
				return 'fade-in-left';
			}
		}

		// For 3 Columns Layout
		if ( $number_of_cols == 3 ) {
			if ( $col_index % 3 == 0 ) {
				return 'fade-in-right';
			} else if ( $col_index % 3 == 1 ) {
				return 'fade-in-left';
			} else {
				return 'fade-in-up';
			}
		}

		// For 4 Columns Layout
		if ( $number_of_cols == 4 ) {
			if ( $col_index % 4 == 0 ) {
				return 'fade-in-right';
			} else if ( $col_index % 4 == 1 ) {
				return 'fade-in-left';
			} else {
				return 'fade-in-up';
			}
		}

		return 'fade-in-up';

	}
}

if ( ! function_exists( 'get_inspiry_custom_excerpt' ) ) {
	/**
	 * Return excerpt for given number of words from custom contents
	 *
	 * @param string $contents
	 * @param int $len
	 * @param string $trim
	 *
	 * @return array|string
	 */
	function get_inspiry_custom_excerpt( $contents, $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', $contents, $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			$last_item = array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . $trim;

		return $excerpt;
	}
}

if ( ! function_exists( 'inspiry_excerpt' ) ) {
	/**
	 * Output excerpt for given number of words
	 *
	 * @param int $len
	 * @param string $trim
	 */
	function inspiry_excerpt( $len = 15, $trim = "&hellip;" ) {
		echo get_inspiry_excerpt( $len, $trim );
	}
}

if ( ! function_exists( 'get_inspiry_excerpt' ) ) {
	/**
	 * Return excerpt for given number of words.
	 *
	 * @param int $len
	 * @param string $trim
	 *
	 * @return string
	 */
	function get_inspiry_excerpt( $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt(), $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			$last_item = array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . $trim;

		return $excerpt;
	}
}