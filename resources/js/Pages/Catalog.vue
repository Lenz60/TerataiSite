<template>
    <Navbar :CartCount="cartCounts"></Navbar>
    <div
        class="m-2 items-center border-2 border-red-400 flex flex-col bg-base-100"
    >
        <!-- Hero -->
        <div class="bg-success text-neutral-content flex w-full flex-col">
            <div class="w-[60%] m-5 text-wrap">
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
        <div class="m-2 flex flex-col w-full">
            <div class="flex flex-row items-center justify-center">
                <div
                    class="m-2 border-2 border-cyan-300 card rounded-md p-2 text-wrap w-fit h-fit"
                >
                    <Link :href="route('catalog.index')">
                        <button class="btn btn-sm btn-accent h-fit w-fit">
                            <h1 class="text-xl font-normal w-fit h-fit">All</h1>
                        </button>
                    </Link>
                </div>
                <div class="m-2 card rounded-sm p-2 text-wrap w-fit h-fit">
                    <Link
                        :href="
                            route('catalog.filtered', { category: 'indoor' })
                        "
                    >
                        <button class="btn btn-sm btn-neutral h-fit w-fit">
                            <h1 class="text-xl font-normal w-fit">
                                Indoor Furniture
                            </h1>
                        </button>
                    </Link>
                </div>
                <div class="m-2 card rounded-sm p-2 text-wrap w-fit h-fit">
                    <Link
                        :href="
                            route('catalog.filtered', { category: 'outdoor' })
                        "
                    >
                        <button class="btn btn-sm btn-neutral h-fit w-fit">
                            <h1 class="text-xl font-normal w-fit">
                                Outdoor Furniture
                            </h1>
                        </button>
                    </Link>
                </div>
                <div class="m-2 card rounded-sm p-2 text-wrap w-fit h-fit">
                    <Link
                        :href="
                            route('catalog.filtered', {
                                category: 'handicraft',
                            })
                        "
                    >
                        <button class="btn btn-sm btn-neutral h-fit w-fit">
                            <h1 class="text-xl font-normal w-fit">
                                Handicraft Furniture
                            </h1>
                        </button>
                    </Link>
                </div>
                <div class="m-2 card rounded-sm p-2 text-wrap w-fit h-fit">
                    <Link
                        :href="route('catalog.filtered', { category: 'root' })"
                    >
                        <button class="btn btn-sm btn-neutral h-fit w-fit">
                            <h1 class="text-xl font-normal w-fit">
                                Root Furniture
                            </h1>
                        </button>
                    </Link>
                </div>
            </div>
            <div
                class="bg-base-200 border-2 border-green-400 h-full text-accent-content bg-center m-2 mx-10 card shadow-xl rounded-md"
            >
                <div
                    class="border-2 border-green-500 w-auto h-full grid grid-cols-6 gap-1 grid-rows-2 m-2"
                >
                    <div
                        v-for="furniture in paginatedFurnitures"
                        :key="furniture.uuid"
                        class="border-2 border-yellow-400 card rounded-md items-center h-fit shadow-sm hover:shadow-xl hover:border-2 hover:border-neutral w-fit m-2 p-5 flex flex-col"
                    >
                        <div>
                            <img
                                :src="image + furniture.image"
                                alt=""
                                class="w-[100px] h-[100px]"
                            />
                            <h1
                                class="font-semibold text-center text-md p-1 text-wrap"
                            >
                                {{ furniture.description }}
                            </h1>
                            <div class="text-sm">
                                <div>
                                    <h1 class="font-bold">Dimentions :</h1>
                                    <p>
                                        {{ furniture.width }} x
                                        {{ furniture.depth }} x
                                        {{ furniture.height }} cm
                                    </p>
                                </div>
                                <div>
                                    <h1 class="font-bold">Materials :</h1>
                                    <p>{{ furniture.wood_type }}</p>
                                </div>
                                <h1 class="p-1 text-wrap">
                                    Color: {{ furniture.color }}
                                </h1>
                                <h1 class="p-1 text-wrap">
                                    Ready stock : {{ furniture.stock }}
                                </h1>
                                <h2 class="p-1 text-center font-bold">
                                    ${{ furniture.price }}
                                </h2>
                            </div>
                            <button
                                @click="
                                    addToCart(
                                        furniture.uuid,
                                        furniture.description,
                                        furniture.stock
                                    )
                                "
                                class="btn btn-success rounded-md p-2"
                            >
                                <div v-if="furniture.stock > 0">
                                    Add to cart
                                </div>
                                <div v-else>Pre order</div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="join justify-center items-center m-2">
                    <button
                        v-for="page in totalPages"
                        :key="page"
                        @click="changePage(page)"
                        :class="{ 'btn-enabled': page === currentPage.value }"
                        class="join-item btn"
                    >
                        {{ page }}
                    </button>
                </div>
            </div>
        </div>
        <div class="text-neutral-focus" id="custom-target"></div>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Navbar from "@/Components/Home/Navbar.vue";
import { router, Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { computed, ref } from "vue";
export default {
    props: ["furnitures", "user", "cartCounts"],
    components: {
        AuthenticatedLayout,
        Navbar,
        Link,
    },
    setup(props) {
        const image = "http://inventory.test/storage/";
        const user = props.user;
        // const furnitures = ref(props.furnitures);
        const currentPage = ref(1);
        const itemsPerPage = ref(10);
        // console.log(state);
        const cartCount = props.cartCounts;
        console.log(props.cartCounts);

        const paginatedFurnitures = computed(() => {
            const start = (currentPage.value - 1) * itemsPerPage.value;
            const end = start + itemsPerPage.value;
            return props.furnitures.slice(start, end);
        });
        const totalPages = computed(() => {
            const pages = Math.ceil(
                props.furnitures.length / itemsPerPage.value
            );
            // console.log("Total pages:", pages); // Debugging line
            return pages;
        });

        const changePage = (page) => {
            console.log("Changing page to:", page); // Debugging line
            currentPage.value = page;
        };

        // console.log("Total pages :" + totalPages.page);
        return {
            image,
            user,
            currentPage,
            itemsPerPage,
            paginatedFurnitures,
            totalPages,
            changePage,
            cartCount,
        };
    },
    methods: {
        async addToCart(uuid, desc, stock) {
            // console.log(this.user);
            if (this.user) {
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
                console.log(stock);
                if (stock == "0") {
                    // console.log(true);
                    router.post(route("catalog.cart"), {
                        _method: "post",
                        uuid: uuid,
                        preorder: true,
                    });
                } else {
                    router.post(route("catalog.cart"), {
                        _method: "post",
                        uuid: uuid,
                        preorder: false,
                    });
                }
            } else {
                const result = await Swal.fire({
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
#custom-target {
    position: relative;
    width: 600px;
    height: 300px;
    border-style: solid;
}
</style>
