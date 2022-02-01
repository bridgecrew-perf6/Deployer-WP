<?php

// add_filter('allowed_block_types', 'misha_allowed_block_types');

// function misha_allowed_block_types($allowed_blocks)
// {
//     return array(
//         'core/image',
//         'core/paragraph',
//         'core/heading',
//         'core/list'
//     );
// }

function my_acf_block_render_callback($block)
{
  $slug = str_replace('acf/', '', $block['name']);
  $block['slug'] = $slug;
  $block['classes'] = implode(' ', [$block['slug'], $block['align']]);
  echo \App\template("blocks/${slug}", ['block' => $block]);
}

add_action('acf/init', function () {
  if (function_exists('acf_register_block')) {
    $dir = new DirectoryIterator(locate_template("views/blocks/"));
    foreach ($dir as $fileinfo) {
      if (!$fileinfo->isDot()) {
        $slug = str_replace('.blade.php', '', $fileinfo->getFilename());
        $file_path = locate_template("views/blocks/${slug}.blade.php");
        $file_headers = get_file_data($file_path, [
          'title' => 'Title',
          'description' => 'Description',
          'category' => 'Category',
          'icon' => 'Icon',
          'post-type' => 'Post-type',
          'keywords' => 'Keywords',
        ]);
        if (empty($file_headers['title'])) {
          die(_e('This block needs a title: ' . $file_path));
        }
        if (empty($file_headers['category'])) {
          die(_e('This block needs a category: ' . $file_path));
        }
        
        $datas = [
          'name' => $slug,
          'title' => $file_headers['title'],
          'description' => $file_headers['description'],
          'category' => $file_headers['category'],
          'icon' => $file_headers['icon'],
          'keywords' => explode(' ', $file_headers['keywords']),
          'post_types' => explode(' ', $file_headers['post-type']),
          'render_callback'  => 'my_acf_block_render_callback',
        ];
        
        acf_register_block($datas);
      }
    }
  }
});

function template_block_category($categories, $post) {
  return array_merge($categories, array(array('slug' => 'template-blocks','title' => __('Template Blocks', 'template-blocks'))));
}

add_filter('block_categories', 'template_block_category', 10, 2);
