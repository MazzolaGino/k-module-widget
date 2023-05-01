<?php

namespace KModuleWidget\Lib;

use Twig\Environment;

/**
 * Summary of ReleaseWidget
 */
class HlWidget extends \WP_Widget
{
    private Environment $twig;

    public function __construct(
        Environment $twig        
    ) {
        $this->twig = $twig;

        parent::__construct('hl_widget', esc_html__('hl_widget', 'textdomain'), array(
            'description' => esc_html__('Affiche les articles mis en avant', 'textdomain'),
        ));
    }

    /**
     * Summary of widget
     * 
     * @return void
     */
    public function widget($args, $instance)
    {
        
        $data = $this->getData();
        $structuredData = [];

        foreach($data as $post) {
            $structuredData[] = [
                'link' => get_permalink($post),
                'img_link' => get_the_post_thumbnail_url($post),
                'title' => $post->post_title
            ];
        }

        echo $this->twig->render('hl_widget/hl.html.twig', [
            'data' => $structuredData
        ]);
    }

    private function getCategoryIDBySlug(string $slug): mixed  
    {
        $idObj = get_category_by_slug($slug);

        $id = null;

        if ( $idObj instanceof \WP_Term ) {
            $id = $idObj->term_id;
        }

        return $id;
    }

    private function getData(){
        
        $args = array( 
            'posts_per_page' => 4, 
            'category' => $this->getCategoryIDBySlug('highlighted')
        );
        
        return get_posts($args);
    }

}
