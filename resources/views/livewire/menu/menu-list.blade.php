<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Danh Sách Menu</label>
            <ul class="list-group">
                @foreach($menuItems as $item)
                    @if(isset($item['header']))
                        <li class="list-group-item header">
                            {{ $item['header'] }}
                            <button wire:click="editItem('{{ $item['header'] }}')" class="btn btn-warning btn-sm">Edit</button>
                                <button wire:click="deleteItem('{{ $item['header'] }}')" class="btn btn-danger btn-sm">Delete</button>
                        </li>
                        
                    @else
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="submenu" style="width:400px">
                                <a href="{{ url($item['url']) }}">
                                    <i class="{{ $item['icon'] }}"></i> {{ $item['text'] }}
                                </a>
                                @if(isset($item['submenu']))
                                    <ul class="list-group mt-2">
                                        @foreach($item['submenu'] as $submenu)
                                            <li class="list-group-item submenu-item" style="display:flex;justify-content:space-between">
                                                <a href="{{ url($submenu['url']) }}">
                                                    <i class="{{ $submenu['icon'] }}"></i> {{ $submenu['text'] }}
                                                </a>
                                                <div class="float-end">
                                                    <button wire:click="editItem('{{ $submenu['text'] }}')" class="btn btn-warning btn-sm">Edit</button>
                                                    <button wire:click="deleteItem('{{ $submenu['text'] }}')" class="btn btn-danger btn-sm">Delete</button>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div>
                                <button wire:click="editItem('{{ $item['text'] }}')" class="btn btn-warning btn-sm">Edit</button>
                                <button wire:click="deleteItem('{{ $item['text'] }}')" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>