@extends('layouts.admin')

@section('content')

    <h3 class="fs-4 mb-3 fw-bold">Edit User</h3>
    <div class="card shadow-sm border-0">

        {{--  Header --}}
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-secondary">
                Update Resident Information
            </h5>
        </div>

        {{--  Body --}}
        <div class="card-body">

            {{-- Update User Form --}}
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- User Name Input --}}
                <div class="mb-3">
                    <label class="form-label fw-bold" for="name">
                        Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                    >

                    {{-- Validation Error Message --}}
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- User Email Input --}}
                <div class="mb-3">
                    <label class="form-label fw-bold" for="email">
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                    >

                    {{-- Validation Error Message --}}
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Form Action Buttons --}}
                <div class="d-flex gap-2">

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-primary">
                        Save Changes
                    </button>

                    {{-- Back --}}
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                        Back
                    </a>

                </div>
            </form>
        </div>
    </div>

@endsection
