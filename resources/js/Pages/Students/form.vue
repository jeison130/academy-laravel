<template>
    <jet-form-section @submitted="saveStudent">
        <template #title>
            Información del estudiante
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="name" value="Nombres"/>
                    <jet-input class="mt-1 block w-full" id="name" autocomplete="name" v-model="form.name"/>
                    <jet-input-error :message="form.error('name')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4 mt-6">
                    <jet-label for="lastName" value="Apellidos"/>
                    <jet-input class="mt-1 block w-full" id="lastName" v-model="form.lastName"/>
                    <jet-input-error :message="form.error('lastName')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4 mt-6">
                    <jet-label for="age" value="Edad"/>
                    <jet-input class="mt-1 block w-full" id="age" v-model="form.age"/>
                    <jet-input-error :message="form.error('age')" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4 mt-6">
                    <jet-label for="email" value="Email"/>
                    <jet-input class="mt-1 block w-full" id="email" autocomplete="email" v-model="form.email"/>
                    <jet-input-error :message="form.error('email')" class="mt-2"/>
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
        name: "FormStudents",
        components: {JetLabel, JetInput, JetFormSection, JetInputError, Loading},
        props: {
            student: {
                default: null
            }
        },
        data() {
            return {
                form: this.$inertia.form({
                        '_method': !this.student ? 'POST' : 'PUT',
                        name: !this.student ? '' : this.student.name,
                        lastName: !this.student ? '' : this.student.lastName,
                        age: !this.student ? '' : this.student.age,
                        email: !this.student ? '' : this.student.email
                    },
                    
                ),
            }
        },
        methods: {
            saveStudent() {
                this.$emit('saving', true)
                this.form.post(
                    !this.student ? route('students.store') :
                        route('students.update', this.student.id)
                ).then(() => {
                    this.$emit('saving', false)
                })
            }
        }
    }
</script>

<style scoped>

</style>
