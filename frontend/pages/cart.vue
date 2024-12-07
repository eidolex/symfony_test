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
                                {{
                                    moment(item.time).format("YYYY-MM-DD HH:mm")
                                }}
                                - {{ item.duration }} minutes
                            </h3>
                            <p class="text-gray-500">
                                {{ item.type }} ({{ item.trainer }})
                            </p>
                            <p class="text-gray-900">${{ item.price }}</p>
                        </div>
                        <div class="flex space-x-4">
                            <Button
                                variant="link"
                                type="button"
                                class="text-destructive px-0 py-0"
                                @click="cartStore.removeFromCart(item)"
                                >Remove</Button
                            >
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
                <form class="mt-6" @submit="onSubmit">
                    <div class="grid grid-cols-12 gap-x-4 gap-y-6">
                        <FormField
                            as="div"
                            class="col-span-full"
                            v-slot="{ componentField }"
                            name="name"
                        >
                            <FormItem>
                                <FormLabel for="id_name">Name</FormLabel>
                                <FormControl>
                                    <Input
                                        type="text"
                                        id="id_name"
                                        v-bind="componentField"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField
                            as="div"
                            class="col-span-full"
                            v-slot="{ componentField }"
                            name="email"
                        >
                            <FormItem>
                                <FormLabel for="id_email">Email</FormLabel>
                                <FormControl>
                                    <Input
                                        type="text"
                                        id="id_email"
                                        v-bind="componentField"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField
                            as="div"
                            class="col-span-full"
                            v-slot="{ componentField }"
                            name="phone"
                        >
                            <FormItem>
                                <FormLabel for="id_phone">Phone</FormLabel>
                                <FormControl>
                                    <Input
                                        type="text"
                                        id="id_phone"
                                        v-bind="componentField"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField
                            as="div"
                            class="col-span-full"
                            v-slot="{ value, handleChange }"
                            type="checkbox"
                            :unchecked-value="false"
                            name="terms"
                        >
                            <FormItem
                                class="flex flex-row items-start space-x-3 space-y-0"
                            >
                                <FormControl>
                                    <Checkbox
                                        :checked="value"
                                        value="1"
                                        @update:checked="handleChange"
                                    />
                                </FormControl>
                                <FormLabel class="font-normal">
                                    Accept terms and conditions
                                </FormLabel>
                            </FormItem>
                            <FormMessage class="mt-2" />
                        </FormField>
                    </div>

                    <div class="mt-6">
                        <Button
                            class="w-full"
                            :disabled="isPending"
                            type="submit"
                        >
                            <Loader2
                                v-if="isPending"
                                class="w-4 h-4 mr-2 animate-spin"
                            />
                            Pay {{ cartStore.total }}
                        </Button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</template>

<script setup lang="ts">
import { isAxiosError } from "axios";
import { useMutation } from "@tanstack/vue-query";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import { useCartStore } from "~/stores/cart";
import { booking } from "~/api/booking";
import moment from "moment";
import { toast } from "vue-sonner";
import { Loader2 } from "lucide-vue-next";

const formSchema = toTypedSchema(
    z.object({
        name: z.string().max(255),
        email: z.string().email(),
        phone: z.string().max(100),
        terms: z.boolean().refine((value) => value === true, {
            message: "You must accept the terms and conditions.",
        }),
    }),
);

const cartStore = useCartStore();

const { handleSubmit, resetForm } = useForm({
    validationSchema: formSchema,
});

const { mutate: bookMutation, isPending } = useMutation({
    mutationKey: ["book"],
    mutationFn: booking,
    onSuccess: (data) => {
        cartStore.clearCart();
        resetForm({});
        toast("Success", {
            description: data.message,
        });
    },
    onError: (error) => {
        if (!isAxiosError(error) || !error.response) {
            return;
        }
        // if (error.response?.status === 422) {
        return toast("Error", {
            description: error.response.data.message,
        });
        // }
    },
});

const onSubmit = handleSubmit((values) => {
    if (cartStore.items.length === 0) {
        return toast("Error", {
            description: "Cart is empty.",
        });
    }
    bookMutation({
        ...values,
        items: cartStore.items.map((item) => ({
            id: item.id,
        })),
    });
});
</script>
