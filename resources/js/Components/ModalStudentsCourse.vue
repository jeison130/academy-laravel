<template>
    <!-- Modal list courses from student -->
    <jet-confirmation-modal v-if="course" :icon="false" :show="show" @close="closeModal">
        <template #title>
            Estudiantes del Curso {{ course.name }} {{ course.lastName }}
        </template>

        <template #content>
            <div class="px-6">
                <alert v-if="text" :text="text"/>
            </div>
            <datatable :data="students" :pagination="false" :loading="loading">
                <template #head>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Estudiantes matriculados
                        </th>

                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                </template>

                <template #body>
                    <tr v-for="(student, index) in students.data" :key="course.id">
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="ml-4">
                                <div class="text-sm leading-5 font-medium text-gray-900">
                                    {{ student.name }} {{ student.lastName }}
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    {{ student.email }}
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    Fecha de matrícula {{ student.inscription_date }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                            <loading v-if="student.loading"/>
                            <a v-else @click="deleteStudent(student, index)"
                               class="cursor-pointer text-red-600 hover:text-red-900">Eliminar</a>
                        </td>
                    </tr>
                </template>
            </datatable>

        </template>

        <template #footer>
            <jet-secondary-button @click.native="closeModal">
                Cancelar
            </jet-secondary-button>

        </template>
    </jet-confirmation-modal>
</template>

<script>
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";
    import Datatable from "@/Components/Datatable";
    import Alert from "@/Components/Alert";
    import Loading from "@/Components/Loading";
    import Vue from 'vue'

    export default {
        name: "ModalStudentsCourses",
        components: {JetConfirmationModal, JetSecondaryButton, Datatable, Alert, Loading},
        props: ['show', 'course'],
        data() {
            return {
                students: {
                    data: []
                },
                loading: false,
                text: null,
            }
        },
        methods: {
            closeModal() {
                this.$emit('close')
            },
            fetchData() {
                setTimeout(() => {
                    this.text = null
                }, 5000)
                this.loading = true
                this.$nextTick(() => {
                    axios.get(route('courses.students', this.course.id)).then((students) => {
                        this.students = {
                            data: students.data
                        }
                        this.loading = false
                    })
                })
            },
            deleteStudent(student, index) {

                setTimeout(() => {
                    this.text = null
                }, 5000)

                student.loading = true
                Vue.set(this.students.data, index, student)

                axios.delete(route('courses.students.delete', [this.course.id, student.id]), {
                    data: {
                        _token: document.querySelector("meta[name='csrf-token']").content
                    }
                }).then((response) => {
                    this.text = response.data.message
                    this.fetchData()
                })
            }
        },
    }
</script>

<style scoped>

</style>
