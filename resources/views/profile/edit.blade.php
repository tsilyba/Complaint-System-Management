<x-app-layout>
    <div class="container py-5">
        
        {{-- PAGE HEADER --}}
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <h2 class="fw-bold text-dark mb-1">
                    <i class="bi bi-person-gear me-2 text-primary"></i>Account Settings
                </h2>
                <p class="text-muted">Manage your profile details and security preferences.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                {{-- 1. SUCCESS NOTIFICATIONS --}}
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>Profile updated successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @elseif (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                        <i class="bi bi-shield-check me-2"></i>Password changed successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- 2. PROFILE INFORMATION CARD --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-person-lines-fill me-2"></i>Profile Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            {{-- Name Field --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold text-secondary">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Email Field --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold text-secondary">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                
                                {{-- Email Verification Check --}}
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="alert alert-warning mt-2 d-flex align-items-center" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <div>
                                            Your email is unverified.
                                            <button form="send-verification" class="btn btn-link p-0 text-decoration-none fw-bold">
                                                Click here to resend.
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- 3. UPDATE PASSWORD CARD  --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-key-fill me-2"></i>Update Password
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="update_password_current_password" class="form-label fw-bold text-secondary">Current Password</label>
                                <input type="password" class="form-control" id="update_password_current_password" name="current_password" autocomplete="current-password">
                                
                                @if($errors->updatePassword->has('current_password'))
                                    <div class="text-danger small mt-1">
                                        {{ $errors->updatePassword->first('current_password') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="update_password_password" class="form-label fw-bold text-secondary">New Password</label>
                                <input type="password" class="form-control" id="update_password_password" name="password" autocomplete="new-password">
                                
                                @if($errors->updatePassword->has('password'))
                                    <div class="text-danger small mt-1">
                                        {{ $errors->updatePassword->first('password') }}
                                    </div>
                                @endif
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3">
                                <label for="update_password_password_confirmation" class="form-label fw-bold text-secondary">Confirm New Password</label>
                                <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
                                
                                @if($errors->updatePassword->has('password_confirmation'))
                                    <div class="text-danger small mt-1">
                                        {{ $errors->updatePassword->first('password_confirmation') }}
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end align-items-center gap-3">
                                @if (session('status') === 'password-updated')
                                    <span class="text-success small fw-bold" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                        <i class="bi bi-check-circle me-1"></i>Saved.
                                    </span>
                                @endif

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-shield-lock me-1"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- 4. DELETE ACCOUNT ZONE --}}
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger bg-opacity-10 py-3 border-danger">
                        <h5 class="mb-0 fw-bold text-danger">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>Delete Account
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data or information that you wish to retain before deleting your account.
                        </p>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                            <i class="bi bi-trash-fill me-1"></i>Delete Account
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL: CONFIRM DELETION --}}
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold text-danger">Are you sure?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <p class="text-muted">
                            This action cannot be undone. Please enter your password to confirm you would like to permanently delete your account.
                        </p>
                        <div class="mt-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password to confirm">
                            @error('password', 'userDeletion') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>