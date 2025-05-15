
window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables Initialization
    const datatablesSimple = document.getElementById('datatablesSimple');
    let dataTableInstance = null; // Optional: Store the instance if you need it later

    if (datatablesSimple) {
        // Initialize DataTables
        // This line triggers the creation of .datatable-wrapper and .datatable-top
        dataTableInstance = new simpleDatatables.DataTable(datatablesSimple);

        // --- NOW, Immediately After Initialization ---
        // --- Insert your custom header HTML ---

        const customHeaderHTML = `
            <div class="my-custom-datatable-header"> <!-- Added a unique class -->
              <div class="col table-upper-right">
                <p class="word1">All Report</p>
                <p class="d-block word2">Orders</p>
              </div>
            </div>
        `;

        // Find the datatable-wrapper element (it should exist now)
        const datatableWrapper = datatablesSimple.closest('.datatable-wrapper');

        if (datatableWrapper) {
            // Find the datatable-top div inside the wrapper
            const datatableTop = datatableWrapper.querySelector('.datatable-top');

            if (datatableTop) {
                // Create a temporary div to convert the HTML string into a DOM element
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = customHeaderHTML.trim();

                // Get the actual element from the temporary div
                const elementToInsert = tempDiv.firstChild;

                // Check if the element was successfully created and insert it
                if (elementToInsert) {
                    // Insert the element at the beginning of the datatable-top div
                    datatableTop.prepend(elementToInsert);
                    console.log('Custom header successfully inserted into datatable-top.');

                    // You might need CSS to style the layout of datatable-top
                    // to accommodate your new element next to the existing controls.
                    // For example, make datatableTop a flex container and adjust alignment.

                } else {
                    console.error('Failed to create DOM element from custom header HTML.');
                }

            } else {
                console.error('Could not find the .datatable-top div inside the wrapper.');
            }
        } else {
            // This error is less likely with the correct script order and timing
            console.error('Could not find the .datatable-wrapper div after DataTables initialization.');
        }

        // --- End of custom header insertion ---

    } else {
        console.log('Table element with ID "datatablesSimple" not found.');
    }
});

