@extends('layout')

@section('content')

@if ($errors->any())
    <script>
        // Show error message using SweetAlert2
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
        });
    </script>
@endif

<div class="h-screen flex items-center justify-center">
    {{-- login and sign up box --}}

    <div class="flex flex-col justify-center items-center bg-yellow-400 rounded-lg shadow-lg w-max-w-6xl p-8">
        <!-- Login Form -->
        <form id="loginForm" class="w-full px-8" action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <h1 class="text-[36px] mb-6 text-black font-bold text-center">Login</h1>

            <div class="input-box relative w-full mb-6">
                <input id="username" type="text" aria-label="Username" placeholder="Username" required=""
                    name="username"
                    class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-gray-500 placeholder:font-semibold">
                <i class="fa-solid fa-user absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
            </div>

            <div class="input-box relative w-full mb-6">
                <input id="password" type="password" aria-label="Password" placeholder="Password" required=""
                    name="password" minlength="8"
                    class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-gray-500 placeholder:font-semibold">
                <i class="fa-solid fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
            </div>

            <button type="submit"
                class="w-full bg-emerald-800 text-white font-bold py-2 px-4 rounded hover:bg-emerald-900">Login</button>
        </form>
    </div>
</div>

@endsection
