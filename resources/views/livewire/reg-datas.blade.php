<div class="p-10">
    <h1 class="font-bold text-2xl text-center">Data Undian Pajak Daerah Tahun 2024</h1>

    <table class="my-10 mx-auto min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="border px-4 py-2">No.</th>
                <th class="border px-4 py-2">NIK</th>
                <th class="border px-4 py-2">Nama WP</th>
                <th class="border px-4 py-2">No. Pendaftaran</th>
                <th class="border px-4 py-2">Merchant</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataregs as $index => $reg)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $index + 1 + ($dataregs->currentPage() - 1) * $dataregs->perPage() }}</td>
                    <td class="border px-4 py-2 text-center">{{ $reg->nik }}</td>
                    <td class="border px-4 py-2 text-center">{{ $reg->nm_wp }}</td>
                    <td class="border px-4 py-2 text-center">{{ $reg->id }}</td>
                    <td class="border px-4 py-2 text-center">{{ $reg->nm_merchant }}</td>
                    <td class="border px-4 py-2 text-center">{{ $reg->reg_status }}</td>
                    <td class="border px-4 py-2 text-center">
                        <a href="" class="btn py-1 px-2 bg-blue-600 text-white rounded-md">Validasi</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="border px-4 py-2 text-center">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginasi -->
    <div class="mt-4">
    {{ $dataregs->onEachSide(1)->links('pagination::tailwind') }}
</div>

</div>
