<?php
/* Block Name: Social Links */

$social_links = get_field('social_links');

if ($social_links) : ?>
    <ul class="wp-block-social-links is-layout-flex wp-block-social-links-is-layout-flex">
        <?php foreach ($social_links as $link) : ?>
            <li class="wp-social-link wp-social-link-facebook  wp-block-social-link">
                <a href="<?php echo esc_url($link['profile_link']['url']); ?>" target="_blank">
                    <?php
                    switch ($link['social_profile']) {
                        case 'facebook':
                            echo '<i class="fab fa-facebook"></i>';
                            break;
                        case 'instagram':
                            echo '<i class="fab fa-instagram"></i>';
                            break;
                        case 'twitter':
                            echo '<i class="fab fa-twitter"></i>';
                            break;
                        case 'snapchat':
                            echo '<i class="fab fa-snapchat-ghost"></i>';
                            break;
                        case 'linkedIn':
                            echo '<i class="fab fa-linkedin"></i>';
                            break;
                        case 'pinterest':
                            echo '<i class="fab fa-pinterest"></i>';
                            break;
                        case 'reddit':
                            echo '<i class="fab fa-reddit"></i>';
                            break;
                        case 'youtube':
                            echo '<i class="fab fa-youtube"></i>';
                            break;
                        default:
                            break;
                    }
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
