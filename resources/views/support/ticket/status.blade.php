<p><b>Statut:</b> 
  @if ($ticket->status == 'open')
    <span>Ouvert</span>
  @elseif ($ticket->status == 'wait_staff')
    <span>En attente du staff</span>
  @elseif ($ticket->status == 'wait_customer')
    <span>En attente du client</span>
  @elseif ($ticket->status == 'closed')
    <span>Clos</span>
  @else
    <span class="badge bg-dark">{{ $ticket->status }}</span>
  @endif
</p>