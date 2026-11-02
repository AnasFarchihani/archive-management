<div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                    <label class="form-label" for="f-name">Nom Complet
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="f-name"
                        name="name"
                        required 
                        value="{{ old('name', $user?->name) }}">
                        @error('name')
                        <div class="invalid-feedback">  {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                    <label class="form-label" for="f-email">Adresse e-mail
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="f-email"
                        name="email"
                        required 
                        value="{{ old('email', $user?->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                    <label class="form-label" for="f-password">Mot de passe
                        <span class="text-danger" aria-hidden="true">*</span>
                        @if ($user) <small class="text-muted">(laisser vide pour ne pas changer)</small> @endif
                    </label>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="f-password"
                        name="password"
                        {{ $user ? '' : 'required' }}> 
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                    <label class="form-label" for="f-password_confirmation">Confirmer le mot de passe
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="password"
                        class="form-control"
                        id="f-password_confirmation"
                        name="password_confirmation"
                        {{ $user ? '' : 'required' }}>
                    </div>
                    <div class="col-md-6">
                    <label class="form-label" for="f-role">Rôle
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <select
                        class="form-select @error('role') is-invalid @enderror"
                        id="f-role"
                        name="role"
                        required>
                        {{-- <option value="">Sélectionner…</option> --}}
                        @foreach($roles as $role)
                            <option value="{{ $role->value }}"
                                {{ old('role', $user?->role->value) === $role->value ? 'selected' : '' }}>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="f-department">Département
                            <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <select
                            class="form-select @error('department_id') is-invalid @enderror"
                            id="f-department"
                            name="department_id"
                            >
                            <option value="">— Aucun (Admin) —</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('department_id', $user?->department_id) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }} ({{ $dept->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input
                        type="checkbox"
                        name="is_active"
                        id="is_active" value="1"
                        class="form-check-input"
                        {{ old('is_active', $user?->is_active ?? true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Compte actif</label>
                    </div>
                </div>
            </div>