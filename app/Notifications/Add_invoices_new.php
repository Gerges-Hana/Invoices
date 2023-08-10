<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;


use App\invoices;
class Add_invoices_new extends Notification
{
    use Queueable;

    protected $invoices;

    public function __construct(\App\Models\invoices $invoices)
    {
        $this->invoices = $invoices;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->invoices['id'],
            'title' =>'تمت اضافه الفتوره بواستط: ',
            'user' =>Auth::user()->name
        ];
    }


}
