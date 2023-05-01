<?php

namespace KModuleWidget\Controller;

use KModuleWidget\Lib\Release;

class WidgetController extends Controller
{
    public function date_action(): void
    {
        $this->handleAction(Release::LN);
    }

    public function nodate_action(): void
    {
        $this->handleAction(Release::NN);
    }

    private function handleAction(string $type): void
    {
        $app = $this->getApp();

        $rm = new Release(
            $app->getCnf(),
            $app->getPa(),
            $this->post(),
            $type
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
            'referer' => "admin.php?page=k-module-widget-widget-{$type}&name=",
            'message' => $message,
            'releases' => $releases,
            'type' => $type
        ]);
    }
}
