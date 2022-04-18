{{-- Extends layout --}}
@extends('layouts.app')

{{-- Content --}}
@section('content')
    <status-matrix :matrix="{{ $statusMatrix  }}" :roles="{{ $roles  }}">

    </status-matrix>
@endsection
