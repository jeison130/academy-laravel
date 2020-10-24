<template>
    <!--Modal confirmation delete student-->
    <jet-confirmation-modal :icon="false" :show="show" @close="closeModal">
        <template #title>
            Top 3 cursos con más estudiantes en los ultimos 6 meses
        </template>

        <template #content>
            <datatable :data="courses" :pagination="false" :loading="loading">
                <template #head>
                    <tr>
                        <th class="text-center text-sm leading-5 font-medium text-gray-900">
                            #
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Cursos
                        </th>
                    </tr>
                </template>

                <template #body>
                    <tr v-for="(course, index) in courses.data" :key="course.id">
                        <td class="text-center text-sm leading-5 font-medium text-gray-900">
                            {{ index + 1 }}
                        </td>
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
                                <div class="text-sm leading-5 text-gray-500">
                                    Cantidad de estudiantes {{ course.students_count }}
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </datatable>

        </template>

        <template #footer>
            <jet-secondary-button @click.native="closeModal">
                Cerrar
            </jet-secondary-button>

        </template>
    </jet-confirmation-modal>
</template>

<script>
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";
    import Datatable from "@/Components/Datatable";

    export default {
        name: "ModalTopCourses",
        components: {JetConfirmationModal, JetSecondaryButton, Datatable},
        props: ['show'],
        data() {
            return {
                courses: {
                    data: []
                },
                loading: false,
            }
        },
        methods: {
            closeModal() {
                this.$emit('close')
            },
            fetchData() {
                this.loading = true
                this.$nextTick(() => {
                    axios.get(route('courses.top')).then((courses) => {
                        this.courses = {
                            data: courses.data
                        }
                        this.loading = false
                    })
                })
            }
        },
    }
</script>

<style scoped>

</style>
