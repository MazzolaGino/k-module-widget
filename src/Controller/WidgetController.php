<?php

namespace KModuleWidget\Controller;
use KModuleWidget\Lib\Release;


class WidgetController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function date_action(): void
    {
        $app = $this->getApp();

        $rm = new Release(
            $app->getCnf(), 
            $app->getPa(), 
            $this->post()
        );

        

        $message = '';

        if (!empty($this->post())) {

            $rm->addRelease($rm->getPostRelease());
            $message = 'Jeu ajouté avec succès.';
            
        } elseif (!empty($this->get('name'))) {

            $name = urldecode($this->get('name'));
            $rm->removeReleaseByName($name);
            $message = 'Jeu supprimé avec succès.';
        }

        $releases = $rm->readJsonFile();

        $this->render('date', ['message' => $message, 'releases' => $releases]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function nodate_action(): void
    {
        $app = $this->getApp();

        $rm = new Release(
            $app->getCnf(), 
            $app->getPa(), 
            $this->post()
        );

        $message = '';

        if (!empty($this->post())) {

            $rm->addRelease($rm->getPostRelease());
            $message = 'Jeu ajouté avec succès.';
            
        } elseif (!empty($this->get('name'))) {

            $name = urldecode($this->get('name'));
            $rm->removeReleaseByName($name);
            $message = 'Jeu supprimé avec succès.';
        }

        $releases = $rm->readJsonFile();

        $this->render('date', ['message' => $message, 'releases' => $releases]);
    }
}
