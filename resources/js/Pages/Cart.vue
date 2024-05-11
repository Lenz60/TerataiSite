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
                    class="bg-base-200 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">This is a cart view</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
export default {
    components: {
        AuthenticatedLayout,
    },
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
