@extends('components.admin.layout')

@section('content')
<div class="col-sm-12">
                <div class="home-tab">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Audiences</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab" aria-selected="false">Demographics</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">More</a>
                      </li>
                    </ul>
                    <div>
                      <div class="btn-wrapper">
                        <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i> Share</a>
                        <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                        <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
                      </div>
                    </div>
                  </div>
                  <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="row">
                            <!-- Total Booking Card -->
                            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                              <div class="card">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-9">
                                      <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $totalBookings }}</h3>
                                      </div>
                                      <h6 class="text-muted font-weight-normal">Total Booking</h6>
                                    </div>
                                    <div class="col-3">
                                      <div class="icon icon-box-primary">
                                        <span class="mdi mdi-calendar-multiple icon-item"></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <!-- Pending Booking Card -->
                            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                              <div class="card">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-9">
                                      <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $pendingBookings }}</h3>
                                      </div>
                                      <h6 class="text-muted font-weight-normal">Booking Pending</h6>
                                    </div>
                                    <div class="col-3">
                                      <div class="icon icon-box-warning">
                                        <span class="mdi mdi-clock-outline icon-item"></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <!-- Paid Booking Card -->
                            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                              <div class="card">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-9">
                                      <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $paidBookings }}</h3>
                                      </div>
                                      <h6 class="text-muted font-weight-normal">Booking Lunas</h6>
                                    </div>
                                    <div class="col-3">
                                      <div class="icon icon-box-success">
                                        <span class="mdi mdi-check-circle icon-item"></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <!-- Today Booking Card -->
                            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                              <div class="card">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-9">
                                      <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $todayBookings }}</h3>
                                      </div>
                                      <h6 class="text-muted font-weight-normal">Booking Hari Ini</h6>
                                    </div>
                                    <div class="col-3">
                                      <div class="icon icon-box-info">
                                        <span class="mdi mdi-calendar-today icon-item"></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                      <h4 class="card-title card-title-dash">
                                        <i class="mdi mdi-calendar-clock text-primary me-2"></i>
                                        Booking Masuk Terbaru
                                      </h4>
                                      <p class="card-subtitle card-subtitle-dash">
                                        <i class="mdi mdi-information-outline me-1"></i>
                                        {{ $recentBookings->count() }} booking terbaru
                                      </p>
                                    </div>
                                    <div>
                                      <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-lg text-white mb-0 me-0">
                                        <i class="mdi mdi-eye me-1"></i>Lihat Semua
                                      </a>
                                    </div>
                                  </div>
                                  <div class="table-responsive mt-1">
                                    <table class="table select-table">
                                      <thead>
                                        <tr>
                                          <th><i class="mdi mdi-account-outline me-1"></i>Customer</th>
                                          <th><i class="mdi mdi-package-variant me-1"></i>Package</th>
                                          <th><i class="mdi mdi-calendar-range me-1"></i>Tanggal Acara</th>
                                          <th><i class="mdi mdi-currency-usd me-1"></i>Total</th>
                                          <th><i class="mdi mdi-flag-outline me-1"></i>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @forelse($recentBookings as $booking)
                                        <tr>
                                          <td>
                                            <div class="d-flex">
                                              <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 40px; height: 40px;">
                                                <i class="mdi mdi-account text-white"></i>
                                              </div>
                                              <div>
                                                <h6 class="mb-1">{{ $booking->name }}</h6>
                                                <p class="text-muted small mb-0">
                                                  <i class="mdi mdi-phone me-1"></i>{{ $booking->phone }}
                                                </p>
                                              </div>
                                            </div>
                                          </td>
                                          <td>
                                            <h6 class="mb-1">
                                              <i class="mdi mdi-palette me-1 text-primary"></i>
                                              {{ $booking->package->title ?? 'N/A' }}
                                            </h6>
                                            <p class="text-muted small mb-0">{{ $booking->package->description ?? 'Paket Makeup' }}</p>
                                          </td>
                                          <td>
                                            <div>
                                              <h6 class="mb-1">
                                                <i class="mdi mdi-calendar me-1 text-info"></i>
                                                {{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}
                                              </h6>
                                              <p class="text-muted small mb-0">
                                                <i class="mdi mdi-clock-outline me-1"></i>
                                                {{ \Carbon\Carbon::parse($booking->event_time)->format('H:i') }}
                                              </p>
                                            </div>
                                          </td>
                                          <td>
                                            <h6 class="mb-0">
                                              <i class="mdi mdi-cash me-1 text-success"></i>
                                              Rp {{ number_format($booking->pay_now, 0, ',', '.') }}
                                            </h6>
                                          </td>
                                          <td>
                                            @if($booking->payment_status === 'paid')
                                              @if($booking->status === 'pending')
                                                <div class="badge badge-opacity-warning">Menunggu Konfirmasi</div>
                                              @elseif($booking->status === 'approved')
                                                <div class="badge badge-opacity-success">Disetujui</div>
                                              @elseif($booking->status === 'completed')
                                                <div class="badge badge-opacity-success">Selesai</div>
                                              @else
                                                <div class="badge badge-opacity-danger">{{ ucfirst($booking->status) }}</div>
                                              @endif
                                            @else
                                              <div class="badge badge-opacity-secondary">Belum Bayar</div>
                                            @endif
                                          </td>
                                        </tr>
                                        @empty
                                        <tr>
                                          <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">Belum ada booking masuk</div>
                                          </td>
                                        </tr>
                                        @endforelse
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              

@endsection