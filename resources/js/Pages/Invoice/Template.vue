<template>
    <div>
        <h1>Title : {{ title }}</h1>

        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>code</th>
                        <th>Desc</th>
                        <th>Category</th>
                        <th>Wood_type</th>
                        <th>Width</th>
                        <th>Length</th>
                        <th>Height</th>
                        <th>Stock</th>
                        <th>Color</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <tr v-for="furniture in furnitures">
                        <td>{{ furniture.uuid }}</td>
                        <td>{{ furniture.code }}</td>
                        <td>{{ furniture.description }}</td>
                        <td>{{ furniture.category }}</td>
                        <td>{{ furniture.wood_type }}</td>
                        <td>{{ furniture.width }}</td>
                        <td>{{ furniture.length }}</td>
                        <td>{{ furniture.height }}</td>
                        <td>{{ furniture.stock }}</td>
                        <td>{{ furniture.color }}</td>
                        <td>{{ furniture.price }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "date", "furnitures"],
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
