@php
    $modalAction = Route::has('admin.alumni.store') ? route('admin.alumni.store') : '#';
@endphp

<!-- Standard Bootstrap modal (no blade component) -->
<div class="modal fade" id="addAlumniModal" tabindex="-1" aria-labelledby="addAlumniModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlumniModalLabel">Add Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ $modalAction }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- form fields --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="major" class="form-label">Program Studi</label>
                            @if (isset($major) &&
                                    (is_array($major) ||
                                        $major instanceof \Illuminate\Contracts\Support\Arrayable ||
                                        (is_object($major) && count((array) $major) > 0)))
                                <select id="major" name="major_id"
                                    class="form-control @error('major') is-invalid @enderror">
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($major as $m)
                                        @php
                                            $val = is_object($m) ? $m->id ?? $m : $m;
                                            $label = is_object($m) ? $m->name ?? $m : $m;
                                        @endphp
                                        <option value="{{ $val }}"
                                            {{ (string) old('major') === (string) $val || (string) old('major') === (string) $label ? 'selected' : '' }}>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input id="major" name="major" type="text"
                                    class="form-control @error('major') is-invalid @enderror"
                                    value="{{ old('major') }}">
                            @endif
                            @error('major')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nim" class="form-label">NIM</label>
                            <input id="nim" name="nim" type="text"
                                class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="photo" class="form-label">Photo</label>
                            <input id="photo" name="photo_profile" type="file"
                                class="form-control @error('photo_profile') is-invalid @enderror">
                            @error('photo_profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- end fields --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Alumni</button>
            </div>
            </form>
        </div>
    </div>
</div>
