<template>
    <app-layout>
        <template #header>
            <div class="flex ">
                <div class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Cursos
                    </h2>
                </div>
                <div class="flex-auto">
                    <a
                        class="bg-indigo-500 py-2 px-5 text-white float-right rounded-lg outline-none focus:outline-none"
                        :href="route('courses.create')"
                    >
                        Crear
                    </a>
                </div>
            </div>

        </template>

        <div class="py-12">
            <datatable :data="courses">
                <template #head>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Horario
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Fecha inicio
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Fecha finalización
                        </th>
                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                </template>

                <template #body>
                    <tr v-for="course in courses.data">
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="text-sm leading-5 font-medium text-gray-900">
                                {{ course.name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="text-sm leading-5 font-medium text-gray-900">
                                {{ course.schedule }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="text-sm leading-5 font-medium text-gray-900">
                                {{ course.start_date }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            <div class="text-sm leading-5 font-medium text-gray-900">
                                {{ course.end_date }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                            <div class="flex items-center justify-around">
                                <a :href="route('courses.edit', course.id)"
                                   class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                <a @click="showDeleteCourseModal(course)"
                                   class="cursor-pointer text-red-600 hover:text-red-900 ml-1">Eliminar</a>

                                <button type="button"
                                        class="bg-blue-400 hover:bg-blue-500 py-2 px-5 text-white float-right rounded-lg outline-none focus:outline-none"
                                        @click="showCoursesStudent(course)">
                                    Ver Estudiantes
                                </button>

                            </div>

                        </td>
                    </tr>
                </template>
            </datatable>
        </div>

        <!--Modal confirmation delete student-->
        <jet-confirmation-modal v-if="currentCourse" :show="deleteCourseModal" @close="deleteCourseModal = false">
            <template #title>
                Eliminar curso
            </template>

            <template #content>
                ¿Está seguro que desea eliminar el curso {{ currentCourse.name }}?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="deleteCourseModal = false">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteCourse"
                                   :class="{ 'opacity-25': formDelete.processing }"
                                   :disabled="formDelete.processing">

                    <div class="flex justify-center items-center">
                        <loading v-if="formDelete.processing" size="3" color="white"/>
                        Eliminar
                    </div>
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        <modal-students-course :show="coursesStudentModal" ref="coursesStudent"
                               :course="currentCourse"
                               @close="coursesStudentModal = false"
            ></modal-students-course>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";
    import JetDangerButton from "@/Jetstream/DangerButton";
    import Loading from "@/Components/Loading";
    import Datatable from "@/Components/Datatable";
    import ModalStudentsCourse from "@/Components/ModalStudentsCourse";

    export default {
        name: "CoursesList",
        components: {AppLayout, JetConfirmationModal, JetSecondaryButton, JetDangerButton, Loading, Datatable, ModalStudentsCourse},
        props: ['courses'],
        data() {
            return {
                deleteCourseModal: false,
                currentCourse: null,
                formDelete: this.$inertia.form({
                    '_method': 'DELETE'
                }),
                coursesStudentModal: false,
            }

        },
        methods: {
            showDeleteCourseModal(course) {
                this.deleteCourseModal = true
                this.currentCourse = course

            },
            deleteCourse() {
                this.formDelete.delete(route('courses.destroy', this.currentCourse.id))
            },
            showCoursesStudent(course) {
                this.coursesStudentModal = true
                this.currentCourse = course
                this.$refs.coursesStudent.fetchData()
            }
        }
    }
</script>

<style scoped>

</style>
