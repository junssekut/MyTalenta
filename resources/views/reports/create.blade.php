@extends(auth()->user()->role->name === 'student' ? 'layouts.mobile' : 'layouts.sidebar')

@section('title', 'Buat Laporan - MyTalenta')

@section('content')
    <div class="min-h-screen">
        @livewire('reports.create-report')
    </div>
@endsection
