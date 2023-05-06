<?php

namespace KModuleWidget\Controller;

use KModuleWidget\Lib\Release;
use KModuleWidget\Lib\ReleaseRepository;

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
    /**
     *
     */
    private function handleAction(string $type): void
    {

        $rm = new ReleaseRepository();

        $message = '';

        if (!empty($this->post())) {

            $rls = $this->post();

            if(isset($rls['supports']) && is_array($rls['supports'])) {
                $rls['supports'] = implode('|', $rls['supports']);
            }else{
                $rls['supports'] = '';
            }

            $rls['type'] = $type;

            if (isset($rls['id'])) {
                // modifier le jeu
                $rm->update($rls['id'], $rls);
                $message = 'Release mise à jour avec succès';
            } else {
                // ajouter le jeu
                $rm->create($rls);
                $message = 'Release ajoutée avec succès';
            }

        }

        $releases = $rm->listByReleaseDate($type);

        $this->render('date', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'referer' => "admin.php?page=k-module-widget-widget-" . (($type === 'list_date') ? 'date' : 'nodate') . "&id=",
            'message' => $message,
            'releases' => $releases,
            'type' => $type
        ]);
    }
}
