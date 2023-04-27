<?php

namespace KModuleWidget\Lib;

use KLib\Implementation\PathInterface;
use Twig\Environment;

/**
 * Summary of ReleaseWidget
 */
class ReleaseWidget extends \WP_Widget
{

    private Release $rm;
    private PathInterface $pa;
    private string $type;

    private Environment $twig;

    public function __construct(
        Environment $twig,
        PathInterface $pa,
        Release $release,
        string $title = 'Prochaines Sorties',
        string $type = 'list_date'
    ) {
        $this->rm = $release;
        $this->pa = $pa;
        $this->type = $type;
        $this->twig = $twig;

        parent::__construct($this->type, esc_html__($title, 'textdomain'), array(
            'description' => esc_html__('Affiche les prochaines sorties', 'textdomain'),
        ));
    }

    /**
     * Summary of widget
     * 
     * @return void
     */
    public function widget($args, $instance)
    {
        $data = $this->rm->readJsonFile();
        $i = $j = $page = 0;

        $tpl = $this->pa->fromTemplate('release_widget', 'releases');

        if ($this->type === 'list_date') {
            $prefix = 'ln';
        } else {
            $prefix = 'nn';
        }

        echo $this->twig->render('release_widget/releases.html.twig', [
            'data' => $data,
            'i' => $i,
            'j' => $j,
            'page' => $page,
            'type' => $this->type,
            'prefix' => $prefix
        ]);
    }
}
