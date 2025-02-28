<form action='{{route("paypal.create")}}' method='POST'>
    @csrf
    <input type='hidden' name='ticket_ids' value='{{ implode(",", $ticket_ids) }}'>

    <input type='hidden' name='payment_method' value='{{$payment_method}}'>
    <input type='hidden' name='total' value='{{$total}}'>
    <button type='submit' class='w-full bg-blue-600 text-white py-2 mt-2 px-4 rounded hover:bg-blue-700 transition'>
        Pay with Credit Card
    </button>