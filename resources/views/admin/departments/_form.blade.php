        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="f-code">Code
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('code') is-invalid @enderror"
                        id="f-code"
                        name="code"
                        value="{{ old('code', $department?->code) }}"
                        required >
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="f-nom">Nom
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        id="f-nom"
                        name="name"
                        value="{{ old('name', $department?->name) }}"
                        required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label" for="f-description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="f-description" rows="3">{{ old('description', $department?->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                    class="form-check-input"
                    {{ old('is_active', $department?->is_active ?? true) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Département actif</label>
                </div>
            </div>
        </div>