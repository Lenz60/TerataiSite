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
                    <div v-for="cart in carts" class="flex flex-col m-1">
                        <div
                            class="flex flex-row w-fill h-fit p-2 bg-white m-2 hover:border-2 hover:border-accent"
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
                                    <div v-if="cart.preorder">
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
                                <div
                                    class="mb-5 ml-7 flex flex-col text-center justify-end"
                                >
                                    <div class="mb-2">
                                        <!-- <p>$400</p> -->
                                        <p>
                                            ${{ cart.total_price * cart.qty }}
                                        </p>
                                    </div>
                                    <div class="h-full w-32">
                                        <div
                                            class="flex flex-row h-10 border-2 hover:border-accent w-full rounded-md relative bg-transparent mt-1"
                                        >
                                            <div v-if="cart.qty == 1">
                                                <button
                                                    @click="
                                                        removeFromCart(
                                                            cart.furniture_id,
                                                            cart.description
                                                        )
                                                    "
                                                    class="bg-transparent text-green-600 ml-2 h-full w-5 rounded-1 cursor-pointer outline-none"
                                                >
                                                    <svg
                                                        class="w-[16px] ml-2 h-fit absolute inset-x-0 bottom-2"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512"
                                                    >
                                                        <path
                                                            d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div v-else>
                                                <button
                                                    @click="cart.qty--"
                                                    class="bg-transparent text-green-600 h-full w-[25px] ml-1.5 rounded-1 cursor-pointer outline-none"
                                                >
                                                    <span
                                                        class="m-auto text-2xl font-thin"
                                                        >-</span
                                                    >
                                                </button>
                                            </div>
                                            <input
                                                v-model="cart.qty"
                                                type="text"
                                                class="input rounded-sm bg-transparent outline-none focus:outline-none text-center w-full h-full font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700"
                                            />
                                            <button
                                                @click="cart.qty++"
                                                class="bg-transparent text-green-600 h-full w-[25px] mr-1.5 rounded-1 cursor-pointer outline-none"
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
                        class="w-fill text-center bg-slate-400 p-2 mx-5 rounded-md"
                    >
                        <div class="hover:cursor-pointer">
                            Total Price : ${{ total }}
                        </div>
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
import { ref, computed, watch, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
export default {
    props: ["carts"],
    components: {
        AuthenticatedLayout,
    },
    setup(props) {
        // console.log(props.carts[0].qty);
        const image = "http://inventory.test/storage/";
        const carts = ref(props.carts);

        const total = ref(0);
        console.log(carts);

        watch(
            carts,
            () => {
                total.value = carts.value.reduce(
                    (acc, cart) =>
                        acc + Number(cart.qty) * Number(cart.total_price),
                    0
                );
                sessionStorage.setItem("carts", JSON.stringify(carts.value));
            },
            { deep: true }
        );

        onMounted(() => {
            const storedCarts = sessionStorage.getItem("carts");
            if (storedCarts) {
                carts.value = JSON.parse(storedCarts);
            }
        });

        return { image, carts, total };
    },
    methods: {
        async removeFromCart(furnitureId, furnitureDesc) {
            const result = await Swal.fire({
                title: "Confirmation!",
                text:
                    "Are you sure want to remove " +
                    furnitureDesc +
                    " from the cart?",
                icon: "warning",
                reverseButtons: true,
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonColor: "#141414",
                confirmButtonColor: "#D40014",
                cancelButtonText: "No",
                confirmButtonText: "Yes",
                allowOutsideClick: true,
            });
            if (result.isConfirmed) {
                // Remove the item with the passed furnitureId from carts
                this.carts = this.carts.filter(
                    (cart) => cart.furniture_id !== furnitureId
                );
                // Update sessionStorage with the updated carts value
                sessionStorage.setItem("carts", JSON.stringify(this.carts));
                router.post(route("cart.destroy"), {
                    _method: "delete",
                    uuid: furnitureId,
                });
            } else {
                location.reload();
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
