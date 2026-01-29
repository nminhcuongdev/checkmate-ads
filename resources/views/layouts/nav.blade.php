<style>
    #number-notification {
        position: absolute;
        top: 20px;
        right: 50px;
        width: 14px;
        height: 15px;
        background: #F8D241;
        border-radius: 50%;
        color: #fff ;
        line-height: 16px;
        text-align: center;
        font-size: 10px;
    }
</style>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">CHECKMATE MANAGEMENT</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>

            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">@if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
                       {{ \Illuminate\Support\Facades\Auth::guard('customer')->user()->nick_name }}
                   @else
                       {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}
                   @endif</span>
                    </a>
                </li>
                @if (!\Illuminate\Support\Facades\Auth::guard('admin')->check())
                    <li class="nav-item dropdown px-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell cursor-pointer"></i>
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            @php
                                $customerNotifications = \App\Models\CustomerNotification::where('customer_id', \Illuminate\Support\Facades\Auth::guard('customer')->user()->id)->where('read_flag', '0')->limit(5)->get();
                            @endphp
                            @foreach($customerNotifications as $customerNotification)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="{{ route('customer.notification.show', ['id' => $customerNotification->notification->id]) }}">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="/images/logo.png" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">{{ $customerNotification->notification->title }}</span>
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    {{ $customerNotification->notification->date }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <span id="number-notification">{{ $customerNotifications->count() }}</span>
                @endif
                <li class="nav-item p-2 d-flex align-items-center">
                    <a href="@if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
                    {{ route('customer.logout') }}
                    @else
                    {{ route('logout') }}
                    @endif" class="nav-link text-body p-0">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
