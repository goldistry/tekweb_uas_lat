
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('adminSidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="w-full min-h-screen flex flex-col p-4">
        <div class="shadow-lg border-gray b-[2px]">
            <form id="editForm" class="p-4">
                <?php echo csrf_field(); ?>
                <div class="my-2 mx-2 max-w-full md:max-w-[50%]">
                    <h1 class="text-xl font-semibold mb-4">Edit <?php echo e($admin['username']); ?></h1>
                    <div class="flex flex-col mb-2">
                        <label for="nama_admin">Nama</label>
                        <input type="text" name="nama_admin" id="nama_admin" placeholder="Nama Admin"
                            class="border-[1px] border-gray rounded-lg p-1 my-2" value="<?php echo e($admin['nama_admin']); ?>">
                    </div>
                    <div class="flex flex-col mb-2">
                        <label for="tanggal">Username</label>
                        <input type="text" name="username" id="username" placeholder="Username"
                            class="border-[1px] border-gray rounded-lg p-1 my-2" value="<?php echo e($admin['username']); ?>">
                    </div>
                    <div class="flex flex-col mb-2">
                        <label for="status">Status</label>
                        <select class="rounded-lg" name="status" id="status">
                            <option value="1" <?php if($admin['status'] == 1): ?> selected <?php endif; ?>>Aktif</option>
                            <option value="0" <?php if($admin['status'] == 0): ?> selected <?php endif; ?>>Tidak Aktif</option>
                        </select>

                    </div>

                </div>
                <div class="flex justify-center items-center">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg m-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        const id = <?php echo json_encode($admin_id); ?>; // Ensure this is a valid JS variable
        const editForm = document.getElementById('editForm');

        editForm.addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent the default form submission

            const form = event.target;
            const formData = new FormData(form); // Get form data

            console.log([...formData.entries()]); // Log form data to verify

            try {
                // Convert FormData to JSON for easier handling
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                data.id = id; // Add the id manually to the data object if needed
                console.log([...formData.entries()]); // Log form data to verify

                // Send the form data using Fetch API
                const response = await fetch(`<?php echo e(url('/admins')); ?>/${id}`, {
                    method: "PATCH", // Use PATCH method for updating
                    body: JSON.stringify(data), // Send data as JSON
                    headers: {
                        'Content-Type': 'application/json', // Indicate that we're sending JSON
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>" // CSRF token for security
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
                    // }).then(() => {
                    //     // Redirect after success (optional)
                    //     window.location.reload(); // Reload the page (or redirect as needed)
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\C14230250_JESSICA_CHANDRA_UAS_TEKWEB_LAT\resources\views/editUserAdmin.blade.php ENDPATH**/ ?>