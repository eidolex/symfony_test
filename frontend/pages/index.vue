<template>
  <div class="h-full flex">
    <div class="lg:flex lg:h-full lg:flex-col flex-grow">
      <header
        class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none"
      >
        <div>
          <select
            v-model="selectedType"
            id="type"
            name="type"
            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
          >
            <option value="">All</option>
            <option v-for="type in types" :key="type" :value="type">
              {{ type }}
            </option>
          </select>
        </div>
        <div class="flex items-center ml-auto">
          <div
            class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch"
          >
            <button
              @click="onPreviousMonth"
              type="button"
              class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50"
            >
              <span class="sr-only">Previous month</span>
              <ChevronLeftIcon class="size-5" aria-hidden="true" />
            </button>
            <button
              type="button"
              class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block"
            >
              <time :datetime="selectedYearMonth">{{ selectedYearMonth }}</time>
            </button>
            <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden" />
            <button
              @click="onNextMonth"
              type="button"
              class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50"
            >
              <span class="sr-only">Next month</span>
              <ChevronRightIcon class="size-5" aria-hidden="true" />
            </button>
          </div>
        </div>
      </header>
      <div class="shadow ring-1 ring-black/5 lg:flex lg:flex-auto lg:flex-col">
        <div
          class="grid grid-cols-7 gap-px border-b border-gray-300 bg-gray-200 text-center text-xs/6 font-semibold text-gray-700 lg:flex-none"
        >
          <div class="bg-white py-2">
            M<span class="sr-only sm:not-sr-only">on</span>
          </div>
          <div class="bg-white py-2">
            T<span class="sr-only sm:not-sr-only">ue</span>
          </div>
          <div class="bg-white py-2">
            W<span class="sr-only sm:not-sr-only">ed</span>
          </div>
          <div class="bg-white py-2">
            T<span class="sr-only sm:not-sr-only">hu</span>
          </div>
          <div class="bg-white py-2">
            F<span class="sr-only sm:not-sr-only">ri</span>
          </div>
          <div class="bg-white py-2">
            S<span class="sr-only sm:not-sr-only">at</span>
          </div>
          <div class="bg-white py-2">
            S<span class="sr-only sm:not-sr-only">un</span>
          </div>
        </div>
        <div class="flex bg-gray-200 text-xs/6 text-gray-700 lg:flex-auto">
          <div
            class="hidden w-full lg:grid lg:grid-cols-7 lg:gap-px"
            :class="{
              'grid-rows-4': totalRows === 4,
              'grid-rows-5': totalRows === 5,
              'grid-rows-6': totalRows === 6,
              'grid-rows-7': totalRows === 7,
            }"
          >
            <div
              v-for="day in days"
              :key="day.date"
              :class="[
                day.isCurrentMonth ? 'bg-white' : 'bg-gray-50 text-gray-500',
                'relative px-3 py-2',
              ]"
              @click="onSelectDate(day.date)"
            >
              <time
                :datetime="day.date"
                :class="
                  selectedDate == day.date
                    ? 'flex size-6 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white'
                    : undefined
                "
                >{{ day.date.split("-").pop()?.replace(/^0/, "") }}
              </time>
              <ol v-if="day.events.length > 0" class="mt-2">
                <li v-for="event in day.events.slice(0, 2)" :key="event.name">
                  <p class="group flex">
                    <p
                      class="flex-auto truncate font-medium text-gray-900 group-hover:text-indigo-600"
                    >
                      {{ event.name }}
                    </p>
                    <p
                      class="ml-3 hidden flex-none text-gray-500 group-hover:text-indigo-600 xl:block"
                      >{{ event.count }}
                  </p>
                </p>
                </li>
                <li v-if="day.events.length > 2" class="text-gray-500">
                  + {{ day.events.length - 2 }} more
                </li>
              </ol>
            </div>
          </div>
          <div
            class="isolate grid w-full grid-cols-7 grid-rows-6 gap-px lg:hidden"
          >
            <button
              v-for="day in days"
              :key="day.date"
              type="button"
              :class="[
                day.isCurrentMonth ? 'bg-white' : 'bg-gray-50',
                day.isToday && 'font-semibold',
                day.date == selectedDate ||
                  (day.date == selectedDate && 'text-white'),
                !(day.date == selectedDate) && day.isToday && 'text-indigo-600',
                !(day.date == selectedDate) &&
                  day.isCurrentMonth &&
                  !day.isToday &&
                  'text-gray-900',
                !(day.date == selectedDate) &&
                  !day.isCurrentMonth &&
                  !day.isToday &&
                  'text-gray-500',
                'flex h-14 flex-col px-3 py-2 hover:bg-gray-100 focus:z-10',
              ]"
            >
              <time
                :datetime="day.date"
                :class="[
                  day.date == selectedDate &&
                    'flex size-6 items-center justify-center rounded-full',
                  day.date == selectedDate && day.isToday && 'bg-indigo-600',
                  day.date == selectedDate && !day.isToday && 'bg-gray-900',
                  'ml-auto',
                ]"
                >{{ day.date.split("-").pop()?.replace(/^0/, "") }}
              </time>
              <span class="sr-only">{{ day.events.length }} events</span>
              <span
                v-if="day.events.length > 0"
                class="-mx-0.5 mt-auto flex flex-wrap-reverse"
              >
                <span
                  v-for="event in day.events"
                  :key="event.name"
                  class="mx-0.5 mb-1 size-1.5 rounded-full bg-gray-400"
                />
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="w-80 px-4 ml-4 border-l">
      <div class="divide-y divide-gray-200">
        <div
          v-for="session in sessions"
          :key="session.id"
          class="relative flex gap-3 pb-4 pt-3.5"
        >
          <div class="min-w-0 flex-1 text-sm/6">
            <label
              :for="`session_${session.id}`"
              class="font-medium text-gray-900"
              :class="{
                'line-through': !!cartStore.items.find(
                  (item) => item.id === session.id
                ),
              }"
              >{{ moment(session.time).format("HH:mm") }} -
              {{ session.duration }} minutes</label
            >
            <p
              id="comments-description"
              class="text-gray-500"
              :class="{
                'line-through': !!cartStore.items.find(
                  (item) => item.id === session.id
                ),
              }"
            >
              {{ session.type }} ({{ session.trainer }})
            </p>
          </div>
          <div class="flex h-6 shrink-0 items-center">
            <div class="group grid size-4 grid-cols-1">
              <input
                :disabled="
                  !!cartStore.items.find((item) => item.id === session.id)
                "
                v-model="selectedSessions"
                :value="session"
                :id="`session_${session.id}`"
                aria-describedby="comments-description"
                name="comments"
                type="checkbox"
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
        </div>
      </div>
      <button
        @click="onAddToCart"
        type="button"
        class="mt-6 w-full rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
      >
        Add to Cart
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import {
  ChevronDownIcon,
  ChevronLeftIcon,
  ChevronRightIcon,
  ClockIcon,
  EllipsisHorizontalIcon,
} from "@heroicons/vue/20/solid";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";

import moment from "moment";
import { ref, computed } from "vue";
import { useCartStore } from "~/stores/cart";
import type { Session } from "~/types/session";

const types = ref(["padel", "tennis", "fitness"]);
const cartStore = useCartStore();
const selectedSessions = ref<Session[]>([]);
const selectedDate = ref("");
const selectedType = ref("");
const selectedYearMonth = ref(moment().format("YYYY-MM"));

const { data } = useLazyFetch<{
  data: {
    [key: string]: {
      types: {
        [key: string]: number;
      };
      sessions: Session[];
    };
  };
}>("http://localhost:8000/api/v1/sessions", {
  query: {
    type: selectedType,
  },
});

const days = computed(() => {
  const firstDay = moment(selectedYearMonth.value)
    .startOf("month")
    .startOf("week");
  const lastDay = moment(selectedYearMonth.value).endOf("month").endOf("week");

  const days = [];
  let day = firstDay;

  while (day.isSameOrBefore(lastDay)) {
    const date = day.format("YYYY-MM-DD");
    const session = data.value?.data[date];
    const events = [];

    if (session) {
      for (const type in session.types) {
        events.push({
          name: type,
          count: session.types[type],
        });
      }
    }

    days.push({
      date: date,
      isCurrentMonth: day.isSame(selectedYearMonth.value, "month"),
      isToday: day.isSame(moment(), "day"),
      events: events,
    });
    day = day.add(1, "day");
  }

  return days;
});

const sessions = computed(() => {
  const items = data.value?.data[selectedDate.value]?.sessions || [];
  if (items.length === 0) {
    return items;
  }

  return items;
  // return items.filters((item) => !cartStore.items.includes((cartItem) => cartItem.id === item.id));
});

const totalRows = computed(() => Math.ceil(days.value.length / 7));

function onNextMonth() {
  selectedYearMonth.value = moment(selectedYearMonth.value)
    .add(1, "month")
    .format("YYYY-MM");
}

function onPreviousMonth() {
  selectedYearMonth.value = moment(selectedYearMonth.value)
    .subtract(1, "month")
    .format("YYYY-MM");
}

function onSelectDate(date: string) {
  selectedSessions.value = [];
  selectedDate.value = date;
}

function onAddToCart() {
  if (selectedSessions.value.length == 0) {
    return;
  }
  cartStore.addToCart(selectedSessions.value.slice(0));
  selectedSessions.value = [];
}

// const selectedDay = days.find((day) => day.isSelected);
</script>
