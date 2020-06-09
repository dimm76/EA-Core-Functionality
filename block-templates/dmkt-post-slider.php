<?php 
/**
 * Proyect Slides
 * The block includes an animation functionality based on MagikScroll
 */

// Load values and assign defaults.
$post_number = get_field('dmkt-post-slider-post-quantity');
$scroll_magic = get_field('dmkt-post-slider-magicscroll');
$title = get_field('dmkt-post-slider-title');



// Create id for magic scroll if magicscroll option is selected
if( true == $scroll_magic ) {
    $trigger = 'trigger-' . $block['id'];
    $reveal = 'reveal-' . $block['id'];

    // Export the variables to javascript in order to create individual triggers for the appearance effect
    ?>
    <script>
        var triggerRecupered = <?php echo json_encode($trigger); ?>;
        var revealRecupered = <?php echo json_encode($reveal); ?>;
    </script>

    <?php
}

// Create id attribute.
$id = 'dmkt-proyect-slide-' . $block['id'];

// Create class attribute allowing for custom "className".
$className = 'dmkt-proyect-slide';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}



/**
 * Displays de content
 */

// Define de loop arguments
$args = array(
    'post_type'         => 'proyectos',
    'orderby'           => 'date',
    'order'             => 'DESC',
    'posts_per_page'    => $post_number,
);    


?>
<section class ="<?php echo $className; ?> alignfull"  id="<?php echo $id; ?>">

    <div id="<?php echo $trigger; ?>"></div>

    <div class="sw-title-2 alignwide" id="<?php echo $reveal; ?>"> 
        <h2> <?php echo $title ?> </h2>
        <hr>
    </div>

    <div class="dmkt-proyect-slide--wrap owl-carousel owl-theme" id="<?php echo $reveal; ?>">

        <?php
        // Starts the loop
        $the_query = new WP_Query( $args );
        
        // The Loop
        if ( $the_query->have_posts() ) {
            
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                    ?>

                    <div class="dmkt-proyect-slide--item">
                        <a href="<?php the_permalink(); ?>" title= "<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </a>
                    </div>      
                    <?php
            }
            
        } else {
            // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata();

        ?>

    </div>

</section>
<?php

// Shows banner in admin view
if ( is_admin () ){
    ?>
    <div class="dmkt-proyect-slide--admin" >
        <h2> El front page mostrará un slider con los últimos proyectos </h2>
    </div>   
    <?php
}




/**
 * Creates the script to give the block appearance effect.  
 * Supported by the previously loaded scrollmagic settings file that creates the controller variable
 */
?>
<script>
// build scene 
new ScrollMagic.Scene({
    triggerElement: "#" + triggerRecupered,
	triggerHook: 0.8,
	offset: 50, // move trigger to center of element
	reverse: false // only do once
})
.setClassToggle("#" + revealRecupered, "visible") // add class toggle
//.addIndicators() // add indicators (requires plugin)
.addTo(controller);
</script>



<?php
/**
 * OWLSlider Settings
 * 
 */
?>
<script type= "text/javascript">
    $(document).ready(function() {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items: 3,
            center:true,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });
    })
</script>
<?php



// Load the dynamic styles of the block
?>
<style type="text/css">
    #<?php echo $reveal; ?> {
        <?php if ( is_admin() ){ ?>
            opacity: 1;
        <?php } else {?>
        opacity: 0;
        transition: all 1s ease-in-out;
        <?php } ?>
    }
    #<?php echo $reveal; ?>.visible {
        opacity: 1;
        transform: none;
    }
    



</style>








