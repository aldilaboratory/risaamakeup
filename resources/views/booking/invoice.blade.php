@php
  $fmt = fn($n) => 'Rp '.number_format((int)$n, 0, ',', '.');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Invoice #{{ $booking->id }}</title>
<style>
  *{ box-sizing:border-box; }
  body{ font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; color:#222; }
  .wrap{ width:100%; padding:20px; }
  .row{ display:flex; justify-content:space-between; align-items:flex-start; gap:20px; }
  .mb-1{ margin-bottom:6px; } .mb-2{ margin-bottom:12px; } .mb-3{ margin-bottom:18px; } .mb-4{ margin-bottom:24px; }
  .h1{ font-size:22px; font-weight:700; }
  .h2{ font-size:16px; font-weight:700; }
  .muted{ color:#666; }
  .box{ border:1px solid #ddd; padding:12px; border-radius:2px; }
  table{ width:100%; border-collapse:collapse; }
  th,td{ padding:8px 10px; border-bottom:1px solid #eee; vertical-align:top; }
  th{ text-align:left; background:#fafafa; }
  .right{ text-align:right; }
  .total-row td{ border-top:1px solid #ccc; font-weight:700; }
  /* .badge{ display:inline-block; padding:2px 6px; border-radius:4px; font-size:11px; }
  .badge-success{ background:#16a34a; color:#fff; }
  .badge-warning{ background:#f59e0b; color:#fff; }
  .badge-danger{  background:#dc2626; color:#fff; } */
  .brand{ font-weight:700; font-size:18px; color:#e91e63; }
  .tiny{ font-size:10px; }
  .mt-2{ margin-top: 8px;}
</style>
</head>
<body>
  <div class="wrap">
    <div class="row mb-3">
      <div>
        <div class="brand">Risaa Makeup</div>
        <div class="tiny muted">WhatsApp: 0896-1273-3794</div>
      </div>
      <div class="mt-2">
        <div class="h1">INVOICE</div>
        <div class="muted">#{{ $booking->id }}</div>
        @if($booking->midtrans_order_id)
          <div class="tiny muted">Order ID: {{ $booking->midtrans_order_id }}</div>
        @endif
        <div class="tiny muted">Tanggal: {{ $booking->created_at?->format('d M Y, H:i') }}</div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="box" style="flex:1">
        <div class="h2 mb-1">Ditagihkan Kepada</div>
        <div>{{ $booking->name }}</div>
        <div class="muted tiny">{{ $booking->phone }}</div>
        <div class="tiny">{{ $booking->location }} @if($booking->city) - {{ $booking->city }} @endif</div>
      </div>
      <div class="box">
        <div class="h2 mb-1">Rincian Acara</div>
        <div class="tiny">Kategori: {{ ucfirst($booking->category?->name ?? '-') }}</div>
        <div class="tiny">Tanggal: {{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</div>
        <div class="tiny">Waktu: {{ $booking->event_time }}</div>
        <div class="tiny">Status Bayar:
          @php
            $map = [
              'paid' => ['label'=>'Lunas','class'=>'badge-success'],
              'pending'=>['label'=>'Menunggu','class'=>'badge-warning'],
              'failed'=>['label'=>'Gagal','class'=>'badge-danger'],
              'expired'=>['label'=>'Kadaluarsa','class'=>'badge-danger'],
            ];
            $pb = $map[$booking->payment_status] ?? ['label'=>ucfirst($booking->payment_status),'class'=>'badge-warning'];
          @endphp
          <span class="badge {{ $pb['class'] }}">{{ $pb['label'] }}</span>
        </div>
      </div>
    </div>

    <table class="mb-3">
      <thead>
        <tr>
          <th style="width:50%">Deskripsi</th>
          <th class="right" style="width:15%">Harga</th>
          <th class="right" style="width:10%">Qty</th>
          <th class="right" style="width:25%">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div class="fw">{{ $booking->package?->title ?? '-' }}</div>
            <div class="tiny muted">Kategori: {{ ucfirst($booking->category?->name ?? '-') }}</div>
          </td>
          <td class="right">{{ $fmt($booking->package?->price ?? 0) }}</td>
          <td class="right">{{ (int)($booking->qty ?? 1) }}</td>
          <td class="right">{{ $fmt($booking->subtotal ?? (($booking->package?->price ?? 0) * ($booking->qty ?? 1))) }}</td>
        </tr>
        @if(($booking->dp_percent ?? 100) < 100)
        <tr>
          <td colspan="3" class="right">DP {{ (int)$booking->dp_percent }}%</td>
          <td class="right">-</td>
        </tr>
        @endif
        <tr class="total-row">
          <td colspan="3" class="right">Total Dibayar</td>
          <td class="right">{{ $fmt($booking->subtotal ?? 0) }}</td>
        </tr>
      </tbody>
    </table>

    @if($booking->notes)
      <div class="mb-3">
        <div class="h2 mb-1">Catatan</div>
        <div class="tiny">{{ $booking->notes }}</div>
      </div>
    @endif

    <div class="tiny muted">
      * Invoice ini dibuat secara otomatis oleh sistem Risaa Makeup.
      Simpan sebagai bukti pembayaran/booking.
    </div>
  </div>
</body>
</html>
