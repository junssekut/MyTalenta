@extends(auth()->user()->role->name === 'student' ? 'layouts.mobile' : 'layouts.sidebar')

@section('title', 'Pemesanan Fasilitas - MyTalenta')

@section('content')
    <div class="min-h-screen">
        @livewire('booking.create-facility-booking')
    </div>
@endsection
