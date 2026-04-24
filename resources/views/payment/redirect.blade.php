<form id="payment-form" action='{{route("paypal.create")}}' method='POST'>
    @csrf
    <input type='hidden' name='ticket_ids' value='{{ implode(",", $ticket_ids) }}'>
    <input type='hidden' name='payment_method' value='{{$payment_method}}'>
    <input type='hidden' name='total' value='{{$total}}'>
</form>

<div class="flex items-center justify-center min-h-screen">
    <div class="text-center">
        <div class="mb-4">
            <div class="inline-block">
                <svg class="animate-spin h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-600 mb-4">Redirecting to payment gateway...</p>
        <p class="text-sm text-gray-500">Please wait, you will be redirected automatically.</p>
    </div>
</div>

<script>
    // Auto-submit the form when page loads
    document.getElementById('payment-form').submit();
</script>