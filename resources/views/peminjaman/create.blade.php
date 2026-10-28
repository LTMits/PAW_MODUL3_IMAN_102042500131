@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="fw-bold mb-1">Transaksi Peminjaman Buku</h3>
                <p class="text-muted small mb-0">Catat peminjaman buku oleh anggota perpustakaan.</p>
            </div>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    {{-- TODO:- Buat dropdown select 'anggota_id' untuk memilih anggota peminjam --}}
                    {{--       - Buat dropdown select 'buku_id' untuk memilih buku yang akan dipinjam --}}
                    {{--       - Buat input field 'tanggal_pinjam' bertipe date --}}
                    {{--       - Tampilkan pesan error validasi di bawah setiap input jika ada error (@error) --}}
                    {{--       - Buat tombol submit untuk menyimpan transaksi peminjaman --}}

                    {{-- Input Anggota (Dropdown) --}}
                    <div class="mb-3 mt-3">
                        <label for="anggota_id" class="form-label">Anggota Peminjam <span class="text-danger">*</span></label>
                        <select class="form-select @error('anggota_id') is-invalid @enderror" id="anggota_id" name="anggota_id" required>
                            <option value="" disabled selected>-- Pilih Anggota --</option>
                            @foreach($anggota as $a)
                                <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama }} ({{ $a->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Buku (Dropdown) --}}
                    <div class="mb-3">
                        <label for="buku_id" class="form-label">Buku yang Dipinjam <span class="text-danger">*</span></label>
                        <select class="form-select @error('buku_id') is-invalid @enderror" id="buku_id" name="buku_id" required>
                            <option value="" disabled selected>-- Pilih Buku --</option>
                            @foreach($buku as $b)
                                <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->judul }} (Stok: {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Tanggal Pinjam --}}
                    <div class="mb-4">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <!-- Secara default diset ke hari ini menggunakan date('Y-m-d') -->
                        <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Transaksi
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection