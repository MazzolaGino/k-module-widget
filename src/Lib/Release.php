<?php

namespace KModuleWidget\Lib;

use KLib\Implementation\ConfigurationInterface;
use KLib\Implementation\PathInterface;

class Release
{

    private string $filename;
    private ConfigurationInterface $config;
    private PathInterface $path;
    private array $post;



    public function __construct(ConfigurationInterface $config, PathInterface $path, array $post = [])
    {
        $this->config = $config;
        $this->path = $path;
        $this->filename = $this->path->path() . $this->config->get('release_json');
        $this->post = $post;
    }

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

        foreach ($json['list_date'] as $key => $release) {
            if ($release['name'] === $name) {
                unset($json['list_date'][$key]);
            }
        }

        $json['list_date'] = array_values($json['list_date']);
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
            throw new \Exception("Unable to retrieve game releases JSON file ($this->filename)");
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
        $timestamp = strtotime($this->post('date'));

        return [
            'name' => $this->post('name'),
            'date' => date('d-m-Y', $timestamp),
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
        $json['list_date'][] = $release;
        file_put_contents($this->filename, json_encode($json, JSON_PRETTY_PRINT));
    }
}
