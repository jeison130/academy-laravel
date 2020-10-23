<template>
    <div :class="`bg-${color}-100 border-l-4 border-${color}-500 text-${color}-700 p-4`" role="alert">
        <p class="font-bold" v-if="title">{{ title }}</p>
        <p v-if="text">{{ text }}</p>
    </div>
</template>

<script>
    export default {
        name: "Alert",
        props: {
            color: {
                default: 'green'
            },
            title: {
                default: null
            },
            text: {
                default: null
            }
        }
    }
</script>

<style scoped>

</style>
