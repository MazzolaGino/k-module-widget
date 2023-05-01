<?php

namespace KModuleWidget\Lib;

use KLib\Implementation\ConfigurationInterface;
use KLib\Implementation\PathInterface;

class Release
{

    public const NN = 'list_no_date';
    public const LN = 'list_date';

    private string $filename;
    private ConfigurationInterface $config;
    private PathInterface $path;
    private array $post;

    private string $type;

    public function __construct(ConfigurationInterface $config, PathInterface $path, array $post = [], string $type = 'list_date')
    {
        $this->config = $config;
        $this->path = $path;
        $this->filename = $this->path->path() . $this->config->get('release_json');
        $this->post = $post;
        $this->type = $type;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return mixed
     */
    private function post(string $name = ''): mixed
    {
        $r = [];

        if (array_key_exists($name, $this->post)) {
            $r = $this->post[$name];
        }

        if ($name === '') {
            $r = $this->post;
        }

        return $r;
    }

    /**
     * Undocumented function
     *
     * @param string $this->filename
     * @param string $name
     * @return void
     */
    public function removeReleaseByName(string $name): void
    {
        $content = file_get_contents($this->filename);
        $json = json_decode($content, true);

        foreach ($json[$this->type] as $key => $release) {
            if ($release['name'] === $name) {
                unset($json[$this->type][$key]);
            }
        }

        $json[$this->type] = array_values($json[$this->type]);
        $updatedContent = json_encode($json, JSON_PRETTY_PRINT);

        file_put_contents($this->filename, $updatedContent);
    }

    /**
     * Undocumented function
     *
     * @param string $this->filename
     * @return array
     */
    public function readJsonFile(): array
    {

        if (!file_exists($this->filename)) {
            throw new 
            \Exception("Unable to retrieve game releases JSON file ($this->filename)");
        }

        $content = file_get_contents($this->filename);

        return json_decode($content, true);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getPostRelease(): array
    {
        if($this->type === self::LN) {
            $timestamp = strtotime($this->post('date'));
            $date = date('d-m-Y', $timestamp);
        }else{
            $date = $this->post('date');
        }
       
        return [
            'name' => $this->post('name'),
            'date' => $date,
            'supports' => implode('|', $this->post('supports'))
        ];
    }

    /**
     * Undocumented function
     *
     * @param string $this->filename
     * @param array $release
     * @return void
     */
    public function addRelease(array $release): void
    {
        $json = $this->readJsonFile();

        $release['url'] = "/?s=" . $this->transformTitle($release['name']);

        $json[$this->type][] = $release;
        $json[$this->type] = $this->sortReleases($json[$this->type]);
        
        
        file_put_contents($this->filename, json_encode($json, JSON_PRETTY_PRINT));
    }

    public function sortReleases(array $releases)
    {
        if($this->type === self::LN) {

            usort($releases, function($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });

        }else{
            
            usort($releases, function($a, $b) {
                return strtotime($a['date'] . '-01-01') - strtotime($b['date'] . '-01-01');
            });

        }

        return $releases;
    }

    private function transformTitle($title) {
        // Supprime les espaces à la fin et au début de la chaîne de caractères
        $title = trim($title);
     
        // Convertit tous les caractères en minuscules
        $title = strtolower($title);
     
        // Remplace tous les espaces et les caractères spéciaux par des plus (+)
        $title = preg_replace('/[^a-zA-Z0-9]/','+',$title);
     
        // Supprime les plus en double
        $title = preg_replace('/\++/','+',$title);
     
        // Supprime le dernier plus s'il existe
        $title = rtrim($title,'+');
     
        return $title;
     }
     
    
}
