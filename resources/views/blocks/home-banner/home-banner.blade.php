<section class="home-banner">
    @php
        $args = [
            'post_type'      => 'product',
            'posts_per_page' => 2,
        ];
        $query = new WP_Query($args);
    @endphp

    @if ($query->have_posts())
        <div class="banner-container">
            @while ($query->have_posts()) 
                @php $query->the_post(); @endphp
                @php $product = wc_get_product(get_the_ID()); @endphp

                <div class="banner-product">
                    <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'full') }}" alt="{{ get_the_title() }}">
                    <h2>{{ get_the_title() }}</h2>
                    <p>{{ get_the_excerpt() }}</p>
                    <a href="{{ get_permalink() }}">View Product</a>
                </div>
            @endwhile
        </div>
        @php wp_reset_postdata(); @endphp
    @else
        <p>No products found.</p>
    @endif
</section>