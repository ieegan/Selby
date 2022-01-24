@if (session('status'))
<div class="notification is-success">
	<p>{{ session('status') }}</p>
</div>
@endif
