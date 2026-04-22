<script src="assets/vendors/js/vendors.min.js"></script>
<!-- vendors.min.js {always must need to be top} -->
<script src="assets/vendors/js/daterangepicker.min.js"></script>
<script src="assets/vendors/js/apexcharts.min.js"></script>
<script src="assets/vendors/js/circle-progress.min.js"></script>
<!--! END: Vendors JS !-->
<!--! BEGIN: Apps Init  !-->
<script src="assets/js/common-init.min.js"></script>
<script src="assets/js/dashboard-init.min.js"></script>
<!--! END: Apps Init !-->
<!--! BEGIN: Theme Customizer  !-->
<script src="assets/js/theme-customizer-init.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.status-toggle-input').forEach(function (toggle) {

        toggle.addEventListener('change', function () {

            let url = this.dataset.url;
            let textSpan = this.closest('.status-toggle-wrapper')
                               .querySelector('.status-toggle-text');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    let isActive = data.is_active;

                    if (this.dataset.type === 'vip') {
                        textSpan.innerText = isActive ? 'Yes' : 'No';
                    } else {
                        textSpan.innerText = isActive ? 'Active' : 'Inactive';
                    }

                } else {
                    alert('Toggle failed');
                }

            })
            .catch(error => {
                console.error(error);
                alert('Error updating status');
            });

        });

    });

});
</script>