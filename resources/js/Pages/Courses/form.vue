<template>
    <jet-form-section @submitted="saveCourse">
        <template #title>
            Información del curso
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="name" value="Nombre"/>
                    <jet-input class="mt-1 block w-full" id="name" autocomplete="name" v-model="form.name"/>
                    <jet-input-error :message="form.error('name')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4 mt-6">
                    <jet-label for="schedule" value="Horario"/>
                    <jet-input class="mt-1 block w-full" id="schedule" v-model="form.schedule"/>
                    <jet-input-error :message="form.error('schedule')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4 mt-6">
                    <jet-label for="start_date" value="Fecha de inicio"/>
                    <jet-input type="date" class="mt-1 block w-full" id="start_date" v-model="form.start_date"/>
                    <jet-input-error :message="form.error('start_date')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4 mt-6">
                    <jet-label for="end_date" value="Fecha de finalización"/>
                    <jet-input type="date" class="mt-1 block w-full" id="end_date" autocomplete="end_date" v-model="form.end_date"/>
                    <jet-input-error :message="form.error('end_date')" class="mt-2"/>
                </div>
            </div>
        </template>

    </jet-form-section>
</template>

<script>
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetFormSection from '@/Jetstream/FormSection'
    import Loading from "@/Components/Loading";

    export default {
        name: "CoursesForm",
        components: {JetLabel, JetInput, JetFormSection, JetInputError, Loading},
        props: {
            course: {
                default: null
            }
        },
        data() {
            return {
                form: this.$inertia.form({
                        '_method': !this.course ? 'POST' : 'PUT',
                        name: !this.course ? '' : this.course.name,
                        schedule: !this.course ? '' : this.course.schedule,
                        start_date: !this.course ? '' : this.course.start_date,
                        end_date: !this.course ? '' : this.course.end_date
                    },

                ),
            }
        },
        methods: {
            saveCourse() {
                this.$emit('saving', true)
                this.form.post(
                    !this.course ? route('courses.store') :
                        route('courses.update', this.course.id)
                ).then(() => {
                    this.$emit('saving', false)
                })
            }
        }
    }
</script>

<style scoped>

</style>
