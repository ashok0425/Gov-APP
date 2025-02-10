<div>
    <div class="modal fade" id="mobileModal" tabindex="-1" aria-labelledby="mobileModalLabel" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-center">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="mobileModalLabel">View in Mobile</h5>
            </div>
            <div class="modal-body">
              Please view this content on a mobile device for the best experience.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" id="saveBtn">ok</button>
            </div>
          </div>
        </div>
      </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mobileWidth = 768; // Define mobile width threshold
        const screenWidth = window.innerWidth;

        if (screenWidth > mobileWidth) {
            // Show the modal if the screen is not mobile-sized
            const mobileModal = new bootstrap.Modal(document.getElementById('mobileModal'));
            mobileModal.show();
            const modalElement = document.getElementById('mobileModal');
        modalElement.addEventListener('click', function(event) {
            if (event.target === modalElement) {
                event.stopPropagation();
            }
        });
        }
    });

    document.getElementById('saveBtn').addEventListener('click', function() {
        // Simulate switching to a mobile view
        alert('Switching to mobile view...');
        const currentUrl = window.location.href;

        window.open(currentUrl, 'Mobile View', 'width=375,height=812');
    // Optionally, close the modal after opening the window
    // const mobileModal = bootstrap.Modal.getInstance(document.getElementById('mobileModal'));
    // mobileModal.hide();

    });
    </script>
