<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css'); }}">
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css"/>
        <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>UP TREND</title>
    </head>

    <body>
    @include('user.navbar')

    
    @if(session()->has('error'))
            <div class="flex justify-center items-center w-full fixed top-0 right-0 left-0 z-50">
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
            <div class="flex justify-center items-center w-full fixed top-0 right-0 left-0 z-50">
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
    <section class="bg-white py-8 antialiasedmd:py-16">
  <form action="{{ route('order.place') }}" method="POST" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    @csrf
    <ol class="items-center flex w-full max-w-2xl text-center text-sm font-medium sm:text-base">
      <li class="after:border-1 flex items-center text-primary-700 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-black sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
        <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] sm:after:hidden text-green-500">
          <i class="ph-bold ph-check-circle"></i>
          <span class="ml-2">Cart</span>
        </span>
      </li>

      <li class="after:border-1 flex items-center after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-black sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
        <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] sm:after:hidden text-green-500">
          <i class="ph-bold ph-check-circle"></i>
          <span class="ml-2">Checkout</span>
        </span>
      </li>

      <li class="flex shrink-0 items-center">
        <i class="ph-bold ph-check-circle"></i>
        <span class="ml-2">Order summary</span>
      </li>
    </ol>

    <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
      <div class="min-w-0 flex-1 space-y-8">
        <div class="space-y-4">
          <h2 class="text-xl font-semibold text-gray-900">Delivery Details</h2>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label for="your_name" class="mb-2 block text-sm font-medium text-gray-900"> Name </label>
              <input type="text" id="your_name" name="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" placeholder="Your name" required />
            </div>

            <div>
              <label for="email" class="mb-2 block text-sm font-medium text-gray-900"> Email </label>
              <input type="email" id="email" name="email" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" placeholder="name@gmail.com" required />
            </div>

            <div>
              <label for="address" class="mb-2 block text-sm font-medium text-gray-900"> Address </label>
              <input type="text" id="address" name="address" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" placeholder="Your address" required />
            </div>

            <div>
              <div class="mb-2 flex items-center gap-2">
                <label for="region" class="block text-sm font-medium text-gray-900"> Region </label>
              </div>
              <select id="region" name="region" onchange="fetch_provinces()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500">
                <option value="">Region</option>
              </select>
            </div>

            <div>
              <div class="mb-2 flex items-center gap-2">
                <label for="province" class="block text-sm font-medium text-gray-900"> Province </label>
              </div>
              <select id="province" name="province" onchange="fetch_cities()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500">
                <option value="">Province</option>
              </select>
            </div>

            <div>
              <div class="mb-2 flex items-center gap-2">
                <label for="city" class="block text-sm font-medium text-gray-900"> City </label>
              </div>
              <select id="city" name="city" onchange="fetch_barangays()" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500">
                <option value="">City</option>
              </select>
            </div>

            <div>
              <div class="mb-2 flex items-center gap-2">
                <label for="barangay" class="block text-sm font-medium text-gray-900"> Barangay </label>
              </div>
              <select id="barangay" name="barangay" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500">
                <option value="">Barangay</option>
              </select>
            </div>

            <div>
              <label for="phoneno" class="mb-2 block text-sm font-medium text-gray-900"> Phone Number </label>
              <div class="flex items-center">
                <select id="phoneno" name="phone" class="w-28 text-start rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100" onchange="updatePhoneCode()">
                  <option value="">Country</option>
                </select>
                <div class="relative w-full">
                  <input type="text" id="phone-input" name="phone" class="z-20 block w-full rounded-e-lg border border-s-0 border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" placeholder="123-456-7890" maxlength="10" required/>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-4">
          <h3 class="text-xl font-semibold text-gray-900">Payment</h3>

          <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4">
              <div class="flex items-start">
                <div class="flex h-5 items-center">
                  <input id="pay-on-delivery" aria-describedby="pay-on-delivery-text" type="radio" name="payment_method" value="cash_on_delivery" class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600" checked/>
                </div>

                <div class="ms-4 text-sm">
                  <label for="pay-on-delivery" class="font-medium leading-none text-gray-900"> Cash on delivery </label>
                  <p id="pay-on-delivery-text" class="mt-1 text-xs font-normal text-gray-500">+₱300 Delivery fee</p>
                </div>
              </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 ps-4">
              <div class="flex items-start">
                <div class="flex h-5 items-center">
                  <input id="credit-card" aria-describedby="credit-card-text" type="radio" name="payment_method" value="credit_card" class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600"/>
                </div>

                <div class="ms-4 text-sm">
                  <label for="credit-card" class="font-medium leading-none text-gray-900"> Credit Card </label>
                  <p id="credit-card-text" class="mt-1 text-xs font-normal text-gray-500">Pay with your credit card</p>
                </div>
              </div>          
            </div>
          </div>
        </div>
      </div>
      @php
        $shippingFee = 300;
      @endphp
      <div class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
        <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
          <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm  sm:p-6">
            <p class="text-xl font-semibold text-gray-900">Order summary</p>
            <div class="space-y-4">
              <div class="space-y-2">
                  <dl class="flex items-center justify-between gap-4">
                      <dt class="text-base font-normal text-gray-500">Bag</dt>
                      <dd class="text-base font-medium text-gray-900">₱{{ number_format($totalAmount, 2) }}</dd>
                  </dl>
                  <dl class="flex items-center justify-between gap-4">
                      <dt class="text-base font-normal text-gray-500">Shipping Fee</dt>
                      <dd class="text-base font-medium text-gray-900">₱{{ number_format($shippingFee, 2) }}</dd>
                  </dl>
              </div>

              <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                  <dt class="text-base font-bold text-gray-900">Total</dt>
                  <dd class="text-base font-bold text-gray-900">₱{{ number_format($totalAmount + $shippingFee, 2) }}</dd>
                  
              </dl>


              <!-- Hidden inputs to pass the values with the form -->
              <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
              <input type="hidden" name="shipping_fee" value="{{ $shippingFee }}">
              <input type="hidden" id="payment-method-input" name="payment_method" value="{{ old('payment_method', 'cash_on_delivery') }}">

          </div>

            <button type="submit" class="w-full flex items-center justify-center rounded-lg bg-black px-5 py-2.5 text-sm font-medium text-white">
                Place Order
            </button>
            <div class="flex items-center justify-center gap-2">
              <span class="text-sm font-normal text-gray-500"> or </span>
              <a href="/" title="" class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline">
                Continue Shopping
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<script>
  fetch(`https://psgc.gitlab.io/api/regions/`)
  .then(response => response.json())
  .then(data => {
    const regionsSelect = document.getElementById('region');
    data.sort((a, b) => a.name.localeCompare(b.name));
    data.forEach(region => {
      const option = document.createElement('option');
      option.value = region.code;
      option.textContent = region.name;
      regionsSelect.appendChild(option);
    });
  });

  async function fetch_provinces() {
    const region = document.getElementById('region').value;
    fetch(`https://psgc.gitlab.io/api/regions/` + region + `/provinces/`)
    .then(response => response.json())
    .then(data => {
      const provincesSelect = document.getElementById('province');
      const buffer = document.createElement('option');
      provincesSelect.innerHTML = '';
      provincesSelect.appendChild(buffer);
      data.sort((a, b) => a.name.localeCompare(b.name));
      data.forEach(province => {
        const option = document.createElement('option');
        option.value = province.code;
        option.textContent = province.name;
        provincesSelect.appendChild(option);
      });
    });
  }

  async function fetch_cities() {
    const province = document.getElementById('province').value;
    fetch(`https://psgc.gitlab.io/api/provinces/` + province + `/cities-municipalities/`)
    .then(response => response.json())
    .then(data => {
      const citiesSelect = document.getElementById('city');
      const buffer = document.createElement('option');
      citiesSelect.innerHTML = '';
      citiesSelect.appendChild(buffer);
      data.sort((a, b) => a.name.localeCompare(b.name));
      data.forEach(city => {
        const option = document.createElement('option');
        option.value = city.code;
        option.textContent = city.name;
        citiesSelect.appendChild(option);
      });
    });
  }

  async function fetch_barangays() {
    const city = document.getElementById('city').value;
    fetch(`https://psgc.gitlab.io/api/cities-municipalities/` + city + `/barangays/`)
    .then(response => response.json())
    .then(data => {
      const barangaysSelect = document.getElementById('barangay');
      const buffer = document.createElement('option');
      barangaysSelect.innerHTML = '';
      barangaysSelect.appendChild(buffer);
      data.sort((a, b) => a.name.localeCompare(b.name));
      data.forEach(barangay => {
        const option = document.createElement('option');
        option.value = barangay.code;
        option.textContent = barangay.name;
        barangaysSelect.appendChild(option);
      });
    });
  }
</script>
      <script>
        function updatePhoneCode() {
        const phoneSelect = document.getElementById('phoneno');
        const selectedOption = phoneSelect.options[phoneSelect.selectedIndex];
        phoneSelect.options[phoneSelect.selectedIndex].textContent = selectedOption.value;
        }

        fetch('https://restcountries.com/v3.1/all')
        .then(response => response.json())
        .then(data => {
        const phoneSelect = document.getElementById('phoneno');
        data.sort((a, b) => a.name.common.localeCompare(b.name.common));
        data.forEach(country => {
          if (country.idd && country.idd.root) {
          const option = document.createElement('option');
          option.value = country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] : '');
          option.textContent = `${country.name.common} (${option.value})`;
          phoneSelect.appendChild(option);
          }
        });
        });
      </script>

      <script>
      document.addEventListener('DOMContentLoaded', function () {
          const button = document.querySelector('[data-drawer-toggle="default-sidebar"]');
          const sidebar = document.getElementById('default-sidebar');
          const dashboardLink = document.getElementById('dashboard-link');

          button.addEventListener('click', function () {
              sidebar.classList.toggle('-translate-x-full');
          });

          dashboardLink.addEventListener('click', function () {
              sidebar.classList.add('-translate-x-full');
          });
      });
      function closeAlert() {
          const alert = document.querySelector('[data-dismiss="alert"]').closest('.flex');
          alert.style.display = 'none';
      }
      </script>
    </body>
</html>