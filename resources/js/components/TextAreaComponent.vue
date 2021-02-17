<template>
    <div>
        <textarea class="c-vue-textarea"
            v-bind="$attrs"
            v-on="$listeners">
        </textarea>
    </div>
</template>

<style lang="scss">
    .c-vue-textarea {
        width: 100%;
        min-height: 200px;
        padding: 15px;
        font-size: 1.2em;
        border: 1px solid #ccc;
    }
</style>
