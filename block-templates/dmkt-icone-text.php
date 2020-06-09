<?php 
/**
 * Schotten icone+text block
 *
 */


// Load values and assign defaults.
$icone = get_field('sw-icone-text--icone');
$text = get_field('sw-icone-text--text');
$scroll_magic = get_field('sw-icone-text-scrollmagic');

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

// Create id attribute allowing for custom "anchor" value.
$id = 'dmkt-iconetext-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'dmkt-iconetext';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

/**
 * Show the block
 */ 


?>
<div class ="<?php echo $className; ?> "  id="<?php echo $id; ?>">

    <div id="<?php echo $trigger; ?>"></div>
    
    <div class="dmkt-iconetext--wrap " id="<?php echo $reveal; ?>">
        
        <div class="dmkt-iconetext--icone">
            <?php if( !empty( $icone ) ){ ?>
                <img src="<?php echo esc_url($icone['url']); ?>" alt="<?php echo esc_attr($icone['alt']); ?>" />
            <?php } ?>
        </div>

        <div class="dmkt-iconetext--text">
            <p> <?php echo $text; ?>
    </div>
    </div>

</div>
<?php 



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








