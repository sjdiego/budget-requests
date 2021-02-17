<template>
    <div>
        <p>Descripción del trabajo</p>
        <text-area-component
            @input="setDescription"
            :value="description">
        </text-area-component>

        <p>Fecha estimada</p>
        <select-options-component
            v-model="estimatedDate"
            @input="setEstimatedDate"
            :options="estimatedDates">
        </select-options-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                estimatedDate: {},
                description: ''
            }
        },
        props: {
            estimatedDates: {
                type: Object,
                default: function() {
                    return {
                        1: 'Lo antes posible',
                        13: 'De 1 a 3 meses',
                        30: 'Más de 3 meses'
                    }
                }
            },
        },
        methods: {
            setDescription(event) {
                this.$store.commit('setDescription', event.target.value)
                this.description = event.target.value
            },
            setEstimatedDate: function(target) {
                this.$store.commit('setEstimatedDate', target.value)
                this.estimatedDate = target.value
            }
        }
    }
</script>

<style lang="scss" scoped>
    p {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
