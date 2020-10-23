<template>
    <app-layout>
        <template #header>
            <div class="flex ">
                <div class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Estudiantes
                    </h2>
                </div>
                <div class="flex-auto">
                    <a
                        class="bg-indigo-500 py-2 px-5 text-white float-right rounded-lg outline-none focus:outline-none"
                        :href="route('students.create')"
                    >
                        Crear
                    </a>
                </div>
            </div>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                Nombres
                                            </th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                Apellidos
                                            </th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                Edad
                                            </th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th class="px-6 py-3 bg-gray-50"></th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-if="!students.data.length">
                                            <td colspan="5">
                                                <div class="text-center py-5 text-gray-500">
                                                    No se han encontrado resultados para tu busqueda
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-for="student in students.data" v-else>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ student.name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ student.lastName }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ student.age }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ student.email }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                                <a :href="route('students.edit', student.id)"
                                                   class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                                <a @click="showDeleteStudentModal(student)"
                                                   class="cursor-pointer text-red-600 hover:text-red-900 ml-1">Eliminar</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <pagination :data="students"/>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal confirmation delete student-->
        <jet-confirmation-modal v-if="studentDelete" :show="deleteStudentModal" @close="deleteStudentModal = false">
            <template #title>
                Eliminar estudiante
            </template>

            <template #content>
                ¿Está seguro que desea eliminar al estudiante {{ studentDelete.name }} {{ studentDelete.lastName }}?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="deleteStudentModal = false">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteStudent"
                                   :class="{ 'opacity-25': formDelete.processing }"
                                   :disabled="formDelete.processing">

                    <div class="flex justify-center items-center">
                        <loading v-if="true" size="3" color="white"/>
                        Eliminar
                    </div>
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from "@/Components/Pagination";
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";
    import JetDangerButton from "@/Jetstream/DangerButton";
    import Loading from "@/Components/Loading";

    export default {
        name: "list.vue",
        components: {AppLayout, Pagination, JetConfirmationModal, JetSecondaryButton, JetDangerButton, Loading},
        props: ['students'],
        data() {
            return {
                deleteStudentModal: false,
                studentDelete: null,
                formDelete: this.$inertia.form({
                    '_method': 'DELETE'
                })
            }

        },
        methods: {
            showDeleteStudentModal(student) {
                this.deleteStudentModal = true
                this.studentDelete = student

            },
            deleteStudent() {
                this.formDelete.delete(route('students.destroy', this.studentDelete.id))
            }
        }
    }
</script>

<style scoped>

</style>
