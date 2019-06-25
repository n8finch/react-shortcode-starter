<?php

// Add the link to the WP Docs here

add_shortcode('react_shortcode_posts', array('ReactShortcodePosts', 'react_shortcode_posts'));

class ReactShortcodePosts
{
    public static function react_shortcode_posts($atts, $content = '')
    {
        $post_categories = get_terms('post-tag');

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
            $catagories_array = get_the_terms($post, 'post-tag');
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
    </script>

    <style>
        .top-elements {
            max-width: 850px;
            margin: auto;
        }

        .top-elements form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 50px;
        }

        .top-elements form input::placeholder {
            color: #777;
        }

        .top-elements form input[type="submit"],
        .top-elements form a.location-direction.order-pickup.theme-button.large {
            background-color: #ac121a;
            border-radius: 0;
            font-family: 'open sans';
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 0 !important;
            padding: 11px 30px !important;
            text-align: center;
            text-transform: uppercase;
        }

        .top-elements form input[type="submit"]:hover,
        .top-elements form a.location-direction.order-pickup.theme-button.large:hover {
            background-color: #000;
            border-radius: 0;
            font-family: 'open sans';
            font-weight: 700;
            font-size: 20px !important;
            text-align: center;
            text-transform: uppercase;
        }

        .arichive-post-search .medium.gfield_select {
            appearance: none;
            -webkit-appearance: none;
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: center;
            border-radius: 0;
            height: 42px;
            margin: 0 20px 0 0;
            padding: 5px;
            width: 200px;
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
            font-family: "Open Sans", sans-serif;
            margin-bottom: 10px;
            padding-left: 0;
        }

        .location-direction.order-pickup {
            background-color: #ac121a
        }

        .location-direction.order-pickup:hover {
            background-color: #000;
        }

        @media(max-width: 1000px) {
            .archive-post-items {
                display: grid;
                grid-gap: 30px;
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        @media(max-width: 500px) {
            .archive-post-items {
                display: grid;
                grid-gap: 30px;
                grid-template-columns: 1fr;
            }
        }
    </style>

    <h2 style="text-align: center">Our posts</h2>
    <div class="top-elements">
        <div id="react-posts-element" class="react-post-search"></div>
    </div>
    <?php
    wp_reset_postdata();
}
}
