<?php

namespace App\Http\Livewire\Frontend\traits;


trait SendSweetAlertTrait
{

    public function sendSweetAlert($type, $mssg)
    {
        $mssg = str_replace('Deafult','Cart',$mssg);
        $this->alert( $type, $mssg, [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => TRUE,
            'timerProgressBar' => TRUE,
        ] );
    }
}