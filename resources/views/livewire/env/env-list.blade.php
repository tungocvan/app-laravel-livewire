<div>
    <h1>Chỉnh sửa file .env</h1>
    <ul>
        @foreach($envVariables as $line)
            @php
                $line = trim($line);
                if (strpos($line, '=') !== false) {
                    [$key, $value] = explode('=', $line, 2);
                    $value = trim($value);
                } else {
                    $key = $line;
                    $value = '';
                }
            @endphp
            <li>
                <strong>{{ $key }}</strong>: {{ $value }}
                <button wire:click="openModal('{{ $key }}', '{{ $value }}')">Chỉnh sửa</button>
                <button wire:click="deleteEnv('{{ $key }}')">Xóa</button>
            </li>
        @endforeach
    </ul>

    <!-- Modal -->
    <div id="modal" style="display: none;">
        <div style="background: rgba(0, 0, 0, 0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000;"></div>
        <div style="background: white; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; z-index: 1001;">
            <h2>Chỉnh sửa {{ $selectedKey }}</h2>
            <input type="text" wire:model="selectedValue" />
            <button wire:click="updateEnv">Cập nhật</button>
            <button wire:click="$set('selectedKey', null)">Đóng</button>
        </div>
    </div>

    <script>
        window.addEventListener('open-modal', () => {
            document.getElementById('modal').style.display = 'block';
        });

        window.addEventListener('close-modal', () => {
            document.getElementById('modal').style.display = 'none';
        });
    </script>
</div>