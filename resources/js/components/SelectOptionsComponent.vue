<template>
    <select
        v-bind="$attrs"
        @input="$emit('input', $event.target)">
        <option
            v-for="(value, key) in options"
            :key="key"
            :value="key">{{ value }}
        </option>
    </select>
</template>

<script>
    export default {
        props: {
            options: {
                type: Object,
                default: function() {
                    return {
                        0: '-- Seleccione una opción --'
                    }
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    select {
        height: 40px;
        font-size: 1.2em;
        width: 100%;
    }
</style>
