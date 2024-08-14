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
            </tr>
        </thead>
        <tbody>
            @foreach($dataregs as $index => $reg)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $reg->nik }}</td>
                    <td class="border px-4 py-2">{{ $reg->nm_wp }}</td>
                    <td class="border px-4 py-2">{{ $reg->id }}</td>
                    <td class="border px-4 py-2">{{ $reg->nm_merchant }}</td> <!-- Merchant name from join -->
                    <td class="border px-4 py-2">{{ $reg->status_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
