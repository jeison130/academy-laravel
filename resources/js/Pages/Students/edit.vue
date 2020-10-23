<template>
    <app-layout>
        <template #header>
            <div class="flex ">
                <div class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Editar estudiante <span class="font-medium italic text-lg">{{ student.name }}</span>
                    </h2>
                </div>
                <div class="flex-auto">
                    <button
                        :disabled="loading"
                        class="bg-indigo-500 py-2 px-5 text-white float-right rounded-r-lg outline-none focus:outline-none"
                        @click="saveStudent()">
                        <div class="flex">
                            <loading v-if="loading" color="white" />
                            Guardar
                        </div>
                    </button>

                    <a
                        class="bg-gray-500 py-2 px-5 text-white float-right rounded-l-lg outline-none focus:outline-none"
                        :href="route('students.index')"
                    >
                        Volver
                    </a>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <form-student ref="form" :student="student" @saving="(res) => loading = res"/>
        </div>

    </app-layout>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Loading from "@/Components/Loading";
    import FormStudent from '@/Pages/Students/form'

    export default {
        name: "EditStudent",
        components: {AppLayout, Loading, FormStudent},
        props: ['student'],
        data() {
            return {
                loading: false,
            }
        },
        methods: {
            saveStudent(){
                this.$refs.form.saveStudent()
            }
        }
    }
</script>

<style scoped>

</style>
