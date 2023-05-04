<?php

namespace KModuleWidget\Lib;

use KLib\Implementation\PathInterface;
use Twig\Environment;

/**
 * Summary of ReleaseWidget
 */
class ReleaseWidget extends \WP_Widget
{

    private ReleaseRepository $rm;

    private PathInterface $pa;
    private string $type;

    private Environment $twig;

    private string $title;

    public function __construct(
        Environment $twig,
        PathInterface $pa,
        ReleaseRepository $release,
        string $title = 'Prochaines Sorties',
        string $type = 'list_date'
    ) {
        $this->rm = $release;
        $this->pa = $pa;
        $this->type = $type;
        $this->twig = $twig;
        $this->title = $title;

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

        $prefix = ($this->type === 'list_date') ? 'ln' : 'nn';
        $siteUrl = get_site_url();

        $json = <<<EOF
        {
            "updated_at": "26-05-2022",
            "url": "$siteUrl",
            "support_urls": {
                "PS4": "\/category\/ps4\/",
                "PS5": "\/category\/ps5\/",
                "Switch": "\/category\/switch\/",
                "PC": "\/category\/pc\/",
                "Xbox": "\/category\/xbox-series\/",
                "Apple IOS": "\/category\/apple-ios\/",
                "Android": "\/category\/android\/"
            }
        }
        EOF;

        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $data[$this->type] = $this->rm->listByReleaseDate($this->type);

        $i = $j = $page = 0;

        echo $this->twig->render('release_widget/releases.html.twig', [
            'data' => $data,
            'i' => $i,
            'j' => $j,
            'page' => $page,
            'type' => $this->type,
            'prefix' => $prefix,
            'title' => $this->title
        ]);
    }
}
