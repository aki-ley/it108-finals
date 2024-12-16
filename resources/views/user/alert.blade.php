@if(session()->has('error'))
    <div class="flex justify-center items-center w-full fixed top-0 right-0 left-0 z-50 alert-message">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white bg-opacity-90 rounded-lg shadow">
                <button type="button" class="close absolute top-3 end-2.5 text-gray-500 hover:text-red-500 " data-dismiss="alert" onclick="closeAlert()">
                    <i class="ph-bold ph-x"></i>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <h3 class="mt-5 mb-5 text-lg font-normal text-red-500">{{ session()->get('error') }}</h3>
                </div>
            </div>
        </div>
    </div>
@endif

@if(session()->has('message'))
    <div class="flex justify-center items-center w-full fixed top-0 right-0 left-0 z-50 alert-message">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white bg-opacity-90 rounded-lg shadow">
                <button type="button" class="close absolute top-3 end-2.5 text-gray-500 hover:text-red-500 " data-dismiss="alert" onclick="closeAlert()">
                    <i class="ph-bold ph-x"></i>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <h3 class="mt-5 mb-5 text-lg font-normal text-green-500">{{ session()->get('message') }}</h3>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
function closeAlert() {
    const alert = document.querySelector('[data-dismiss="alert"]').closest('.flex');
    alert.style.display = 'none';
}

// Alert Fade after 3 seconds
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-message');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 3000);
});
</script>
