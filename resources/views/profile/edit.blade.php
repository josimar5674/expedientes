@extends('layouts.app')

@section('content')



<div class="py-12">
    
    <div class="max-w-4xl mx-auto space-y-6">
        <div style="margin-bottom:15px;">
    <a href="{{ url()->previous() }}" 
       class="bg-gray-500 text-white px-4 py-2 rounded">
        ← Atrás
    </a>
</div>

        <div class="card">
       
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card">
         
            @include('profile.partials.update-password-form')
        </div>

        
    </div>
</div>

@endsection