@extends('layout')
@section('content')
    @include('adminSidebar')
    <div class="w-full min-h-screen flex flex-col">
        {{-- topbar --}}


        <div class="border-2 border-gray rounded-lg p-2 m-4">
            <!-- Form Submission -->
            <form id="deliveryForm">
                @csrf
                <div class="my-2 mx-2 max-w-full md:max-w-[50%]">
                    <h1 class="text-xl font-semibold mb-4">Entry Nomor Resi</h1>

                    <div class="flex flex-col mb-2">
                        <label for="tanggal_resi">Tanggal_resi</label>
                        <input type="date" name="tanggal_resi" id="tanggal_resi"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>

                    <div class="flex flex-col mb-2">
                        <label for="nomor_resi">Nomor Resi</label>
                        <input type="text" name="nomor_resi" id="nomor_resi"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>
                </div>

                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg m-2">Submit</button>
                </div>
            </form>
            @if ($deliveryTransactions)
                {{-- <div class="border-2 border-gray rounded-lg p-2 m-4"> --}}
                <h1 class="text-xl font-semibold mb-4">Data Resi Pengiriman</h1>
                <table class="w-full">
                    <thead class="bg-black text-white">
                        <tr>
                            <th class="border border-gray-600 px-4 py-2">No</th>
                            <th class="border border-gray-600 px-4 py-2">Tanggal Resi</th>
                            <th class="border border-gray-600 px-4 py-2">Nomor Resi</th>
                            <th class="border border-gray-600 px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deliveryTransactions as $deliveryTransaction)
                            <tr>
                                <td class="border border-gray-600 px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border border-gray-600 px-4 py-2">{{ $deliveryTransaction['tanggal_resi'] }}</td>
                                <td class="border border-gray-600 px-4 py-2">{{ $deliveryTransaction['nomor_resi'] }}</td>
                                <td class="border border-gray-600 px-4 py-2 space-x-4">
                                    <button class="px-4 py-2 bg-blue-500 rounded-lg text-white entryLogBtn"
                                        data-nomor-resi={{ $deliveryTransaction['nomor_resi'] }}>Entry
                                        Log</button>
                                    <button class="delete_transaction px-4 py-2 bg-red-500 rounded-lg text-white"
                                        data-id="{{ $deliveryTransaction['id'] }}">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
        @endif
    </div>

    <!-- SweetAlert JS Script -->
    <script>
        document.getElementById('deliveryForm').addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent the default form submission

            const form = e.target;
            const formData = new FormData(form); // Get form data

            try {
                // Send the form data using Fetch API
                const response = await fetch("{{ route('delivery_transactions.store') }}", {
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
                        window.location.href = "{{ route('admin.dashboard') }}"; // Example redirection
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

        document.querySelectorAll('.delete_transaction').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault(); // Prevent the default form submission

                const transactionId = button.getAttribute(
                    'data-id'); // Get the transaction ID from the data attribute

                try {
                    // Send the DELETE request using Fetch API
                    const response = await fetch(
                        `{{ url('/delivery_transactions') }}/${transactionId}`, {
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
        document.querySelectorAll('.entryLogBtn').forEach(button => {
            button.addEventListener('click', function() {
                const nomorResi = button.getAttribute('data-nomor-resi');

                // Set the nomor_resi to the hidden field in the form
                document.getElementById('nomor_resi').value = nomorResi;

                // Redirect to the Entry Log page with nomor_resi in the URL
                window.location.href = "/delivery_logs/" +
                nomorResi; // Use string concatenation to create the URL
            });
        });
    </script>
@endsection
