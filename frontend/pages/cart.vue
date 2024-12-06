<template>
  <main class="lg:flex lg:min-h-full lg:flex-row-reverse lg:overflow-hidden">
    <h1 class="sr-only">Checkout</h1>

    <!-- Order summary -->
    <section
      aria-labelledby="summary-heading"
      class="hidden w-full max-w-md flex-col bg-gray-50 lg:flex"
    >
      <h2 id="summary-heading" class="sr-only">Order summary</h2>

      <ul
        role="list"
        class="flex-auto divide-y divide-gray-200 overflow-y-auto px-6"
      >
        <li v-for="item in cartStore.items" :key="item.id" class="py-6">
          <div class="flex flex-col justify-between space-y-4">
            <div class="space-y-1 text-sm font-medium">
              <h3 class="text-gray-900">
                {{ moment(item.time).format("YYYY-MM-DD HH:mm") }} -
                {{ item.duration }} minutes
              </h3>
              <p class="text-gray-500">{{ item.type }} ({{ item.trainer }})</p>
              <p class="text-gray-900">${{ item.price }}</p>
            </div>
            <div class="flex space-x-4">
              <button
                @click="cartStore.removeFromCart(item)"
                type="button"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
              >
                Remove
              </button>
            </div>
          </div>
        </li>
      </ul>

      <div
        class="sticky bottom-0 flex-none border-t border-gray-200 bg-gray-50 px-6 pb-6"
      >
        <dl class="mt-10 text-sm font-medium text-gray-500">
          <div
            class="flex items-center justify-between border-gray-200 text-gray-900"
          >
            <dt class="text-base">Total</dt>
            <dd class="text-base">{{ cartStore.total }}</dd>
          </div>
        </dl>
      </div>
    </section>

    <!-- Checkout form -->
    <section
      aria-labelledby="payment-heading"
      class="flex-auto overflow-y-auto px-4 pb-16 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-24 lg:pt-0"
    >
      <div class="mx-auto max-w-lg">
        <form class="mt-6">
          <div class="grid grid-cols-12 gap-x-4 gap-y-6">
            <div class="col-span-full">
              <label
                for="name"
                class="block text-sm/6 font-medium text-gray-700"
                >Name</label
              >
              <div class="mt-2">
                <input
                  type="text"
                  id="name"
                  name="mame"
                  v-model="cartStore.form.name"
                  class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
              </div>
            </div>

            <div class="col-span-full">
              <label
                for="email-address"
                class="block text-sm/6 font-medium text-gray-700"
                >Email address</label
              >
              <div class="mt-2">
                <input
                  type="email"
                  id="email-address"
                  name="email-address"
                  autocomplete="email"
                  v-model="cartStore.form.email"
                  class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
              </div>
            </div>

            <div class="col-span-full">
              <label
                for="phone-number"
                class="block text-sm/6 font-medium text-gray-700"
                >Phone Number</label
              >
              <div class="mt-2">
                <input
                  type="tel"
                  id="phone-number"
                  name="phone_number"
                  v-model="cartStore.form.phone"
                  class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                />
              </div>
            </div>
          </div>

          <button
            @click="onBook"
            type="button"
            class="mt-6 w-full rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Pay {{ cartStore.total }}
          </button>

          <p class="mt-6 flex justify-center text-sm font-medium text-gray-500">
            <LockClosedIcon
              class="mr-1.5 size-5 text-gray-400"
              aria-hidden="true"
            />
            Payment details stored in plain text
          </p>
        </form>
      </div>
    </section>
  </main>
</template>

<script setup lang="ts">
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { LockClosedIcon } from "@heroicons/vue/20/solid";
import { useCartStore } from "~/stores/cart";
import moment from "moment";
import { ref } from "vue";

const isLoading = ref(false);

const cartStore = useCartStore();

async function onBook() {
  await cartStore.book();
}
</script>
