<template>
    <Navbar :CartCount="cartCounts"></Navbar>
    <div class="flex flex-col bg-base-100 w-full h-full">
        <!-- Hero -->
        <div class="bg-success text-neutral-content flex w-fit flex-col">
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
        <div class="m-2 flex flex-row w-fit h-full">
            <div class="w-fit flex flex-col h-full">
                <div class="p-3">
                    <ul>
                        <li>
                            <details
                                tabindex="0"
                                class="collapse collapse-arrow bg-base-100 rounded-md"
                            >
                                <summary
                                    class="collapse-title text-md font-medium"
                                >
                                    Filter
                                </summary>
                                <ul class="p-1">
                                    <li>
                                        <div
                                            class="card rounded-md p-2 text-wrap w-full h-fit"
                                        >
                                            <Link
                                                :href="route('catalog.index')"
                                            >
                                                <h1
                                                    class="text-sm font-normal w-fit h-fit"
                                                >
                                                    All
                                                </h1>
                                            </Link>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="card rounded-sm p-2 text-wrap w-full h-fit"
                                        >
                                            <Link
                                                :href="
                                                    route('catalog.filtered', {
                                                        category: 'indoor',
                                                    })
                                                "
                                            >
                                                <h1
                                                    class="text-sm font-normal w-full"
                                                >
                                                    Indoor
                                                </h1>
                                            </Link>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="card rounded-sm p-2 text-wrap w-full h-fit"
                                        >
                                            <Link
                                                :href="
                                                    route('catalog.filtered', {
                                                        category: 'outdoor',
                                                    })
                                                "
                                            >
                                                <h1
                                                    class="text-sm font-normal w-full"
                                                >
                                                    Outdoor
                                                </h1>
                                            </Link>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="card rounded-sm p-2 text-wrap w-full h-fit"
                                        >
                                            <Link
                                                :href="
                                                    route('catalog.filtered', {
                                                        category: 'handicraft',
                                                    })
                                                "
                                            >
                                                <h1
                                                    class="text-sm font-normal w-full"
                                                >
                                                    Handicraft
                                                </h1>
                                            </Link>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="card rounded-sm p-2 text-wrap w-full h-fit"
                                        >
                                            <Link
                                                :href="
                                                    route('catalog.filtered', {
                                                        category: 'root',
                                                    })
                                                "
                                            >
                                                <h1
                                                    class="text-sm font-normal w-full"
                                                >
                                                    Root
                                                </h1>
                                            </Link>
                                        </div>
                                    </li>
                                </ul>
                            </details>
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="bg-base-100 w-fit h-full text-accent-content bg-center m-2 mx-10 card rounded-md"
            >
                <div class="w-fit h-full grid grid-cols-3 gap-5 m-2">
                    <div
                        v-for="(furniture, key) in groupedFurniture"
                        :key="furniture.uuid"
                        class="card rounded-md shadow-2xl w-full items-center h-full bg-base-100 hover:shadow-2xl hover:border hover:border-neutral p-5 flex flex-col"
                    >
                        <div class="m1 p-1 w-full items-center justify-center">
                            <div>
                                <div
                                    v-if="
                                        furniture.image.includes('placeholder')
                                    "
                                    class="w-full flex items-center justify-center"
                                >
                                    <img
                                        class="w-[100px] h-[100px] object-contain rounded-md"
                                        :src="
                                            'https://loremflickr.com/100/100/furniture?random=' +
                                            key
                                        "
                                    />
                                </div>
                                <div
                                    v-else
                                    class="w-full flex items-center justify-center"
                                >
                                    <img
                                        class="w-[100px] h-[100px] object-cover rounded-md"
                                        :src="image + furniture.image"
                                    />
                                </div>
                            </div>

                            <h1
                                class="font-semibold text-center text-md p-1 text-wrap"
                            >
                                {{ furniture.description }}
                            </h1>
                            <div class="text-sm">
                                <div class="flex flex-row">
                                    <h1 class="font-bold">Dimentions</h1>
                                    <p class="pl-2">
                                        {{ furniture.width }} x
                                        {{ furniture.length }} x
                                        {{ furniture.height }} cm
                                    </p>
                                </div>
                                <div
                                    class="text-center items-center flex flex-row"
                                >
                                    <h1 class="p-1 text-wrap">Color:</h1>

                                    <div
                                        v-for="(
                                            color, index
                                        ) in furniture.color"
                                        :key="index"
                                    >
                                        <div v-if="furniture.color.length > 1">
                                            <div class="flex flex-row">
                                                <label
                                                    class="label cursor-pointer"
                                                >
                                                    <input
                                                        type="radio"
                                                        name="
                                                            radioMultiple
                                                        "
                                                        :value="color"
                                                        class="radio radio-sm"
                                                        :style="{
                                                            color: color,
                                                            background: color,
                                                        }"
                                                        @change="
                                                            selectedColor(
                                                                value,
                                                                furniture.code,
                                                                index
                                                            )
                                                        "
                                                        :checked="
                                                            color ==
                                                            furniture.color[0]
                                                        "
                                                    />
                                                </label>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="flex flex-row">
                                                <label
                                                    class="label cursor-pointer"
                                                    for="radio"
                                                >
                                                    <input
                                                        type="radio"
                                                        :name="
                                                            'radio' +
                                                            furniture.code
                                                        "
                                                        :value="color"
                                                        class="radio radio-sm"
                                                        :style="{
                                                            color: color,
                                                            background: color,
                                                        }"
                                                        @change="
                                                            selectedColor(
                                                                $event,
                                                                furniture.code
                                                            )
                                                        "
                                                        :checked="
                                                            color ==
                                                            furniture.color[0]
                                                        "
                                                    />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row">
                                    <div
                                        class="p-1 bg-base-200 w-fit rounded-sm"
                                    >
                                        <p class="text-[12px]">
                                            {{ furniture.wood_type }}
                                        </p>
                                    </div>
                                    <div
                                        v-for="color in furniture.color"
                                        class="ml-1 p-1 bg-base-200 w-fit rounded-sm"
                                    >
                                        <p class="text-[12px]">
                                            {{ color }}
                                        </p>
                                    </div>
                                </div>

                                <div v-if="furniture.price.length <= 1">
                                    <h2 class="p-1 text-center font-bold">
                                        ${{ furniture.price[0] }}
                                    </h2>
                                </div>
                                <div v-else class="p-1">
                                    <h2 class="p-1 text-center font-bold">
                                        $ {{ furniture.price[colorIndex] }}
                                    </h2>
                                </div>
                            </div>
                            <div
                                class="items-center justify-center text-center"
                            >
                                <button
                                    @click="
                                        addToCart(
                                            furniture.code,
                                            furniture.description,
                                            furniture.color
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
                </div>
                <div class="w-fulljoin justify-center items-center m-2">
                    <button
                        v-for="page in totalPages - 1"
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
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Navbar from "@/Components/Home/Navbar.vue";
import { router, Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { computed, ref } from "vue";
import { onMounted } from "vue";
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
        const colorSelectedArray = ref([]);
        const radioMultiple = ref("");
        const priceIndex = ref(0);
        const colorIndex = ref(0);
        let groupedFurniture = ref([]);
        const cartCount = props.cartCounts;

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
            console.log(currentPage.value);
        };

        onMounted(() => {
            let grouped = {};
            props.furnitures.forEach((furniture) => {
                if (!grouped[furniture.code]) {
                    grouped[furniture.code] = furniture;
                    grouped[furniture.code].color = [furniture.color]; // Wrap the color in an array
                    grouped[furniture.code].price = [furniture.price]; // Wrap the color in an array
                } else {
                    let colors = new Set(grouped[furniture.code].color);
                    let prices = new Set(grouped[furniture.code].price);
                    colors.add(furniture.color); // Add the color to the set
                    prices.add(furniture.price); // Add the color to the set
                    grouped[furniture.code].color = Array.from(colors); // Convert the set back to an array
                    grouped[furniture.code].price = Array.from(prices); // Convert the set back to an array
                }
            });
            const start = (currentPage.value - 1) * itemsPerPage.value;
            const end = start + itemsPerPage.value;
            groupedFurniture.value = Object.values(grouped).slice(start, end);
        });

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
            colorSelectedArray,
            radioMultiple,
            priceIndex,
            colorIndex,
            groupedFurniture,
        };
    },
    methods: {
        selectedColor(color, furnitureCode, index) {
            const colorObject = { furnitureCode, color };
            this.colorSelectedArray = [];
            this.colorSelectedArray.push(colorObject);

            this.colorIndex = index;
            this.radioChange += 1;
        },
        getColor(code, color) {
            if (
                this.colorSelectedArray[0] &&
                this.colorSelectedArray[0].furnitureCode == code
            ) {
                if (color.length > 1) {
                    return color[this.colorIndex];
                } else {
                    return color[0];
                }
            } else {
                return color[0];
            }
        },
        addToCart(code, desc, color) {
            color = this.getColor(code, color);
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

<style scoped></style>
