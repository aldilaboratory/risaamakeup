
<div class="container py-5 text-center">
  <h3 class="mb-3">Memproses Pembayaran…</h3>
  <p>Jangan tutup halaman ini.</p>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ $clientKey }}"></script>
<script>
  function postStatus(orderId) {
    return fetch("{{ route('midtrans.check') }}", {
      method: "POST",
      headers: {"Content-Type":"application/json","X-CSRF-TOKEN":"{{ csrf_token() }}"},
      body: JSON.stringify({ order_id: orderId })
    }).then(r => r.json());
  }

  document.addEventListener('DOMContentLoaded', function() {
    const orderId = @json($booking->midtrans_order_id);
    snap.pay('{{ $snapToken }}', {
      onSuccess: async () => { await postStatus(orderId); window.location = "{{ route('booking.thank-you', ['booking' => $booking->id]) }}"; },
      onPending: async () => { await postStatus(orderId); window.location = "{{ route('booking.thank-you', ['booking' => $booking->id]) }}"; },
      onError:   async () => { await postStatus(orderId); alert('Pembayaran gagal'); window.location = "{{ route('packages.public.show', ['category'=>$booking->category, 'package'=>$booking->package]) }}"; },
      onClose:   async () => { await postStatus(orderId); window.location = "{{ route('packages.public.show', ['category'=>$booking->category, 'package'=>$booking->package]) }}"; }
    });
  });
</script>

