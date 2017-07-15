@if(session()->has('alert'))
<div class="alert alert-{{ session()->get('response') }}" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    {{ session()->get('alert') }}
</div>
@endif