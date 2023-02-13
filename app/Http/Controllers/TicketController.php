<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function createTicketForm(){
        return view('create-ticket-form');
    }

    public function storeTicket(Request $request){
        $incomings = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $incomings['title'] = strip_tags($incomings['title']);
        $incomings['body'] = strip_tags($incomings['body']);
        $incomings['user_id'] = auth()->id();

        $newTicket = Ticket::create($incomings);

        return redirect("/ticket/{$newTicket->id}")->with('success','Ticket created successfully!!');
    }

    public function singleTicket(Ticket $ticket){
        return view('single-ticket',['ticket'=>$ticket]);
    }
}
