<div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="f-name">Nom
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control  @error('name') is-invalid @enderror"
                        id="f-name"
                        name="name"
                        value="{{ old('name', $storageLocation?->name) }}"
                        required >
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="f-floor">Étage
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('floor') is-invalid @enderror"
                        id="f-floor"
                        name="floor"
                        value="{{ old('floor', $storageLocation?->floor) }}"
                        required >
                    @error('floor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="f-room">Salle
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('room') is-invalid @enderror""
                        id="f-room"
                        name="room"
                        value="{{ old('room', $storageLocation?->room) }}"
                        required >
                    @error('room') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="f-cabinet">Armoire
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('cabinet') is-invalid @enderror"
                        id="f-cabinet"
                        name="cabinet"
                        value="{{ old('cabinet', $storageLocation?->cabinet) }}"
                        required >
                    @error('cabinet') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="f-shelf">Étagère
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('shelf') is-invalid @enderror"
                        id="f-shelf"
                        name="shelf"
                        value="{{ old('shelf', $storageLocation?->shelf) }}"
                        required >
                    @error('shelf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="f-box">Boîte
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('box') is-invalid @enderror"
                        id="f-box"
                        name="box"
                        value="{{ old('box', $storageLocation?->box) }}"
                        required >
                    <div class="invalid-feedback"></div>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label" for="status">Description</label>
                    <textarea
                    name="description"
                    id="description" rows="3"
                    class="form-control">{{ old('description', $storageLocation?->description) }}</textarea>
                </div>

                <div class="mb-3 form-check">
                    <input
                    type="checkbox"
                    name="is_active" id="is_active" value="1"
                    class="form-check-input"
                    {{ old('is_active', $storageLocation?->is_active ?? true) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Emplacement actif</label>
                </div>
            </div>
        </div>