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
                                    <form class="" id="checkout">
                                        <div class="">
                                            <div class="m-2">
                                                <InputLabel
                                                    for="name"
                                                    value="Name"
                                                />
                                                <TextInput
                                                    required
                                                    class="w-full"
                                                    v-model="form.name"
                                                    type="text"
                                                    :value="form.name"
                                                />
                                                <InputError
                                                    class="mt-2 text-start"
                                                    :message="errors['name']"
                                                />
                                            </div>
                                            <div class="m-2">
                                                <InputLabel
                                                    for="company"
                                                    value="Company"
                                                />
                                                <TextInput
                                                    required
                                                    class="w-full"
                                                    v-model="form.company"
                                                    type="text"
                                                    :value="form.company"
                                                />
                                                <InputError
                                                    class="mt-2 text-start"
                                                    :message="errors['company']"
                                                />
                                            </div>

                                            <div class="m-2">
                                                <InputLabel
                                                    for="email"
                                                    value="Email"
                                                />
                                                <TextInput
                                                    required
                                                    class="w-full"
                                                    v-model="form.email"
                                                    type="text"
                                                    :value="form.email"
                                                />
                                                <InputError
                                                    class="mt-2 text-start"
                                                    :message="errors['email']"
                                                />
                                            </div>
                                            <div class="m-2">
                                                <div class="flex flex-row">
                                                    <InputLabel
                                                        for="phoneNumber"
                                                        value="Phone Number"
                                                    />
                                                    <span
                                                        class="block ml-2 text-sm text-gray-700"
                                                    >
                                                        (Whatsapp)</span
                                                    >
                                                </div>
                                                <input
                                                    required
                                                    class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm w-full"
                                                    v-model="form.phoneNumber"
                                                    type="number"
                                                />
                                                <InputError
                                                    class="mt-2 text-start"
                                                    :message="
                                                        errors['phoneNumber']
                                                    "
                                                />
                                            </div>
                                            <div class="m-2">
                                                <InputLabel
                                                    for="address"
                                                    value="Address"
                                                />
                                                <TextInput
                                                    required
                                                    class="w-full"
                                                    v-model="form.address"
                                                    :value="form.address"
                                                    type="text"
                                                />
                                                <InputError
                                                    class="mt-2 text-start"
                                                    :message="errors['address']"
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
                                                    required
                                                    class="w-full"
                                                    v-model="form.address2"
                                                    :value="form.address2"
                                                    type="text"
                                                />
                                            </div>
                                            <div class="m-2 flex flex-row">
                                                <div class="flex flex-col w-44">
                                                    <InputLabel
                                                        for="country"
                                                        value="Country"
                                                    />
                                                    <!--! Ignore the vue[warn] it will go away when its production  -->
                                                    <CountrySelect
                                                        required
                                                        :usei18n="false"
                                                        :countryName="true"
                                                        :regionName="true"
                                                        class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                                        v-model="form.country"
                                                        :country="form.country"
                                                    ></CountrySelect>
                                                    <InputError
                                                        class="mt-2 text-start"
                                                        :message="
                                                            errors['country']
                                                        "
                                                    />
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
                                                        required
                                                        :usei18n="false"
                                                        :countryName="true"
                                                        :regionName="true"
                                                        class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
                                                        v-model="form.region"
                                                        :country="form.country"
                                                        :region="form.region"
                                                    ></RegionSelect>
                                                    <InputError
                                                        class="mt-2 text-start"
                                                        :message="
                                                            errors['region']
                                                        "
                                                    />
                                                </div>
                                                <div
                                                    class="mx-2 flex flex-col w-[100px]"
                                                >
                                                    <InputLabel
                                                        for="zip"
                                                        value="Zip code"
                                                    />
                                                    <input
                                                        required
                                                        class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm w-full"
                                                        v-model="form.zip"
                                                        type="number"
                                                    />
                                                    <InputError
                                                        class="mt-2 text-start"
                                                        :message="errors['zip']"
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
                                    <div v-if="stateLoading">
                                        <button
                                            form="checkout"
                                            class="btn btn-info btn-disabled cursor-pointer w-full"
                                            type="submit"
                                            @click="checkout()"
                                        >
                                            Continue Checkout
                                        </button>
                                    </div>
                                    <div v-else>
                                        <button
                                            class="btn btn-info w-full"
                                            type="submit"
                                            @click="checkout()"
                                            :class="
                                                stateLoading
                                                    ? 'cursor-not-allowed, btn-disabled, cursor-pointer'
                                                    : ''
                                            "
                                        >
                                            Continue Checkout
                                        </button>
                                    </div>
                                </div>
                                <!-- <div class="border-2 border-blue-500 m-2"></div> -->
                            </div>
                        </div>
                        <div class="mx-5 w-[40%] flex flex-col">
                            <div class="flex flex-row w-full">
                                <h1
                                    class="w-full text-xl font-semibold text-gray-600"
                                >
                                    Your cart
                                </h1>
                                <h1
                                    class="w-6 h-6 mt-0.5 mb-1 text-center justify-center items-center text-base-100 font-semibold bg-primary rounded-full"
                                >
                                    {{ cartCounts }}
                                </h1>
                            </div>
                            <div class="h-full">
                                <div
                                    class="h-fit bg-base-100 rounded-md w-full shadow-xl"
                                >
                                    <div
                                        v-for="(cart, index) in formattedCarts"
                                        :index="index"
                                        class=""
                                    >
                                        <div
                                            class="flex-row w-full w-fit inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white"
                                        >
                                            <div class="w-full">
                                                <h1 class="font-semibold">
                                                    {{ cart.description }}
                                                </h1>
                                                <p class="text-sm">
                                                    Color: {{ cart.color }}
                                                </p>
                                                <p class="text-sm">
                                                    Materials:
                                                    {{ cart.wood_type }}
                                                </p>
                                            </div>
                                            <div>
                                                <h1>{{ cart.qty }}</h1>
                                            </div>
                                            <div
                                                class="text-gray-600 text-center items-center w-full h-full"
                                            >
                                                <h1>{{ cart.total_price }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex flex-row w-full items-center"
                                    >
                                        <h1 class="p-2 w-full">
                                            Total (USD) :
                                        </h1>
                                        <div
                                            class="text-center items-center w-full h-full"
                                        >
                                            <h1>${{ totalPrice }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full mt-8">
                                    <div>
                                        <h1 class="font-bold text-sm">
                                            Note :
                                        </h1>
                                        <p class="p-1 text-sm">
                                            An active phone number is needed to
                                            send the invoice via WhatsApp.
                                        </p>
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
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
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
    props: ["carts", "totalPrice", "cartCounts", "errors"],
    setup(props) {
        console.log(props.cart);
        const totalPrice = ref(props.totalPrice);
        const carts = ref(props.carts);
        const address1 = ref("");
        const address2 = ref("");
        const stateLoading = ref(false);
        console.log(stateLoading);
        const form = useForm({
            name: usePage().props.auth.user.name || "",
            company: usePage().props.auth.user.company || "",
            email: usePage().props.auth.user.email || "",
            phoneNumber: "",
            address: "",
            address2: "",
            country: "",
            region: "",
            zip: "",
        });
        // const address = computed(() => form.address + ", " + address2.value);
        // console.log(form.errors);
        const errorProps = props.errors;
        const formErrors = computed(() => form.errors);
        console.log(props.errors);

        return {
            form,
            address1,
            address2,
            carts,
            totalPrice,
            // address,
            stateLoading,
            errorProps,
        };
    },
    computed: {
        formattedCarts() {
            console.log(this.form.errors);
            return this.carts.map((cart) => {
                return {
                    ...cart,
                    total_price: `$${cart.total_price}`,
                };
            });
        },
    },
    methods: {
        async checkout() {
            // this.form.address = this.form.address + "," + this.address2;
            // console.log(this.formErrors);
            // console.log(this.form);
            // router.post(route("checkout.create"), {
            //     _method: "post",
            //     form: this.form,
            // });
            // this.form.post(route("checkout.create"));
            // this.stateLoading = !this.stateloading;
            // console.log(this.stateLoading);
            const checkout = await router.post(route("checkout.create"), {
                _method: "post",
                info: this.form,
                cart: this.carts,
                totalPrice: this.totalPrice,
            });
            if (checkout) {
                // this.stateLoading = !this.stateLoading;
                router.get(route("cart.index"));
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
