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

        $this->render('date', [
            'referer' => 'admin.php?page=k-module-widget-widget-date&name=',
            'message' => $message,
            'releases' => $releases,
            'type' => $rm::LN
        ]);
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
            $this->post(),
            Release::NN
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

        $this->render('date', [
            'referer' => 'admin.php?page=k-module-widget-widget-nodate&name=',
            'message' => $message,
            'releases' => $releases,
            'type' => $rm::NN
        ]);
    }
}
