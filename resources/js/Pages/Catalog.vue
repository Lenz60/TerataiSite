<template>
    <div class="border-2 border-green-400 m-2 flex flex-row">
        <div class="border-2 border-blue-400 m-2 flex flex-col w-full">
            <div
                class="border-2 border-yellow-300 m-2 justify-center text-center"
            >
                <h1>This is a Title</h1>
            </div>
            <div class="border-2 border-red-400 m-2">
                <div class="border-2 border-cyan-400 m-2 flex flex-row">
                    <div
                        v-for="furniture in furnitures"
                        class="border-2 border-green-500 m-2 w-[500px] flex flex-col items-center justify-center"
                    >
                        <div>
                            <img
                                :src="image + furniture.image"
                                alt=""
                                class="w-[100px] h-[100px]"
                            />
                            <h2 class="p-2">${{ furniture.price }}</h2>
                            <h1 class="p-2">{{ furniture.description }}</h1>
                        </div>
                    </div>
                </div>
                <div class="border-2 border-cyan-400 m-2 flex flex-row">
                    <div
                        v-for="furniture in furnitures"
                        class="border-2 border-green-500 m-2 w-[500px] flex flex-col items-center justify-center"
                    >
                        <div>
                            <img
                                :src="image + furniture.image"
                                alt=""
                                class="w-[100px] h-[100px]"
                            />
                            <h2 class="p-2">${{ furniture.price }}</h2>
                            <h1 class="p-2">{{ furniture.description }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["furnitures"],
    setup() {
        const image = "http://inventory.test/storage/";
        return { image };
    },
};
</script>

<style lang="scss" scoped></style>
