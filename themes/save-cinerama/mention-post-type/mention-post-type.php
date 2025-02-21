<?php
function create_mention_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Mentions',
            'singular_name' => 'Mention',
            'add_new_item' => 'Add Mention',
            'edit_item' => 'Edit Mention',
            'new_item' => 'New Mention',
            'view_item' => 'View Mention',
            'search_items' => 'Search Mentions',
            'not_found' => 'No Mentions Found',
            'not_found_in_trash' => 'No Mentions Found in Trash',
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'supports' => array('title'), // Only supports the title, no body editor
        'has_archive' => true,
        'rewrite' => array('slug' => 'mentions'),
    );

    register_post_type('mention', $args); // Corrected post type name here
}

function mention_meta_boxes() {
    // Add Company Name meta box
    add_meta_box(
        'publisher_name_meta_box',
        'Publisher',
        'display_company_name_field',
        'mention',
        'normal',
        'high'
    );
    
    // Add Company URL meta box
    add_meta_box(
        'article_url_meta_box',
        'URL',
        'display_company_url_field',
        'mention',
        'normal',
        'high'
    );
    
    // Add Date meta box
    add_meta_box(
        'mention_date_meta_box',    // ID of the meta box
        'Published',             // Title of the meta box
        'display_date_field',       // Callback function to display field
        'mention',                  // Custom post type
        'normal',                   // Context
        'high'                      // Priority
    );
}

function display_company_name_field($post) {
    $publisher = get_post_meta($post->ID, 'publisher', true);
    echo '<input type="text" name="publisher" value="' . esc_attr($publisher) . '" class="widefat" />';
}

function display_company_url_field($post) {
    $article_url = get_post_meta($post->ID, 'article_url', true);
    echo '<input type="url" name="article_url" value="' . esc_url($article_url) . '" class="widefat" />';
}

function display_date_field($post) {
    $mention_date = get_post_meta($post->ID, 'mention_date', true);
    // Use the date picker for input
    echo '<input type="date" name="mention_date" value="' . esc_attr($mention_date) . '" class="widefat" />';
}

function save_mention_meta($post_id) {
    // Check if post type is 'mention' to avoid saving in non-'mention' posts
    if (get_post_type($post_id) != 'mention') {
        return;
    }

    // Save Company Name
    if (isset($_POST['publisher'])) {
        update_post_meta($post_id, 'publisher', sanitize_text_field($_POST['publisher']));
    }

    // Save Company URL
    if (isset($_POST['article_url'])) {
        update_post_meta($post_id, 'article_url', esc_url_raw($_POST['article_url']));
    }

    // Save Mention Date
    if (isset($_POST['mention_date'])) {
        // Ensure the date is in the correct format (YYYY-MM-DD)
        update_post_meta($post_id, 'mention_date', sanitize_text_field($_POST['mention_date']));
    }
}

// Add custom columns to the Mention post type overview
function add_mention_columns($columns) {
    // Insert custom columns after the 'title' column
    $columns['publisher'] = 'Publisher';
    $columns['article_url'] = 'Article URL';
    $columns['mention_date'] = 'Released';
    return $columns;
}

// Populate the custom columns with metadata
function show_mention_column_data($column, $post_id) {
    if ($column === 'publisher') {
        // Get the 'publisher' metadata value for the current post
        $publisher = get_post_meta($post_id, 'publisher', true);
        echo esc_html($publisher);
    }
    if ($column === 'article_url') {
        // Get the 'article_url' metadata value for the current post
        $article_url = get_post_meta($post_id, 'article_url', true);
        // Display the company URL, making it clickable if it's a valid URL
        if ($article_url) {
            echo '<a href="' . esc_url($article_url) . '" target="_blank">' . esc_url($article_url) . '</a>';
        }
    }

    if ($column === 'mention_date') {
        // Get the 'publisher' metadata value for the current post
        $company_released = get_post_meta($post_id, 'mention_date', true);
        echo esc_html($company_released);
    }
}

// Make columns sortable
function make_mention_columns_sortable($columns) {
    $columns['publisher'] = 'publisher';
    $columns['article_url'] = 'article_url';
    $columns['mention_date'] = 'mention_date';
    return $columns;
}

// Custom sorting logic
function sort_mention_columns($query) {
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ('publisher' === $orderby) {
        $query->set('meta_key', 'publisher');
        $query->set('orderby', 'meta_value');
    }

    if ('article_url' === $orderby) {
        $query->set('meta_key', 'article_url');
        $query->set('orderby', 'meta_value');
    }

    if ('mention_date' === $orderby) {
        $query->set('meta_key', 'mention_date');
        $query->set('orderby', 'meta_value');
    }
}

add_action('init', 'create_mention_post_type');
add_action('save_post_mention', 'save_mention_meta');
add_action('add_meta_boxes', 'mention_meta_boxes');
add_filter('manage_mention_posts_columns', 'add_mention_columns');
add_action('manage_mention_posts_custom_column', 'show_mention_column_data', 10, 2);
add_filter('manage_edit-mention_sortable_columns', 'make_mention_columns_sortable');
add_action('pre_get_posts', 'sort_mention_columns');
?>
