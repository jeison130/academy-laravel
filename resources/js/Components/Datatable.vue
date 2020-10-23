<template>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 w-full">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <slot name="head"></slot>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="loading">
                                    <td colspan="5">
                                        <div class="flex py-5 text-gray-500 justify-center">
                                            <loading />
                                        </div>

                                    </td>
                                </tr>
                                <tr v-else-if="!data.data.length">
                                    <td colspan="5">
                                        <div class="text-center py-5 text-gray-500">
                                            No se han encontrado resultados para tu búsqueda
                                        </div>
                                    </td>
                                </tr>
                                <template v-else>
                                    <slot name="body"></slot>
                                </template>
                                </tbody>
                            </table>

                            <pagination v-if="pagination" :data="data"/>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Pagination from "@/Components/Pagination";
    import Loading from "@/Components/Loading";

    export default {
        name: "Datatable",
        props: {
            data: {
                default: null
            },
            pagination: {
                default: true
            },
            loading: {
                default: false
            }
        },
        components: { Pagination, Loading }
    }
</script>

<style scoped>

</style>
