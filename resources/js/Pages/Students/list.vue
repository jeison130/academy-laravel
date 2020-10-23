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
            <datatable :data="students">
                <template #head>
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
                </template>

                <template #body>
                    <tr v-for="student in students.data">
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
                            <div class="flex items-center justify-around">
                                <a :href="route('students.edit', student.id)"
                                   class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <a @click="showDeleteStudentModal(student)"
                                   class="cursor-pointer text-red-600 hover:text-red-900">Eliminar</a>

                                <button type="button"
                                        class="bg-green-400 hover:bg-green-500 py-2 px-5 text-white float-right rounded-lg outline-none focus:outline-none"
                                        @click="showToAssignCourse(student)">
                                    Asignar Curso
                                </button>

                                <button type="button"
                                        class="bg-blue-400 hover:bg-blue-500 py-2 px-5 text-white float-right rounded-lg outline-none focus:outline-none">
                                    Ver Cursos
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </datatable>
        </div>

        <!--Modal confirmation delete student-->
        <jet-confirmation-modal v-if="currentStudent" :show="deleteStudentModal" @close="deleteStudentModal = false">
            <template #title>
                Eliminar estudiante
            </template>

            <template #content>
                ¿Está seguro que desea eliminar al estudiante {{ currentStudent.name }} {{ currentStudent.lastName }}?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="deleteStudentModal = false">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteStudent"
                                   :class="{ 'opacity-25': formDelete.processing }"
                                   :disabled="formDelete.processing">

                    <div class="flex justify-center items-center">
                        <loading v-if="formDelete.processing" size="3" color="white"/>
                        Eliminar
                    </div>
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        <!--Modal Courses-->
        <modal-courses ref="toAssignCourse" :show="toAssignCourseModal" :student="currentStudent" @close="toAssignCourseModal = false"></modal-courses>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";
    import JetDangerButton from "@/Jetstream/DangerButton";
    import Loading from "@/Components/Loading";
    import Datatable from "@/Components/Datatable";
    import JButton from "@/Jetstream/Button";
    import ModalCourses from "@/Components/ModalCourses";

    export default {
        name: "StudentsList",
        components: {AppLayout, JetConfirmationModal, JetSecondaryButton, JetDangerButton, Loading, Datatable, JButton, ModalCourses},
        props: ['students'],
        data() {
            return {
                deleteStudentModal: false,
                toAssignCourseModal: false,
                currentStudent: null,
                formDelete: this.$inertia.form({
                    '_method': 'DELETE'
                })
            }

        },
        methods: {
            showDeleteStudentModal(student) {
                this.deleteStudentModal = true
                this.currentStudent = student

            },
            deleteStudent() {
                this.formDelete.delete(route('students.destroy', this.currentStudent.id))
            },
            showToAssignCourse(student){
                this.toAssignCourseModal = true
                this.currentStudent = student
                this.$refs.toAssignCourse.fetchData()
            },
        }
    }
</script>

<style scoped>

</style>
