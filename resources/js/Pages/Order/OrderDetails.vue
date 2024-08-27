<template>
    <div class="backdrop">
        <div
            class="bg-base-100 text-center w-[90%] h-fit m-auto mt-[3%] mb-[2%] overflow-auto rounded-md"
        >
            <div class="flex flex-col">
                <div class="text-end justify-end p-2">
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
                </div>
                <div v-if="$page.props.flash.message"></div>
                <div>
                    <h3 class="text-xl font-semibold">Order Items Details</h3>
                </div>
                <div class="p-5">
                    <div class="overflow-x-auto bg-base-300 card rounded-md">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Furniture Image</th>
                                    <th>Furniture Name</th>
                                    <th>Furniture Color</th>
                                    <th>Furniture Status</th>
                                    <th>Qty Order</th>
                                    <th>Total Price</th>
                                    <th>Update Production Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr
                                    v-for="(items, no) in OrderItem"
                                    :key="items.id"
                                    class="hover:bg-base-100"
                                >
                                    <td>
                                        {{ no + 1 }}
                                    </td>
                                    <td>
                                        <div>
                                            <div
                                                v-if="
                                                    items.image.includes(
                                                        'placeholder'
                                                    )
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
                                                    :src="
                                                        'storage/' + items.image
                                                    "
                                                />
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ items.description }}</td>
                                    <td>{{ items.color }}</td>
                                    <td>
                                        <div v-if="items.preorder === 'true'">
                                            Pre-Order
                                        </div>
                                        <div v-else>In stock</div>
                                    </td>
                                    <td>{{ items.qty }}</td>
                                    <td>${{ items.total_price }}</td>
                                    <td>
                                        <div
                                            class="badge rounded-md w-full h-full"
                                            :class="
                                                ['Wrapped', 'Shipped'].includes(
                                                    items.status
                                                )
                                                    ? 'badge-success'
                                                    : items.status ===
                                                      'Finishing'
                                                    ? 'badge-info'
                                                    : 'badge-warning'
                                            "
                                        >
                                            {{ items.status }}
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <input
                                            type="checkbox"
                                            class="checkbox checkbox-sm checkbox-info rounded-sm"
                                            v-if="items.isSelectChanged"
                                        />
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { onUpdated } from "vue";
import Swal from "sweetalert2";
export default {
    props: ["OrderItem"],
    setup(props) {
        // console.log(message);
        onUpdated(() => {
            // const { props } = usePage();
            // const message = usePage().props.flash.message;
            // console.log(props.flash.message);
            if (usePage().props.flash.message == "updateOrder:200") {
                Swal.fire({
                    icon: "success",
                    title: "Item status updated successfully",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // router.get(route("order.index"));
                //Set default message to 404 so that sweetalert not showing two times
                usePage().props.flash.message = "update:404";
            }
        });
        // console.log(props.OrderItem);
        // props.OrderItem.forEach((item) => {
        //     item.selectedOption = item.status;
        //     item.isSelectChanged = false;
        //     item.filteredOptions = options.filter(
        //         (option) => option !== item.status
        //     );
        // });
        return { OrderItem: props.OrderItem };
    },
    methods: {
        closeModal() {
            this.$emit("close");
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
.backdrop {
    top: 0;
    position: fixed;
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
}
</style>
