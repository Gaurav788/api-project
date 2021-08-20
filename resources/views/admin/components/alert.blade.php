<div class="flash-message">
    @if(session()->has('status'))
        <div class="alert alert-{{ session()->get('status') == 'success' ? 'success' : 'danger' }} alert-dismissible ">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('message') }}
        </div>
    @endif
</div>