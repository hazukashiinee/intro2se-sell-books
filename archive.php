<?php
get_header();

$args = array(
    'post_per_pages' => get_option('post_per_pages'),
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'authors',
            'terms' => get_queried_object()->term_id,
        )
    ),
    'meta_query' => array(
        array(
            'key' => 'status',
            'value' => 'upcoming',
            'compare' => '!='
        )
    )
);

$posts = new WP_Query($args);

if ($posts->have_posts()): ?>
    <main>
        <article>
            <section id="archive">
                <?php mimi_sort_bars('Author: ' . get_queried_object()->name, null); ?>
                <div class="row">
                    <?php
                    while ($posts->have_posts()):
                        $posts->the_post();
                        get_template_part('template-parts/post');
                    endwhile;
                    ?>
                </div>
                <?php mimi_pagination($posts->query_vars['paged'], $posts->max_num_pages); ?>
            </section>
        </article>
    </main>
<?php endif;

wp_reset_postdata();
get_footer();