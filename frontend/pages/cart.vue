<template>
  <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-white">
    <body class="h-full">
    ```
  -->
  <main class="lg:flex lg:min-h-full lg:flex-row-reverse lg:overflow-hidden">

    <h1 class="sr-only">Checkout</h1>

    <!-- Mobile order summary -->
<!--    <section aria-labelledby="order-heading" class="bg-gray-50 px-4 py-6 sm:px-6 lg:hidden">-->
<!--      <Disclosure as="div" class="mx-auto max-w-lg" v-slot="{ open }">-->
<!--        <div class="flex items-center justify-between">-->
<!--          <h2 id="order-heading" class="text-lg font-medium text-gray-900">Your Order</h2>-->
<!--          <DisclosureButton class="font-medium text-indigo-600 hover:text-indigo-500">-->
<!--            <span v-if="open">Hide full summary</span>-->
<!--            <span v-if="!open">Show full summary</span>-->
<!--          </DisclosureButton>-->
<!--        </div>-->

<!--        <DisclosurePanel>-->
<!--          <ul role="list" class="divide-y divide-gray-200 border-b border-gray-200">-->
<!--            <li v-for="product in products" :key="product.id" class="flex space-x-6 py-6">-->
<!--              <img :src="product.imageSrc" :alt="product.imageAlt"-->
<!--                   class="size-40 flex-none rounded-md bg-gray-200 object-cover"/>-->
<!--              <div class="flex flex-col justify-between space-y-4">-->
<!--                <div class="space-y-1 text-sm font-medium">-->
<!--                  <h3 class="text-gray-900">{{ product.name }}</h3>-->
<!--                  <p class="text-gray-900">{{ product.price }}</p>-->
<!--                  <p class="text-gray-500">{{ product.color }}</p>-->
<!--                  <p class="text-gray-500">{{ product.size }}</p>-->
<!--                </div>-->
<!--                <div class="flex space-x-4">-->
<!--                  <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Edit</button>-->
<!--                  <div class="flex border-l border-gray-300 pl-4">-->
<!--                    <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Remove-->
<!--                    </button>-->
<!--                  </div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </li>-->
<!--          </ul>-->

<!--          <form class="mt-10">-->
<!--            <label for="discount-code-mobile" class="block text-sm/6 font-medium text-gray-700">Discount code</label>-->
<!--            <div class="mt-1 flex space-x-4">-->
<!--              <input type="text" id="discount-code-mobile" name="discount-code-mobile"-->
<!--                     class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>-->
<!--              <button type="submit"-->
<!--                      class="rounded-md bg-gray-200 px-4 text-sm font-medium text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">-->
<!--                Apply-->
<!--              </button>-->
<!--            </div>-->
<!--          </form>-->

<!--          <dl class="mt-10 space-y-6 text-sm font-medium text-gray-500">-->
<!--            <div class="flex justify-between">-->
<!--              <dt>Subtotal</dt>-->
<!--              <dd class="text-gray-900">{{ subtotal }}</dd>-->
<!--            </div>-->
<!--            <div class="flex justify-between">-->
<!--              <dt class="flex">-->
<!--                Discount-->
<!--                <span class="ml-2 rounded-full bg-gray-200 px-2 py-0.5 text-xs tracking-wide text-gray-600">{{-->
<!--                    discount.code-->
<!--                  }}</span>-->
<!--              </dt>-->
<!--              <dd class="text-gray-900">-{{ discount.amount }}</dd>-->
<!--            </div>-->
<!--            <div class="flex justify-between">-->
<!--              <dt>Taxes</dt>-->
<!--              <dd class="text-gray-900">{{ taxes }}</dd>-->
<!--            </div>-->
<!--            <div class="flex justify-between">-->
<!--              <dt>Shipping</dt>-->
<!--              <dd class="text-gray-900">{{ shipping }}</dd>-->
<!--            </div>-->
<!--          </dl>-->
<!--        </DisclosurePanel>-->

<!--        <p class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6 text-sm font-medium text-gray-900">-->
<!--          <span class="text-base">Total</span>-->
<!--          <span class="text-base">{{ total }}</span>-->
<!--        </p>-->
<!--      </Disclosure>-->
<!--    </section>-->

    <!-- Order summary -->
    <section aria-labelledby="summary-heading" class="hidden w-full max-w-md flex-col bg-gray-50 lg:flex">
      <h2 id="summary-heading" class="sr-only">Order summary</h2>

      <ul role="list" class="flex-auto divide-y divide-gray-200 overflow-y-auto px-6">
        <li v-for="item in cartStore.items" :key="item.id" class="py-6">
          <div class="flex flex-col justify-between space-y-4">
            <div class="space-y-1 text-sm font-medium">
              <h3 class="text-gray-900">{{ moment(item.time).format('YYYY-MM-DD HH:mm') }} - {{ item.duration }}
                minutes</h3>
              <p class="text-gray-500">{{ item.type }} ({{ item.trainer }})</p>
              <p class="text-gray-900">${{ item.price }}</p>
            </div>
            <div class="flex space-x-4">
              <button @click="cartStore.removeFromCart(item)" type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Remove</button>

            </div>
          </div>
        </li>
      </ul>

      <div class="sticky bottom-0 flex-none border-t border-gray-200 bg-gray-50 px-6 pb-6">

        <dl class="mt-10  text-sm font-medium text-gray-500">
          <div class="flex items-center justify-between border-gray-200 text-gray-900">
            <dt class="text-base">Total</dt>
            <dd class="text-base">{{ cartStore.total }}</dd>
          </div>
        </dl>
      </div>
    </section>

    <!-- Checkout form -->
    <section aria-labelledby="payment-heading"
             class="flex-auto overflow-y-auto px-4 pb-16 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pb-24 lg:pt-0">
      <div class="mx-auto max-w-lg">

        <form class="mt-6">
          <div class="grid grid-cols-12 gap-x-4 gap-y-6">
            <div class="col-span-full">
              <label for="name" class="block text-sm/6 font-medium text-gray-700">Name</label>
              <div class="mt-2">
                <input type="text" id="name" name="mame"  v-model="cartStore.form.name"
                       class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
              </div>
            </div>

            <div class="col-span-full">
              <label for="email-address" class="block text-sm/6 font-medium text-gray-700">Email address</label>
              <div class="mt-2">
                <input type="email" id="email-address" name="email-address" autocomplete="email" v-model="cartStore.form.email"
                       class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
              </div>
            </div>

            <div class="col-span-full">
              <label for="phone-number" class="block text-sm/6 font-medium text-gray-700">Phone Number</label>
              <div class="mt-2">
                <input type="tel" id="phone-number" name="phone_number" v-model="cartStore.form.phone"
                       class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
              </div>
            </div>
          </div>


          <button @click="onBook"  type="button"
                  class="mt-6 w-full rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Pay {{ cartStore.total }}
          </button>

          <p class="mt-6 flex justify-center text-sm font-medium text-gray-500">
            <LockClosedIcon class="mr-1.5 size-5 text-gray-400" aria-hidden="true"/>
            Payment details stored in plain text
          </p>
        </form>
      </div>
    </section>
  </main>
</template>

<script setup lang="ts">
import {Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue'
import {LockClosedIcon} from '@heroicons/vue/20/solid'
import {useCartStore} from "~/stores/cart";
import moment from "moment";
import {ref} from "vue";

const isLoading = ref(false);

const cartStore = useCartStore();


async function onBook() {
  await cartStore.book();
}
</script>
