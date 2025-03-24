
// HIGHLIGHT FUNCTION
document.addEventListener("DOMContentLoaded", function () {
  const rows = document.querySelectorAll(".clickable-row");

  rows.forEach(row => {
    row.addEventListener("click", function () {
      // Toggle the "table-active" class on click
      this.classList.toggle("table-active");
    });
  });
});


// ACTIVATE BUTTON
document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".toggle-status-on").addEventListener("click", function () {
    document.querySelectorAll(".clickable-row.table-active").forEach(row => {
      let statusCell = row.querySelector(".status"); // Find the status cell

      statusCell.textContent = "Active";
      statusCell.classList.remove("text-warning");
      statusCell.classList.add("text-success");


      row.classList.remove("table-active");
    });
  });
});


// DEACTIVATE BUTTON
document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".toggle-status-off").addEventListener("click", function () {
    document.querySelectorAll(".clickable-row.table-active").forEach(row => {
      let statusCell = row.querySelector(".status"); // Find the status cell

      statusCell.textContent = "Inactive";
      statusCell.classList.remove("text-success");
      statusCell.classList.add("text-warning");


      row.classList.remove("table-active");
    });
  });
});




// function updateFilteredResults(originalRows) {
//   const searchInput = document.querySelector(".search-bar input").value.toLowerCase();
//   const filterValue = document.querySelector(".form-select").value.toLowerCase();

//   let filteredRows = originalRows.filter(row => {
//     const nameCell = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
//     const status = row.querySelector(".status").textContent.toLowerCase();
//     const role = row.children[5].textContent.toLowerCase(); // 6th column is the role

//     const matchesSearch = searchInput === "" || nameCell.includes(searchInput);
//     const matchesFilter = filterValue === "" || status === filterValue || role === filterValue;

//     return matchesSearch && matchesFilter;
//   });

//   // Hide all rows first
//   originalRows.forEach(row => row.style.display = "none");

//   // Reinitialize pagination with filtered results
//   initializePagination(filteredRows);

//   return filteredRows;
// }




// // SEARCH FUNCTION
// function searchFunction(originalRows) {
//   const searchInput = document.querySelector(".search-bar input"); // Get search input
//   const searchValue = searchInput.value.toLowerCase(); // Get input value and convert to lowercase

//   let filteredRows = originalRows.filter(row => {
//     const nameCell = row.querySelector("td:nth-child(2)"); // Get the "Staff Name" column
//     return nameCell.textContent.toLowerCase().includes(searchValue); // Return matching rows
//   });

//   // Hide all rows first
//   originalRows.forEach(row => row.style.display = "none");

//   // Reinitialize pagination with filtered results
//   initializePagination(filteredRows);

//   return filteredRows;
// }



// REMOVE ACCOUNT BUTTON FUNCTION
// document.addEventListener("DOMContentLoaded", function () {

//   // Select all remove buttons
//   const removeButtons = document.querySelectorAll(".remove-btn");

//   // Loop through each button and add a click event listener
//   removeButtons.forEach(button => {
//     button.addEventListener("click", function () {
//       // Find the parent <tr> of the clicked button and remove it
//       this.closest("tr").remove();


//       const tableBody = document.querySelector("tbody"); // Select tbody instead of the whole table
//       const rows = Array.from(tableBody.querySelectorAll("tr")); // Only get tbody rows
//       initializePagination(rows);

//     });
//   });

// });





// PAGINATION CODE
function initializePagination(rows) {
  const rowsPerPage = 5; // Number of rows per page
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
  if (rows.length > 0) {
    displayPage(1);
  }
}




document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("tbody");
  let originalRows = Array.from(tableBody.querySelectorAll("tr")); // Store all rows

  if (tableBody) {
    initializePagination(originalRows); // Load all rows initially
  }

  // SEARCH & FILTER EVENT LISTENERS
  const searchInput = document.querySelector(".search-bar input");
  const filterSelect = document.querySelector(".form-select");



  searchInput.addEventListener("keyup", function () {
    updateFilteredResults(originalRows); // Start filtering from full dataset
  });

  filterSelect.addEventListener("change", function () {
    updateFilteredResults(originalRows); // Start filtering from full dataset
  });


  // Add event listener for remove buttons
  const removeButtons = document.querySelectorAll(".remove-btn");
  removeButtons.forEach(button => {
    button.addEventListener("click", function () {
      const row = this.closest("tr"); // Get the row associated with the clicked button

      if (row) {
        row.remove(); // Remove the row from the table

        // Update `originalRows` by filtering out the removed row
        originalRows = originalRows.filter(r => r !== row);

        // Reapply pagination after removal
        updateFilteredResults(originalRows);

      }
    });
  });

});





function updateFilteredResults(originalRows) {
  const searchValue = document.querySelector(".search-bar input").value.toLowerCase();
  const filterValue = document.querySelector(".form-select").value.toLowerCase();

  // Always start from the full dataset
  let filteredRows = originalRows.filter(row => {
    const nameCell = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
    const status = row.querySelector(".status").textContent.toLowerCase();
    const role = row.children[5].textContent.toLowerCase(); // 6th column is the role

    const matchesSearch = searchValue === "" || nameCell.includes(searchValue);
    const matchesFilter = filterValue === "" || status === filterValue || role === filterValue;

    return matchesSearch && matchesFilter;
  });

  // Hide all rows first
  originalRows.forEach(row => row.style.display = "none");

  // Reinitialize pagination with the new filtered results
  initializePagination(filteredRows);
}