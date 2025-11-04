
<div class="container py-5 text-center">
  <h3 class="mb-3">Memproses Pembayaran…</h3>
  <p>Jangan tutup halaman ini.</p>
</div>

{{-- Pilih domain Snap sesuai env --}}
<script src="https://{{ config('midtrans.is_production') ? 'app' : 'app.sandbox' }}.midtrans.com/snap/snap.js"
        data-client-key="{{ $clientKey }}"></script>

<script>
  const orderId   = @json($booking->midtrans_order_id);
  const thankUrl  = @json(route('booking.thank-you', ['booking' => $booking->id]));
  const fallback  = @json(route('packages.public.show', ['category'=>$booking->category, 'package'=>$booking->package]));

  async function postStatus(orderId) {
    try {
      const res = await fetch(@json(route('midtrans.check')), {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": @json(csrf_token()),
          "X-Requested-With": "XMLHttpRequest",
          "Accept": "application/json"
        },
        body: JSON.stringify({ order_id: orderId })
      });

      // Jangan bikin gagal redirect hanya karena server balas HTML/error
      const ct = res.headers.get('content-type') || '';
      if (ct.includes('application/json')) { await res.json(); }
      // kalau bukan JSON, abaikan saja
    } catch(e) {
      // diamkan agar redirect tetap jalan
      console.warn('postStatus failed:', e);
    }
  }

  function go(url){ window.location.href = url; }

  document.addEventListener('DOMContentLoaded', function () {
    const token = @json($snapToken);

    snap.pay(token, {
      onSuccess: async function () {
        await postStatus(orderId);
        go(thankUrl);
      },
      onPending: async function () {
        await postStatus(orderId);
        go(thankUrl);
      },
      onError: async function () {
        await postStatus(orderId);
        alert('Pembayaran gagal');
        go(fallback);
      },
      onClose: async function () {
        // User menutup popup: tetap cek & arahkan ke fallback
        await postStatus(orderId);
        go(fallback);
      }
    });
  });
</script>