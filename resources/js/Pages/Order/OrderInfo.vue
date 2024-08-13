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
                <div class="p-5">
                    <div>
                        <h3 class="text-xl font-semibold">
                            Order Information Details
                        </h3>
                    </div>
                    <div class="">
                        <div class="w-full">
                            <div
                                class="items-start text-start justify-center m-2 card rounded-md bg-base-300 flex flex-col"
                                v-for="(info, index) in OrderInfo"
                                :key="info.id"
                            >
                                <div class="p-5">
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Name</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">{{ info.name }}</p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Company</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">{{ info.company }}</p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Email</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">{{ info.email }}</p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Phone Number</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">
                                            {{ info.phone_number }}
                                        </p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Address</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">{{ info.address }}</p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Country</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">{{ info.country }}</p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Region</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">{{ info.region }}</p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Zip</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">{{ info.zip }}</p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Tracking Code</h1>
                                        <h1>:</h1>
                                        <p class="pl-3">
                                            {{ info.track_code }}
                                        </p>
                                    </div>
                                    <div class="flex justify-start">
                                        <h1 class="w-36">Payment Status</h1>
                                        <h1>:</h1>
                                        <div
                                            v-if="info.payment_status == 'Paid'"
                                        >
                                            <p class="pl-3 text-success">
                                                {{ info.payment_status }}
                                            </p>
                                        </div>
                                        <div v-else>
                                            <p class="pl-3 text-warning">
                                                {{ info.payment_status }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- {{ OrderInfo }} -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["OrderInfo"],
    setup() {
        return {};
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
h1 {
    font-size: 1.05rem; /* Adjust as needed */
}
p {
    font-size: 1.02rem;
}
</style>
