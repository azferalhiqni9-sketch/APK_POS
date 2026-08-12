@extends('layouts.app')

@section('title', 'Tambah Jenis')

@section('content')
<h4>Tambah Jenis</h4>

<form action="{{ route('jenis.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('jenis._form', ['jenis' => null])
</form>
@endsection