<div class="card">
    <div class="overflow-x-auto">
        <table class="{{ $tableClass ?? 'min-w-full divide-y divide-gray-200' }}">
            @if(isset($headers))
                <thead>
                    <tr>
                        @foreach($headers as $header)
                            <th class="{{ is_array($header) ? ($header['class'] ?? '') : '' }}"
                                @if(is_array($header) && isset($header['width'])) style="width: {{ $header['width'] }};" @endif>
                                {{ is_array($header) ? ($header['label'] ?? '') : $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if(isset($paginator) && $paginator->hasPages())
        <div class="pagination-wrapper p-4">
            {{ $paginator->links() }}
        </div>
    @endif
</div>
