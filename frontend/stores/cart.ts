import { defineStore } from "pinia";
import type { Session } from "~/types/session";

export const useCartStore = defineStore("cart", () => {
  const items = ref<Session[]>([]);

  const total = computed(() => {
    return items.value.reduce((acc, session) => acc + session.price, 0);
  });

  function addToCart(sessions: Session[]) {
    items.value = [...items.value, ...sessions];
  }

  function removeFromCart(session: Session) {
    const index = items.value.findIndex((s) => s.id === session.id);
    if (index !== -1) {
      items.value.splice(index, 1);
    }
  }

  function clearCart() {
    items.value = [];
  }

  return {
    items,
    total,
    addToCart,
    removeFromCart,
    clearCart,
  };
});
