

// WORKING SEARCH FUNCTION
function filterTable(searchInput, tableRows, originalRows, filterValue, table) {
  const searchValue = searchInput.value.toLowerCase();
  let changingRows = [];

  if (searchValue === "") {
    filterChange(originalRows, table, filterValue);
    return originalRows;
  }

  tableRows.forEach(row => {
    const customerName = row.querySelector(".name-Report").textContent.toLowerCase();

    if (customerName.includes(searchValue)) {
      row.style.display = "";
      changingRows.push(row);

      return customerName.includes(searchValue);
    } else {
      row.style.display = "none";
    }
  });


  return changingRows;
}


// the problem with this code is that it might not work dynamically when adding actual row entries coming from actual customers but that is a problem for the future
// TOTAL ORDERS CARD AND TOTAL SALES CARD - Dynamic Functions
document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("tbody"); // Table body
  let allRows = Array.from(tableBody.querySelectorAll("tr")); // Store all rows initially

  function updateDailySales() {
    const totalCells = allRows.map(row => row.cells[6]); // Get the "Total" column (7th column)
    const dailySalesElement = document.querySelector(".card-report .h5"); // Target the card text

    let totalSales = totalCells.reduce((sum, cell) => {
      let amount = parseFloat(cell.textContent.replace("₱", "").replace(",", ""));
      return sum + (isNaN(amount) ? 0 : amount);
    }, 0);

    // Format as currency and update the card
    dailySalesElement.textContent = "₱" + totalSales.toLocaleString();
  }

  function updateTotalOrders() {
    const totalOrdersElement = document.querySelector(".card-report .total-orders"); // Target the card number
    totalOrdersElement.textContent = allRows.length; // Count all table rows
  }

  function refreshData() {
    allRows = Array.from(tableBody.querySelectorAll("tr")); // Refresh stored rows
    updateDailySales();
    updateTotalOrders();
  }

  refreshData(); // Run once on page load


  // This code snippet does not work but would be good if it does

  // Watch for table changes (new rows added/removed)
  // const observer = new MutationObserver(refreshData);
  // observer.observe(tableBody, { childList: true, subtree: true });

});





// PAGINATION CODE
function initializePagination(rows) {
  const rowsPerPage = 6; // Number of rows per page
  const pagination = document.querySelector(".pagination");

  function displayPage(pageNumber) {
    const start = (pageNumber - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    // Hide all rows
    rows.forEach(row => row.style.display = "none");

    // Show only the selected rows
    rows.slice(start, end).forEach(row => row.style.display = "table-row");

    updatePagination(pageNumber);
  }

  function updatePagination(activePage) {
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    pagination.innerHTML = "";

    // Previous button
    const prevButton = document.createElement("li");
    prevButton.classList.add("page-item");
    if (activePage === 1) prevButton.classList.add("disabled");
    prevButton.innerHTML = `<a class="page-link" href="#">«</a>`;
    prevButton.addEventListener("click", function (e) {
      e.preventDefault();
      if (activePage > 1) displayPage(activePage - 1);
    });
    pagination.appendChild(prevButton);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
      const pageItem = document.createElement("li");
      pageItem.classList.add("page-item");
      if (i === activePage) pageItem.classList.add("active");
      pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
      pageItem.addEventListener("click", function (e) {
        e.preventDefault();
        displayPage(i);
      });
      pagination.appendChild(pageItem);
    }

    // Next button
    const nextButton = document.createElement("li");
    nextButton.classList.add("page-item");
    if (activePage === totalPages) nextButton.classList.add("disabled");
    nextButton.innerHTML = `<a class="page-link" href="#">»</a>`;
    nextButton.addEventListener("click", function (e) {
      e.preventDefault();
      if (activePage < totalPages) displayPage(activePage + 1);
    });
    pagination.appendChild(nextButton);
  }

  // Initialize pagination
  displayPage(1);
}
// END OF PAGINATION CODE







// FILTER FUNCTION
function filterChange(rows, tableBody, filterValue) {
  rows.sort((a, b) => {
    let dateA = new Date(a.cells[2].textContent);
    let dateB = new Date(b.cells[2].textContent);
    let priceA = parseFloat(a.cells[6].textContent.replace("₱", "").replace(",", ""));
    let priceB = parseFloat(b.cells[6].textContent.replace("₱", "").replace(",", ""));

    if (filterValue === "newest") return dateB - dateA; // Newest
    if (filterValue === "oldest") return dateA - dateB; // Oldest
    if (filterValue === "price-low") return priceA - priceB; // Low to High
    if (filterValue === "price-high") return priceB - priceA; // High to Low

    return 0;
  });

  // Append sorted rows back to the table
  tableBody.innerHTML = ""; // Clear table
  rows.forEach(row => tableBody.appendChild(row));
  return rows;
}




// MAIN FUNCTION-----------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector(".rounded-table tbody");
  const rows = Array.from(table.querySelectorAll("tr"));
  let changingRows = rows;
  let filterValue = "";


  // FILTER FUNCTION
  const filterDropdown = document.querySelector(".reports-filter");
  filterDropdown.addEventListener("change", function () {
    filterValue = filterDropdown.value;
    changingRows = filterChange(changingRows, table, filterValue);
    initializePagination(changingRows);
  });
  // END OF FILTER FUNCTION


  // SEARCH FUNCTION
  const searchInput = document.getElementById("searchInput");
  const searchButton = document.getElementById("searchButton");
  searchInput.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
      changingRows = filterTable(searchInput, changingRows, rows, filterValue, table);
      initializePagination(changingRows);
    }
  });

  searchButton.addEventListener("click", function () {
    changingRows = filterTable(searchInput, changingRows, rows, filterValue, table);
    initializePagination(changingRows);
  });
  // END OF SEARCH FUNCTION


  //Initializating Pagination
  initializePagination(changingRows);
});



