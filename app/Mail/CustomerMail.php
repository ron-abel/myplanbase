<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $subdomain, $customer, $floorplan, $items, $note;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subdomain, $customer, $floorplan, $items, $note)
    {
        $this->subdomain = $subdomain;
        $this->customer = $customer;
        $this->floorplan = $floorplan;
        $this->items = $items;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('contractor.email', ['subdomain' => $this->subdomain, "customer" => $this->customer, "floorplan" => $this->floorplan, "items" => $this->items, "note" => $this->note]);
    }
}
