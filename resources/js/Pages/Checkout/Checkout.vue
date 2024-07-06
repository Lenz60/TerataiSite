<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Checkout
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-base-200 shadow-sm sm:rounded-lg">
                    <div
                        class="item-center justify-center m-1 p-2 flex flex-row"
                    >
                        <div class="w-full flex flex-row">
                            <div class="w-full m-2">
                                <!-- Title -->
                                <div class="">
                                    <h1 class="text-xl font-bold">
                                        Billing address
                                    </h1>
                                </div>
                                <!-- Form -->
                                <div class="m-2">
                                    <form class="">
                                        <div class="">
                                            <div class="m-2">
                                                <InputLabel
                                                    for="name"
                                                    value="Name"
                                                />
                                                <TextInput
                                                    class="w-full"
                                                    v-model="form.name"
                                                    type="text"
                                                    :value="form.name"
                                                />
                                            </div>
                                            <div class="m-2">
                                                <InputLabel
                                                    for="company"
                                                    value="Company"
                                                />
                                                <TextInput
                                                    class="w-full"
                                                    v-model="form.company"
                                                    type="text"
                                                    :value="form.company"
                                                />
                                            </div>

                                            <div class="m-2">
                                                <InputLabel
                                                    for="email"
                                                    value="Email"
                                                />
                                                <TextInput
                                                    class="w-full"
                                                    v-model="form.email"
                                                    type="text"
                                                    :value="form.email"
                                                />
                                            </div>
                                            <div class="m-2">
                                                <InputLabel
                                                    for="address1"
                                                    value="Address"
                                                />
                                                <TextInput
                                                    class="w-full"
                                                    v-model="address1"
                                                    type="text"
                                                />
                                            </div>
                                            <div class="m-2">
                                                <div class="flex flex-row">
                                                    <InputLabel
                                                        for="address2"
                                                        value="Address 2"
                                                    />
                                                    <span
                                                        class="block ml-2 text-sm text-gray-700"
                                                    >
                                                        (Optional)</span
                                                    >
                                                </div>
                                                <TextInput
                                                    class="w-full"
                                                    v-model="address2"
                                                    type="text"
                                                />
                                            </div>
                                            <div class="m-2 flex flex-row">
                                                <div class="flex flex-col w-40">
                                                    <InputLabel
                                                        for="country"
                                                        value="Country"
                                                    />
                                                    <!--! Ignore the vue[warn] it will go away when its production  -->
                                                    <CountrySelect
                                                        :usei18n="false"
                                                        :countryName="true"
                                                        :regionName="true"
                                                        class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                                        v-model="form.country"
                                                        :country="form.country"
                                                        topCountry="ID"
                                                    ></CountrySelect>
                                                </div>
                                                <div
                                                    class="mx-2 flex flex-col w-40"
                                                >
                                                    <InputLabel
                                                        for="region"
                                                        value="Region"
                                                    />
                                                    <!--! Ignore the vue[warn] it will go away when its production  -->
                                                    <RegionSelect
                                                        :usei18n="false"
                                                        :countryName="true"
                                                        :regionName="true"
                                                        class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                                        v-model="form.region"
                                                        :country="form.country"
                                                        :region="form.region"
                                                    ></RegionSelect>
                                                </div>
                                                <div
                                                    class="mx-2 flex flex-col w-[100px]"
                                                >
                                                    <InputLabel
                                                        for="zip"
                                                        value="Zip code"
                                                    />
                                                    <input
                                                        class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm w-full"
                                                        v-model="form.zip"
                                                        type="number"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr
                                    class="border-t-1 border-gray-400 my-4 mb-4"
                                />
                                <div class="w-full">
                                    <button
                                        class="btn btn-info w-full"
                                        @click="checkout()"
                                    >
                                        Continue Checkout
                                    </button>
                                </div>
                                <!-- <div class="border-2 border-blue-500 m-2"></div> -->
                            </div>
                        </div>
                        <div class="mx-5 w-[40%] flex flex-col">
                            <div class="">
                                <h1 class="text-xl font-semibold text-gray-600">
                                    Your cart
                                </h1>
                            </div>
                            <div
                                class="rounded-md bg-base-100 w-full shadow-xl"
                            >
                                <div
                                    v-for="(cart, index) in formattedCarts"
                                    :index="index"
                                    class=""
                                >
                                    <div
                                        class="flex-row w-full inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white"
                                    >
                                        <div class="w-full">
                                            <h1 class="font-semibold">
                                                {{ cart.description }}
                                            </h1>
                                            <p class="text-sm">
                                                Color: {{ cart.color }}
                                            </p>
                                            <p class="text-sm">
                                                Materials: {{ cart.wood_type }}
                                            </p>
                                        </div>
                                        <div
                                            class="text-center items-center w-full h-full"
                                        >
                                            <h1>{{ cart.total_price }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row w-full items-center">
                                    <h1 class="p-2 w-full">Total (USD) :</h1>
                                    <div
                                        class="text-center items-center w-full h-full"
                                    >
                                        <h1>${{ totalPrice }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { CountrySelect, RegionSelect } from "vue3-country-region-select-mod";
export default {
    components: {
        AuthenticatedLayout,
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        Head,
        Link,
        useForm,
        CountrySelect,
        RegionSelect,
    },
    props: ["carts", "totalPrice"],
    setup(props) {
        console.log(props.cart);
        const totalPrice = ref(props.totalPrice);
        const carts = ref(props.carts);
        const address1 = ref("");
        const address2 = ref("");
        const form = useForm({
            name: usePage().props.auth.user.name || "",
            company: usePage().props.auth.user.company || "",
            email: usePage().props.auth.user.email || "",
            address: address1.value + address2.value,
            country: "",
            region: "",
            zip: "",
        });
        return { form, address1, address2, carts, totalPrice };
    },
    computed: {
        formattedCarts() {
            return this.carts.map((cart) => {
                return {
                    ...cart,
                    total_price: `$${cart.total_price}`,
                };
            });
        },
    },
    methods: {
        checkout() {
            console.log(this.form);
        },
    },
};
</script>

<style lang="scss" scoped></style>
