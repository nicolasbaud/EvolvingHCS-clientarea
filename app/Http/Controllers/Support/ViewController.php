<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use App\Models\Tickets;
use App\Models\TicketsReplies;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedException;
use Illuminate\Validation\Rule;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render($id)
    {
        if (Tickets::where('userid', Auth::user()->id)->where('ticketid', $id)->count() != '1') {
            throw new NotFoundHttpException;
        }
        return view('support.ticket', [
            'ticket' => Tickets::where('userid', Auth::user()->id)->where('ticketid', $id)->first(),
            'replies' => TicketsReplies::where('userid', Auth::user()->id)->where('ticketid', $id)->orderBy('id', 'DESC')->get(),
        ]);
    }

    public function create(Request $request)
    {
        if (Tickets::where('userid', Auth::user()->id)->where('status', 'open')->count() >= '5') {
            throw new AccessDeniedException ;
        }

        $request->validate([
            'subject' => 'required|max:100',
            'department' => ['required','max:100', Rule::in(['Technique', 'Facturation', 'Commercial', 'Autre'])],
            'content' => 'required|min:20',
        ]);

        $ticketid = rand(0000000, 10000000);
    
        Tickets::create([
            'ticketid' => $ticketid,
            'userid' => Auth::user()->id,
            'department' => $request->department,
            'subject' => $request->subject,
            'status' => 'open',
        ]);
    
        TicketsReplies::create([
            'ticketid' => $ticketid,
            'userid' => Auth::user()->id,
            'content' => $request->content,
        ]);
        return redirect(route('ticket', ['id' => $ticketid]))->with('success', 'Ticket crée.');
    }

    public function update($id, Request $request)
    {
        if (Tickets::where('userid', Auth::user()->id)->where('ticketid', $id)->count() != '1') {
            throw new NotFoundHttpException;
        }

        $request->validate([
            'content' => 'required|min:20',
        ]);
    
        TicketsReplies::create([
            'ticketid' => $id,
            'userid' => Auth::user()->id,
            'content' => $request->content,
        ]);
    
        Tickets::where('ticketid', $id)->update([
            'status' => 'wait_staff',
        ]);
        return redirect(route('ticket', ['id' => $id]))->with('success', 'Réponse envoyé.');
    }

    public function delete($id)
    {
        if (Tickets::where('userid', Auth::user()->id)->where('ticketid', $id)->count() != '1') {
            throw new NotFoundHttpException;
        }
        Tickets::where('userid', Auth::user()->id)->where('ticketid', $id)->update([
            'status' => 'closed',
        ]);
        return redirect(route('tickets'))->with('success', 'Ticket clos.');
    }
}
