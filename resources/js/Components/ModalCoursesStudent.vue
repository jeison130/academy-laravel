<template>
    <!-- Modal list courses from student -->
    <jet-confirmation-modal v-if="student" :icon="false" :show="show" @close="closeModal">
        <template #title>
            Cursos del estudiante {{ student.name }} {{ student.lastName }}
        </template>

        <template #content>
            <div class="px-6">
                <alert v-if="text" :text="text"/>
            </div>
            <datatable :data="courses" :pagination="false" :loading="loading">
                <template #head>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Cursos asignados
                        </th>

                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                </template>

                <template #body>
                    <tr v-for="(course, index) in courses.data" :key="course.id">
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="ml-4">
                                <div class="text-sm leading-5 font-medium text-gray-900">
                                    {{ course.name }}
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    {{ course.schedule }}
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    del {{ course.start_date }} al {{ course.end_date }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                            <loading v-if="course.loading"/>
                            <a v-else @click="deleteCourse(course, index)"
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

            <!--<jet-danger-button class="ml-2" @click.native="deleteStudent"
                               :class="{ 'opacity-25': formDelete.processing }"
                               :disabled="formDelete.processing">

                <div class="flex justify-center items-center">
                    <loading v-if="formDelete.processing" size="3" color="white"/>
                    Eliminar
                </div>
            </jet-danger-button>-->
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
        name: "ModalCourses",
        components: {JetConfirmationModal, JetSecondaryButton, Datatable, Alert, Loading},
        props: ['show', 'student'],
        data() {
            return {
                courses: {
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
                    axios.get(route('students.courses', this.student.id)).then((courses) => {
                        this.courses = {
                            data: courses.data
                        }
                        this.loading = false
                    })
                })
            },
            deleteCourse(course, index) {
                this.text = null
                course.loading = true
                Vue.set(this.courses.data, index, course)

                /*this.$inertia.form({
                    '_method': 'DELETE'
                }).delete(route('students.courses.delete', [this.student.id, course.id])).then(response => {
                    console.log(response)
                })*/
                axios.delete(route('students.courses.delete', [this.student.id, course.id]), {
                    data: {
                        _token: document.querySelector("meta[name='csrf-token']").content
                    }
                }).then((response) => {
                    this.text = response.data.message
                    // this.courses.data.splice(index, 1)
                    this.fetchData()
                })
            }
        },
    }
</script>

<style scoped>

</style>
