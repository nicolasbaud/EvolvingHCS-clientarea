<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\TicketsReplies;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $ticket = Tickets::find($id);

        if (!$ticket) {
            throw new NotFoundHttpException;
        }

        return view('admin.support.ticket', [
            'ticket' => $ticket,
            'replies' => TicketsReplies::where('ticketid', $id)->orderBy('id', 'DESC')->get(),
        ]);
    }
    
    public function update($id, Request $request)
    {
        $ticket = Tickets::find($id);

        if (!$ticket) {
            throw new NotFoundHttpException;   
        }
        
        $request->validate([
            'content' => 'required|min:20',
        ]);
    
        TicketsReplies::create([
            'ticketid' => $id,
            'userid' => $ticket->userid,
            'adminid' => Auth::user()->id,
            'content' => $request->content,
        ]);
    
        $ticket->update([
            'status' => 'wait_customer',
        ]);

        return redirect(route('admin.tickets'))->with('success', 'Réponse envoyé.');
    }
    
    public function delete($id)
    {
        $ticket = Tickets::find($id);

        if (!$ticket) {
            throw new NotFoundHttpException;   
        }
    
        $ticket->update([
            'status' => 'closed',
        ]);

        return redirect(route('admin.tickets'))->with('success', 'Ticket clos.');
    }
}
