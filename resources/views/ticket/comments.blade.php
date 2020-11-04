
<div class="card">
    <div class="card-header">{{ __('Messages') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 mb-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>    
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <button type="button" class="btn w-100 d-block btn-outline-light" data-toggle="modal"
                    data-target=".bd-example-modal-lg">Send message</button>
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formSendMessage" action="{{route('ticketMessages.storeViaPanel')}}" method="POST">
                                    @csrf
                                    @if($ticket->email == null)
                                    <div class="form-group">
                                            <label for="message-text" class="col-form-label">E-mail:</label>
                                            <input type="text"  class="form-control" name="email" id="email-text"></textarea>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Content:</label>
                                        <textarea class="form-control" name="content" id="message-text"></textarea>
                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                                <button id="btnSendMessage" type="button" class="btn btn-outline-primary">Send message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$ticket->messages->isEmpty())
            <div class="col-12 col-md-4 order-2 order-md-1">
                <div class="list-group" id="myList" role="tablist">
                    @foreach($ticket->messages as $message)

                    <a class="list-group-item list-group-item-action   @if ($loop->first)  active  @endif"
                        data-toggle="list" href="#message{{$message->id}}" role="tab">
                        <p>{{$message->sender_email}}</p>
                        <p><strong>{{$message->created_at->format('Y-m-d H:i:s')}}</strong></p>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-8 order-1 order-md-2">
                <div class="tab-content">
                    @foreach($ticket->messages as $message)
                    <div class="tab-pane  @if ($loop->first)  active  @endif" id="message{{$message->id}}"
                        role="tabpanel">
                        <p><strong>Content:</strong></p>
                        <iframe class='iframe-message w-100' src="{{$message->getUrlBody()}}" frameborder="0"></iframe>
                        <a href="{{$message->getUrlBody()}}" target="_blank">Preview</a>
                    </div>
                    @endforeach
                    <script type="application/javascript">
                        $(document).ready(function(){
                            $(".list-group-item.list-group-item-action").click(function() {
                                $('.iframe-message').each(function() {
                                    this.contentWindow.location.reload(true);
                                });
                               
                            });
                            $('.iframe-message').load(function() {
                                    this.style.height =
                                    this.contentWindow.document.body.offsetHeight + 'px';
                            });
                        });

                      
                    </script>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script type="application/javascript">
$(document).ready(function(){
    $('#btnSendMessage').click(function(){
        $('#formSendMessage').submit();
    });
});
</script>
