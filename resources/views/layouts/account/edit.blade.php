@extends('layouts.app')

@section('title', 'Edit Account')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold mb-6">Edit Account Details</h2>

    

{{-- Flash Success --}}
@if (session('success'))
    <div class="flex items-center bg-green-100 text-green-700 p-4 rounded mb-6 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Flash Error (optional) --}}
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-6 text-sm">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">Display Name *</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email Address *</label>
            <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Password Section -->
        <hr class="my-6">
        <h3 class="text-lg font-semibold mb-2">Change Password</h3>

        <div>
            <label for="current_password" class="block font-medium text-sm text-gray-700">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            @error('current_password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="new_password" class="block font-medium text-sm text-gray-700">New Password</label>
            <input type="password" name="new_password" id="new_password" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            @error('new_password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="new_password_confirmation" class="block font-medium text-sm text-gray-700">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
        </div>

        <div class="pt-4">
            <button type="submit" class="px-5 py-2 bg-black text-white rounded hover:bg-gray-800 transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
