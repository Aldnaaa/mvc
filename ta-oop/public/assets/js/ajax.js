$(".edit").on("click", function () {
  const id_transaksi = $(this).data("id");
  const url = $(this).data("url");

  $.ajax({
    url: url + "/History/detailHistory",
    data: { id_transaksi: id_transaksi },
    method: "post",
    dataType: "json",
    success: function (data) {
      console.log(data);
      // Populate the modal with data
      populateModalWithData(data);
    },
  });
});

// Function to populate modal with data
function populateModalWithData(data) {
  const tbody = $("#detailTable tbody");
  const totalHargaElement = $("#totalHarga");

  tbody.empty(); // Clear existing rows

  // Loop through the data and append rows to the table
  data.forEach(function (item) {
    const row = `<tr>
                              <td>${item.nama_barang}</td>
                              <td>Rp. ${item.harga_jual}</td>
                              <td>${item.qty}</td>
                              <td>Rp. ${item.total_harga}</td>
                          </tr>`;
    tbody.append(row);
  });

  // Calculate total harga
  const totalHarga = data.reduce((sum, item) => sum + item.total_harga, 0);

  // Update the total harga in the modal
  totalHargaElement.text(`Rp. ${totalHarga}`);

  // Show the modal
  $("#detailModal").modal("show");
}

$(document).ready(function () {
  $("#checkoutForm").submit(function (event) {
    event.preventDefault();

    // Disable the submit button to prevent multiple submissions
    $("#submitBtn").prop("disabled", true);

    const url = $(this).data("url") + "/Transaksi/checkout";
    var uangBayar = $("#uangBayar").val();

    $.ajax({
      type: "POST",
      url: url,
      data: { bayar: "true", uangBayar: uangBayar },
      dataType: "json", // Expect JSON response
      success: function (data) {
        // Check for success or error in the response
        if (data.success) {
          // Handle success case (e.g., show a success message)
          showAlert("Transaction successful", "success");

          // Fetch and display the transaction details in the modal
          fetchTransactionDetails(data.idTransaksi);
        } else {
          // Handle error case (e.g., display an error message)
          showAlert(data.message, "error");
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX error
        console.error("AJAX Error:", error);
        showAlert("An error occurred during the transaction", "error");
      },
      complete: function () {
        // Re-enable the submit button after AJAX request is complete
        $("#submitBtn").prop("disabled", false);
      },
    });
  });
});

// Function to fetch transaction details and display in the modal
function fetchTransactionDetails(idTransaksi) {
  const url = "http://localhost/mvc/ta-oop/public/Transaksi/strukTransaksi";

  $.ajax({
    url: url,
    data: { idTransaksi: idTransaksi },
    method: "post",
    dataType: "json",
    success: function (data) {
      // Populate the modal with data
      populateModalWithData(data);
      // Open the modal with ID "strukModal"
      $("#strukModal").modal("show");
    },
  });
}

// Function to populate modal with data
function populateModalWithData(data) {
  const tbody = $("#strukTable tbody");
  const totalHargaElement = $("#totalHarga");
  const totalTunaiElement = $("#totalTunai");
  const kembalianElement = $("#kembalian");

  tbody.empty(); // Clear existing rows

  // Loop through the data and append rows to the table
  data.forEach(function (item) {
    const row = `<tr>
                            <td>${item.nama_barang}</td>
                            <td>Rp. ${item.harga_jual}</td>
                            <td>${item.qty}</td>
                            <td>Rp. ${item.total_harga}</td>
                        </tr>`;
    tbody.append(row);
  });

  // Calculate total harga
  const totalHarga = data.reduce((sum, item) => sum + item.total_harga, 0);

  // Update the total harga in the modal
  totalHargaElement.text(`Rp. ${totalHarga}`);

  // Calculate and display total tunai and kembalian
  const totalTunai = parseFloat($("#uangBayar").val());
  const kembalian = totalTunai - totalHarga;

  totalTunaiElement.text(`Rp. ${totalTunai}`);
  kembalianElement.text(`Rp. ${kembalian}`);
}

// Function to display an alert based on the specified type
function showAlert(message, type) {
  if (type === "success") {
    alert(message);
  } else {
    alert("Error: " + message);
  }
}
