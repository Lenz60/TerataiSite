<template>
    <Navbar></Navbar>
    <div
        class="border-2 border-green-400 m-2 items-center flex flex-col bg-base-100"
    >
        <!-- Hero -->
        <div class="bg-accent flex w-full flex-col border-2 border-black">
            <div class="w-[60%] m-5 text-wrap border-2 border-cyan-300">
                <h1 class="indent-8 text-5xl p-2 font-semibold">Catalog</h1>
                <p class="p-2 indent-5">
                    The diverse and plentiful experience the understanding of
                    nature of resource saving technologies directly depends on
                    economic practicability of decisions made. Thus the
                    established organisation structure requires the analysis of
                    strengthening the democratic system. It should be noted that
                    the established organisation structure allows to complete
                    important implementation tasks of strengthening the
                    democratic system.
                </p>
            </div>
        </div>
        <div class="border-2 border-black m-2 flex flex-col w-full">
            <div class="flex flex-row items-center justify-center">
                <div
                    class="border-2 m-2 card rounded-md p-2 text-wrap border-black w-fit h-fit"
                >
                    <h1 class="text-3xl w-fit">Indoor Furniture</h1>
                </div>
                <div
                    class="border-2 m-2 card rounded-md p-2 text-wrap border-black w-fit h-fit"
                >
                    <h1 class="text-3xl w-fit">Outdoor Furniture</h1>
                </div>
                <div
                    class="border-2 m-2 card rounded-md p-2 text-wrap border-black w-fit h-fit"
                >
                    <h1 class="text-3xl w-fit">Handicraft Furniture</h1>
                </div>
                <div
                    class="border-2 m-2 card rounded-md p-2 text-wrap border-black w-fit h-fit"
                >
                    <h1 class="text-3xl w-fit">Root Furniture</h1>
                </div>
            </div>
            <div
                class="border-2 border-red-400 bg-base-100 h-full w-auto m-2 card shadow-md rounded-md"
            >
                <div
                    class="border-2 w-auto h-full grid grid-cols-4 gap-2 grid-rows-2 border-cyan-400 m-2"
                >
                    <div
                        v-for="furniture in furnitures"
                        class="border-2 border-green-300 card rounded-md items-center text-center h-fit shadow-sm hover:shadow-xl w-auto m-2 p-5 flex flex-col"
                    >
                        <div class="items-center">
                            <img
                                :src="image + furniture.image"
                                alt=""
                                class="w-[100px] h-[100px]"
                            />
                            <h2 class="p-2">${{ furniture.price }}</h2>
                            <h1 class="p-2 text-wrap">
                                {{ furniture.description }}
                            </h1>
                            <button
                                @click="
                                    addToCart(
                                        furniture.uuid,
                                        furniture.description
                                    )
                                "
                                class="btn btn-success rounded-md p-2"
                            >
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
                <div class="join justify-center items-center m-2">
                    <button class="join-item btn">1</button>
                    <button class="join-item btn">2</button>
                    <button class="join-item btn btn-disabled">...</button>
                    <button class="join-item btn">99</button>
                    <button class="join-item btn">100</button>
                </div>
                <!-- <div class="border-2 border-cyan-400 m-2 flex flex-row">
                        <div
                            v-for="furniture in furnitures"
                            class="border-2 border-green-500 m-2 w-[500px] flex flex-col items-center justify-center"
                        >
                            <div>
                                <img
                                    :src="image + furniture.image"
                                    alt=""
                                    class="w-[100px] h-[100px]"
                                />
                                <h2 class="p-2">${{ furniture.price }}</h2>
                                <h1 class="p-2">{{ furniture.description }}</h1>
                            </div>
                        </div>
                    </div> -->
            </div>
        </div>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Navbar from "@/Components/Home/Navbar.vue";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
export default {
    props: ["furnitures"],
    components: {
        AuthenticatedLayout,
        Navbar,
    },
    setup() {
        const image = "http://inventory.test/storage/";
        return { image };
    },
    methods: {
        addToCart(uuid, desc) {
            // console.log(uuid, desc);
            Swal.fire({
                text: desc + " added to cart",
                target: "#custom-target",
                customClass: {
                    container: "position-absolute",
                },
                confirmButtonColor: "#049806",
                toast: true,
                position: "bottom-right",
                timer: 2000, // 3000 milliseconds (3 seconds)
                timerProgressBar: true, // Display a progress bar
                showConfirmButton: false,
            });
            router.post(route("catalog.cart"), {
                _method: "post",
                uuid: uuid,
                description: desc,
            });
        },
    },
};
</script>

<style scoped>
#custom-target {
    position: relative;
    width: 600px;
    height: 300px;
    border-style: solid;
}
</style>
