<header
  class="flex z-50 sticky top-0 flex-wrap md:justify-start md:flex-nowrap w-full bg-white text-sm py-3 md:py-0 dark:bg-gray-800 shadow-md">
  <nav class="max-w-[85rem] w-full mx-auto px-4 md:px-6 lg:px-8" aria-label="Global">
    <div class="relative md:flex md:items-center md:justify-between">

      <!-- Logo + Mobile Toggle -->
      <div class="flex items-center justify-between">
        <a class="flex-none text-xl font-semibold dark:text-white" href="/">
          E-commerce
        </a>

        <div class="md:hidden">
          <button type="button"
            class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700"
            data-hs-collapse="#navbar-collapse-with-animation">
            <svg class="hs-collapse-open:hidden w-4 h-4" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <line x1="3" x2="21" y1="6" y2="6" />
              <line x1="3" x2="21" y1="12" y2="12" />
              <line x1="3" x2="21" y1="18" y2="18" />
            </svg>
            <svg class="hs-collapse-open:block hidden w-4 h-4" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M18 6 6 18" />
              <path d="m6 6 12 12" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Menu -->
      <div id="navbar-collapse-with-animation"
        class="hs-collapse hidden transition-all duration-300 basis-full grow md:block">
        <div
          class="flex flex-col mt-5 divide-y divide-dashed md:flex-row md:items-center md:justify-end md:gap-x-7 md:mt-0 md:ps-7 md:divide-y-0">

          <!-- Links -->
          <a wire:navigate href="/"
            class="{{ request()->is('/') ? 'text-blue-600' : 'text-gray-500' }} font-medium py-3 md:py-6">
            Home
          </a>

          <a wire:navigate href="/categories"
            class="{{ request()->is('categories') ? 'text-blue-600' : 'text-gray-500' }} font-medium py-3 md:py-6">
            Categories
          </a>

          <a wire:navigate href="/products"
            class="{{ request()->is('products') ? 'text-blue-600' : 'text-gray-500' }} font-medium py-3 md:py-6">
            Products
          </a>

          <!-- Cart (مثل ما كان) -->
          <a wire:navigate href="/cart"
            class="{{ request()->is('cart') ? 'text-blue-600' : 'text-gray-500' }}
            font-medium flex items-center hover:text-gray-400 py-3 md:py-6">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993
                1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125
                1.125 0 0 1-1.12-1.243l1.264-12A1.125
                1.125 0 0 1 5.513 7.5h12.974c.576 0
                1.059.435 1.119 1.007Z" />
            </svg>

            <span class="mr-1">Cart</span>

            <span
              class="py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
              {{ $total_count }}
            </span>
          </a>

          <!-- Guest -->
          @guest
          <div class="pt-3 md:pt-0">
            <a wire:navigate href="/login"
              class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700">
              Log in
            </a>
          </div>
          @endguest

          <!-- Auth Dropdown (CLICK ONLY + RIGHT) -->
          @auth
          <div class="hs-dropdown relative md:py-4">

            <button type="button"
              class=" cursor-pointer flex items-center font-medium text-gray-500 hover:text-gray-700">
              {{ Auth::user()->name }}
              <svg class="ms-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="m6 9 6 6 6-6" />
              </svg>
            </button>

            <div
              class="hs-dropdown-menu absolute right-0 mt-2 w-48 hidden opacity-0 z-50
              transition-all duration-200
              bg-white shadow-lg rounded-lg p-2
              dark:bg-gray-800 dark:border dark:border-gray-700
              hs-dropdown-open:opacity-100">

              <a href="/my-orders"
                class=" text-white flex items-center px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                My Orders
              </a>

              <a href="#"
                class="flex text-white items-center px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                My Account
              </a>

             <a class="flex items-center text-blue-600 gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/logout">
                Logout
              </a>

            </div>
          </div>
          @endauth

        </div>
      </div>
    </div>
  </nav>
</header>
