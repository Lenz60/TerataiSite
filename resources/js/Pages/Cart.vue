<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cart
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="flex flex-col bg-base-200 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <!-- <div class="p-6 text-gray-900">This is a cart view</div> -->
                    <div
                        v-for="cart in carts"
                        class="flex flex-col border-2 border-green-400 m-2"
                    >
                        <div
                            class="flex flex-row w-fill h-fit p-5 bg-white m-5"
                        >
                            <div class="w-full flex flex-row">
                                <img
                                    class="w-32 h-32 p-2 rounded-lg"
                                    :src="image + cart.image"
                                    alt=""
                                />
                                <div
                                    class="flex flex-col text-center justify-center"
                                >
                                    <!-- <h1>Table 1</h1> -->
                                    <div v-if="cart.qty == 0">
                                        <h1 class="text-bold font-semibold">
                                            [Pre Order]
                                        </h1>
                                        <h1>
                                            {{ cart.description }}
                                        </h1>
                                    </div>
                                    <div v-else>
                                        <h1>{{ cart.description }}</h1>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="w-full flex flex-row items-end justify-end"
                            >
                                <div class="h-full flex flex-col relative">
                                    <svg
                                        class="w-5 h-fit absolute inset-x-0 bottom-2"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512"
                                    >
                                        <path
                                            d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"
                                        />
                                    </svg>
                                </div>
                                <div
                                    class="mb-5 ml-7 flex flex-col text-center justify-end"
                                >
                                    <div class="mb-2">
                                        <!-- <p>$400</p> -->
                                        <p>${{ cart.total_price }}</p>
                                    </div>
                                    <div class="h-full w-32">
                                        <div
                                            class="flex flex-row h-10 border-2 hover:border-accent w-full rounded-md relative bg-transparent mt-1"
                                        >
                                            <button
                                                class="bg-transparent text-green-600 h-full w-20 rounded-1 cursor-pointer outline-none"
                                            >
                                                <span
                                                    class="m-auto text-2xl font-thin"
                                                    >-</span
                                                >
                                            </button>
                                            <input
                                                v-model="cart.qty"
                                                type="text"
                                                class="input rounded-sm bg-transparent outline-none focus:outline-none text-center w-full h-full font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700"
                                            />
                                            <button
                                                class="bg-transparent text-green-600 h-full w-20 rounded-1 cursor-pointer outline-none"
                                            >
                                                <span
                                                    class="m-auto text-2xl font-thin"
                                                    >+</span
                                                >
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                    </div>
                    <div
                        class="w-fill text-center bg-green-400 p-2 m-5 rounded-md"
                    >
                        <div class="hover:cursor-pointer">Checkout</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
export default {
    props: ["carts"],
    components: {
        AuthenticatedLayout,
    },
    setup(props) {
        // console.log(props.carts[0].qty);
        const image = "http://inventory.test/storage/";
        const qty = ref(props.carts);
        return { image, qty };
    },
};
</script>

<style lang="scss" scoped></style>
