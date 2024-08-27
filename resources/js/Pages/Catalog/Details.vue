<template>
    <div class="backdrop" @click.self="closeModal()">
        <div
            class="bg-base-100 text-center w-[90%] h-[90%] m-auto mt-[3%] mb-[2%] rounded-md"
        >
            <div class="flex flex-col">
                <!-- <div class="text-end justify-end p-1">
                    <button
                        class="btn btn-sm btn-square btn-outline"
                        @click="closeModal()"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div> -->
                <div class="p-5 overflow-y-scroll">
                    <div class="p-2">
                        <h3 class="text-xl font-semibold">Product Details</h3>
                    </div>
                    <div>
                        <div
                            v-for="furniture in FurnitureDetails"
                            class="flex flex-row w-full h-full"
                        >
                            <div class="w-[50%] p-2 h-full">
                                <div
                                    v-if="
                                        furniture.image.includes('placeholder')
                                    "
                                    class="w-full flex items-center justify-center"
                                >
                                    <img
                                        class="w-[65%] h-[65%] object-cover rounded-md"
                                        :src="
                                            'https://loremflickr.com/100/100/furniture?random=' +
                                            key
                                        "
                                    />
                                </div>
                                <div
                                    v-else
                                    class="w-full items-center justify-center"
                                >
                                    <img
                                        class="w-[65%] h-[65%] object-cover rounded-md"
                                        :src="image + furniture.image"
                                    />
                                </div>
                            </div>
                            <div
                                class="p-2 text-start w-[50%] h-full flex flex-col card shadow-2xl rounded-md"
                            >
                                <div class="p-2">
                                    <h1 class="w-full h-fit font-bold text-2xl">
                                        {{ furniture.description }}
                                    </h1>
                                </div>
                                <div>
                                    <h2 class="p-2">
                                        Width: {{ furniture.width }} cm |
                                        Length: {{ furniture.length }} cm |
                                        Height: {{ furniture.height }} cm
                                    </h2>
                                </div>
                                <div class="p-2 flex flex-row justify-between">
                                    <h2 class="p-2 font-bold">
                                        Available Colors
                                    </h2>
                                    <select
                                        v-model="selectedColor"
                                        name="colors"
                                        id="color"
                                        class="select select-accent w-[45%] rounded-md mx-10 max-w-xs"
                                    >
                                        <option
                                            :value="color"
                                            v-for="color in furniture.color"
                                        >
                                            {{ color }}
                                        </option>
                                    </select>
                                </div>
                                <div class="p-2">
                                    <p>
                                        This furniture is created using a
                                        {{ furniture.wood_type }}
                                    </p>
                                </div>
                                <div class="p-2 mt-10">
                                    <p class="text-sm">
                                        Category : {{ furniture.category }}
                                    </p>
                                </div>
                                <div class="flex p-2 justify-end">
                                    <button
                                        class="btn btn-success mx-5 w-[30%] rounded-md hover:stroke-base-100 hover:text-base-100"
                                        @click="
                                            addToCart(
                                                furniture.code,
                                                furniture.description,
                                                selectedColor
                                            )
                                        "
                                    >
                                        <div
                                            class="flex flex-row w-full text-center items-center"
                                        >
                                            <p>Add to cart</p>
                                            <svg
                                                viewBox="0 0 24 24"
                                                class="w-7 h-7 ml-3"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                stroke="#ffffff"
                                            >
                                                <g
                                                    id="SVGRepo_bgCarrier"
                                                    stroke-width="0"
                                                ></g>
                                                <g
                                                    id="SVGRepo_tracerCarrier"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                ></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M21 5L19 12H7.37671M20 16H8L6 3H3M11.5 7L13.5 9M13.5 9L15.5 7M13.5 9V3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
                                                        stroke="#141414"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    ></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
import { ref, onUpdated } from "vue";
export default {
    props: ["FurnitureDetails", "User"],
    setup(props) {
        const user = props.User;
        const selectedColor = ref(props.FurnitureDetails[0].color[0]);
        const image = "http://inventory.test/storage/";

        onUpdated(() => {
            console.log(selectedColor.value);
        });
        return { image, user, selectedColor };
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        addToCart(code, desc, color) {
            // console.log(color);
            if (this.user) {
                Swal.fire({
                    text: color + " " + desc + " added to cart",
                    customClass: {
                        container: "position-absolute",
                    },
                    confirmButtonColor: "#049806",
                    toast: true,
                    position: "bottom-right",
                    timer: 3000, // 3000 milliseconds (3 seconds)
                    timerProgressBar: true, // Display a progress bar
                    showConfirmButton: false,
                });
                // console.log(stock);

                // console.log(true);
                router.post(route("catalog.cart"), {
                    _method: "post",
                    code: code,
                    color: color,
                });
                // console.log(this.colorSelected);
                this.colorSelected = "";

                // console.log(this.colorSelected);
            } else {
                const result = Swal.fire({
                    title: "You are not logged in",
                    text: "If you want to add this item to your cart, please login first",
                    icon: "info",
                    reverseButtons: true,
                    showConfirmButton: true,
                    showCancelButton: false,
                    cancelButtonColor: "#499380",
                    confirmButtonColor: "#0B1C11",
                    cancelButtonText: "",
                    confirmButtonText: "Login",
                    allowOutsideClick: true,
                });
                if (result.isConfirmed) {
                    // VueCookies.set("offlineState", "true");
                    router.get(route("login"));
                } else {
                    // location.reload();
                }
            }
            // console.log(this.state);
            // console.log(uuid, desc);
        },
    },
};
</script>

<style scoped>
.modal {
    width: 400px;
    padding: 20px;
    margin: 100px auto;
    background: white;
    border-radius: 10px;
    text-align: center;
}
button:hover svg path {
    stroke: #f1f1f1; /* Change this to the color you want */
}
.backdrop {
    top: 0;
    position: fixed;
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
}
</style>
