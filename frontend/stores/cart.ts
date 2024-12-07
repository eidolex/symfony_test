import { defineStore } from "pinia";
import type { Session } from "~/types/session";

export const useCartStore = defineStore("cart", () => {
  const form = ref({
    name: "",
    email: "",
    phone: "",
    terms: "",
  });
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

  async function book() {
    if (items.value.length == 0) {
      alert("Please add some items to the cart");
      return;
    }
    const result = await useFetch("http://localhost:8000/api/v1/bookings", {
      method: "POST",
      body: JSON.stringify({
        ...form.value,
        items: items.value.map((session) => ({
          id: session.id,
        })),
      }),
    });

    if (result.error.value) {
      const error =
        "errors" in result.error.value.data
          ? JSON.stringify(result.error.value.data.errors)
          : result.error.value.data.message;
      alert(error);
      return;
    }

    if (
      result.data.value &&
      typeof result.data.value === "object" &&
      "message" in result.data.value
    ) {
      alert(result.data.value.message);
      items.value = [];
      form.value = {
        name: "",
        email: "",
        phone: "",
        terms: "",
      };
    }

    return result;
  }

  return {
    form,
    book,
    items,
    total,
    addToCart,
    removeFromCart,
  };
});
