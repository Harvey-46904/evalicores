<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Terminar extends AbstractAction
{
    public function getTitle()
    {
        return 'Entregado';
    }

    public function getIcon()
    {
        return 'voyager-truck';
    }

 

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-warning pull-right',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'entregas';
    }

 

    public function getDefaultRoute()
    {
        return route('facturar',  $this->data->id);

        
    }
}