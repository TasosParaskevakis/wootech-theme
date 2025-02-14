<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;


add_action('wp_enqueue_scripts', function () {
    bundle('app')->enqueue();

    wp_enqueue_style('theme/slick', get_template_directory_uri() . '/resources/styles/slick.css', [], null);
    wp_enqueue_style('theme/style', get_template_directory_uri() . '/resources/styles/style.css', [], null);
    wp_enqueue_style('theme/aos', get_template_directory_uri() . '/resources/styles/aos.css', [], null);

    wp_enqueue_script('theme/jquery', get_template_directory_uri() . '/resources/scripts/jquery-3.6.0.min.js', [], null, true);
    wp_enqueue_script('theme/alpine', get_template_directory_uri() . '/resources/scripts/alpine.min.js', [], null, true);
    wp_enqueue_script('theme/jquery-validate', get_template_directory_uri() . '/resources/scripts/jquery.validate.min.js', [], null, true);
    wp_enqueue_script('theme/slick', get_template_directory_uri() . '/resources/scripts/slick.min.js', [], null, true);
    wp_enqueue_script('theme/aos', get_template_directory_uri() . '/resources/scripts/aos.js', [], null, true);
    wp_enqueue_script('theme/custom', get_template_directory_uri() . '/resources/scripts/script.js', [], null, true);
}, 100);


add_action('admin_menu', function () {
    add_menu_page(
        'Theme Settings',
        'Theme Settings',
        'manage_options',
        'theme-settings',
        'render_theme_settings_page',
        'dashicons-admin-generic',
        2
    );
});


function render_theme_settings_page() {
    ?>
    <div class="wrap">
        <h1>Theme Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('theme_settings_group');
            do_settings_sections('theme-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


add_action('admin_init', function () {
    register_setting('theme_settings_group', 'site_logo');
    register_setting('theme_settings_group', 'contact_email');
    register_setting('theme_settings_group', 'banner_text');
    register_setting('theme_settings_group', 'banner_image');

    add_settings_section('general_settings', 'General Settings', null, 'theme-settings');

    add_settings_field('site_logo', 'Site Logo', function () {
        echo '<input type="text" name="site_logo" value="' . esc_attr(get_option('site_logo', '')) . '" class="regular-text">';
    }, 'theme-settings', 'general_settings');

    add_settings_field('contact_email', 'Contact Email', function () {
        echo '<input type="email" name="contact_email" value="' . esc_attr(get_option('contact_email', '')) . '" class="regular-text">';
    }, 'theme-settings', 'general_settings');

    add_settings_field('banner_text', 'Banner Text', function () {
        echo '<input type="text" name="banner_text" value="' . esc_attr(get_option('banner_text', 'Default Banner Text')) . '" class="regular-text">';
    }, 'theme-settings', 'general_settings');

    add_settings_field('banner_image', 'Banner Image URL', function () {
        echo '<input type="text" name="banner_image" value="' . esc_attr(get_option('banner_image', '')) . '" class="regular-text">';
    }, 'theme-settings', 'general_settings');
});



add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'wootech'),
    ]);
});


add_action('init', function () {
    wp_register_script(
        'wootech-home-banner-editor',
        get_template_directory_uri() . '/resources/views/blocks/home-banner/index.js',
        ['wp-blocks', 'wp-element', 'wp-editor', 'wp-block-editor'],
        filemtime(get_template_directory() . '/resources/views/blocks/home-banner/index.js'),
        true
    );

    register_block_type('wootech/home-banner', [
        'editor_script'   => 'wootech-home-banner-editor',
        'render_callback' => __NAMESPACE__ . '\\wootech_render_home_banner',
    ]);
});


add_action('init', function () {
    wp_register_script(
        'wootech-info-block-editor',
        get_template_directory_uri() . '/resources/views/blocks/info-block/index.js',
        ['wp-blocks', 'wp-element', 'wp-editor', 'wp-block-editor'],
        filemtime(get_template_directory() . '/resources/views/blocks/info-block/index.js'),
        true
    );

    register_block_type('wootech/info-block', [
        'editor_script'   => 'wootech-info-block-editor',
        'render_callback' => __NAMESPACE__ . '\\wootech_render_info_block',
    ]);
});


function wootech_render_home_banner($attributes) {
    $imageUrl = isset($attributes['imageUrl']) && !empty($attributes['imageUrl'])
        ? esc_url($attributes['imageUrl'])
        : get_template_directory_uri() . '/assets/images/home_banner.jpg';

    $title = !empty($attributes['title']) ? esc_html($attributes['title']) : 'Revolutionizing the surgical treatment of eyes.';
    $description = !empty($attributes['description']) ? esc_html($attributes['description']) : 'PRODUCTS';

    // Fetch two random WooCommerce products
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 2,
        'orderby'        => 'rand',
    ];
    $products = new \WP_Query($args);

    ob_start();
    ?>
    <div class="hero relative bg-white">
        <div class="absolute top-0 left-0 w-full h-[330px] md:h-full">
            <img class="absolute top-0 left-0 h-full mx-auto object-cover w-full" src="<?php echo esc_url($imageUrl); ?>" width="1920" height="673" alt="hero">
            <div class="absolute top-0 left-0 right-0 h-full bg-gradient-to-r from-[rgba(0,0,0,0.35)] md:from-[rgba(0,0,0,0.65)] to-[rgba(0,0,0,0)]"></div>
        </div>
        <div class="container relative">
            <div class="md:flex md:flex-col md:h-full pt-6 md:pt-14">
                <div class="xl:w-1/2 lg:w-2/3 md:w-3/4 md:max-w-none max-w-xs my-11 md:my-8 xl:my-12 2xl:my-28">
                    <h1 class="text-white text-[28px] md:text-[40px] mb-10 leading-tight md:leading-snug"><?php echo esc_html($title); ?></h1>
                </div>
                <p class="text-base font-light text-white mb-8 2xl:mt-4"><?php echo esc_html($description); ?></p>

                <div class="grid gap-10 sm:gap-20 md:gap-8 mb-8 md:-mb-[72px] md:grid-cols-2">
                    <?php if ($products->have_posts()) : while ($products->have_posts()) : $products->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="group flex flex-col relative bg-white bg-opacity-95 pt-4 md:pt-0 border-r-[10px] border-blue-100 shadow-xs">
                            <?php if (has_post_thumbnail()) : ?>
                                <img class="absolute -top-[23%] sm:-top-1/3 md:-top-1/4 right-1/2 sm:right-1/3 translate-x-1/2 md:translate-x-0 w-48 sm:w-2/4 px-2 md:px-0 md:w-auto md:right-14 md:ml-0"
                                     src="<?php echo get_the_post_thumbnail_url(); ?>" width="212" height="173" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <div class="py-6 px-5 md:py-6 md:px-8 pb-2 md:mb-4">
                                <h2 class="text-[32px] mt-4 md:mt-8 mb-4 group-hover:underline"><?php the_title(); ?></h2>
                                <p class="text-gray-100 font-light md:mb-4"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                            </div>
                            <div class="bg-white mt-auto">
                                <span class="flex items-center px-5 md:px-8 py-7 text-[13px] font-bold text-blue-200 group-hover:text-blue-100">
                                    <svg class="text-red-50 mr-3 transition ease-out duration-100 group-hover:translate-x-1" aria-hidden="true" focusable="false" width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.962 1.412L12.851 6.374L7.962 11.412" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M12.74 6.414H1" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path>
                                    </svg>
                                    More
                                </span>
                            </div>                        
                        </a>
                    <?php endwhile;
                    wp_reset_postdata(); endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}



function wootech_render_info_block($attributes) {

    $imageUrl = isset($attributes['imageUrl']) && !empty($attributes['imageUrl']) ? esc_url($attributes['imageUrl']) : get_template_directory_uri() . '/assets/images/for_physicians.jpg';
    $title = !empty($attributes['title']) ? esc_html($attributes['title']) : 'For Physicians';
    $tagline = !empty($attributes['tagline']) ? esc_html($attributes['tagline']) : 'Control pressure. Reduce complications';
    $description = !empty($attributes['description']) ? esc_html($attributes['description']) : 'The eyeView system features a non-invasive adjustment mechanism that allows for a simple and accurate control of intraocular pressure.';
    $url = !empty($attributes['url']) ? esc_url($attributes['url']) : '#';

    // Set classes dynamically based on position
    $isRight = isset($attributes['position']) && $attributes['position'] === 'right';

    $sectionClasses = $isRight
        ? 'relative flex flex-col pt-14 pb-14 lg:py-0 lg:flex-col bg-white'
        : 'relative flex flex-col pt-14 pb-7 lg:py-0 lg:flex-col';

    $imageContainerClasses = $isRight
        ? 'inset-y-0 top-0 right-0 w-full mb-8 lg:mb-0 lg:w-1/2 lg:pl-4 lg:absolute aos-init aos-animate'
        : 'inset-y-0 top-0 left-0 w-full mb-8 lg:mb-0 lg:w-1/2 lg:pr-4 lg:absolute aos-init aos-animate';

    $contentContainerClasses = $isRight
        ? 'container flex flex-wrap justify-start'
        : 'container flex flex-wrap justify-end';

    $textContainerClasses = $isRight
        ? 'lg:w-1/2 lg:pr-8 lg:py-12 aos-init aos-animate'
        : 'lg:w-1/2 lg:pl-16 lg:pr-3 lg:py-12 aos-init aos-animate';

    ob_start();
    ?>
    <div class="<?php echo esc_attr($sectionClasses); ?>">
        <div class="<?php echo esc_attr($imageContainerClasses); ?>" data-aos="fade-up" data-aos-duration="1000">
            <img class="object-cover w-full h-full <?php echo $isRight ? 'object-left-top' : ''; ?>" src="<?php echo esc_url($imageUrl); ?>" width="960" height="400" alt="<?php echo esc_attr($title); ?>">
        </div>

        <div class="<?php echo esc_attr($contentContainerClasses); ?>">
            <div class="<?php echo esc_attr($textContainerClasses); ?>" data-aos="fade-up" data-aos-duration="500">
                <div class="flex flex-wrap items-baseline text-blue-100">
                    <h2><?php echo esc_html($title); ?></h2>
                    <svg class="ml-4" aria-hidden="true" focusable="false" width="36" height="37" viewBox="0 0 36 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 35.854V30.52C0.999088 29.1969 1.37473 27.9009 2.08305 26.7833C2.79136 25.6658 3.80308 24.7729 5 24.209L12.846 20.517L13.573 17.554" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <h3 class="text-blue-200 text-[22px] mb-7"><?php echo esc_html($tagline); ?></h3>
                <p class="text-lg font-light mb-8"><?php echo esc_html($description); ?></p>
                <div class="py-2 mb-4">
                    <a class="inline-block px-8 py-4 text-[13px] font-bold transition duration-200 text-white bg-blue-100 hover:bg-blue-200 focus:bg-blue-100 hover:shadow-xs focus:shadow-xs focus:outline-none"
                       href="<?php echo esc_url($url); ?>">Learn more</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}