<template>
    <app-layout>
        <template #header>
            <div class="flex ">
                <div class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Crear nuevo curso
                    </h2>
                </div>
                <div class="flex-auto">
                    <button
                        :disabled="loading"
                        class="bg-indigo-500 py-2 px-5 text-white float-right rounded-r-lg outline-none focus:outline-none"
                        @click="saveCourse()">
                        <div class="flex">
                            <loading v-if="loading" color="white"/>
                            Guardar
                        </div>
                    </button>

                    <a
                        class="bg-gray-500 py-2 px-5 text-white float-right rounded-l-lg outline-none focus:outline-none"
                        :href="route('courses.index')"
                    >
                        Volver
                    </a>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <form-course ref="form" @saving="(res) => loading = res"/>
        </div>

    </app-layout>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Loading from "@/Components/Loading"
    import FormCourse from '@/Pages/Courses/form'

    export default {
        name: "CoursesCreate",
        components: {AppLayout, FormCourse, Loading},
        data() {
            return {
                loading: false,
            }
        },
        methods: {
            saveCourse() {
                this.$refs.form.saveCourse()
            }
        }
    }
</script>

<style scoped>

</style>
