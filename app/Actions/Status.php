<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Status extends AbstractAction
{
    public function getTitle()
    {
        return 'Ver';
    }

    public function getIcon()
    {
        return 'voyager-bubble-heare';
    }

 
    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'entregas';

        
    }

    public function shouldActionDisplayOnRow($row)
    {
        return  $row->tipo != 'Tienda';
    }

    public function getDefaultRoute()
    {
        return route('verentrega',  $this->data->id);
    }
}