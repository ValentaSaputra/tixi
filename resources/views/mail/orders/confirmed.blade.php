<x-mail::message>
Hi {{$booking->name}}, terima kasih telah memesan tiket di Tixi, kami sedang memeriksa pembayaran anda saat ini. anda dapat memeriksa secara berkala pada website kami dan berikut adalah booking transaction ID anda: {{$booking->booking_trx_id}}

<x-mail::button :url="route('front.check_booking')">
Check Booking
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>