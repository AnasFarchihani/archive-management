<div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="f-number">N° de documentaire
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('document_number') is-invalid @enderror"
                        id="f-number"
                        name="document_number"
                        value="{{ old('document_number', $archive?->document_number) }}"
                        >
                    @error('document_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="f-title">Titre
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('title') is-invalid @enderror"
                        id="f-title"
                        name="title"
                        value="{{ old('title', $archive?->title) }}"
                        >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                        <label class="form-label" for="f-subject">Objet
                            <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <textarea
                            name="subject"
                            id="f-subject"
                            class="form-control">
                            {{ old('subject', $archive?->subject) }}
                        </textarea>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                    <label class="form-label" for="f-sender">Expéditeur / source 
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        id="f-sender"
                        name="sender"
                        value="{{ old('sender', $archive?->sender) }}"
                        >
                        @error('sender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="col-md-6">
                    <label class="form-label" for="f-type">Type de documentaire
                        <span class="text-danger" aria-hidden="true">*</span>
                    </label>
                    <select
                        class="form-select"
                        id="f-type"
                        name="document_type"
                        >
                        <option value="">Sélectionner…</option>
                        @foreach ($types as $type)
                        <option value="{{ $type->value }}"
                            {{ old('document_type', $archive?->document_type->value) === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                        @endforeach
                        
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                    <div class="col-md-6">
                        <label class="form-label" for="f-date">Date de dépôt
                            <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="date"
                            class="form-control @error('submission_date') is-invalid @enderror"
                            id="f-date"
                            name="submission_date"
                            value="{{ old('submission_date', $archive?->submission_date?->format('Y-m-d')) }}"
                            >
                        @error('submission_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="f-expiry">Date d'expiration</label>
                        <input
                            type="date"
                            class="form-control"
                            id="f-expiry"
                            name="expiry_date"
                            value="{{ old('expiry_date', $archive?->expiry_date?->format('Y-m-d')) }}">
                    </div>
                    @if(auth()->user()->isAdmin())
                        <div class="col-md-6">
                            <label class="form-label" for="f-department">Département
                                <span class="text-danger" aria-hidden="true">*</span>
                            </label>
                            <select
                                class="form-select"
                                id="f-department"
                                name="department_id"
                                >
                                <option value="">- Sélectionner -</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        {{ old('department_id', $archive?->department_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }} ({{ $dept->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label class="form-label" for="f-status">Statut
                            <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <select
                            class="form-select"
                            id="f-status"
                            name="archive_status"
                            >
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('archive_status', $archive?->archive_status->value) === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('archive_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="f-notes">Notes</label>
                        <textarea
                            class="form-control"
                            id="f-notes"
                            name="notes"
                            rows="3">
                            {{ old('notes', $archive?->notes) }}
                        </textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="f-location">Emplacement physique
                            <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <select
                            class="form-select"
                            id="f-location"
                            name="storage_location_id"
                            >

                            <option value="">- Sélectionner -</option>
                            @foreach ($locations as $loc)
                                <option value="{{ $loc->id }}"
                                    {{ old('storage_location_id', $archive?->storage_location_id) == $loc->id ? 'selected' : '' }}>
                                    {{ $loc->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                        <dl class="loc-detail row g-2 mt-2 mb-0 d-none" id="locDetail"></dl>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="f-files">Fichiers numériques</label>
                        <input
                            class="form-control"
                            type="file"
                            id="f-files"
                            name="files[]"
                            multiple
                            accept=".pdf,.png,.jpg,.jpeg,.doc,.docx">
                        <div class="form-text">PDF, images ou documents Word. Les fichiers ne sont pas envoyés dans cette démonstration.</div>
                        <ul class="file-list list-unstyled mt-2" id="filePreview"></ul>
                    </div>
                </div>
            </div>