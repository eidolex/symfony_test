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
                {{ moment(item.time).format("YYYY-MM-DD HH:mm") }}
                - {{ item.duration }} minutes
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

            <div class="flex gap-3 col-span-full">
              <div class="flex h-6 shrink-0 items-center">
                <div class="group grid size-4 grid-cols-1">
                  <input
                    v-model="cartStore.form.terms"
                    id="terms"
                    aria-describedby="comments-description"
                    name="terms"
                    type="checkbox"
                    value="1"
                    class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                  />
                  <svg
                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                    viewBox="0 0 14 14"
                    fill="none"
                  >
                    <path
                      class="opacity-0 group-has-[:checked]:opacity-100"
                      d="M3 8L6 11L11 3.5"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      class="opacity-0 group-has-[:indeterminate]:opacity-100"
                      d="M3 7H11"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
              </div>
              <div class="text-sm/6">
                <label for="terms" class="font-medium text-gray-900"
                  >Agree term</label
                >
              </div>
            </div>
          </div>

          <button
            :disabled="isLoading"
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
  if (isLoading.value) {
    return;
  }
  try {
    isLoading.value = true;
    await cartStore.book();
  } catch (error) {
    console.error(error);
  } finally {
    isLoading.value = false;
  }
}
</script>
