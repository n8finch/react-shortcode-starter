<?php

// Add the link to the WP Docs here

add_shortcode('react_shortcode_posts', array('ReactShortcodePosts', 'react_shortcode_posts'));

class ReactShortcodePosts
{
    public static function react_shortcode_posts($atts, $content = '')
    {
        $post_categories = get_terms('category');

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 100,
            'order' => 'DESC',
            'orderby' => 'title',
            'tax_query' => array(
                'relation' => 'OR',
            ),
        );

        // The Query
        $posts_query = new WP_Query($args);

        // Prep the data for the React app.
        $react_post_categories = [];
        $react_post_list = [];
        $count = 0;
        $counter = 0;

        foreach ($post_categories as $cat) {
            $react_post_categories[$count] = $cat->name;
            $count++;
        }

        foreach ($posts_query->posts as $post) {
            $catagories_array = get_the_terms($post, 'category');
            $categories       = '';
            foreach ($catagories_array as $index => $cat) {
                if ($index > 0) {
                    $categories .= ', ';
                }
                $categories .= $cat->name;
            }
            $react_post_list[$counter]['link'] =  esc_url(get_permalink($post));
            $react_post_list[$counter]['thumb'] = esc_url(get_the_post_thumbnail_url($post->ID, 'blog_entry'));
            $react_post_list[$counter]['title'] = esc_html($post->post_title);
            $react_post_list[$counter]['alt'] = esc_html($post->post_title);
            $react_post_list[$counter]['cat'] = $categories;
            $counter++;
        }
        ?>

    <script>
        // TODO: Probably a better way to do this.
        // Send React data to the browser
        var reactPosts = {
            postCategories: <?php echo wp_json_encode($react_post_categories) ?>,
            postQuery: <?php echo wp_json_encode($react_post_list) ?>,
        };
        console.log(reactPosts);
    </script>

    <style>
        .top-elements {
            max-width: 850px;
            margin: auto;
        }

        .top-elements form {
            margin-bottom: 50px;
            text-align: center;
        }

        .top-elements form input,
        .top-elements form select {
            max-width: 45%;
            height: 50px;
        }

        .archive-post-items {
            display: grid;
            grid-gap: 30px;
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }

        .archive-post-items h3 {
            font-size: 18px;
            margin-bottom: 0;
            margin-top: 0;
            padding-left: 0;
        }

        .archive-post-items p {
            font-size: 16px;
            margin-bottom: 10px;
            padding-left: 0;
        }

        .archive-post-items a.post-button {
            background-color: #333;
            border: 1px solid #333;
            border-radius: 5px;
            color: white;
            padding: 5px 15px;
            text-decoration: none;
            transition: 0.25s all ease;
        }

        .archive-post-items a.post-button:hover {
            background-color: #fff;
            color: #333;
        }

        @media (max-width: 1000px) {
            .archive-post-items {
                display: grid;
                grid-gap: 30px;
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        @media (max-width: 500px) {
            .archive-post-items {
                display: grid;
                grid-gap: 30px;
                grid-template-columns: 1fr;
            }
        }
    </style>
    <div class="top-elements">
        <div id="react-posts-element" class="react-post-search"></div>
    </div>
    <?php
    wp_reset_postdata();
}
}
