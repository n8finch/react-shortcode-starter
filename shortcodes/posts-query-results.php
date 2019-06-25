<?php

add_shortcode('store_archive_grid', array('StoreArchiveGrid', 'store_archive_grid'));

class StoreArchiveGrid
{
    public static function store_archive_grid($atts, $content = '')
    {
        $req_cat = (array_key_exists('store-cat', $_REQUEST)) ? $_REQUEST['store-cat'] : false;
        $req_string = (array_key_exists('store-string', $_REQUEST)) ? $_REQUEST['store-string'] : false;

        $store_categories = get_terms('store-tag');

        $args = array(
            'post_type' => 'stores',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title',
            'tax_query' => array(
                'relation' => 'OR',
            ),
        );

        // Meal is specified.
        if ($req_cat) {
            $store_cats = array(
                'taxonomy' => 'store-tag',
                'field' => 'slug',
                'terms' => array($req_cat),
            );

            array_push($args['tax_query'], $store_cats);
        }

        if ($req_string) {
            $args['s'] = $req_string;
        }

        // The Query
        $store_query = new WP_Query($args);


        /**
         * DO THE STUFF FOR REACT
         */
        $react_store_categories = [];
        $react_store_list = [];
        $count = 0;
        $counter = 0;

        foreach ($store_categories as $cat) {
            $react_store_categories[$count] = $cat->name;
            $count++;
        }

        foreach ($store_query->posts as $post) {
            $catagories_array = get_the_terms($post, 'store-tag');
            $categories       = '';
            foreach ($catagories_array as $index => $cat) {
                if ($index > 0) {
                    $categories .= ', ';
                }
                $categories .= $cat->name;
            }
            $react_store_list[$counter]['link'] =  esc_url(get_permalink($post));
            $react_store_list[$counter]['thumb'] = esc_url(get_the_post_thumbnail_url($post->ID, 'blog_entry'));
            $react_store_list[$counter]['title'] = esc_html($post->post_title);
            $react_store_list[$counter]['alt'] = esc_html($post->post_title);
            $react_store_list[$counter]['cat'] = $categories;
            $counter++;
        }
        ?>
    <script>
        // SEND REACT STUFF TO BROWSER
        var milios = {
            storeCategories: <?php echo wp_json_encode($react_store_categories) ?>,
            storeQuery: <?php echo wp_json_encode($react_store_list) ?>,
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

        .arichive-store-search .medium.gfield_select {
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

        .archive-store-items {
            display: grid;
            grid-gap: 30px;
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }

        .archive-store-items h3 {
            font-size: 18px;
            margin-bottom: 0;
            margin-top: 0;
            padding-left: 0;
        }

        .archive-store-items p {
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
            .archive-store-items {
                display: grid;
                grid-gap: 30px;
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        @media(max-width: 500px) {
            .archive-store-items {
                display: grid;
                grid-gap: 30px;
                grid-template-columns: 1fr;
            }
        }
    </style>

    <h1 style="text-align: center">Our Stores</h1>
    <h2 style="color: #ac121a; font-family:'Rock Salt'; text-align: center">Come and Get It!</h2>

    <div class="top-elements">
        <div id="milios-react-element" class="arichive-store-search"></div>
    </div>
    <?php
    wp_reset_postdata();
}
}
