@extends('layouts.pelanggan')

@section('title', 'Buat Order')
@section('page-title', 'Order Baru')

@section('content')
    <form action="{{ route('pelanggan.orders.store') }}" method="POST" id="orderForm" autocomplete="off">
        @csrf
        <div class="row row-cards">

            <div class="col-lg-5">
                <div class="card mb-3">
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-header">
                        <h3 class="card-title text-heading">Informasi Order</h3>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label required">Tipe Order</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-selectgroup-item flex-fill">
                                        <input type="radio" name="tipe_order" value="datang_langsung"
                                               class="form-selectgroup-input tipe-order-radio"
                                            {{ old('tipe_order', 'datang_langsung') == 'datang_langsung' ? 'checked' : '' }}>
                                        <span class="form-selectgroup-label d-flex align-items-center gap-2 py-2"
                                              style="border-radius: 6px;">
                    <i class="ti ti-building-store fs-2 text-primary"></i> Datang Langsung
                  </span>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="form-selectgroup-item flex-fill">
                                        <input type="radio" name="tipe_order" value="delivery"
                                               class="form-selectgroup-input tipe-order-radio"
                                            {{ old('tipe_order') == 'delivery' ? 'checked' : '' }}>
                                        <span class="form-selectgroup-label d-flex align-items-center gap-2 py-2"
                                              style="border-radius: 6px;">
                    <i class="ti ti-moped fs-2 text-orange"></i> Delivery (Dijemput Kurir)
                  </span>
                                    </label>
                                </div>
                            </div>
                            @error('tipe_order')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="alamatJemputWrapper">
                            <label class="form-label required">Alamat Penjemputan</label>
                            <textarea name="alamat_jemput"
                                      id="alamatJemput"
                                      class="form-control @error('alamat_jemput') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Masukkan alamat lengkap penjemputan cucian">{{ old('alamat_jemput', $pelanggan->alamat) }}</textarea>
                            @error('alamat_jemput')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Alamat diisi otomatis sesuai profil Anda. Anda dapat menggantinya jika lokasi penjemputan berbeda.</small>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan" class="form-control" rows="3"
                                      placeholder="Contoh: Lipat dua, jangan pakai pewangi mawar, dll. (Opsional)">{{ old('catatan') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between pb-2">
                        <div>
                            <h3 class="card-title text-heading">Item Layanan</h3>
                            <p class="text-secondary small mb-0">Pilih jenis layanan laundry yang diambil</p>
                        </div>
                        <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1"
                                id="addItem" style="border-radius: 6px;">
                            <i class="ti ti-plus fs-2"></i> Tambah Item
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table" id="itemTable">
                            <thead>
                            <tr>
                                <th>Layanan</th>
                                <th style="width: 140px;">Jumlah / Berat</th>
                                <th style="width: 130px;" class="text-end">Harga Satuan</th>
                                <th style="width: 130px;" class="text-end">Subtotal</th>
                                <th style="width: 44px;"></th>
                            </tr>
                            </thead>
                            <tbody id="itemRows">
                            <tr class="item-row align-middle">
                                <td>
                                    <select name="items[0][layanan_id]" class="form-select layanan-select" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach($layanan as $l)
                                            <option value="{{ $l->id }}" data-harga="{{ $l->harga }}"
                                                    data-satuan="{{ $l->satuan }}">
                                                {{ $l->nama }} ({{ $l->harga_formatted }}/{{ $l->satuan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <div class="input-group input-group-flat">
                                        <input type="number" name="items[0][jumlah]"
                                               class="form-control text-end jumlah-input" min="0.1" step="0.1" value="1"
                                               required>
                                        <span class="input-group-text satuan-label bg-light px-2">kg</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="harga-display text-secondary small">-</span>
                                </td>
                                <td class="text-end">
                                    <span class="subtotal-display fw-semibold text-heading">-</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-ghost-danger remove-row"
                                            disabled style="border-radius: 6px;">
                                        <i class="ti ti-trash fs-2"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr class="bg-muted-lt fw-bold text-heading">
                                <td colspan="3" class="text-end py-3">TOTAL BAYAR :</td>
                                <td class="text-end text-primary py-3 fs-3" id="grandTotal">Rp 0</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    @error('items')
                    <div class="alert alert-important alert-danger m-3 d-flex align-items-center mb-0" role="alert">
                        <i class="ti ti-alert-circle me-2 fs-2"></i>
                        <div>{{ $message }}</div>
                    </div>
                    @enderror
                </div>

                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="{{ route('pelanggan.orders.index') }}" class="btn btn-ghost-secondary" style="border-radius: 6px;">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1"
                            style="border-radius: 6px;">
                        <i class="ti ti-check fs-2"></i> Buat Order & Simpan
                    </button>
                </div>
            </div>

        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const layananData = @json($layanan->keyBy('id'));
        let rowIndex = 1;

        function formatRupiah(n) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
        }

        function calcRow(row) {
            const sel = row.querySelector('.layanan-select');
            const opt = sel.options[sel.selectedIndex];
            const harga = parseFloat(opt?.dataset?.harga || 0);
            const jumlah = parseFloat(row.querySelector('.jumlah-input').value || 0);
            const satuan = opt?.dataset?.satuan || 'kg';
            const subtotal = harga * jumlah;

            row.querySelector('.harga-display').textContent = harga ? formatRupiah(harga) : '-';
            row.querySelector('.subtotal-display').textContent = subtotal ? formatRupiah(subtotal) : '-';
            row.querySelector('.satuan-label').textContent = satuan;
            calcTotal();
        }

        function calcTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const sel = row.querySelector('.layanan-select');
                const opt = sel.options[sel.selectedIndex];
                const harga = parseFloat(opt?.dataset?.harga || 0);
                const jumlah = parseFloat(row.querySelector('.jumlah-input').value || 0);
                total += harga * jumlah;
            });
            document.getElementById('grandTotal').textContent = formatRupiah(total);
        }

        function bindRow(row) {
            row.querySelector('.layanan-select').addEventListener('change', () => calcRow(row));
            row.querySelector('.jumlah-input').addEventListener('input', () => calcRow(row));
            row.querySelector('.remove-row').addEventListener('click', () => {
                row.remove();
                updateIndexes();
                calcTotal();
            });
        }

        function updateIndexes() {
            document.querySelectorAll('.item-row').forEach((row, i) => {
                row.querySelector('.layanan-select').name = `items[${i}][layanan_id]`;
                row.querySelector('.jumlah-input').name = `items[${i}][jumlah]`;
                const btn = row.querySelector('.remove-row');
                btn.disabled = document.querySelectorAll('.item-row').length === 1;
            });
        }

        document.querySelectorAll('.item-row').forEach(bindRow);

        document.getElementById('addItem').addEventListener('click', () => {
            const tbody = document.getElementById('itemRows');
            const tmpl = tbody.querySelector('.item-row').cloneNode(true);

            tmpl.querySelector('.layanan-select').selectedIndex = 0;
            tmpl.querySelector('.jumlah-input').value = 1;
            tmpl.querySelector('.harga-display').textContent = '-';
            tmpl.querySelector('.subtotal-display').textContent = '-';
            tmpl.querySelector('.satuan-label').textContent = 'kg';
            tmpl.querySelector('.remove-row').disabled = false;

            tbody.appendChild(tmpl);
            bindRow(tmpl);
            updateIndexes();
        });

        const tipeOrderRadios = document.querySelectorAll('.tipe-order-radio');
        const alamatJemputWrapper = document.getElementById('alamatJemputWrapper');
        const alamatJemputInput = document.getElementById('alamatJemput');

        // Simpan alamat asli pelanggan dari profil agar tidak hilang saat switch radio
        const defaultAlamat = @json($pelanggan->alamat);

        function toggleAlamatJemput() {
            const selected = document.querySelector('.tipe-order-radio:checked')?.value;

            if (selected === 'delivery') {
                alamatJemputWrapper.style.display = 'block';
                alamatJemputInput.setAttribute('required', 'required');

                // Kembalikan isi alamat jika sebelumnya kosong
                if (!alamatJemputInput.value) {
                    alamatJemputInput.value = defaultAlamat;
                }
            } else {
                alamatJemputWrapper.style.display = 'none';
                alamatJemputInput.removeAttribute('required');
            }
        }

        tipeOrderRadios.forEach(radio => radio.addEventListener('change', toggleAlamatJemput));

        // Eksekusi saat halaman pertama kali dimuat
        toggleAlamatJemput();

        const orderForm = document.getElementById('orderForm');

        orderForm.addEventListener('submit', function (e) {
            if (orderForm.dataset.confirmed === 'true') {
                return;
            }

            e.preventDefault();

            if (!orderForm.reportValidity()) {
                return;
            }

            const jumlahItem = document.querySelectorAll('.item-row').length;
            const totalBayar = document.getElementById('grandTotal').textContent;
            const tipeOrder = document.querySelector('.tipe-order-radio:checked')?.value === 'delivery'
                ? 'Delivery (Dijemput Kurir)'
                : 'Datang Langsung';

            Swal.fire({
                title: 'Buat Order Baru?',
                html: `
      Tipe Order: <b>${tipeOrder}</b><br>
      Jumlah item layanan: <b>${jumlahItem}</b><br>
      Total bayar: <b>${totalBayar}</b><br><br>
      Pastikan data sudah benar sebelum disimpan.
    `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Buat Order',
                cancelButtonText: 'Periksa Lagi',
                confirmButtonColor: '#206bc4',
                cancelButtonColor: '#626976',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    orderForm.dataset.confirmed = 'true';
                    orderForm.submit();
                }
            });
        });
    </script>
@endpush
