@csrf

<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Nama</label>
    <input type="text" name="name" class="form-control bg-light @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name ?? '') }}" placeholder="Masukkan nama lengkap" required>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Email</label>
    <input type="email" name="email" class="form-control bg-light @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email ?? '') }}" placeholder="nama@example.com" required>
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Password</label>
    <input type="password" name="password" class="form-control bg-light @error('password') is-invalid @enderror" 
        placeholder="Minimal 8 karakter" minlength="8" {{ isset($user) ? '' : 'required' }}>
    @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
    @if(isset($user))
        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
    @endif
</div>

<div class="mb-4">
    <label class="form-label fw-semibold text-secondary">Role</label>
    <select name="role_id" class="form-select bg-light @error('role_id') is-invalid @enderror" required>
        <option value="" selected disabled>-- Pilih Role --</option>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>
    @error('role_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.users') }}" class="btn btn-light px-4 border">Batal</a>
    <button type="submit" class="btn btn-primary px-4 shadow-sm">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
</div>