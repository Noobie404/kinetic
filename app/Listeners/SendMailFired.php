<?php

namespace App\Listeners;
use Mail;
use App\Models\Bill;
use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailFired
{
    public function __construct()
    {

    }
    public function handle(SendMail $event)
    {
        echo ($event->bill_id);
        $bill = Bill::select('bills.*','customers.email','customers.name as customer_name')->join('customers','customers.id','bills.f_customer_no')->where('bills.id',$event->bill_id)->first()->toArray();
        $details = [
            'title' => 'Bill Information',
            'body' => $bill
        ];
        \Mail::to($bill['email'])->send(new \App\Mail\Mail($details));
    }
}
