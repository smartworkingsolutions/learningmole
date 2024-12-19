<?php
/**
 * The template part for displaying social share icons.
 *
 * @package LearningMole
 */

$img_url = '';

if ( has_post_thumbnail() ) {
	$img_url = get_the_post_thumbnail_url( get_the_id(), 'full' );
}
?>

<div class="grid gap-2 bg-light-color p-4">
	<?php echo '<div class="text-lg font-bold">' . esc_html__( 'Share:', 'learningmole' ) . '</div>'; ?>
	<div class="flex gap-2">
		<a href="//www.facebook.com/share.php?m2w&s=100&p[url]=<?php echo rawurlencode( get_permalink() ); ?>&p[images][0]=<?php echo rawurlencode( $img_url ); ?>&p[title]=<?php echo rawurlencode( get_the_title() ); ?>&u=<?php echo rawurlencode( get_permalink() ); ?>&t=<?php echo rawurlencode( get_the_title() ); ?>" class="grid place-content-center w-12 sm:w-20 h-10 bg-[#3c589a]" target="_blank"><span class="w-6 h-6 flex text-white"><?php get_svg( 'icons/facebook' ); ?></span></a>

		<a title="Click to share this post on Twitter" href="http://twitter.com/intent/tweet?text=<?php echo rawurlencode( get_the_title() ); ?>&url=<?php echo rawurlencode( get_permalink() ); ?>" class="grid place-content-center w-12 sm:w-20 h-10 bg-[#55acee]" target="_blank" rel="noopener noreferrer"><span class="w-6 h-6 flex text-white"><?php get_svg( 'icons/twitter' ); ?></span></a>

		<a href="//www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( get_permalink() ); ?>&title=<?php echo rawurlencode( get_the_title() ); ?>&source=<?php echo 'url'; ?>" class="grid place-content-center w-12 sm:w-20 h-10 bg-[#0077b5]" target="_blank"><span class="w-6 h-6 flex text-white"><?php get_svg( 'icons/linkedin' ); ?></span></a>

		<a href="http://pinterest.com/pin/create/button/?url=<?php echo rawurlencode( get_permalink( get_the_id() ) ); ?>&media=<?php echo rawurlencode( $img_url ); ?>&description=<?php echo rawurlencode( get_the_title() ); ?>" class="grid place-content-center w-12 sm:w-20 h-10 bg-[#cc2329]" target="_blank"><span class="w-6 h-6 flex text-white"><?php get_svg( 'icons/pinterest' ); ?></span></a>

		<a href="whatsapp://send?text=<?php echo rawurlencode( get_the_title() ); ?> <?php echo rawurlencode( get_permalink() ); ?>" class="grid place-content-center w-12 sm:w-20 h-10 bg-[#55eb4c]" target="_blank"><span class="w-6 h-6 flex text-white"><?php get_svg( 'icons/whatsapp' ); ?></span></a>
	</div>
</div>
