<div>
    <h1>Edit Menu</h1>

    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <textarea wire:model="menuString" rows="20" class="form-control"></textarea>
        <button type="submit" class="btn btn-primary mt-3">Save Menu</button>
    </form>
</div>