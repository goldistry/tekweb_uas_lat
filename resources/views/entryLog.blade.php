@extends('layout')
@section('content')
    @include('adminSidebar')
    <div class="w-full min-h-screen flex flex-col p-4">
        <div class="shadow-lg border-gray b-[2px]">
            <form id="entryLogForm" class="p-4">
                @csrf
                <div class="my-2 mx-2 max-w-full md:max-w-[50%]">
                    <h1 class="text-xl font-semibold mb-4">Entry Nomor Resi</h1>
                    <div class="flex flex-col mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>
                    <div class="flex flex-col mb-2">
                        <label for="kota">Kota</label>
                        <input type="text" name="kota" id="kota"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>
                    <div class="flex flex-col mb-2">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan"
                            class="border-[1px] border-gray rounded-lg p-1 my-2">
                    </div>
                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg m-2">Submit</button>
                </div>
            </form>
        </div>
        @if($entry_log)
        <table class="w-full">
          <thead class="bg-black text-white">
              <tr>
                  <th class="border border-gray-600 px-4 py-2">Nomor Resi</th>
                  <th class="border border-gray-600 px-4 py-2">Tanggal</th>
                  <th class="border border-gray-600 px-4 py-2">Kota</th>
                  <th class="border border-gray-600 px-4 py-2">Keterangan</th>
                  <th class="border border-gray-600 px-4 py-2">Action</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($entry_log as $log)
                  <tr>
                      <td class="border border-gray-600 px-4 py-2">{{ $log['nomor_resi'] }}</td>
                      <td class="border border-gray-600 px-4 py-2">{{ $log['tanggal'] }}</td>
                      <td class="border border-gray-600 px-4 py-2">{{ $log['kota'] }}</td>
                      <td class="border border-gray-600 px-4 py-2">{{ $log['keterangan'] }}</td>

                      <td class="border border-gray-600 px-4 py-2 space-x-4">
                          <button class="delete_entry px-4 py-2 bg-red-500 rounded-lg text-white"
                              data-id="{{ $log['id'] }}">Hapus</button>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
            @endif
    </div>
@endsection
@section('script')
    <script>
      const nomor_resi = <?php echo json_encode($nomor_resi); ?>;
      // console.log(nomor_resi);
        const entryLogForm = document.getElementById('entryLogForm');
        entryLogForm.addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = event.target;
            const formData = new FormData(form); // Get form data
            formData.append('nomor_resi', nomor_resi);
            try {
                // Send the form data using Fetch API
                const response = await fetch("{{ route('delivery_logs.save') }}", {
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
                        window.location.reload(); // Example redirection
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
        document.querySelectorAll('.delete_entry').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault(); // Prevent the default form submission

                const entryId = button.getAttribute(
                    'data-id'); // Get the entry ID from the data attribute

                try {
                    // Send the DELETE request using Fetch API
                    const response = await fetch(
                        `{{ url('/delivery_logs') }}/${entryId}`, {
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
        
    </script>
@endsection
