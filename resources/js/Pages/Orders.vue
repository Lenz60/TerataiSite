<template>
    <Head title="Purchased Order" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Purchased Order
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-base-200 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Track Code</th>
                                        <th>Payment Status</th>
                                        <th>Detail Info</th>
                                        <th>Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr
                                        v-for="(order, no) in orders"
                                        :key="order.id"
                                        class="hover:cursor-pointer hover:bg-base-100"
                                        @click="showDetailModal(order.id)"
                                    >
                                        <td>{{ no + 1 }}</td>
                                        <td>{{ order.name }}</td>
                                        <td>{{ order.track_code }}</td>
                                        <td>
                                            <div
                                                v-if="
                                                    order.payment_status ==
                                                    'Paid'
                                                "
                                            >
                                                <div
                                                    class="badge badge-outline w-full rounded-md badge-success"
                                                >
                                                    {{ order.payment_status }}
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div
                                                    class="badge badge-outline w-full rounded-md badge-warning"
                                                >
                                                    {{ order.payment_status }}
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            @click.stop
                                            @click="showInfoModal(order.id)"
                                        >
                                            <button class="btn btn-info">
                                                Detail Info
                                            </button>
                                        </td>
                                        <td
                                            @click.stop
                                            @click="downloadInvoice(order.id)"
                                        >
                                            <button class="btn btn-primary">
                                                Download
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="itemsModal">
            <ItemsModal
                @close="showDetailModal()"
                :OrderItem="selectedOrderItems"
            ></ItemsModal>
        </div>
        <div v-if="infoModal">
            <InfoModal
                @close="showInfoModal()"
                :OrderInfo="selectedOrderInfo"
            ></InfoModal>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import InfoModal from "@/Pages/Order/OrderInfo.vue";
import ItemsModal from "@/Pages/Order/OrderDetails.vue";
import { router, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
export default {
    components: {
        Head,
        AuthenticatedLayout,
        InfoModal,
        ItemsModal,
    },
    props: ["orders", "order_items", "order_info"],
    setup() {
        const selectedOrderItems = ref([]);
        const selectedOrderInfo = ref([]);
        const itemsModal = ref(false);
        const infoModal = ref(false);

        onMounted(() => {
            if (usePage().props.flash.message == "order:404") {
                Swal.fire({
                    icon: "success",
                    title: "Invoice not found",
                    text: "Invoice file is not found please contact administrator",
                    showConfirmButton: true,
                });
                usePage().props.flash.message = "";
            }
        });
        return { infoModal, itemsModal, selectedOrderInfo, selectedOrderItems };
    },
    methods: {
        filterOrderItems(context, orderId) {
            if (context == "Detail") {
                return this.order_items.filter(
                    (item) => item.order_id === orderId
                );
            } else {
                return this.order_info.filter(
                    (info) => info.order_id === orderId
                );
            }
        },
        showDetailModal(orderId) {
            if (orderId === "") {
                this.itemsModal = !this.itemsModal;
            } else {
                this.selectedOrderItems = this.filterOrderItems(
                    "Detail",
                    orderId
                );
                this.itemsModal = !this.itemsModal;
            }
        },
        showInfoModal(orderId) {
            if (orderId === "") {
                this.infoModal = !this.infoModal;
            } else {
                this.selectedOrderInfo = this.filterOrderItems("Info", orderId);
                console.log(this.selectedOrderInfo);
                this.infoModal = !this.infoModal;
            }
        },
        downloadInvoice(orderId) {
            router.post(route("orders.invoice"), {
                _method: "POST",
                Id: orderId,
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
