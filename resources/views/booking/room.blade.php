@extends(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'student' ? 'layouts.mobile' : 'layouts.sidebar')

@section('title', 'Peminjaman Ruangan - MyTalenta')

@section('content')
    <div class="min-h-screen">
        @livewire('booking.create-room-booking')
    </div>
@endsection
