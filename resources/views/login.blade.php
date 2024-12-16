@extends('layout')
@section('content')
    <div class="h-screen flex items-center justify-center">
        {{-- login and sign up box --}}
        <div class="flex flex-col justify-center items-center bg-yellow-400 rounded-lg shadow-lg w-max-w-6xl p-8">

            <!-- Login Form -->
            <form id="loginForm" class="w-full px-8" action="{{ route('user.login') }}" method="POST">
                @csrf
                <h1 class="text-[36px] mb-6 text-black font-bold text-center">Login</h1>
                <div class="input-box relative w-full mb-6">
                    <input id="usernameOrEmail" type="text" aria-label="Username or Email" placeholder="Username/Email"
                        required="" name="usernameOrEmail"
                        class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-gray-500 placeholder:font-semibold">
                    <i class="fa-solid fa-user absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
                </div>
                <div class="input-box relative w-full mb-6">
                    <input id="loginPassword" type="password" aria-label="Password" placeholder="Password" required=""
                        name="password" minlength="8"
                        class="w-full pr-[50px] pl-5 py-3 bg-gray-200 rounded-[8px] border-none outline-none text-[16px] placeholder-gray-500 placeholder:font-semibold">
                    <i class="fa-solid fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-[20px] text-gray-400"></i>
                </div>
                <button type="submit"
                    class="w-full bg-emerald-800 text-white font-bold py-2 px-4 rounded hover:bg-emerald-900">Login</button>
            </form>

        </div>
    </div>

    <!-- JavaScript to toggle between forms -->
    <script>
        function toggleForm(form) {
            const loginForm = document.getElementById('loginForm');
            const signUpForm = document.getElementById('signUpForm');

            if (form === 'signup') {
                loginForm.classList.add('hidden');
                signUpForm.classList.remove('hidden');
            } else {
                loginForm.classList.remove('hidden');
                signUpForm.classList.add('hidden');
            }
        }

        // Ensure you select the correct form for sign-up
        const signUpForm = document.getElementById('signUpForm');
        signUpForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Registering...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const username = document.getElementById('username').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                const response = await fetch("{{ route('user.signUp') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        username,
                        email,
                        password
                    }),
                });

                const data = await response.json();
                console.log(data);

                // Close the loading spinner after response
                Swal.close();

                if (data.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    });
                    // You can add any further logic after successful registration (like form reset or page redirect)
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Registration failed.',
                    });
                }
            } catch (error) {
                // Close the loading spinner even if an error occurs
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                });
            }
        });
    </script>
@endsection
