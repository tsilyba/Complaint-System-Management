<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">
                            <i class="bi bi-bell-fill me-2 text-primary"></i>Notifications
                        </h2>
                        <p class="text-muted">Stay updated with the latest activity.</p>
                    </div>
                    
          
                </div>

                {{-- Notifications  --}}
                <div class="card shadow-sm border-0">
                    
                    {{-- Card  --}}
                    <div class="card-header bg-primary text-white py-3 border-0">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-list-ul me-2 text-white"></i>All Notifications
                        </h5>
                    </div>

                    <div class="card-body p-0">
                        
                        @if($notifications->isEmpty())
                            {{-- Empty State --}}
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-bell-slash text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                                </div>
                                <h5 class="text-muted fw-bold">No new notifications</h5>
                                <p class="text-muted small">You're all caught up!</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach($notifications as $notification)

                                   
                                    <div class="list-group-item list-group-item-action p-4 d-flex flex-column align-items-start 
                                        {{ $notification->is_read ? 'bg-light text-muted' : 'bg-white border-start border-5' }}"
                                        style="{{ !$notification->is_read ? 'border-color: #6d4c41 !important;' : '' }}">
                                        
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                            {{-- Title --}}
                                            <h5 class="mb-1 {{ $notification->is_read ? '' : 'fw-bold text-primary' }}">
                                                @if(!$notification->is_read)
                                                    <i class="bi bi-circle-fill text-danger me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>
                                                @endif
                                                {{ $notification->title }}
                                            </h5>
                                            
                                            {{-- Time --}}
                                            <small class="{{ $notification->is_read ? 'text-muted' : 'text-dark fw-semibold' }}">
                                                <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        
                                        {{-- Message --}}
                                        <p class="mb-2 {{ $notification->is_read ? 'small' : '' }}">
                                            {{ $notification->message }}
                                        </p>
                                        
                                        {{-- Mark as Read Button --}}
                                        @if(!$notification->is_read)
                                            <div class="mt-2">
                                                <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="bi bi-check2 me-1"></i>Mark as Read
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Pagination Footer --}}
                    @if($notifications instanceof \Illuminate\Pagination\LengthAwarePaginator && $notifications->hasPages())
                        <div class="card-footer bg-white py-3">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>