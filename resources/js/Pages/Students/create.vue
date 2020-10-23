<template>
    <app-layout>
        <template #header>
            <div class="flex ">
                <div class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Crear nuevo estudiante
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
            <jet-form-section @submitted="saveStudent">
                <template #title>
                    Información del estudiante
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="name" value="Nombres"/>
                            <jet-input class="mt-1 block w-full" id="name" autocomplete="name" v-model="form.name"/>
                            <jet-input-error :message="form.error('name')" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 mt-6">
                            <jet-label for="lastName" value="Apellidos"/>
                            <jet-input class="mt-1 block w-full" id="lastName" v-model="form.lastName"/>
                            <jet-input-error :message="form.error('lastName')" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 mt-6">
                            <jet-label for="age" value="Edad"/>
                            <jet-input class="mt-1 block w-full" id="age" v-model="form.age"/>
                            <jet-input-error :message="form.error('age')" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 mt-6">
                            <jet-label for="email" value="Email"/>
                            <jet-input class="mt-1 block w-full" id="email" autocomplete="email" v-model="form.email"/>
                            <jet-input-error :message="form.error('email')" class="mt-2" />
                        </div>
                    </div>
                </template>

            </jet-form-section>
        </div>

    </app-layout>

</template>

<script>
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import AppLayout from '@/Layouts/AppLayout'
    import JetFormSection from '@/Jetstream/FormSection'
    import Loading from "@/Components/Loading";

    export default {
        name: "create",
        components: {AppLayout, JetLabel, JetInput, JetFormSection, JetInputError, Loading},
        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'POST',
                    name: '',
                    lastName: '',
                    age: '',
                    email: ''
                }),
                loading: false,
            }
        },
        methods: {
            saveStudent(){
                this.loading = true
                this.form.post(route('students.store')).then(() => {
                    this.loading = false
                })
            }
        }
    }
</script>

<style scoped>

</style>
