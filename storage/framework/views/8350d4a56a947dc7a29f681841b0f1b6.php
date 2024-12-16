<div class="container mx-auto p-4">
  <!-- Search Form -->
  <div class="flex justify-between items-center mb-4">
      <input type="text" id="searchNomorResi" class="p-2 border" placeholder="Search by Nomor Resi">
      <button id="searchButton" class="bg-blue-500 text-white p-2 rounded">Search</button>
  </div>

  <!-- Table to Display Results -->
  <table class="table-auto w-full">
      <thead>
          <tr>
              <th>Nomor Resi</th>
              <th>Tanggal</th>
              <th>Kota</th>
              <th>Keterangan</th>
          </tr>
      </thead>
      <tbody id="deliveryLogTable">
          <!-- Results will be dynamically populated here -->
      </tbody>
  </table>
</div>

<script>
  document.getElementById('searchButton').addEventListener('click', function () {
      const nomorResi = document.getElementById('searchNomorResi').value;

      // Perform AJAX request
      fetch(`/search-delivery_logs/${nomorResi}`)
          .then(response => response.json())
          .then(data => {
              const tableBody = document.getElementById('deliveryLogTable');
              tableBody.innerHTML = ''; // Clear existing data

              if (data.success) {
                  data.data.forEach(log => {
                      const row = document.createElement('tr');
                      row.innerHTML = `
                          <td>${log.nomor_resi}</td>
                          <td>${log.tanggal}</td>
                          <td>${log.kota}</td>
                          <td>${log.keterangan}</td>
                      `;
                      tableBody.appendChild(row);
                  });
              } else {
                  // No results found
                  tableBody.innerHTML = '<tr><td colspan="4" class="text-center">No log found</td></tr>';
              }
          })
          .catch(error => {
              console.error('Error:', error);
          });
  });
</script>
<?php /**PATH C:\xampp\htdocs\C14230250_JESSICA_CHANDRA_UAS_TEKWEB_LAT\resources\views/WelcomeUser.blade.php ENDPATH**/ ?>