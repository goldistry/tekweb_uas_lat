@extends('layout')
@section('content')
    @include('adminSidebar')
    <div class="w-full min-h-screen flex flex-col p-4">
        <div class="shadow-lg border-gray b-[2px]">
            <form id="addAdmin" class="p-4">
                @csrf
                <div class="my-2 mx-2 max-w-full md:max-w-[50%]">
                    <h1 class="text-xl font-semibold mb-4">Entry New Admin</h1>
                    <div class="flex flex-col mb-2">
                        <label for="nama_admin">Nama</label>
                        <input type="text" name="nama_admin" id="nama_admin" placeholder="Nama Admin"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>
                    <div class="flex flex-col mb-2">
                        <label for="tanggal">Username</label>
                        <input type="text" name="username" id="username" placeholder="Username"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>
                    <div class="flex flex-col mb-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>
                    <div class="flex flex-col mb-2">
                      <label for="status">Status</label>
                        <select class="rounded-lg" name="status" id="status">
                            <option value="1" class="">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg m-2">Submit</button>
                </div>
            </form>
        </div>
        <table class="w-full">
            <thead class="bg-black text-white">
                <tr>
                    <th class="border border-gray-600 px-4 py-2">Nama</th>
                    <th class="border border-gray-600 px-4 py-2">Username</th>
                    <th class="border border-gray-600 px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admin as $userAdmin)
                    <tr>
                        <td class="border border-gray-600 px-4 py-2">{{ $userAdmin['nama_admin'] }}</td>
                        <td class="border border-gray-600 px-4 py-2">{{ $userAdmin['username'] }}</td>

                        <td class="border border-gray-600 px-4 py-2 space-x-4">
                            <button class="edit_admin px-4 py-2 bg-blue-500 rounded-lg text-white"
                                data-id="{{ $userAdmin['id'] }}">Edit</button>
                            <button class="delete_admin px-4 py-2 bg-red-500 rounded-lg text-white"
                                data-id="{{ $userAdmin['id'] }}">Hapus</button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
<script>
   document.getElementById('addAdmin').addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent the default form submission

            const form = e.target;
            const formData = new FormData(form); // Get form data

            try {
                // Send the form data using Fetch API
                const response = await fetch("{{ route('admins.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // CSRF token
                    }
                });

                const result = await response.json(); // Parse the JSON response

                if (result.success) {
                    // Success case: Show Swal with success message
                    Swal.fire({
                        title: 'Success!',
                        text: result.message || 'Data successfully saved.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirect after success (optional)
                        window.location.href = "{{ route('admin.userAdmin') }}"; // Example redirection
                    });
                } else {
                    // Error case: Show Swal with error message
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'Failed to save data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                // Handle any unexpected errors
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while submitting the form. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });

        document.querySelectorAll('.delete_admin').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault(); // Prevent the default form submission

                const transactionId = button.getAttribute(
                    'data-id'); // Get the transaction ID from the data attribute

                try {
                    // Send the DELETE request using Fetch API
                    const response = await fetch(
                        `{{ url('/admins') }}/${transactionId}`, {
                            method: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}" // CSRF token
                            }
                        });

                    const result = await response.json(); // Parse the JSON response

                    if (result.success) {
                        // Success case: Show Swal with success message
                        Swal.fire({
                            title: 'Success!',
                            text: result.message || 'Data successfully deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect after success (optional)
                            window.location.href =
                                "{{ route('admin.dashboard') }}"; // Example redirection
                        });
                    } else {
                        // Error case: Show Swal with error message
                        Swal.fire({
                            title: 'Error!',
                            text: result.message || 'Failed to delete data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                } catch (error) {
                    // Handle any unexpected errors
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while deleting the data. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
        document.querySelectorAll('.edit_admin').forEach(button => {
            button.addEventListener('click', function() {
                const adminId = button.getAttribute('data-id');

                // Set the nomor_resi to the hidden field in the form
                // document.getElementById('nomor_resi').value = nomorResi;

                // Redirect to the Entry Log page with nomor_resi in the URL
                window.location.href = "/admin/userAdmin/edit/" +
                adminId; // Use string concatenation to create the URL
            });
        });
</script>
@endsection
