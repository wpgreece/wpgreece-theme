
        <?php 

            $shortURL = get_permalink();

            $shortTitle = str_replace( ' ', '%20', get_the_title());

            $WPGCThumbnail = wp_get_attachment_url( get_post_thumbnail_id() );

            $twitterURL = 'https://twitter.com/intent/tweet?text='.$shortTitle.'&amp;url='.$shortURL.'&amp;via=wpgreeceorg';

            $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$shortURL;

            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$shortURL. '&amp;media='.$WPGCThumbnail.'&amp;description='.$shortTitle;

            $mailTo = 'mailto:?subject=Σου προτείνω να δεις αυτό το άρθρο&amp;body=Ρίξε μια ματιά εδώ: ' .$shortURL;

        ?>

        <div class ="social-sharing mobile-column desktop-column-10">

            <ul>

                <li>
                    <a class="share-link facebook" href="<?php echo $facebookURL ?>"><img src = "<?php bloginfo ( 'template_url' ) ?>/img/social/facebook.png" alt = "Share on Facebook" /></a> 
                </li>

                <li>
                    <a class="share-link twitter" href="<?php echo $twitterURL ?>"><img src = "<?php bloginfo ( 'template_url' ) ?>/img/social/twitter.png" alt = "Share on Twitter" /></a>
                </li>

                <li>
                    <a class="share-link pinterest" href="<?php echo $pinterestURL ?>"><img src = "<?php bloginfo ( 'template_url' ) ?>/img/social/pinterest.png" alt = "Pin it!" /></a>
                </li>

                 <li>
                    <a class="mail" href="<?php echo $mailTo ?>"><img src = "<?php bloginfo ( 'template_url' ) ?>/img/social/web.png" alt = "Share by Email" /></a>
                </li>


            </ul>

        </div>
