<template>
    <div data-themes="foliage">
        <header class="navbar bg-base-100 shadow-md w-screen">
            <div class="flex-none"></div>
            <div class="flex-1">
                <a href="/">
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
    },
    setup(props) {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
