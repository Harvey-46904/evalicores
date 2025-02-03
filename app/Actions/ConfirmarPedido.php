<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ConfirmarPedido extends AbstractAction
{
    public function getTitle()
    {
        return 'Confirmar';
    }

    public function getIcon()
    {
        return 'voyager-bubble-heare';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'ventas-items';
    }

    public function shouldActionDisplayOnRow($row)
    {
        $isOrden = isset($row->accion) && $row->accion == 'Orden';
        return  $isOrden;
    }

    public function getDefaultRoute()
    {
        return route('confirmar',  $this->data->id);
    }
}