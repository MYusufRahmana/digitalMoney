@extends('layouts.app')

@section('title', 'Profil - Money Tracker')
@section('page-title', 'Profil Saya')

@section('content')
    <!-- User Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-primary p-3 me-3">
                    <i class="bi bi-person fs-1 text-white"></i>
                </div>
                <div>
                    <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                    <small class="text-muted">Bergabung: {{ Auth::user()->created_at->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    </div>

@endsection
