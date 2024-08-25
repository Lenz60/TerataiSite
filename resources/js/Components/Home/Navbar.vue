<template>
    <div data-themes="foliage">
        <header class="navbar bg-base-100 shadow-md w-full">
            <div class="flex-none"></div>
            <div class="flex-1">
                <a :href="route('catalog.index')">
                    <img
                        src="/images/logo.png"
                        alt=""
                        class="btn rounded-md btn-ghost normal-case invisible xl:visible md:visible sm:invisible"
                    />
                </a>
            </div>
            <div v-if="!noAuth" class="px-5">
                <div v-if="$page.props.auth.user" class="menu flex-row-reverse">
                    <div class="flex">
                        <ul class="menu menu-horizontal px-1">
                            <div class="mx-2">
                                <Link :href="route('cart.index')" method="get">
                                    <div
                                        class="text-primary indicator p-2 w-full"
                                    >
                                        <p
                                            class="font-semibold font-montserrat break-words"
                                        >
                                            Cart
                                        </p>
                                        <div v-if="CartCount">
                                            <span
                                                class="indicator-item text-[12px] rounded-full p-0.5 bg-error mt-2 font-montserrat text-base-100 indicator-end w-4 h-4 flex items-center justify-center"
                                            >
                                                {{ CartCount }}
                                            </span>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                            <li>
                                <details class="text-primary">
                                    <summary>
                                        <p
                                            class="text-md font-semibold font-montserrat px-2 break-words"
                                        >
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                    </summary>
                                    <ul
                                        class="flex flex-col bg-base-200 bg-opacity-70 w-full rounded-md text-center justify-center"
                                    >
                                        <li>
                                            <Link
                                                :href="route('dashboard')"
                                                method="get"
                                            >
                                                <p class="text-sm text-center">
                                                    Dashboard
                                                </p>
                                            </Link>
                                        </li>
                                        <!-- <li>
                                            <Link
                                                :href="route('dashboard.admin')"
                                                method="get"
                                            >
                                                <p class="text-sm text-center">
                                                    Dashboard Admin
                                                </p>
                                            </Link>
                                        </li> -->
                                        <li>
                                            <Link
                                                :href="route('profile.edit')"
                                                method="get"
                                            >
                                                <p class="text-sm text-center">
                                                    Profile
                                                </p>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link
                                                :href="route('logout')"
                                                method="post"
                                            >
                                                <p class="text-sm text-center">
                                                    Log out
                                                </p>
                                            </Link>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </div>
                </div>
                <div v-else>
                    <Link :href="route('login')">
                        <p class="btn btn-ghost">Sign in</p>
                    </Link>
                </div>
            </div>
        </header>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        Link,
    },
    props: {
        noAuth: Object,
        CartCount: String,
    },
    setup(props) {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
