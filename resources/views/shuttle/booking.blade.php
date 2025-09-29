@extends(auth()->user()->role->name === 'student' ? 'layouts.mobile' : 'layouts.sidebar')

@section('title', 'Pemesanan Shuttle - MyTalenta')

@section('content')
    <div class="min-h-screen">
        @livewire('shuttle.shuttle-booking')
    </div>
@endsection
