@if (session('status'))
<div class="notification is-black">
	<p><small>{{ session('status') }}</small></p>
</div>
@endif
